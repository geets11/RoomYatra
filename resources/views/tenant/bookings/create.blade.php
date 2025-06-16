@extends('website.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Book Property</h1>
                <a href="{{ route('properties.show', $property) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                    Back to Property
                </a>
            </div>
        </div>
    </div>

    @if (session('error'))
        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="mt-6 md:grid md:grid-cols-3 md:gap-6">
        <!-- Property Preview -->
        <div class="md:col-span-1">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Property Details</h3>
                </div>
                <div class="border-t border-gray-200">
                    <div>
                        @if ($property->images->count() > 0)
                            <img class="h-48 w-full object-cover" src="{{ asset('storage/' . ($property->primaryImage ? $property->primaryImage->image_path : $property->images->first()->image_path)) }}" alt="{{ $property->title }}">
                        @else
                            <div class="h-48 w-full bg-gray-200 flex items-center justify-center">
                                <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h4 class="text-lg font-semibold text-gray-900">{{ $property->title }}</h4>
                        <p class="mt-1 text-sm text-gray-500">{{ $property->propertyType->name }} in {{ $property->city }}, {{ $property->state }}</p>

                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            <span>{{ $property->bedrooms }} bed{{ $property->bedrooms != 1 ? 's' : '' }} • {{ $property->bathrooms }} bath{{ $property->bathrooms != 1 ? 's' : '' }}</span>
                        </div>

                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            <span class="truncate">{{ $property->address }}</span>
                        </div>

                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <span>NPR{{ number_format($property->price, 2) }} / {{ $property->price_type }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="{{ route('tenant.bookings.store', $property) }}" method="POST">
                @csrf
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="check_in" class="block text-sm font-medium text-gray-700">Check-in Date</label>
                                <input type="date" name="check_in" id="check_in" value="{{ old('check_in') }}" min="{{ date('Y-m-d') }}" class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('check_in')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- <div class="col-span-6 sm:col-span-3">
                                <label for="check_out" class="block text-sm font-medium text-gray-700">Check-out Date</label>
                                <input type="date" name="check_out" id="check_out" value="{{ old('check_out') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('check_out')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div> -->

                            <div class="col-span-6 sm:col-span-3">
                                <label for="guests" class="block text-sm font-medium text-gray-700">Number of Guests</label>
                                <input type="number" name="guests" id="guests" value="{{ old('guests', 1) }}" min="1" class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('guests')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="special_requests" class="block text-sm font-medium text-gray-700">Special Requests (Optional)</label>
                                <textarea id="special_requests" name="special_requests" rows="3" class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('special_requests') }}</textarea>
                                @error('special_requests')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                            Request Booking
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Booking Information -->
    <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Booking Information</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Important details about your booking.</p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <div class="text-sm text-gray-700 space-y-4">
                <p>
                    <strong>Booking Process:</strong> When you submit a booking request, the landlord will review it and either approve or reject it. You'll be notified of their decision.
                </p>
                <p>
                    <strong>Cancellation Policy:</strong> You can cancel your booking at any time before check-in. However, please note that cancellations may be subject to the landlord's cancellation policy.
                </p>
                <!-- <p>
                    <strong>Payment:</strong> Payment details will be provided after your booking is approved.
                </p>
                <p>
                    <strong>Check-in/Check-out:</strong> Standard check-in time is after 3:00 PM, and check-out is before 11:00 AM, unless otherwise specified by the landlord.
                </p> -->
            </div>
        </div>
    </div>
</div>


@endsection
