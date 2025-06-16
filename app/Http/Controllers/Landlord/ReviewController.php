<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews for landlord's properties.
     */
    public function index()
    {
        // Get all properties owned by the landlord
        $propertyIds = Auth::user()->properties()->pluck('id');

        // Get all reviews for those properties
        $reviews = Review::whereIn('property_id', $propertyIds)
            ->with(['property', 'user', 'booking'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('landlord.reviews.index', compact('reviews'));
    }

    /**
     * Display the specified review.
     */
    public function show(Review $review)
    {
        // Check if the review is for a property owned by the landlord
        $propertyIds = Auth::user()->properties()->pluck('id');

        if (!$propertyIds->contains($review->property_id)) {
            abort(403, 'Unauthorized action.');
        }

        $review->load(['property', 'user', 'booking']);

        return view('landlord.reviews.show', compact('review'));
    }

    /**
     * Store landlord's response to a review.
     */
    public function respond(Request $request, Review $review)
    {
        // Check if the review is for a property owned by the landlord
        $propertyIds = Auth::user()->properties()->pluck('id');

        if (!$propertyIds->contains($review->property_id)) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the request
        $validated = $request->validate([
            'landlord_response' => 'required|string|min:10|max:1000',
        ]);

        // Update the review with the landlord's response
        $review->update([
            'landlord_response' => $validated['landlord_response'],
        ]);

        return redirect()->route('landlord.reviews.show', $review->id)
            ->with('success', 'Your response has been saved successfully.');
    }

    /**
     * Remove landlord's response from a review.
     */
    public function removeResponse(Review $review)
    {
        // Check if the review is for a property owned by the landlord
        $propertyIds = Auth::user()->properties()->pluck('id');

        if (!$propertyIds->contains($review->property_id)) {
            abort(403, 'Unauthorized action.');
        }

        // Remove the landlord's response
        $review->update([
            'landlord_response' => null,
        ]);

        return redirect()->route('landlord.reviews.show', $review->id)
            ->with('success', 'Your response has been removed successfully.');
    }
}
