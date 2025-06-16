<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the user's reviews.
     */
    public function index()
    {
        $reviews = Review::where('user_id', Auth::id())
            ->with(['property', 'booking'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tenant.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(Booking $booking)
    {
        // Check if the booking belongs to the tenant
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the booking is completed
        if (!$booking->isCompleted()) {
            return redirect()->route('tenant.bookings.show', $booking->id)
                ->with('error', 'You can only review completed bookings.');
        }

        // Check if a review already exists
        $existingReview = Review::where('booking_id', $booking->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->route('tenant.reviews.edit', $existingReview->id)
                ->with('info', 'You have already reviewed this booking. You can edit your review.');
        }

        $booking->load('property');

        return view('tenant.reviews.create', compact('booking'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Booking $booking)
    {
        // Check if the booking belongs to the tenant
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the booking is completed
        if (!$booking->isCompleted()) {
            return redirect()->route('tenant.bookings.show', $booking->id)
                ->with('error', 'You can only review completed bookings.');
        }

        // Check if a review already exists
        $existingReview = Review::where('booking_id', $booking->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->route('tenant.reviews.edit', $existingReview->id)
                ->with('info', 'You have already reviewed this booking.');
        }

        // Validate the request
        $validated = $request->validate([
            'cleanliness_rating' => 'required|integer|min:1|max:5',
            'communication_rating' => 'required|integer|min:1|max:5',
            'check_in_rating' => 'required|integer|min:1|max:5',
            'accuracy_rating' => 'required|integer|min:1|max:5',
            'location_rating' => 'required|integer|min:1|max:5',
            'value_rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        // Calculate the overall rating (average of all ratings)
        $overallRating = Review::calculateOverallRating($validated);

        DB::transaction(function () use ($validated, $booking, $overallRating) {
            // Create the review
            $review = Review::create([
                'booking_id' => $booking->id,
                'user_id' => Auth::id(),
                'property_id' => $booking->property_id,
                'rating' => $overallRating,
                'cleanliness_rating' => $validated['cleanliness_rating'],
                'communication_rating' => $validated['communication_rating'],
                'check_in_rating' => $validated['check_in_rating'],
                'accuracy_rating' => $validated['accuracy_rating'],
                'location_rating' => $validated['location_rating'],
                'value_rating' => $validated['value_rating'],
                'comment' => $validated['comment'],
                'is_approved' => false, // Reviews need approval
                'is_published' => true,
            ]);

            // Update the property's average rating
            $this->updatePropertyRating($booking->property_id);
        });

        return redirect()->route('tenant.reviews.index')
            ->with('success', 'Your review has been submitted successfully and is pending approval.');
    }

    /**
     * Display the specified review.
     */
    public function show(Review $review)
    {
        // Check if the review belongs to the tenant
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $review->load(['property', 'booking']);

        return view('tenant.reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review)
    {
        // Check if the review belongs to the tenant
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $review->load(['property', 'booking']);

        return view('tenant.reviews.edit', compact('review'));
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review)
    {
        // Check if the review belongs to the tenant
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the request
        $validated = $request->validate([
            'cleanliness_rating' => 'required|integer|min:1|max:5',
            'communication_rating' => 'required|integer|min:1|max:5',
            'check_in_rating' => 'required|integer|min:1|max:5',
            'accuracy_rating' => 'required|integer|min:1|max:5',
            'location_rating' => 'required|integer|min:1|max:5',
            'value_rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        // Calculate the overall rating (average of all ratings)
        $overallRating = Review::calculateOverallRating($validated);

        DB::transaction(function () use ($validated, $review, $overallRating) {
            // Update the review
            $review->update([
                'rating' => $overallRating,
                'cleanliness_rating' => $validated['cleanliness_rating'],
                'communication_rating' => $validated['communication_rating'],
                'check_in_rating' => $validated['check_in_rating'],
                'accuracy_rating' => $validated['accuracy_rating'],
                'location_rating' => $validated['location_rating'],
                'value_rating' => $validated['value_rating'],
                'comment' => $validated['comment'],
                'is_approved' => false, // Reset approval status when edited
            ]);

            // Update the property's average rating
            $this->updatePropertyRating($review->property_id);
        });

        return redirect()->route('tenant.reviews.show', $review->id)
            ->with('success', 'Your review has been updated successfully and is pending approval.');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        // Check if the review belongs to the tenant
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $propertyId = $review->property_id;

        DB::transaction(function () use ($review, $propertyId) {
            // Delete the review
            $review->delete();

            // Update the property's average rating
            $this->updatePropertyRating($propertyId);
        });

        return redirect()->route('tenant.reviews.index')
            ->with('success', 'Your review has been deleted successfully.');
    }

    /**
     * Update the property's average rating and review count
     */
    private function updatePropertyRating($propertyId)
    {
        $property = Property::findOrFail($propertyId);

        // Get all approved and published reviews for the property
        $reviews = Review::where('property_id', $propertyId)
            ->where('is_approved', true)
            ->where('is_published', true)
            ->get();

        if ($reviews->count() > 0) {
            // Calculate the average rating
            $averageRating = $reviews->avg('rating');

            // Update the property's rating (if you have these fields in properties table)
            // $property->update([
            //     'rating' => round($averageRating, 1),
            //     'reviews_count' => $reviews->count(),
            // ]);
        }
    }
}
