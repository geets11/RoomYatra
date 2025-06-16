<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'property_id',
        'rating',
        'cleanliness_rating',
        'communication_rating',
        'check_in_rating',
        'accuracy_rating',
        'location_rating',
        'value_rating',
        'comment',
        'landlord_response',
        'is_approved',
        'is_published',
    ];

    protected $casts = [
        'rating' => 'float',
        'cleanliness_rating' => 'integer',
        'communication_rating' => 'integer',
        'check_in_rating' => 'integer',
        'accuracy_rating' => 'integer',
        'location_rating' => 'integer',
        'value_rating' => 'integer',
        'is_approved' => 'boolean',
        'is_published' => 'boolean',
    ];

    /**
     * Get the booking that this review belongs to
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the user (tenant) who wrote this review
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property that this review is for
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Scope to only include approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope to only include published reviews
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to only include public reviews (approved and published)
     */
    public function scopePublic($query)
    {
        return $query->where('is_approved', true)->where('is_published', true);
    }

    /**
     * Check if the review has a landlord response
     */
    public function hasLandlordResponse()
    {
        return !empty($this->landlord_response);
    }

    /**
     * Get formatted rating for display
     */
    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating, 1);
    }

    /**
     * Get the review age in human readable format
     */
    public function getAgeAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Calculate overall rating from individual ratings
     */
    public static function calculateOverallRating($ratings)
    {
        $total = $ratings['cleanliness_rating'] + 
                $ratings['communication_rating'] + 
                $ratings['check_in_rating'] + 
                $ratings['accuracy_rating'] + 
                $ratings['location_rating'] + 
                $ratings['value_rating'];
        
        return round($total / 6, 1);
    }
}
