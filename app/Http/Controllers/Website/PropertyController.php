<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    /**
     * Display a listing of available properties for public
     */
    public function index(Request $request)
    {
        try {
            Log::info('PropertyController@index called with request: ' . json_encode($request->all()));
        
            // Show approved, available, and booked properties to public
            $query = Property::with(['images', 'propertyType', 'amenities', 'user', 'reviews', 'bookings.user'])
                ->whereIn('status', [Property::STATUS_APPROVED, Property::STATUS_AVAILABLE, Property::STATUS_BOOKED]);

            // Search filters
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            if ($request->filled('city')) {
                $query->where('city', 'like', '%' . $request->city . '%');
            }

            if ($request->filled('property_type')) {
                $query->where('property_type_id', $request->property_type);
            }

            if ($request->filled('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }

            if ($request->filled('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            // Bedrooms filter
            if ($request->filled('bedrooms')) {
                $query->where('bedrooms', '>=', $request->bedrooms);
            }

            // Bathrooms filter
            if ($request->filled('bathrooms')) {
                $query->where('bathrooms', '>=', $request->bathrooms);
            }

            // Furnished filter
            if ($request->filled('is_furnished')) {
                $query->where('is_furnished', $request->is_furnished == '1');
            }

            // Status filter
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Amenities filter
            if ($request->filled('amenities')) {
                $amenityIds = $request->amenities;
                $query->whereHas('amenities', function($q) use ($amenityIds) {
                    $q->whereIn('amenities.id', $amenityIds);
                });
            }

            // Sorting
            $sortBy = $request->get('sort_by', 'default');
            $sortOrder = $request->get('sort_order', 'asc');

            switch ($sortBy) {
                case 'price_low_high':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high_low':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'rating':
                    $query->withAvg('reviews as avg_rating', 'rating')
                          ->orderBy('avg_rating', 'desc');
                    break;
                case 'title':
                    $query->orderBy('title', $sortOrder);
                    break;
                case 'bedrooms':
                    $query->orderBy('bedrooms', $sortOrder);
                    break;
                default:
                    // Default sorting: available first, then by status priority
                    $query->orderByRaw("CASE 
                        WHEN status = 'available' THEN 1 
                        WHEN status = 'approved' THEN 2 
                        WHEN status = 'booked' THEN 3 
                        WHEN status = 'pending' THEN 4 
                        ELSE 5 
                    END")
                    ->orderBy('created_at', 'desc');
                    break;
            }

            $properties = $query->paginate(12)->appends($request->query());
            $propertyTypes = PropertyType::all();
            $amenities = Amenity::all();

            // Get unique cities for filter dropdown
            $cities = Property::whereIn('status', [Property::STATUS_APPROVED, Property::STATUS_AVAILABLE, Property::STATUS_BOOKED])
                             ->distinct()
                             ->pluck('city')
                             ->filter()
                             ->sort()
                             ->values();

            // Get price range for slider
            $priceRange = Property::whereIn('status', [Property::STATUS_APPROVED, Property::STATUS_AVAILABLE, Property::STATUS_BOOKED])
                                 ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
                                 ->first();

            Log::info('Properties found: ' . $properties->count());

            return view('website.properties.index', compact(
                'properties', 
                'propertyTypes', 
                'amenities', 
                'cities', 
                'priceRange'
            ));
        } catch (\Exception $e) {
            Log::error('Error in PropertyController@index: ' . $e->getMessage());
            return view('website.properties.index', [
                'properties' => collect(),
                'propertyTypes' => PropertyType::all(),
                'amenities' => Amenity::all(),
                'cities' => collect(),
                'priceRange' => (object)['min_price' => 0, 'max_price' => 100000],
            ])->withErrors(['error' => 'An error occurred while loading properties.']);
        }
    }

    /**
     * Show property details - Now shows booked properties with tenant info
     */
    public function show(Property $property)
    {
        // Allow viewing of approved, available, and booked properties
        if (!in_array($property->status, [Property::STATUS_APPROVED, Property::STATUS_AVAILABLE, Property::STATUS_BOOKED])) {
            abort(404, 'Property not available');
        }

        // Load all necessary relationships including current booking
        $property->load([
            'images', 
            'amenities', 
            'propertyType', 
            'user', 
            'reviews' => function($query) {
                $query->where('is_approved', true)->with('user');
            },
            'bookings' => function($query) {
                $query->with('user')->latest();
            }
        ]);
        
        // Get current booking (if any)
        $currentBooking = $property->bookings()
            ->where('status', 'approved')
            ->where('check_in', '<=', now())
            // ->where('check_out', '>=', now())
            ->with('user')
            ->first();
        
        // Get upcoming booking (if any)
        $upcomingBooking = $property->bookings()
            ->where('status', 'approved')
            ->where('check_in', '>', now())
            ->with('user')
            ->orderBy('check_in')
            ->first();
        
        // Check if property is actually available for booking
        $isAvailableForBooking = $property->status === 'available' && !$currentBooking && !$upcomingBooking;
        
        // Calculate average rating
        $property->loadAvg('reviews', 'rating');
        
        // Get similar properties
        $similarProperties = Property::with(['images', 'propertyType'])
            ->where('id', '!=', $property->id)
            ->where('property_type_id', $property->property_type_id)
            ->whereIn('status', [Property::STATUS_APPROVED, Property::STATUS_AVAILABLE, Property::STATUS_BOOKED])
            ->limit(3)
            ->get();
        
        Log::info('Showing property: ' . $property->title . ' (ID: ' . $property->id . ', Status: ' . $property->status . ')');
        
        return view('website.property-details', compact('property', 'similarProperties', 'currentBooking', 'upcomingBooking', 'isAvailableForBooking'));
    }

    /**
     * Search for properties via AJAX.
     */
    public function search(Request $request)
    {
        $query = Property::with(['images', 'propertyType', 'bookings.user'])
            ->whereIn('status', [Property::STATUS_APPROVED, Property::STATUS_AVAILABLE, Property::STATUS_BOOKED]);

        // Apply search filters
        if ($request->has('keyword') && $request->keyword) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%")
                  ->orWhere('city', 'like', "%{$keyword}%");
            });
        }

        // Apply other filters
        if ($request->has('city') && $request->city) {
            $query->where('city', $request->city);
        }

        if ($request->has('property_type') && $request->property_type) {
            $query->where('property_type_id', $request->property_type);
        }

        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        $properties = $query->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'properties' => $properties,
                'html' => view('website.properties._property_list', compact('properties'))->render()
            ]);
        }

        return $properties;
    }
}
