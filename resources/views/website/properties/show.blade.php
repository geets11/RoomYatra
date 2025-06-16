<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $property->title }} - RoomYatra</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-blue-600">
                        🏠 RoomYatra
                    </a>
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                        <a href="/" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">Home</a>
                        <a href="{{ route('rooms') }}" class="text-blue-600 px-3 py-2 text-sm font-medium border-b-2 border-blue-600">Rooms</a>
                        <a href="{{ route('howitworks') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">How It Works</a>
                        <a href="{{ route('contact') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">Contact</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @if(Auth::check())
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="hidden md:block">{{ Auth::user()->name }}</span>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                @if(Auth::user()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                @elseif(Auth::user()->hasRole('landlord'))
                                    <a href="{{ route('landlord.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                @elseif(Auth::user()->hasRole('tenant'))
                                    <a href="{{ route('tenant.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    <a href="{{ route('tenant.bookings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Bookings</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">Log in</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Sign up</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4 text-sm">
                <li><a href="/" class="text-gray-500 hover:text-gray-700">Home</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><a href="{{ route('rooms') }}" class="text-gray-500 hover:text-gray-700">Properties</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li class="text-gray-900 font-medium">{{ $property->title }}</li>
            </ol>
        </nav>

        <!-- Property Header -->
        <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
            <div class="relative h-80">
                @if($property->images->count() > 0)
                    <img src="{{ $property->images->first()->image_url }}" 
                         alt="{{ $property->title }}" 
                         class="w-full h-full object-cover"
                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&h=600&q=80';"
                         loading="lazy">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                        <span class="text-6xl">🏠</span>
                    </div>
                @endif
                <div class="absolute top-4 right-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        {{ ucfirst($property->status) }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $property->title }}</h1>
                        <p class="text-lg text-gray-600 mb-4">📍 {{ $property->address }}, {{ $property->city }}, {{ $property->state }}</p>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $property->propertyType->name }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                Available from {{ \Carbon\Carbon::parse($property->available_from)->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 md:mt-0 md:text-right">
                        <div class="text-3xl font-bold text-blue-600">NPR {{ number_format($property->price, 0) }}</div>
                        <div class="text-sm text-gray-500">per {{ $property->price_type }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Property Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Current Booking Status -->
                @if($currentBooking || $upcomingBooking || $property->status === 'booked')
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Current Booking Status</h2>
                        
                        @if($currentBooking)
                            <!-- Currently Occupied -->
                            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Currently Occupied</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p><strong>Tenant:</strong> {{ $currentBooking->user->name }}</p>
                                            <p><strong>Email:</strong> {{ $currentBooking->user->email }}</p>
                                            <p><strong>Check-out:</strong> {{ $currentBooking->check_out->format('M d, Y') }}</p>
                                            <p><strong>Duration:</strong> {{ $currentBooking->check_in->diffInDays($currentBooking->check_out) }} days</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($upcomingBooking)
                            <!-- Upcoming Booking -->
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Upcoming Booking</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p><strong>Tenant:</strong> {{ $upcomingBooking->user->name }}</p>
                                            <p><strong>Email:</strong> {{ $upcomingBooking->user->email }}</p>
                                            <p><strong>Check-in:</strong> {{ $upcomingBooking->check_in->format('M d, Y') }}</p>
                                            <p><strong>Check-out:</strong> {{ $upcomingBooking->check_out->format('M d, Y') }}</p>
                                            <p><strong>Days until check-in:</strong> {{ now()->diffInDays($upcomingBooking->check_in) }} days</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Available -->
                            <div class="bg-green-50 border-l-4 border-green-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">Available for Booking</h3>
                                        <div class="mt-2 text-sm text-green-700">
                                            <p>This property is currently available for new bookings.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Property Features -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Property Features</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->bedrooms }}</div>
                            <div class="text-sm text-gray-600">🛏️ Bedrooms</div>
                        </div>
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->bathrooms }}</div>
                            <div class="text-sm text-gray-600">🚿 Bathrooms</div>
                        </div>
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->size }}</div>
                            <div class="text-sm text-gray-600">📐 Sq Ft</div>
                        </div>
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $property->furnished ? 'Yes' : 'No' }}</div>
                            <div class="text-sm text-gray-600">🪑 Furnished</div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Description</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $property->description }}</p>
                </div>

                <!-- Photo Gallery -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Photo Gallery</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @if($property->images->count() > 0)
                            @foreach($property->images->take(6) as $image)
                                <div class="relative">
                                    <img src="{{ $image->image_url }}" 
                                         alt="{{ $property->title }}" 
                                         class="w-full h-32 object-cover rounded-lg"
                                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300&q=80';"
                                         loading="lazy">
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-full bg-gray-100 rounded-lg h-48 flex items-center justify-center">
                                <div class="text-center text-gray-500">
                                    <div class="text-4xl mb-2">🏠</div>
                                    <p>No images available</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Amenities -->
                @if($property->amenities->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Amenities</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($property->amenities as $amenity)
                            <div class="flex items-center space-x-2 p-2 bg-blue-50 rounded-lg">
                                <div class="w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs">✓</span>
                                </div>
                                <span class="text-sm text-gray-700">{{ $amenity->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Reviews -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Reviews & Ratings</h2>
                    
                    @if($property->reviews->count() > 0)
                        <div class="mb-6 p-4 bg-yellow-50 rounded-lg">
                            <div class="flex items-center justify-center space-x-4">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-xl {{ $i <= ($property->reviews_avg_rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}">⭐</span>
                                    @endfor
                                </div>
                                <span class="text-xl font-semibold">{{ number_format($property->reviews_avg_rating ?? 0, 1) }}</span>
                                <span class="text-gray-600">({{ $property->reviews->count() }} reviews)</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @foreach($property->reviews->take(3) as $review)
                                <div class="border-b border-gray-200 pb-4 last:border-b-0">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-medium text-gray-900">{{ $review->user->name }}</h4>
                                                <div class="flex items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span class="text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">⭐</span>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-500 mb-1">{{ $review->created_at->format('M d, Y') }}</p>
                                            <p class="text-gray-700">{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-4xl mb-2">⭐</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">No reviews yet</h3>
                            <p class="text-gray-500">Be the first to review this property!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 space-y-6">
                    <!-- Property Information -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Property Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Type:</span>
                                <span class="font-medium">{{ $property->propertyType->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Available From:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($property->available_from)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium">{{ ucfirst($property->status) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Listed by:</span>
                                <span class="font-medium">{{ $property->user->name }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Section -->
                    @if(!Auth::check())
                        <!-- Login to Book Section - For non-logged in users -->
                        <div class="bg-white rounded-lg shadow p-6 text-center">
                            <div class="text-3xl mb-3">🔐</div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Login Required</h3>
                            <p class="text-gray-600 mb-4">Please log in to book this property</p>
                            <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-blue-700 w-full text-center">
                                Login to Book
                            </a>
                        </div>
                    @elseif(Auth::check() && Auth::user()->hasRole('tenant'))
                        @if($currentBooking)
                            <!-- Property is currently occupied -->
                            <div class="bg-white rounded-lg shadow p-6 text-center">
                                <div class="text-3xl mb-3">🏠</div>
                                <h3 class="text-lg font-semibold text-red-600 mb-2">Currently Occupied</h3>
                                <p class="text-gray-600 mb-4">This property is currently booked by another tenant</p>
                                <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                                    <p class="text-sm text-red-700">
                                        <strong>Occupied by:</strong> {{ $currentBooking->user->name }}<br>
                                        <strong>Available after:</strong> {{ $currentBooking->check_out->format('M d, Y') }}
                                    </p>
                                </div>
                                <div class="bg-red-100 text-red-600 py-2 px-4 rounded-md text-sm font-medium cursor-not-allowed">
                                    ❌ Not Available for Booking
                                </div>
                            </div>
                        @elseif($upcomingBooking)
                            <!-- Property has upcoming booking -->
                            <div class="bg-white rounded-lg shadow p-6 text-center">
                                <div class="text-3xl mb-3">📅</div>
                                <h3 class="text-lg font-semibold text-yellow-600 mb-2">Booking Scheduled</h3>
                                <p class="text-gray-600 mb-4">This property has an upcoming booking</p>
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                                    <p class="text-sm text-yellow-700">
                                        <strong>Booked by:</strong> {{ $upcomingBooking->user->name }}<br>
                                        <strong>From:</strong> {{ $upcomingBooking->check_in->format('M d, Y') }} to {{ $upcomingBooking->check_out->format('M d, Y') }}
                                    </p>
                                </div>
                                <div class="bg-yellow-100 text-yellow-600 py-2 px-4 rounded-md text-sm font-medium cursor-not-allowed">
                                    ⏳ Booking Pending
                                </div>
                            </div>
                        @elseif($property->status === 'booked')
                            <!-- Property status is booked but no specific booking found -->
                            <div class="bg-white rounded-lg shadow p-6 text-center">
                                <div class="text-3xl mb-3">🚫</div>
                                <h3 class="text-lg font-semibold text-red-600 mb-2">Currently Booked</h3>
                                <p class="text-gray-600 mb-4">This property is currently not available for new bookings</p>
                                <div class="bg-red-100 text-red-600 py-2 px-4 rounded-md text-sm font-medium cursor-not-allowed">
                                    ❌ Not Available for Booking
                                </div>
                            </div>
                        @elseif($isAvailableForBooking && $property->status === 'available')
                            <!-- Property is available for booking -->
                            <div class="bg-white rounded-lg shadow p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Book this Property</h3>
                                <form action="{{ route('tenant.bookings.store', $property->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Check-in Date</label>
                                        <input type="text" name="check_in" id="check_in" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Select date" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Number of Guests</label>
                                        <select name="guests" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" required>
                                            <option value="1">1 Guest</option>
                                            <option value="2">2 Guests</option>
                                            <option value="3">3 Guests</option>
                                            <option value="4">4 Guests</option>
                                            <option value="5">5+ Guests</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Message (Optional)</label>
                                        <textarea name="message" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 resize-none" placeholder="Tell the host about your visit..."></textarea>
                                    </div>
                                    <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-green-700">
                                        🎯 Request to Book
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Property has other status or not available -->
                            <div class="bg-white rounded-lg shadow p-6 text-center">
                                <div class="text-3xl mb-3">🚫</div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Not Available</h3>
                                <p class="text-gray-600 mb-4">This property is currently {{ $property->status }} and not available for booking</p>
                                <div class="bg-gray-100 text-gray-500 py-2 px-4 rounded-md text-sm font-medium cursor-not-allowed">
                                    ❌ Not Available for Booking
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- For logged in users who are not tenants -->
                        <div class="bg-white rounded-lg shadow p-6 text-center">
                            <div class="text-3xl mb-3">👤</div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Tenant Account Required</h3>
                            <p class="text-gray-600 mb-4">Only tenant accounts can book properties</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Similar Properties -->
        @if(isset($similarProperties) && $similarProperties->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Similar Properties</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($similarProperties as $similarProperty)
                        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow">
                            <div class="relative h-48">
                                @if($similarProperty->images->count() > 0)
                                    <img src="{{ $similarProperty->primaryImage ? $similarProperty->primaryImage->image_url : $similarProperty->images->first()->image_url }}" 
                                         alt="{{ $similarProperty->title }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&wsrc='https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300&q=80';"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <span class="text-3xl">🏠</span>
                                    </div>
                                @endif
                                <div class="absolute top-3 right-3 bg-white px-2 py-1 rounded text-xs font-medium">
                                    {{ $similarProperty->propertyType->name }}
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $similarProperty->title }}</h3>
                                <p class="text-sm text-gray-600 mb-3">📍 {{ $similarProperty->city }}, {{ $similarProperty->state }}</p>
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-3 text-xs text-gray-600">
                                        <span>🛏️ {{ $similarProperty->bedrooms }}</span>
                                        <span>🚿 {{ $similarProperty->bathrooms }}</span>
                                    </div>
                                    <div class="font-semibold text-blue-600">
                                        NPR {{ number_format($similarProperty->price, 0) }}
                                    </div>
                                </div>
                                <a href="{{ route('properties.show', $similarProperty->id) }}" class="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-blue-700">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">🏠 RoomYatra</h3>
                    <p class="text-gray-400 mb-4">Making room rentals simple and secure for landlords and tenants.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">For Tenants</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white">Find a Room</a></li>
                        <li><a href="#" class="hover:text-white">How It Works</a></li>
                        <li><a href="#" class="hover:text-white">Tenant Resources</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">For Landlords</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white">List a Property</a></li>
                        <li><a href="#" class="hover:text-white">Pricing Guide</a></li>
                        <li><a href="#" class="hover:text-white">Host Protection</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white">About</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                        <li><a href="#" class="hover:text-white">Privacy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 RoomYatra, Inc. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize date picker
        document.addEventListener('DOMContentLoaded', function() {
            const checkInInput = document.getElementById('check_in');
            if (checkInInput) {
                flatpickr(checkInInput, {
                    minDate: "today",
                    dateFormat: "Y-m-d",
                });
            }
        });
    </script>
</body>
</html>
