@extends('layouts.subadmin.subadmin')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">User Details</h1>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <a href="{{ route('subadmin.users.edit', $user) }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                        Edit User
                    </a>
                    <a href="{{ route('subadmin.users.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to Users
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- User Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">User Information</h3>
                        </div>
                        <div class="px-6 py-4">
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold text-xl">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900">{{ $user->name }}</h4>
                                    <p class="text-sm text-gray-500">Member since {{ $user->created_at->format('M Y') }}</p>
                                </div>
                            </div>

                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->phone ?? 'Not provided' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                                    <dd class="mt-1">
                                        @foreach ($user->roles as $role)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if ($role->name == 'admin') bg-red-100 text-red-800
                                            @elseif($role->name == 'subadmin') bg-yellow-100 text-yellow-800
                                            @elseif($role->name == 'landlord') bg-green-100 text-green-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @endforeach
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        @if ($user->email_verified_at)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Inactive
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Joined</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F j, Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Activity and Details -->
                <div class="lg:col-span-2 space-y-6">
                    @if ($user->hasRole('landlord') && $properties->count() > 0)
                        <!-- Properties (for landlords) -->
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Properties</h3>
                            </div>
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($properties as $property)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    @if ($property->images->count() > 0)
                                                        <img class="h-16 w-16 rounded-lg object-cover"
                                                            src="{{ asset('storage/' . $property->images->first()->image_path) }}"
                                                            alt="{{ $property->title }}">
                                                    @else
                                                        <div
                                                            class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                            <svg class="h-8 w-8 text-gray-400"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4 flex-1">
                                                    <h4 class="text-sm font-medium text-gray-900">{{ $property->title }}
                                                    </h4>
                                                    <p class="text-sm text-gray-500">{{ $property->city }},
                                                        {{ $property->state }}</p>
                                                    <p class="text-sm font-medium text-gray-900">
                                                        NPR {{ number_format($property->price) }}/month</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($user->hasRole('tenant') && $bookings->count() > 0)
                        <!-- Bookings (for tenants) -->
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Recent Bookings</h3>
                            </div>
                            <div class="px-6 py-4">
                                <div class="space-y-4">
                                    @foreach ($bookings as $booking)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    @if ($booking->property->images->count() > 0)
                                                        <img class="h-16 w-16 rounded-lg object-cover"
                                                            src="{{ asset('storage/' . $booking->property->images->first()->image_path) }}"
                                                            alt="{{ $booking->property->title }}">
                                                    @else
                                                        <div
                                                            class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                            <svg class="h-8 w-8 text-gray-400"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4 flex-1">
                                                    <h4 class="text-sm font-medium text-gray-900">
                                                        {{ $booking->property->title }}</h4>
                                                    
                                                    <div class="flex items-center justify-between mt-2">
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        @if ($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                                        @elseif($booking->status == 'approved') bg-green-100 text-green-800
                                                        @elseif($booking->status == 'completed') bg-blue-100 text-blue-800
                                                        @elseif($booking->status == 'cancelled') bg-red-100 text-red-800
                                                        @elseif($booking->status == 'rejected') bg-gray-100 text-gray-800 @endif">
                                                            {{ ucfirst($booking->status) }}
                                                        </span>
                                                        <span class="text-sm font-medium text-gray-900">
                                                            NPR {{ number_format($booking->total_price) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($reviews->count() > 0)
                        <!-- Reviews -->
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Recent Reviews</h3>
                            </div>
                            <div class="px-6 py-4">
                                <div class="space-y-4">
                                    @foreach ($reviews as $review)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-gray-900">
                                                        {{ $review->property->title }}</h4>
                                                    <div class="flex items-center mt-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        @endfor
                                                        <span class="ml-2 text-sm text-gray-500">{{ $review->rating }}/5</span>
                                                    </div>
                                                    <p class="text-sm text-gray-600 mt-2">{{ $review->comment }}</p>
                                                </div>
                                                <span class="text-xs text-gray-500">
                                                    {{ $review->created_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
