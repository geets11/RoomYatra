@extends('website.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">My Bookings</h1>
        </div>
    </div>

    <!-- Content -->
    <div class="mt-6">
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Booking Tabs -->
        <div class="mb-6">
            <div class="sm:hidden">
                <label for="booking-tabs" class="sr-only">Select a tab</label>
                <select id="booking-tabs" name="booking-tabs" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-rose-500 focus:border-rose-500 sm:text-sm rounded-md">
                    <option value="all" selected>All Bookings</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <a href="#" class="booking-tab border-rose-500 text-rose-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-status="all">
                            All Bookings
                        </a>
                        <a href="#" class="booking-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-status="pending">
                            Pending
                        </a>
                        <a href="#" class="booking-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-status="approved">
                            Approved
                        </a>
                        <a href="#" class="booking-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-status="completed">
                            Completed
                        </a>
                        <a href="#" class="booking-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-status="cancelled">
                            Cancelled
                        </a>
                        <a href="#" class="booking-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-status="rejected">
                            Rejected
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Bookings List -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse ($bookings as $booking)
                    <li class="booking-item" data-status="{{ $booking->status }}">
                        <a href="{{ route('tenant.bookings.show', $booking) }}" class="block hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            @if ($booking->property->images->count() > 0)
                                                <img class="h-12 w-12 rounded-md object-cover" src="{{ asset('storage/' . ($booking->property->primaryImage ? $booking->property->primaryImage->image_path : $booking->property->images->first()->image_path)) }}" alt="{{ $booking->property->title }}">
                                            @else
                                                <div class="h-12 w-12 rounded-md bg-gray-200 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $booking->property->title }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $booking->property->propertyType->name }} in {{ $booking->property->city }}, {{ $booking->property->state }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($booking->status == 'approved') bg-green-100 text-green-800
                                            @elseif($booking->status == 'rejected') bg-red-100 text-red-800
                                            @elseif($booking->status == 'cancelled') bg-gray-100 text-gray-800
                                            @elseif($booking->status == 'completed') bg-blue-100 text-blue-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                            <span>{{  \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</span>
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                            <span>{{ $booking->guests }} {{ Str::plural('guest', $booking->guests) }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>NPR {{ number_format($booking->total_price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @empty
                    <li>
                        <div class="px-4 py-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Start by booking a property.</p>
                            <div class="mt-6">
                                <a href="{{ route('properties.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                    Browse Properties
                                </a>
                            </div>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<script>
    // Booking tabs functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.booking-tab');
        const mobileTabSelect = document.getElementById('booking-tabs');
        const bookingItems = document.querySelectorAll('.booking-item');

        function filterBookings(status) {
            bookingItems.forEach(item => {
                if (status === 'all' || item.dataset.status === status) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();

                // Update active tab
                tabs.forEach(t => {
                    t.classList.remove('border-rose-500', 'text-rose-600');
                    t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                });
                this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                this.classList.add('border-rose-500', 'text-rose-600');

                // Filter bookings
                filterBookings(this.dataset.status);

                // Update mobile select
                if (mobileTabSelect) {
                    mobileTabSelect.value = this.dataset.status;
                }
            });
        });

        if (mobileTabSelect) {
            mobileTabSelect.addEventListener('change', function() {
                filterBookings(this.value);

                // Update desktop tabs
                tabs.forEach(tab => {
                    if (tab.dataset.status === this.value) {
                        tab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                        tab.classList.add('border-rose-500', 'text-rose-600');
                    } else {
                        tab.classList.remove('border-rose-500', 'text-rose-600');
                        tab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    }
                });
            });
        }
    });
</script>
@endsection
