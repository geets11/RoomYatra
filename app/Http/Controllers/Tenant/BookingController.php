<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Notifications\BookingRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['property', 'property.images', 'property.user'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tenant.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // Check if the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->load(['property', 'property.images', 'property.amenities', 'property.user']);

        return view('tenant.bookings.show', compact('booking'));
    }

    public function create(Property $property)
    {
        // Check if property is approved
        if ($property->status !== 'approved') {
            abort(404);
        }

        $property->load(['propertyType', 'images', 'amenities', 'user']);

        // Get unavailable dates
        $unavailableDates = [];

        if ($property->bookings()->where('status', 'approved')->exists()) {
            $bookedDates = $property->bookings()
                ->where('status', 'approved')
                ->select('check_in', 'check_out')
                ->get();

            foreach ($bookedDates as $booking) {
                $start = Carbon::parse($booking->check_in);
                $end = Carbon::parse($booking->check_out);

                for ($date = $start; $date->lte($end); $date->addDay()) {
                    $unavailableDates[] = $date->format('Y-m-d');
                }
            }
        }

        return view('tenant.bookings.create', compact('property', 'unavailableDates'));
    }

    public function store(Request $request, Property $property)
    {
        // Validate the request
        $validated = $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'guests' => 'required|integer|min:1',
            'message' => 'nullable|string|max:500',
        ]);

        // Check if property is available for booking
        if (!in_array($property->status, ['available', 'approved'])) {
            return back()->withErrors(['property' => 'This property is not available for booking.'])->withInput();
        }

        // Check if property is currently booked
        if ($property->status === 'booked') {
            return back()->withErrors(['property' => 'This property is currently booked and not available.'])->withInput();
        }

        // Check if property has active bookings
        $activeBooking = $property->bookings()
            ->where('status', 'approved')
            // ->where('check_out', '>=', now())
            ->exists();

        if ($activeBooking) {
            return back()->withErrors(['property' => 'This property has an active booking and is not available.'])->withInput();
        }

        // Check if property is available for the selected dates
        $checkIn = Carbon::parse($validated['check_in']);

        $conflictingBookings = $property->bookings()
            ->where('status', 'approved')
            ->where(function($query) use ($checkIn) {
            $query->orWhere(function($q) use ($checkIn) {
                    $q->where('check_in', '<=', $checkIn);
                });
        })
            ->exists();

        if ($conflictingBookings) {
            return back()->withErrors(['check_in' => 'The property is not available for the selected dates.'])->withInput();
        }

        // Create the booking
        $booking = new Booking();
        $booking->property_id = $property->id;
        $booking->user_id = Auth::id();
        $booking->check_in = $checkIn;
        $booking->guests = $validated['guests'];
        $booking->message = $validated['message'];
        $booking->status = 'pending';
        $booking->save();

        // Load relationships for notification
        $booking->load(['property', 'user']);

        // Send notification to landlord with error handling
        try {
            $landlord = $property->user;
            $landlord->notify(new BookingRequestNotification($booking));
            
            $successMessage = 'Booking request submitted successfully! The property owner will review your request and you will receive an email notification.';
        } catch (\Exception $e) {
            // Log the email error but don't fail the booking
            Log::error('Failed to send booking notification email: ' . $e->getMessage(), [
                'booking_id' => $booking->id,
                'landlord_id' => $property->user_id,
                'error' => $e->getMessage()
            ]);
            
            $successMessage = 'Booking request submitted successfully! The property owner will review your request. (Note: Email notification could not be sent, but your booking is confirmed.)';
        }

        return redirect()->route('tenant.bookings.show', $booking->id)
            ->with('success', $successMessage);
    }

    public function cancel(Request $request, Booking $booking)
    {
        // Check if the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the booking can be cancelled
        if (!in_array($booking->status, ['pending', 'approved'])) {
            return back()->withErrors(['message' => 'This booking cannot be cancelled.']);
        }

        // Validate the request
        $validated = $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        // Update the booking
        $booking->status = 'cancelled';
        $booking->cancellation_reason = $validated['cancellation_reason'];
        $booking->cancelled_at = now();
        $booking->cancelled_by = 'tenant';
        $booking->save();

        return redirect()->route('tenant.bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }
}
