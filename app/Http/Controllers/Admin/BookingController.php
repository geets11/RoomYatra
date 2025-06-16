<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     */
    public function index(Request $request)
    {
        try {
            $query = Booking::with(['property', 'user']);

            // Apply filters
            if ($request->filled('booking_status')) {
                $query->where('status', $request->booking_status);
            }

            if ($request->filled('property_status')) {
                $query->whereHas('property', function($q) use ($request) {
                    $q->where('status', $request->property_status);
                });
            }

            if ($request->filled('property_id')) {
                $query->where('property_id', $request->property_id);
            }

            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Sort bookings
            $sortField = $request->get('sort', 'created_at');
            $sortDirection = $request->get('direction', 'desc');
            $query->orderBy($sortField, $sortDirection);

            $bookings = $query->paginate(15);
            
            // Get filter data
            $properties = Property::select('id', 'title')->orderBy('title')->get();
            $users = User::select('id', 'name', 'email')->orderBy('name')->get();
            
            $bookingStatuses = [
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
                'cancelled' => 'Cancelled',
                'completed' => 'Completed'
            ];
            
            $propertyStatuses = [
                'available' => 'Available',
                'booked' => 'Booked',
                'undermaintenance' => 'Under Maintenance'
            ];

            // Get summary statistics
            $totalBookings = Booking::count();
            $bookingsByStatus = Booking::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            return view('admin.bookings', compact(
                'bookings', 
                'properties', 
                'users', 
                'bookingStatuses', 
                'propertyStatuses',
                'totalBookings',
                'bookingsByStatus'
            ));

        } catch (\Exception $e) {
            Log::error('Error loading bookings: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->back()->with('error', 'Failed to load bookings. Please try again.');
        }
    }

    /**
     * Display the specified booking.
     */
    public function show($id)
    {
        try {
            $booking = Booking::with([
                'property.images', 
                'property.user',
                'user', 
                'review'
            ])->findOrFail($id);
            
            return view('admin.bookings.show', compact('booking'));
            
        } catch (\Exception $e) {
            Log::error('Error loading booking: ' . $e->getMessage(), [
                'booking_id' => $id
            ]);
            
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Booking not found.');
        }
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,approved,rejected,cancelled,completed',
                'rejection_reason' => 'required_if:status,rejected|max:500',
                'property_status' => 'sometimes|in:available,booked,undermaintenance',
            ]);

            $booking = Booking::with('property')->findOrFail($id);
            $oldStatus = $booking->status;
            
            // Update booking status
            $booking->status = $request->status;
            
            if ($request->status === 'rejected') {
                $booking->rejection_reason = $request->rejection_reason;
            } else {
                $booking->rejection_reason = null;
            }
            
            $booking->save();

            // Update property status if provided
            if ($request->filled('property_status') && $booking->property) {
                $booking->property->status = $request->property_status;
                $booking->property->save();
            } else {
                // Auto-update property status based on booking status
                $this->autoUpdatePropertyStatus($booking, $oldStatus, $request->status);
            }

            return redirect()->back()->with('success', 'Booking status updated successfully.');
            
        } catch (\Exception $e) {
            Log::error('Error updating booking status: ' . $e->getMessage(), [
                'booking_id' => $id,
                'request_data' => $request->all(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->back()->with('error', 'Failed to update booking status. Please try again.');
        }
    }

    /**
     * Auto-update property status based on booking status.
     */
    private function autoUpdatePropertyStatus($booking, $oldStatus, $newStatus)
    {
        if (!$booking->property) return;

        try {
            switch ($newStatus) {
                case 'approved':
                    if ($oldStatus !== 'approved') {
                        $booking->property->status = 'booked';
                        $booking->property->save();
                    }
                    break;
                    
                case 'completed':
                    $booking->property->status = 'available';
                    $booking->property->save();
                    break;
                    
                case 'rejected':
                case 'cancelled':
                    // Only set to available if this was the active booking
                    if ($oldStatus === 'approved') {
                        $booking->property->status = 'available';
                        $booking->property->save();
                    }
                    break;
            }
        } catch (\Exception $e) {
            Log::error('Error auto-updating property status: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
                'property_id' => $booking->property->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]);
        }
    }

    /**
     * Approve a booking.
     */
    public function approve(Request $request, $id)
    {
        try {
            $booking = Booking::with('property')->findOrFail($id);
            
            $booking->status = 'approved';
            $booking->rejection_reason = null;
            $booking->save();

            if ($booking->property) {
                $booking->property->status = 'booked';
                $booking->property->save();
            }

            return redirect()->back()->with('success', 'Booking approved successfully.');
            
        } catch (\Exception $e) {
            Log::error('Error approving booking: ' . $e->getMessage(), [
                'booking_id' => $id
            ]);
            
            return redirect()->back()->with('error', 'Failed to approve booking.');
        }
    }

    /**
     * Reject a booking.
     */
    public function reject(Request $request, $id)
    {
        try {
            $request->validate([
                'rejection_reason' => 'required|max:500',
            ]);

            $booking = Booking::with('property')->findOrFail($id);
            $oldStatus = $booking->status;
            
            $booking->status = 'rejected';
            $booking->rejection_reason = $request->rejection_reason;
            $booking->save();

            // Set property to available if it was previously approved
            if ($oldStatus === 'approved' && $booking->property) {
                $booking->property->status = 'available';
                $booking->property->save();
            }

            return redirect()->back()->with('success', 'Booking rejected successfully.');
            
        } catch (\Exception $e) {
            Log::error('Error rejecting booking: ' . $e->getMessage(), [
                'booking_id' => $id
            ]);
            
            return redirect()->back()->with('error', 'Failed to reject booking.');
        }
    }

    /**
     * Complete a booking.
     */
    public function complete(Request $request, $id)
    {
        try {
            $booking = Booking::with('property')->findOrFail($id);
            
            $booking->status = 'completed';
            $booking->save();

            if ($booking->property) {
                $booking->property->status = 'available';
                $booking->property->save();
            }

            return redirect()->back()->with('success', 'Booking completed successfully.');
            
        } catch (\Exception $e) {
            Log::error('Error completing booking: ' . $e->getMessage(), [
                'booking_id' => $id
            ]);
            
            return redirect()->back()->with('error', 'Failed to complete booking.');
        }
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Request $request, $id)
    {
        try {
            $booking = Booking::with('property')->findOrFail($id);
            $oldStatus = $booking->status;
            
            $booking->status = 'cancelled';
            $booking->save();

            // Set property to available if it was previously approved
            if ($oldStatus === 'approved' && $booking->property) {
                $booking->property->status = 'available';
                $booking->property->save();
            }

            return redirect()->back()->with('success', 'Booking cancelled successfully.');
            
        } catch (\Exception $e) {
            Log::error('Error cancelling booking: ' . $e->getMessage(), [
                'booking_id' => $id
            ]);
            
            return redirect()->back()->with('error', 'Failed to cancel booking.');
        }
    }
}
