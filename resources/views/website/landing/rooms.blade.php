@extends('website.layouts.app')

@section('content')
    <!-- Page Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Find Your Perfect Space</h1>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <form action="{{ route('rooms') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" value="{{ request('location') }}"
                            placeholder="City, State"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    </div>
                    <div>
                        <label for="property_type" class="block text-sm font-medium text-gray-700">Property Type</label>
                        <select name="property_type" id="property_type"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                            <option value="">All Types</option>
                            @foreach ($propertyTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ request('property_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="price_range" class="block text-sm font-medium text-gray-700">Price Range</label>
                        <select name="price_range" id="price_range"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                            <option value="">Any Price</option>
                            <option value="0-500" {{ request('price_range') == '0-500' ? 'selected' : '' }}>NPR 0 - NPR 500
                            </option>
                            <option value="500-1000" {{ request('price_range') == '500-1000' ? 'selected' : '' }}>NPR 500 -
                                NPR 1,000</option>
                            <option value="1000-1500" {{ request('price_range') == '1000-1500' ? 'selected' : '' }}>NPR 1,000 -
                                NPR 1,500</option>
                            <option value="1500-2000" {{ request('price_range') == '1500-2000' ? 'selected' : '' }}>NPR 1,500 -
                                NPR 2,000</option>
                            <option value="2000+" {{ request('price_range') == '2000+' ? 'selected' : '' }}>NPR 2,000+
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="bedrooms" class="block text-sm font-medium text-gray-700">Bedrooms</label>
                        <select name="bedrooms" id="bedrooms"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                            <option value="">Any</option>
                            <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+ Bedroom</option>
                            <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+ Bedrooms</option>
                            <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+ Bedrooms</option>
                            <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+ Bedrooms</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="bathrooms" class="block text-sm font-medium text-gray-700">Bathrooms</label>
                        <select name="bathrooms" id="bathrooms"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                            <option value="">Any</option>
                            <option value="1" {{ request('bathrooms') == '1' ? 'selected' : '' }}>1+ Bathroom</option>
                            <option value="2" {{ request('bathrooms') == '2' ? 'selected' : '' }}>2+ Bathrooms
                            </option>
                            <option value="3" {{ request('bathrooms') == '3' ? 'selected' : '' }}>3+ Bathrooms
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="amenities" class="block text-sm font-medium text-gray-700">Amenities</label>
                        <select name="amenities[]" id="amenities" multiple
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                            @foreach ($amenities as $amenity)
                                <option value="{{ $amenity->id }}"
                                    {{ in_array($amenity->id, request('amenities', [])) ? 'selected' : '' }}>
                                    {{ $amenity->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="availability" class="block text-sm font-medium text-gray-700">Availability</label>
                        <select name="availability" id="availability"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                            <option value="">Any Time</option>
                            <option value="immediate" {{ request('availability') == 'immediate' ? 'selected' : '' }}>
                                Immediate</option>
                            <option value="within_week" {{ request('availability') == 'within_week' ? 'selected' : '' }}>
                                Within a Week</option>
                            <option value="within_month" {{ request('availability') == 'within_month' ? 'selected' : '' }}>
                                Within a Month</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Count and Sort -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <p class="text-gray-600 mb-4 md:mb-0">{{ $properties->total() }} properties found</p>
            <div class="flex items-center">
                <label for="sort" class="mr-2 text-sm font-medium text-gray-700">Sort by:</label>
                <select id="sort" name="sort" onchange="window.location.href=this.value"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                    <option value="{{ route('rooms', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}"
                        {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="{{ route('rooms', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}"
                        {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('rooms', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}"
                        {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="{{ route('rooms', array_merge(request()->except('sort'), ['sort' => 'rating'])) }}"
                        {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                </select>
            </div>
        </div>

        <!-- Property Listings -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($properties as $property)
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="relative h-48">
                        @if ($property->images->count() > 0)
                            <img src="{{ asset('storage/' . ($property->primaryImage ? $property->primaryImage->image_path : $property->images->first()->image_path)) }}"
                                alt="{{ $property->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                        @endif
                        <div
                            class="absolute top-2 right-2 bg-white px-2 py-1 rounded-md text-sm font-semibold text-rose-600">
                            {{ $property->propertyType->name }}
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $property->title }}</h3>
                            <p class="text-lg font-bold text-rose-600">NPR {{ number_format($property->price, 0) }}<span
                                    class="text-sm text-gray-500">/{{ $property->price_type }}</span></p>
                        </div>
                        <p class="text-gray-500 text-sm mb-2">{{ $property->city }}, {{ $property->state }}</p>
                        <div class="flex items-center text-sm text-gray-600 mb-3">
                            <div class="flex items-center mr-4">
                                <svg class="h-4 w-4 text-gray-400 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                {{ $property->bedrooms }} {{ Str::plural('bed', $property->bedrooms) }}
                            </div>
                            <div class="flex items-center">
                                <svg class="h-4 w-4 text-gray-400 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                                {{ $property->bathrooms }} {{ Str::plural('bath', $property->bathrooms) }}
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach ($property->amenities->take(3) as $amenity)
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $amenity->name }}
                                </span>
                            @endforeach
                            @if ($property->amenities->count() > 3)
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                    +{{ $property->amenities->count() - 3 }} more
                                </span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span
                                    class="text-sm text-gray-600 ml-1">{{ number_format($property->reviews_avg_rating ?? 0, 1) }}
                                    ({{ $property->reviews_count ?? 0 }})</span>
                            </div>
                            <a href="{{ route('properties.show', $property->id) }}"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-lg shadow-md p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No properties found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search filters or check back later for new
                        listings.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $properties->appends(request()->query())->links() }}
        </div>
    </div>

@endsection
