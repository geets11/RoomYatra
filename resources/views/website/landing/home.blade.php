@extends('website.layouts.app')

@section('content')
   @php
       $properties = App\Models\Property::with(['propertyType', 'images', 'amenities', 'user'])
           ->where('status', '!=', 'rejected')
           ->withCount('reviews')
           ->withAvg('reviews', 'rating')
           ->orderByRaw("CASE 
               WHEN status = 'available' THEN 1 
               WHEN status = 'approved' THEN 2 
               WHEN status = 'booked' THEN 3 
               WHEN status = 'pending' THEN 4 
               ELSE 5 
           END")
           ->take(6)
           ->get();
   @endphp
   <!-- Hero Section -->
   <div class="relative bg-white overflow-hidden">
       <div class="max-w-7xl mx-auto">
           <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
               <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                   <div class="sm:text-center lg:text-left">
                       <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                           <span class="block xl:inline">Find your perfect</span>
                           <span class="block text-rose-600 xl:inline"> room today</span>
                       </h1>
                       <p
                           class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                           The easiest way to find and rent rooms. Browse listings from verified landlords or list your
                           property to find the perfect tenant.
                       </p>
                       <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                           <div class="rounded-md shadow">
                               <a href="{{ route('properties.index') }}"
                                   class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 md:py-4 md:text-lg md:px-10">
                                   Find a Room
                               </a>
                           </div>
                           <div class="mt-3 sm:mt-0 sm:ml-3">
                               <a href="{{ route('register') }}"
                                   class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-rose-600 bg-rose-100 hover:bg-rose-200 md:py-4 md:text-lg md:px-10">
                                   Get Started
                               </a>
                           </div>
                       </div>
                   </div>
               </main>
           </div>
       </div>
       <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
           <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
               src="{{ url('/') }}/images/bed30.jpeg" alt="Room rental">
       </div>
   </div>

   <!-- User Type Selection -->
   <div class="bg-white py-12">
       <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
           <div class="lg:text-center">
               <h2 class="text-base text-rose-600 font-semibold tracking-wide uppercase">Choose Your Role</h2>
               <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                   Are you a landlord or a tenant?
               </p>
           </div>

           <div class="mt-10">
               <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
                   <div class="pt-6">
                       <div
                           class="flow-root bg-gray-50 rounded-lg px-6 pb-8 border-2 border-gray-200 hover:border-rose-500 transition-all">
                           <div class="-mt-6">
                               <div>
                                   <span
                                       class="inline-flex items-center justify-center p-3 bg-rose-500 rounded-md shadow-lg">
                                       <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                           viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                               d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                       </svg>
                                   </span>
                               </div>
                               <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">I'm a Landlord</h3>
                               <p class="mt-5 text-base text-gray-500">
                                   List your properties, find reliable tenants, and manage your rentals all in one place.
                                   Our platform makes it easy to showcase your rooms and connect with potential tenants.
                               </p>
                               <div class="mt-6">
                                   <a href="{{ route('register') }}"
                                       class="inline-flex px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-rose-600 hover:bg-rose-700">
                                       List Your Property
                                   </a>
                               </div>
                           </div>
                       </div>
                   </div>

                   <div class="pt-6">
                       <div
                           class="flow-root bg-gray-50 rounded-lg px-6 pb-8 border-2 border-gray-200 hover:border-rose-500 transition-all">
                           <div class="-mt-6">
                               <div>
                                   <span
                                       class="inline-flex items-center justify-center p-3 bg-rose-500 rounded-md shadow-lg">
                                       <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                           viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                               d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                       </svg>
                                   </span>
                               </div>
                               <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">I'm a Tenant</h3>
                               <p class="mt-5 text-base text-gray-500">
                                   Find your perfect room from our wide selection of verified listings. Filter by location,
                                   price, and amenities to discover the ideal place to call home.
                               </p>
                               <div class="mt-6">
                                   <a href="{{ route('properties.index') }}"
                                       class="inline-flex px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-rose-600 hover:bg-rose-700">
                                       Find a Room
                                   </a>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <!-- Featured Rooms Section -->
   <div class="bg-gray-50 py-12">
       <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
           <div class="text-center">
               <h2 class="text-base text-rose-600 font-semibold tracking-wide uppercase">Featured Listings</h2>
               <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                   Discover Available Rooms
               </p>
               <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                   Browse our selection of quality rooms from verified landlords
               </p>
           </div>

           <div class="mt-10">
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
                                       <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                           fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                               d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                       </svg>
                                   </div>
                               @endif
                               <div
                                   class="absolute top-2 right-2 bg-white px-2 py-1 rounded-md text-sm font-semibold text-rose-600">
                                   {{ $property->propertyType->name }}
                               </div>
                               <!-- Status Badge -->
                               <div class="absolute top-2 left-2">
                                   @if($property->status === 'booked')
                                       <span class="bg-red-500 text-white px-2 py-1 rounded-md text-xs font-semibold">
                                           Booked
                                       </span>
                                   @elseif($property->status === 'available')
                                       <span class="bg-green-500 text-white px-2 py-1 rounded-md text-xs font-semibold">
                                           Available
                                       </span>
                                   @else
                                       <span class="bg-yellow-500 text-white px-2 py-1 rounded-md text-xs font-semibold">
                                           {{ ucfirst($property->status) }}
                                       </span>
                                   @endif
                               </div>
                           </div>
                           <div class="p-4">
                               <div class="flex justify-between items-start">
                                   <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $property->title }}</h3>
                                   <p class="text-lg font-bold text-rose-600">NPR
                                       {{ number_format($property->price, 0) }}<span
                                           class="text-sm text-gray-500">/{{ $property->price_type }}</span></p>
                               </div>
                               <p class="text-gray-500 text-sm mb-2">{{ $property->city }}, {{ $property->state }}</p>
                               <div class="flex items-center text-sm text-gray-600 mb-3">
                                   <div class="flex items-center mr-4">
                                       <svg class="h-4 w-4 text-gray-400 mr-1" xmlns="http://www.w3.org/2000/svg"
                                           fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                               d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                       </svg>
                                       {{ $property->bedrooms }} {{ Str::plural('bed', $property->bedrooms) }}
                                   </div>
                                   <div class="flex items-center">
                                       <svg class="h-4 w-4 text-gray-400 mr-1" xmlns="http://www.w3.org/2000/svg"
                                           fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                           ({{ $property->reviews_count ?? 0 }})
                                       </span>
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
                           <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                               fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                           </svg>
                           <h3 class="mt-2 text-sm font-medium text-gray-900">No properties found</h3>
                           <p class="mt-1 text-sm text-gray-500">Try adjusting your search filters or check back later for
                               new
                               listings.</p>
                       </div>
                   @endforelse
               </div>
               
               <!-- View All Properties Button -->
               <div class="text-center">
                   <a href="{{ route('properties.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                       View All Properties
                       <svg class="ml-2 -mr-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                       </svg>
                   </a>
               </div>
           </div>
       </div>
   </div>

   <!-- How It Works Section -->
   <div class="bg-white py-12">
       <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
           <div class="lg:text-center">
               <h2 class="text-base text-rose-600 font-semibold tracking-wide uppercase">How It Works</h2>
               <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                   Simple process, great results
               </p>
               <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                   Our platform makes finding or listing rooms quick and easy
               </p>
           </div>

           <div class="mt-10">
               <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                   <div class="relative">
                       <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                           <span class="text-lg font-bold">1</span>
                       </div>
                       <div class="ml-16">
                           <h3 class="text-lg leading-6 font-medium text-gray-900">Create an Account</h3>
                           <p class="mt-2 text-base text-gray-500">
                               Sign up as a landlord or tenant to access our platform's features.
                           </p>
                       </div>
                   </div>

                   <div class="relative">
                       <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                           <span class="text-lg font-bold">2</span>
                       </div>
                       <div class="ml-16">
                           <h3 class="text-lg leading-6 font-medium text-gray-900">Browse or List</h3>
                           <p class="mt-2 text-base text-gray-500">
                               Search for available rooms or list your property with detailed information.
                           </p>
                       </div>
                   </div>

                   <div class="relative">
                       <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                           <span class="text-lg font-bold">3</span>
                       </div>
                       <div class="ml-16">
                           <h3 class="text-lg leading-6 font-medium text-gray-900">Connect</h3>
                           <p class="mt-2 text-base text-gray-500">
                               Message landlords or tenants directly through our secure messaging system.
                           </p>
                       </div>
                   </div>

                   <div class="relative">
                       <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                           <span class="text-lg font-bold">4</span>
                       </div>
                       <div class="ml-16">
                           <h3 class="text-lg leading-6 font-medium text-gray-900">Finalize</h3>
                           <p class="mt-2 text-base text-gray-500">
                               Schedule viewings, sign agreements, and manage payments all in one place.
                           </p>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <!-- Testimonials -->
   <div class="bg-gray-50 py-12">
       <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
           <div class="text-center">
               <h2 class="text-base text-rose-600 font-semibold tracking-wide uppercase">Testimonials</h2>
               <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                   What Our Users Say
               </p>
           </div>
           <div class="mt-10">
               <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                   <div class="bg-white p-6 rounded-lg shadow">
                       <div class="flex items-center mb-4">
                           <img class="h-12 w-12 rounded-full" src="https://placehold.co/100/rose/white?text=J"
                               alt="User">
                           <div class="ml-4">
                               <h4 class="text-lg font-bold">Geeta</h4>
                               <p class="text-gray-500">Tenant</p>
                           </div>
                       </div>
                       <p class="text-gray-600">
                           "I found my dream apartment in just two days using this platform. The filtering options made it
                           easy to find exactly what I was looking for."
                       </p>
                       <div class="mt-4 flex text-rose-500">
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                       </div>
                   </div>

                   <div class="bg-white p-6 rounded-lg shadow">
                       <div class="flex items-center mb-4">
                           <img class="h-12 w-12 rounded-full" src="https://placehold.co/100/rose/white?text=S"
                               alt="User">
                           <div class="ml-4">
                               <h4 class="text-lg font-bold">Raju</h4>
                               <p class="text-gray-500">Landlord</p>
                           </div>
                       </div>
                       <p class="text-gray-600">
                           "As a landlord, I've been able to find reliable tenants quickly. The platform handles all the
                           initial screening, saving me tons of time."
                       </p>
                       <div class="mt-4 flex text-rose-500">
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                       </div>
                   </div>

                   <div class="bg-white p-6 rounded-lg shadow">
                       <div class="flex items-center mb-4">
                           <img class="h-12 w-12 rounded-full" src="https://placehold.co/100/rose/white?text=M"
                               alt="User">
                           <div class="ml-4">
                               <h4 class="text-lg font-bold">Reyom</h4>
                               <p class="text-gray-500">Tenant</p>
                           </div>
                       </div>
                       <p class="text-gray-600">
                           "The virtual tours feature saved me so much time. I was able to narrow down my options before
                           scheduling in-person viewings."
                       </p>
                       <div class="mt-4 flex text-rose-500">
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                           <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                               <path
                                   d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                           </svg>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <!-- CTA Section -->
   <div class="bg-rose-700">
       <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
           <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
               <span class="block">Ready to find your perfect room?</span>
               <span class="block text-rose-200">Join our platform today.</span>
           </h2>
           <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
               <div class="inline-flex rounded-md shadow">
                   <a href="#"
                       class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-rose-600 bg-white hover:bg-rose-50">
                       Get Started
                   </a>
               </div>
               <div class="ml-3 inline-flex rounded-md shadow">
                   <a href="#"
                       class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-rose-600 hover:bg-rose-500">
                       Learn More
                   </a>
               </div>
           </div>
       </div>
   </div>
@endsection
