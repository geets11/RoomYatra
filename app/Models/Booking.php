<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'property_id',
        'user_id',
        'check_in',
        'check_out',
        'guests',
        'total_price',
        'special_requests',
        'status',
        'rejection_reason',
        'is_paid',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'total_price' => 'float',
        'guests' => 'integer',
        'is_paid' => 'boolean',
    ];

    /**
     * Get the property that was booked.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the user (tenant) who made the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the review associated with the booking.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Check if the booking can be reviewed.
     */
    public function canBeReviewed()
    {
        return $this->status === self::STATUS_COMPLETED && !$this->review()->exists();
    }

    /**
     * Check if the booking is completed
     */
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if the booking is approved
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if the booking is pending
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Calculate the number of nights.
     */
    public function getNightsAttribute()
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    /**
     * Get all available status options
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    /**
     * Scope for completed bookings
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope for reviewable bookings (completed and no review yet)
     */
    public function scopeReviewable($query)
    {
        return $query->where('status', self::STATUS_COMPLETED)
                    ->doesntHave('review');
    }
}
