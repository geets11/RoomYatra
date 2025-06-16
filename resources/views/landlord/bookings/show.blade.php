@extends('website.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Booking Details</h1>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('landlord.bookings.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Bookings
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Error Message -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Booking Details -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <!-- Booking Header -->
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 flex justify-between items-center">
                        <h2 class="text-lg font-medium text-gray-900">Booking #{{ $booking->id }}</h2>
                        <div class="flex items-center">
                            @switch($booking->status)
                                @case('pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @break

                                @case('approved')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Approved
                                    </span>
                                @break

                                @case('completed')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Completed
                                    </span>
                                @break

                                @case('cancelled')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Cancelled
                                    </span>
                                @break

                                @case('rejected')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @break
                            @endswitch
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Check-in</h3>
                                <p class="mt-1 text-base font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($booking->check_in)->format('D, M d, Y') }}</p>
                                <p class="text-sm text-gray-500">After {{ $booking->property->check_in_time ?? '3:00 PM' }}
                                </p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Guests</h3>
                                <p class="mt-1 text-base font-semibold text-gray-900">{{ $booking->guests }}
                                    {{ Str::plural('guest', $booking->guests) }}</p>
                            </div>
                        </div>

                        @if ($booking->message)
                            <div class="mt-6">
                                <h3 class="text-sm font-medium text-gray-500">Guest's Message</h3>
                                <div class="mt-1 p-4 bg-gray-50 rounded-md">
                                    <p class="text-gray-800">{{ $booking->message }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($booking->landlord_message)
                            <div class="mt-6">
                                <h3 class="text-sm font-medium text-gray-500">Your Response</h3>
                                <div class="mt-1 p-4 bg-gray-50 rounded-md">
                                    <p class="text-gray-800">{{ $booking->landlord_message }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($booking->rejection_reason)
                            <div class="mt-6">
                                <h3 class="text-sm font-medium text-gray-500">Rejection Reason</h3>
                                <div class="mt-1 p-4 bg-red-50 rounded-md">
                                    <p class="text-gray-800">{{ $booking->rejection_reason }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Booking Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:justify-end sm:space-x-4">
                            @if ($booking->status == 'pending')
                                <button type="button"
                                    onclick="document.getElementById('reject-modal').style.display='block'"
                                    class="mb-2 sm:mb-0 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Reject Booking
                                </button>
                                <button type="button"
                                    onclick="document.getElementById('approve-modal').style.display='block'"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Approve Booking
                                </button>
                            @elseif($booking->status == 'approved')
                                <p class="text-gray-600">Booking Approved.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Property Details -->
                <div class="mt-8 bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h2 class="text-lg font-medium text-gray-900">Property Details</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-1/3 mb-4 md:mb-0">
                                @if ($booking->property->images->count() > 0)
                                    <img src="{{ $booking->property->images->first()->image_url }}"
                                        alt="{{ $booking->property->title }}" class="w-full h-48 object-cover rounded-md">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-md">
                                        <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="md:w-2/3 md:pl-6">
                                <h3 class="text-xl font-semibold text-gray-900">{{ $booking->property->title }}</h3>
                                <p class="text-gray-600 mt-1">{{ $booking->property->address }},
                                    {{ $booking->property->city }}, {{ $booking->property->state }}
                                    {{ $booking->property->zip_code }}</p>

                                <div class="mt-4 flex flex-wrap gap-4">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        <span>{{ $booking->property->bedrooms }}
                                            {{ Str::plural('Bedroom', $booking->property->bedrooms) }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                        </svg>
                                        <span>{{ $booking->property->bathrooms }}
                                            {{ Str::plural('Bathroom', $booking->property->bathrooms) }}</span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('landlord.properties.show', $booking->property->id) }}"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                        View Property Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
    <!-- Guest Information -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h2 class="text-lg font-medium text-gray-900">Guest Information</h2>
        </div>
        <div class="p-6">
            <!-- Guest Profile -->
            <div class="flex items-center mb-6">
                <div class="h-16 w-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                    {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $booking->user->name }}</h3>
                    <p class="text-sm text-gray-500">Member since {{ $booking->user->created_at->format('M Y') }}</p>
                    <div class="flex items-center mt-1">
                        @if($booking->user->email_verified_at)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Verified
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Unverified
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="space-y-4 mb-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Contact Details
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Email</span>
                            <a href="mailto:{{ $booking->user->email }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                {{ $booking->user->email }}
                            </a>
                        </div>
                        @if ($booking->user->phone)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Phone</span>
                                <a href="tel:{{ $booking->user->phone }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    {{ $booking->user->phone }}
                                </a>
                            </div>
                        @else
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Phone</span>
                                <span class="text-sm text-gray-400">Not provided</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Guest Statistics -->
            <div class="border-t border-gray-200 pt-6 mb-6">
                <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Booking History
                </h4>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 rounded-lg p-3 text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $booking->user->bookings()->count() }}</div>
                        <div class="text-xs text-blue-600 font-medium">Total Bookings</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $booking->user->bookings()->where('status', 'completed')->count() }}</div>
                        <div class="text-xs text-green-600 font-medium">Completed</div>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-3 text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $booking->user->bookings()->where('status', 'approved')->count() }}</div>
                        <div class="text-xs text-yellow-600 font-medium">Active</div>
                    </div>
                    <div class="bg-red-50 rounded-lg p-3 text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $booking->user->bookings()->where('status', 'cancelled')->count() }}</div>
                        <div class="text-xs text-red-600 font-medium">Cancelled</div>
                    </div>
                </div>
            </div>

            <!-- Current Booking Details -->
            <div class="border-t border-gray-200 pt-6">
                <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    This Booking
                </h4>
                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Check-in
                        </span>
                        <span class="text-sm font-semibold text-gray-900">{{ $booking->check_in->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            </svg>
                            Guests
                        </span>
                        <span class="text-sm font-semibold text-gray-900">{{ $booking->guests }} {{ Str::plural('person', $booking->guests) }}</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-gray-200 pt-3">
                        <span class="text-sm text-gray-600 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                            </svg>
                            Total Amount
                        </span>
                        <span class="text-lg font-bold text-green-600">NPR {{ number_format($booking->total_price, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            Payment
                        </span>
                        <span class="text-sm font-semibold {{ ($booking->is_paid ?? false) ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ ($booking->is_paid ?? false) ? '✓ Paid' : '⏳ Pending' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Special Requests -->
            @if($booking->special_requests)
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    Special Requests
                </h4>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <p class="text-sm text-blue-800">{{ $booking->special_requests }}</p>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Quick Actions</h4>
                <div class="space-y-2">
                    <a href="mailto:{{ $booking->user->email }}" 
                       class="w-full inline-flex items-center justify-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Send Email
                    </a>
                    @if($booking->user->phone)
                    <a href="tel:{{ $booking->user->phone }}" 
                       class="w-full inline-flex items-center justify-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Call Guest
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
        </div>

        <!-- Simple Approve Modal -->
        <div id="approve-modal"
            style="display: none; position: fixed; z-index: 50; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
            <div
                style="position: relative; margin: 10% auto; padding: 20px; width: 80%; max-width: 500px; background-color: white; border-radius: 8px;">
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">Approve Booking</h3>
                    <p style="margin-bottom: 15px;">Are you sure you want to approve this booking?</p>

                    <form action="{{ route('landlord.bookings.approve', $booking->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div style="margin-bottom: 15px;">
                            <label for="approve-message" style="display: block; margin-bottom: 5px; font-weight: 500;">Message to
                                Guest (Optional)</label>
                            <textarea name="message" id="approve-message" rows="3"
                                style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;"
                                placeholder="Add any special instructions or welcome message"></textarea>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button" onclick="document.getElementById('approve-modal').style.display='none'"
                                style="padding: 8px 16px; background-color: white; border: 1px solid #d1d5db; border-radius: 4px; cursor: pointer;">
                                Cancel
                            </button>
                            <button type="submit"
                                style="padding: 8px 16px; background-color: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                Approve
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Simple Reject Modal -->
        <div id="reject-modal"
            style="display: none; position: fixed; z-index: 50; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
            <div
                style="position: relative; margin: 10% auto; padding: 20px; width: 80%; max-width: 500px; background-color: white; border-radius: 8px;">
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">Reject Booking</h3>
                    <p style="margin-bottom: 15px;">Are you sure you want to reject this booking?</p>

                    <form action="{{ route('landlord.bookings.reject', $booking->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div style="margin-bottom: 15px;">
                            <label for="reject-message" style="display: block; margin-bottom: 5px; font-weight: 500;">Reason for
                                Rejection (Optional)</label>
                            <textarea name="message" id="reject-message" rows="3"
                                style="width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;"
                                placeholder="Explain why you're rejecting this booking"></textarea>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button" onclick="document.getElementById('reject-modal').style.display='none'"
                                style="padding: 8px 16px; background-color: white; border: 1px solid #d1d5db; border-radius: 4px; cursor: pointer;">
                                Cancel
                            </button>
                            <button type="submit"
                                style="padding: 8px 16px; background-color: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                Reject
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Simple Modal Close Script -->
        <script>
            // Close modals when clicking outside
            window.onclick = function(event) {
                var approveModal = document.getElementById('approve-modal');
                var rejectModal = document.getElementById('reject-modal');

                if (event.target == approveModal) {
                    approveModal.style.display = "none";
                }

                if (event.target == rejectModal) {
                    rejectModal.style.display = "none";
                }
            }

            // Close modals with Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    document.getElementById('approve-modal').style.display = "none";
                    document.getElementById('reject-modal').style.display = "none";
                }
            });
        </script>
    </div>
@endsection
