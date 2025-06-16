<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Notifications\BookingApprovedNotification;
use App\Notifications\BookingRejectedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        // Get all properties owned by the landlord
        $propertyIds = Property::where('user_id', Auth::id())->pluck('id');

        // Get all bookings for those properties
        $bookings = Booking::with(['property', 'property.images', 'user'])
            ->whereIn('property_id', $propertyIds)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get counts for different booking statuses
        $pendingCount = $bookings->where('status', 'pending')->count();
        $approvedCount = $bookings->where('status', 'approved')->count();
        $completedCount = $bookings->where('status', 'completed')->count();
        $cancelledCount = $bookings->where('status', 'cancelled')->count();
        $rejectedCount = $bookings->where('status', 'rejected')->count();

        return view('landlord.bookings.index', compact('bookings', 'pendingCount', 'approvedCount', 'completedCount', 'cancelledCount', 'rejectedCount'));
    }

    public function show(Booking $booking)
    {
        // Check if the booking is for a property owned by the landlord
        $propertyIds = Property::where('user_id', Auth::id())->pluck('id');

        if (!$propertyIds->contains($booking->property_id)) {
            abort(403, 'Unauthorized action.');
        }

        $booking->load(['property', 'property.images', 'property.amenities', 'user']);

        return view('landlord.bookings.show', compact('booking'));
    }

    public function approve(Request $request, Booking $booking)
    {
        try {
            // Check if the booking is for a property owned by the landlord
            $propertyIds = Property::where('user_id', Auth::id())->pluck('id');

            if (!$propertyIds->contains($booking->property_id)) {
                return back()->withErrors(['error' => 'Unauthorized action.']);
            }

            // Validate the request
            $validated = $request->validate([
                'message' => 'nullable|string|max:1000',
            ]);

            // Check if the booking can be approved
            if ($booking->status !== 'pending') {
                return back()->withErrors(['error' => 'This booking cannot be approved. Current status: ' . $booking->status]);
            }

            // Update the booking
            $booking->status = 'approved';
            $booking->landlord_message = $validated['message'] ?? null;
            $booking->save();

            // DON'T change property status to 'booked' - keep it available for future bookings
            // Properties can have multiple bookings for different time periods
            
            // Send notification to tenant (with error handling)
            try {
                $tenant = $booking->user;
                $tenant->notify(new BookingApprovedNotification($booking));
                Log::info('Booking approved notification sent', ['booking_id' => $booking->id, 'tenant_id' => $tenant->id]);
            } catch (\Exception $e) {
                Log::error('Failed to send booking approval notification: ' . $e->getMessage(), [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage()
                ]);
                // Continue execution even if notification fails
            }

            return redirect()->route('landlord.bookings.show', $booking->id)
                ->with('success', 'Booking approved successfully! The tenant has been notified.');

        } catch (\Exception $e) {
            Log::error('Error approving booking: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['error' => 'An error occurred while approving the booking: ' . $e->getMessage()]);
        }
    }

    public function reject(Request $request, Booking $booking)
    {
        try {
            // Check if the booking is for a property owned by the landlord
            $propertyIds = Property::where('user_id', Auth::id())->pluck('id');

            if (!$propertyIds->contains($booking->property_id)) {
                return back()->withErrors(['error' => 'Unauthorized action.']);
            }

            // Validate the request
            $validated = $request->validate([
                'message' => 'nullable|string|max:1000',
            ]);

            // Check if the booking can be rejected
            if ($booking->status !== 'pending') {
                return back()->withErrors(['error' => 'This booking cannot be rejected. Current status: ' . $booking->status]);
            }

            // Update the booking
            $booking->status = 'rejected';
            $booking->landlord_message = $validated['message'] ?? null;
            $booking->rejection_reason = $validated['message'] ?? 'No reason provided';
            $booking->save();

            // Property remains available for other bookings when a booking is rejected

            // Send notification to tenant (with error handling)
            try {
                $tenant = $booking->user;
                $tenant->notify(new BookingRejectedNotification($booking));
                Log::info('Booking rejected notification sent', ['booking_id' => $booking->id, 'tenant_id' => $tenant->id]);
            } catch (\Exception $e) {
                Log::error('Failed to send booking rejection notification: ' . $e->getMessage(), [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage()
                ]);
                // Continue execution even if notification fails
            }

            return redirect()->route('landlord.bookings.show', $booking->id)
                ->with('success', 'Booking rejected successfully. The tenant has been notified.');

        } catch (\Exception $e) {
            Log::error('Error rejecting booking: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['error' => 'An error occurred while rejecting the booking: ' . $e->getMessage()]);
        }
    }

    // Legacy method for backward compatibility
    public function updateStatus(Request $request, Booking $booking)
    {
        $status = $request->input('status');
        
        if ($status === 'approved') {
            return $this->approve($request, $booking);
        } elseif ($status === 'rejected') {
            return $this->reject($request, $booking);
        }
        
        return back()->withErrors(['error' => 'Invalid status provided.']);
    }
}
