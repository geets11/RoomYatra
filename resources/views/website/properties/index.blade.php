@extends('website.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                Find Your Perfect Room
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                Browse our selection of quality rooms and apartments available for rent
            </p>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <form action="{{ route('properties.index') }}" method="GET" class="space-y-6">
                <!-- Search Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500"
                            placeholder="Location, property name, description...">
                    </div>

                    <div>
                        <label for="property_type" class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                        <select id="property_type" name="property_type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            <option value="">All Types</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type->id }}" {{ request('property_type') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                        <select id="city" name="city" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            <option value="">All Cities</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Price Range and Property Details Row -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" 
                                class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500"
                                placeholder="Min ({{ number_format($priceRange->min_price ?? 0) }})">
                            <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" 
                                class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500"
                                placeholder="Max ({{ number_format($priceRange->max_price ?? 100000) }})">
                        </div>
                    </div>

                    <div>
                        <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-2">Min Bedrooms</label>
                        <select id="bedrooms" name="bedrooms" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            <option value="">Any</option>
                            <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+</option>
                            <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+</option>
                            <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+</option>
                            <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+</option>
                        </select>
                    </div>

                    <div>
                        <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-2">Min Bathrooms</label>
                        <select id="bathrooms" name="bathrooms" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            <option value="">Any</option>
                            <option value="1" {{ request('bathrooms') == '1' ? 'selected' : '' }}>1+</option>
                            <option value="2" {{ request('bathrooms') == '2' ? 'selected' : '' }}>2+</option>
                            <option value="3" {{ request('bathrooms') == '3' ? 'selected' : '' }}>3+</option>
                        </select>
                    </div>

                    <div>
                        <label for="is_furnished" class="block text-sm font-medium text-gray-700 mb-2">Furnished</label>
                        <select id="is_furnished" name="is_furnished" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            <option value="">Any</option>
                            <option value="1" {{ request('is_furnished') == '1' ? 'selected' : '' }}>Furnished</option>
                            <option value="0" {{ request('is_furnished') == '0' ? 'selected' : '' }}>Unfurnished</option>
                        </select>
                    </div>
                </div>

                <!-- Status Filter Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Availability Status</label>
                        <select id="status" name="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            <option value="">All Status</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                    </div>
                </div>

                <!-- Amenities Section -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Amenities</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                        @foreach($amenities as $amenity)
                            <div class="flex items-center">
                                <input id="amenity-{{ $amenity->id }}" name="amenities[]" type="checkbox" value="{{ $amenity->id }}"
                                    {{ in_array($amenity->id, request('amenities', [])) ? 'checked' : '' }}
                                    class="h-4 w-4 text-rose-600 focus:ring-rose-500 border-gray-300 rounded">
                                <label for="amenity-{{ $amenity->id }}" class="ml-2 text-sm text-gray-700">
                                    {{ $amenity->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('properties.index') }}" 
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                        Reset
                    </a>
                    <button type="submit" 
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Section -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="text-2xl font-bold text-gray-900">
                    Available Properties
                    <span class="text-lg font-normal text-gray-500">({{ $properties->total() }} found)</span>
                </h2>
                
                <!-- Sort Options -->
                <div class="flex items-center space-x-4">
                    <label for="sort_by" class="text-sm font-medium text-gray-700">Sort by:</label>
                    <form action="{{ route('properties.index') }}" method="GET" id="sortForm" class="flex items-center space-x-2">
                        <!-- Preserve all current filters -->
                        @foreach(request()->except(['sort_by', 'sort_order']) as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $item)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        
                        <select name="sort_by" id="sort_by" onchange="document.getElementById('sortForm').submit()"
                            class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500 text-sm">
                            <option value="default" {{ request('sort_by') == 'default' ? 'selected' : '' }}>Default</option>
                            <option value="price_low_high" {{ request('sort_by') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high_low" {{ request('sort_by') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="rating" {{ request('sort_by') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Name A-Z</option>
                            <option value="bedrooms" {{ request('sort_by') == 'bedrooms' ? 'selected' : '' }}>Most Bedrooms</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Properties Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($properties as $property)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <!-- Property Image -->
                    <div class="relative h-48">
                        @if($property->images->count() > 0)
                            <img src="{{ asset('storage/' . $property->images->first()->image_path) }}" 
                                alt="{{ $property->title }}" 
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Property Type Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="bg-white px-2 py-1 rounded-md text-sm font-semibold text-rose-600">
                                {{ $property->propertyType->name ?? 'Property' }}
                            </span>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 left-3">
                            @if($property->status === 'booked')
                                <span class="bg-red-500 text-white px-3 py-1 rounded-md text-xs font-semibold shadow-lg">
                                    🚫 BOOKED
                                </span>
                            @elseif($property->status === 'available')
                                <span class="bg-green-500 text-white px-3 py-1 rounded-md text-xs font-semibold shadow-lg">
                                    ✅ AVAILABLE
                                </span>
                            @else
                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-md text-xs font-semibold shadow-lg">
                                    {{ strtoupper($property->status) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $property->title }}</h3>
                            <div class="text-right">
                                <p class="text-lg font-bold text-rose-600">
                                    NPR {{ number_format($property->price, 0) }}
                                </p>
                                <p class="text-sm text-gray-500">/{{ $property->price_type ?? 'month' }}</p>
                            </div>
                        </div>
                        
                        <p class="text-gray-500 text-sm mb-3 flex items-center">
                            <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $property->city }}, {{ $property->state }}
                        </p>

                        <!-- Current Booking Info (if booked) -->
                        @if($property->status === 'booked')
                            @php
                                $currentBooking = $property->bookings->where('status', 'approved')
                                    ->where('check_in', '<=', now())
                                    ->where('check_out', '>=', now())
                                    ->first();
                            @endphp
                            @if($currentBooking)
                                <div class="bg-red-50 border border-red-200 rounded-md p-2 mb-3">
                                    <p class="text-xs text-red-700 font-medium">Currently occupied by:</p>
                                    <p class="text-sm text-red-800">{{ $currentBooking->user->name }}</p>
                                    <p class="text-xs text-red-600">Until {{ $currentBooking->check_out->format('M d, Y') }}</p>
                                </div>
                            @endif
                        @endif

                        <!-- Property Features -->
                        <div class="flex items-center text-sm text-gray-600 mb-3 space-x-4">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                {{ $property->bedrooms }} bed{{ $property->bedrooms > 1 ? 's' : '' }}
                            </div>
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                                {{ $property->bathrooms }} bath{{ $property->bathrooms > 1 ? 's' : '' }}
                            </div>
                        </div>

                        <!-- Amenities Preview -->
                        @if($property->amenities->count() > 0)
                            <div class="flex flex-wrap gap-1 mb-4">
                                @foreach($property->amenities->take(3) as $amenity)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $amenity->name }}
                                    </span>
                                @endforeach
                                @if($property->amenities->count() > 3)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        +{{ $property->amenities->count() - 3 }} more
                                    </span>
                                @endif
                            </div>
                        @endif

                        <!-- Action Button -->
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="ml-1 text-sm text-gray-600">
                                    {{ number_format($property->avg_rating ?? $property->average_rating ?? 0, 1) }} 
                                    ({{ $property->reviews->where('is_approved', true)->count() }})
                                </span>
                            </div>
                            @if($property->status === 'booked')
                                <span class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-600 bg-red-50 cursor-not-allowed">
                                    View Details (Booked)
                                </span>
                            @else
                                <a href="{{ route('properties.show', $property->id) }}" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-colors duration-200">
                                    View Details
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No properties found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search filters or check back later for new listings.</p>
                        <div class="mt-6">
                            <a href="{{ route('properties.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700">
                                Clear Filters
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($properties->hasPages())
            <div class="flex justify-center">
                {{ $properties->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
