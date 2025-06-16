@extends('website.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Your Review</h1>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('tenant.reviews.show', $review->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Review
            </a>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700">
                    @foreach($errors->all() as $error)
                    {{ $error }}<br>
                    @endforeach
                </p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <!-- Review Form -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900">Your Review for {{ $review->property->title }}</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('tenant.reviews.update', $review->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Your Review</label>
                            <textarea name="comment" id="comment" rows="6" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500" placeholder="Share your experience with this property..." required>{{ old('comment', $review->comment) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Minimum 10 characters</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-700 mb-4">Rate Your Experience</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="cleanliness_rating" class="block text-sm font-medium text-gray-700 mb-1">Cleanliness</label>
                                    <div class="flex items-center">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="mr-1 cursor-pointer">
                                                    <input type="radio" name="cleanliness_rating" value="{{ $i }}" class="sr-only peer" {{ old('cleanliness_rating', $review->cleanliness_rating) == $i ? 'checked' : '' }} required>
                                                    <svg class="h-8 w-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="communication_rating" class="block text-sm font-medium text-gray-700 mb-1">Communication</label>
                                    <div class="flex items-center">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="mr-1 cursor-pointer">
                                                    <input type="radio" name="communication_rating" value="{{ $i }}" class="sr-only peer" {{ old('communication_rating', $review->communication_rating) == $i ? 'checked' : '' }} required>
                                                    <svg class="h-8 w-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="check_in_rating" class="block text-sm font-medium text-gray-700 mb-1">Check-in</label>
                                    <div class="flex items-center">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="mr-1 cursor-pointer">
                                                    <input type="radio" name="check_in_rating" value="{{ $i }}" class="sr-only peer" {{ old('check_in_rating', $review->check_in_rating) == $i ? 'checked' : '' }} required>
                                                    <svg class="h-8 w-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="accuracy_rating" class="block text-sm font-medium text-gray-700 mb-1">Accuracy</label>
                                    <div class="flex items-center">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="mr-1 cursor-pointer">
                                                    <input type="radio" name="accuracy_rating" value="{{ $i }}" class="sr-only peer" {{ old('accuracy_rating', $review->accuracy_rating) == $i ? 'checked' : '' }} required>
                                                    <svg class="h-8 w-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="location_rating" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <div class="flex items-center">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="mr-1 cursor-pointer">
                                                    <input type="radio" name="location_rating" value="{{ $i }}" class="sr-only peer" {{ old('location_rating', $review->location_rating) == $i ? 'checked' : '' }} required>
                                                    <svg class="h-8 w-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="value_rating" class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                                    <div class="flex items-center">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label class="mr-1 cursor-pointer">
                                                    <input type="radio" name="value_rating" value="{{ $i }}" class="sr-only peer" {{ old('value_rating', $review->value_rating) == $i ? 'checked' : '' }} required>
                                                    <svg class="h-8 w-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                Update Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Property Information -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900">Property Details</h2>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        @if($review->property->images->count() > 0)
                            <img src="{{ asset('storage/' . $review->property->images->first()->image_path) }}" alt="{{ $review->property->title }}" class="w-full h-48 object-cover rounded-md">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-md">
                                <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900">{{ $review->property->title }}</h3>
                    <p class="text-gray-600 mt-1">{{ $review->property->address }}, {{ $review->property->city }}, {{ $review->property->state }} {{ $review->property->zip_code }}</p>

                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-500">Booking Details</h4>
                        <p class="mt-1 text-gray-900">
                            {{ \Carbon\Carbon::parse($review->booking->check_in)->format('M d, Y') }} -
                            {{ \Carbon\Carbon::parse($review->booking->check_out)->format('M d, Y') }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($review->booking->check_in)->diffInDays(\Carbon\Carbon::parse($review->booking->check_out)) }} nights, {{ $review->booking->guests }} {{ Str::plural('guest', $review->booking->guests) }}
                        </p>
                    </div>

                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-500">Host</h4>
                        <p class="mt-1 text-gray-900">{{ $review->property->user->name }}</p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('properties.show', $review->property->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                            View Property
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
