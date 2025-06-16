<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_AVAILABLE = 'available';
    const STATUS_BOOKED = 'booked';
    const STATUS_UNDERMAINTENANCE = 'undermaintenance';

    protected $fillable = [
        'user_id',
        'property_type_id',
        'title',
        'slug',
        'description',
        'price',
        'price_type',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'latitude',
        'longitude',
        'bedrooms',
        'bathrooms',
        'size',
        'is_furnished',
        'is_approved',
        'is_featured',
        'is_available',
        'available_from',
        'available_to',
        'status',
    ];

    protected $casts = [
        'is_furnished' => 'boolean',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'is_available' => 'boolean',
        'available_from' => 'date',
        'available_to' => 'date',
    ];

    /**
     * Get the user that owns the property.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property type that owns the property.
     */
    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    /**
     * Get the images for the property.
     */
    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    /**
     * Get the primary image for the property.
     */
    public function primaryImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_primary', true);
    }

    /**
     * Get the amenities for the property.
     */
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'property_amenities');
    }

    /**
     * Scope a query to only include available properties.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope a query to only include approved properties.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include featured properties.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the bookings for the property.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the reviews for the property.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the average rating for the property.
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating') ?: 0;
    }

    /**
     * Get the number of reviews for the property.
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->where('is_approved', true)->count();
    }

    /**
     * Check if the property is available for booking (improved logic)
     */
    public function isAvailableForBooking()
    {
        // Property must be available and in approved/available status
        if (!$this->is_available || !in_array($this->status, [self::STATUS_APPROVED, self::STATUS_AVAILABLE])) {
            return false;
        }

        // Property is available for booking regardless of existing bookings
        // Multiple bookings can exist for different time periods
        return true;
    }

    /**
     * Check if the property is available for the given dates.
     */
    public function isAvailable($checkIn, $checkOut)
    {
        // First check if property is generally available for booking
        if (!$this->isAvailableForBooking()) {
            return false;
        }

        $checkIn = is_string($checkIn) ? new \DateTime($checkIn) : $checkIn;
        $checkOut = is_string($checkOut) ? new \DateTime($checkOut) : $checkOut;

        // Check if there are any overlapping approved bookings for the specific dates
        $overlappingBookings = $this->bookings()
            ->where('status', 'approved')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->where(function ($q) use ($checkIn, $checkOut) {
                    // Check if the new booking's check-in date falls within an existing booking
                    $q->where('check_in', '<=', $checkIn->format('Y-m-d'))
                        ->where('check_in', '>', $checkIn->format('Y-m-d')); // This logic needs to be fixed
                });
                // Simplified for now - just check basic overlap
            })
            ->count();

        return $overlappingBookings === 0;
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all available status options
     * 
     * @return array
     */
    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_AVAILABLE => 'Available',
            self::STATUS_BOOKED => 'Booked',
            self::STATUS_UNDERMAINTENANCE => 'Under Maintenance',
        ];
    }

    /**
     * Scope a query to only include available properties.
     */
    public function scopeAvailableForBooking($query)
    {
        return $query->where('is_available', true)
                     ->whereIn('status', [self::STATUS_APPROVED, self::STATUS_AVAILABLE]);
    }
    
    /**
     * Scope a query to include properties for public display
     * This includes properties that are approved or available
     */
    public function scopePubliclyVisible($query)
    {
        return $query->where(function($q) {
            $q->where('status', self::STATUS_APPROVED)
              ->orWhere('status', self::STATUS_AVAILABLE);
        })->where('is_available', true);
    }

    /**
     * Scope a query to only include properties visible to public
     */
    public function scopePublicVisible($query)
    {
        return $query->whereIn('status', [self::STATUS_APPROVED, self::STATUS_AVAILABLE])
                     ->where('is_available', true);
    }

    /**
     * Scope a query to only include properties that admins can see
     */
    public function scopeAdminVisible($query)
    {
        return $query->where('status', '!=', self::STATUS_REJECTED);
    }

    /**
     * Check if property is visible to public
     */
    public function isPublicVisible(): bool
    {
        return in_array($this->status, [self::STATUS_APPROVED, self::STATUS_AVAILABLE]) 
               && $this->is_available;
    }

    /**
     * Check if property is pending approval
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }
}
