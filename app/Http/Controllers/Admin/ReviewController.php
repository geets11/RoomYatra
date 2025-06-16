<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of all reviews.
     */
    public function index()
    {
        $reviews = Review::with(['property', 'user', 'booking'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Display the specified review.
     */
    public function show(Review $review)
    {
        $review->load(['property', 'user', 'booking']);

        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Approve a review.
     */
    public function approve(Review $review)
    {
        DB::transaction(function () use ($review) {
            $review->update(['is_approved' => true]);
            
            // Update property rating
            $this->updatePropertyRating($review->property_id);
        });

        return redirect()->back()
            ->with('success', 'Review has been approved successfully.');
    }

    /**
     * Reject/Unapprove a review.
     */
    public function reject(Review $review)
    {
        DB::transaction(function () use ($review) {
            $review->update(['is_approved' => false]);
            
            // Update property rating
            $this->updatePropertyRating($review->property_id);
        });

        return redirect()->back()
            ->with('success', 'Review has been rejected successfully.');
    }

    /**
     * Toggle review publication status.
     */
    public function togglePublication(Review $review)
    {
        DB::transaction(function () use ($review) {
            $review->update(['is_published' => !$review->is_published]);
            
            // Update property rating
            $this->updatePropertyRating($review->property_id);
        });

        $status = $review->is_published ? 'published' : 'unpublished';
        
        return redirect()->back()
            ->with('success', "Review has been {$status} successfully.");
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        $propertyId = $review->property_id;

        DB::transaction(function () use ($review, $propertyId) {
            $review->delete();
            
            // Update property rating
            $this->updatePropertyRating($propertyId);
        });

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review has been deleted successfully.');
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
