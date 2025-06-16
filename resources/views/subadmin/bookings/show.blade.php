@extends('layouts.subadmin.subadmin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Booking Details</h1>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('subadmin.bookings.index') }}"
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
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
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
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
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
                        <p class="text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </p>
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
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Check-in</h3>
                                <p class="mt-1 text-base font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($booking->check_in)->format('D, M d, Y') }}</p>
                                <p class="text-sm text-gray-500">After {{ $booking->property->check_in_time ?? '3:00 PM' }}
                                </p>
                            </div>
                            
                        </div>

                        <div class="mt-6">
                            <h3 class="text-sm font-medium text-gray-500">Guests</h3>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $booking->guests }}
                                {{ Str::plural('guest', $booking->guests) }}</p>
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
                                <h3 class="text-sm font-medium text-gray-500">Landlord's Response</h3>
                                <div class="mt-1 p-4 bg-gray-50 rounded-md">
                                    <p class="text-gray-800">{{ $booking->landlord_message }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($booking->admin_notes)
                            <div class="mt-6">
                                <h3 class="text-sm font-medium text-gray-500">Admin Notes</h3>
                                <div class="mt-1 p-4 bg-blue-50 rounded-md">
                                    <p class="text-gray-800">{{ $booking->admin_notes }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($booking->cancellation_reason)
                            <div class="mt-6">
                                <h3 class="text-sm font-medium text-gray-500">Cancellation Reason</h3>
                                <div class="mt-1 p-4 bg-red-50 rounded-md">
                                    <p class="text-gray-800">{{ $booking->cancellation_reason }}</p>
                                    <p class="mt-2 text-sm text-gray-500">Cancelled by {{ $booking->cancelled_by }} on
                                        {{ \Carbon\Carbon::parse($booking->cancelled_at)->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Subadmin Actions -->
                    <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
                        <div class="flex flex-col sm:flex-row sm:justify-end sm:space-x-4">
                            @if ($booking->status == 'pending')
                                <button type="button"
                                    onclick="document.getElementById('reject-modal').style.display='block'"
                                    class="mb-2 sm:mb-0 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 rounded-md">
                                    Reject Booking
                                </button>
                                <button type="button"
                                    onclick="document.getElementById('approve-modal').style.display='block'"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 rounded-md">
                                    Approve Booking
                                </button>
                            @elseif($booking->status == 'approved')
                                <button type="button"
                                    onclick="document.getElementById('complete-modal').style.display='block'"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-md">
                                    Mark as Completed
                                </button>
                            @endif
                            
                            <!-- Update Status Button -->
                            <button type="button"
                                onclick="document.getElementById('status-modal').style.display='block'"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md">
                                Update Status
                            </button>
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
                                    <img src="{{ asset('storage/' . $booking->property->images->first()->image_path) }}"
                                        alt="{{ $booking->property->title }}"
                                        class="w-full h-48 object-cover rounded-md">
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
                                    <a href="{{ route('subadmin.properties.show', $booking->property->id) }}"
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
                        <div class="flex items-center">
                            <div
                                class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold">
                                {{ substr($booking->user->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $booking->user->name }}</h3>
                                <p class="text-gray-500">Member since {{ $booking->user->created_at->format('M Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500">Email</h4>
                            <p class="mt-1">{{ $booking->user->email }}</p>
                        </div>

                        @if ($booking->user->phone)
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                                <p class="mt-1">{{ $booking->user->phone }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Landlord Information -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                        <h2 class="text-lg font-medium text-gray-900">Landlord Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center">
                            <div
                                class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold">
                                {{ substr($booking->property->user->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ $booking->property->user->name }}</h3>
                                <p class="text-gray-500">Property Owner</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500">Email</h4>
                            <p class="mt-1">{{ $booking->property->user->email }}</p>
                        </div>

                        @if ($booking->property->user->phone)
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                                <p class="mt-1">{{ $booking->property->user->phone }}</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <!-- Modals -->
        
        <!-- Approve Modal -->
        <div id="approve-modal"
            style="display: none; position: fixed; z-index: 50; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
            <div
                style="position: relative; margin: 10% auto; padding: 20px; width: 80%; max-width: 500px; background-color: white; border-radius: 8px;">
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">Approve Booking</h3>
                    <p style="margin-bottom: 15px;">Are you sure you want to approve this booking?</p>

                    <form action="{{ route('subadmin.bookings.update-status', $booking->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="approved">

                        <div style="margin-bottom: 15px;">
                            <label for="admin_notes"
                                style="display: block; margin-bottom: 5px; font-weight: 500;">Admin Notes (Optional)</label>
                            <textarea name="admin_notes" id="admin_notes" rows="3"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                placeholder="Add any notes about this approval"></textarea>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button"
                                onclick="document.getElementById('approve-modal').style.display='none'"
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

        <!-- Reject Modal -->
        <div id="reject-modal"
            style="display: none; position: fixed; z-index: 50; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
            <div
                style="position: relative; margin: 10% auto; padding: 20px; width: 80%; max-width: 500px; background-color: white; border-radius: 8px;">
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">Reject Booking</h3>
                    <p style="margin-bottom: 15px;">Are you sure you want to reject this booking?</p>

                    <form action="{{ route('subadmin.bookings.update-status', $booking->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">

                        <div style="margin-bottom: 15px;">
                            <label for="admin_notes" style="display: block; margin-bottom: 5px; font-weight: 500;">Reason for
                                Rejection</label>
                            <textarea name="admin_notes" id="admin_notes" rows="3" required
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                placeholder="Explain why you're rejecting this booking"></textarea>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button"
                                onclick="document.getElementById('reject-modal').style.display='none'"
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

        <!-- Complete Modal -->
        <div id="complete-modal"
            style="display: none; position: fixed; z-index: 50; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
            <div
                style="position: relative; margin: 10% auto; padding: 20px; width: 80%; max-width: 500px; background-color: white; border-radius: 8px;">
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">Mark as Completed</h3>
                    <p style="margin-bottom: 15px;">Are you sure you want to mark this booking as completed?</p>

                    <form action="{{ route('subadmin.bookings.update-status', $booking->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="completed">

                        <div style="margin-bottom: 15px;">
                            <label for="admin_notes"
                                style="display: block; margin-bottom: 5px; font-weight: 500;">Admin Notes (Optional)</label>
                            <textarea name="admin_notes" id="admin_notes" rows="3"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                placeholder="Add any notes about this completion"></textarea>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button"
                                onclick="document.getElementById('complete-modal').style.display='none'"
                                style="padding: 8px 16px; background-color: white; border: 1px solid #d1d5db; border-radius: 4px; cursor: pointer;">
                                Cancel
                            </button>
                            <button type="submit"
                                style="padding: 8px 16px; background-color: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                Mark Completed
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Status Update Modal -->
        <div id="status-modal"
            style="display: none; position: fixed; z-index: 50; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
            <div
                style="position: relative; margin: 10% auto; padding: 20px; width: 80%; max-width: 500px; background-color: white; border-radius: 8px;">
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">Update Booking Status</h3>

                    <form action="{{ route('subadmin.bookings.update-status', $booking->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div style="margin-bottom: 15px;">
                            <label for="status" style="display: block; margin-bottom: 5px; font-weight: 500;">Status</label>
                            <select name="status" id="status" required
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $booking->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label for="admin_notes"
                                style="display: block; margin-bottom: 5px; font-weight: 500;">Admin Notes</label>
                            <textarea name="admin_notes" id="admin_notes" rows="3"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                placeholder="Add notes about this status change">{{ $booking->admin_notes }}</textarea>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button type="button"
                                onclick="document.getElementById('status-modal').style.display='none'"
                                style="padding: 8px 16px; background-color: white; border: 1px solid #d1d5db; border-radius: 4px; cursor: pointer;">
                                Cancel
                            </button>
                            <button type="submit"
                                style="padding: 8px 16px; background-color: #6366f1; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Close Script -->
        <script>
            // Close modals when clicking outside
            window.onclick = function(event) {
                var approveModal = document.getElementById('approve-modal');
                var rejectModal = document.getElementById('reject-modal');
                var completeModal = document.getElementById('complete-modal');
                var statusModal = document.getElementById('status-modal');

                if (event.target == approveModal) {
                    approveModal.style.display = "none";
                }
                if (event.target == rejectModal) {
                    rejectModal.style.display = "none";
                }
                if (event.target == completeModal) {
                    completeModal.style.display = "none";
                }
                if (event.target == statusModal) {
                    statusModal.style.display = "none";
                }
            }

            // Close modals with Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    document.getElementById('approve-modal').style.display = "none";
                    document.getElementById('reject-modal').style.display = "none";
                    document.getElementById('complete-modal').style.display = "none";
                    document.getElementById('status-modal').style.display = "none";
                }
            });
        </script>
    </div>
@endsection
