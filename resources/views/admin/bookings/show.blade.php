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
                                <form action="{{ route('landlord.bookings.complete', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <!-- <button type="submit"
                                        onclick="return confirm('Are you sure you want to mark this booking as completed?')"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Mark as Completed
                                    </button> -->
                                </form>
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
                        <div class="flex items-center mb-6">
                            <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold text-xl">
                                {{ substr($booking->user->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $booking->user->name }}</h3>

