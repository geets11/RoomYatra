@extends('layouts.landlord.landlord')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Property Reviews</h1>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('landlord.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>

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

        <!-- Reviews Overview -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                <h2 class="text-lg font-medium text-gray-900">Reviews Overview</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $totalReviews = $reviews->total();
                        $averageRating = $reviews->avg('rating') ?? 0;
                        $pendingResponses = $reviews
                            ->filter(function ($review) {
                                return $review->landlord_response === null;
                            })
                            ->count();
                    @endphp

                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <h3 class="text-sm font-medium text-gray-500">Total Reviews</h3>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalReviews }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <h3 class="text-sm font-medium text-gray-500">Average Rating</h3>
                        <div class="mt-2 flex items-center justify-center">
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $averageRating)
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @elseif($i - 0.5 <= $averageRating)
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span
                                class="ml-2 text-2xl font-semibold text-gray-900">{{ number_format($averageRating, 1) }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <h3 class="text-sm font-medium text-gray-500">Pending Responses</h3>
                        <p
                            class="mt-2 text-3xl font-semibold {{ $pendingResponses > 0 ? 'text-rose-600' : 'text-gray-900' }}">
                            {{ $pendingResponses }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews List -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">All Reviews</h2>

                <div class="flex space-x-2">
                    <select id="property-filter"
                        class="rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 text-sm">
                        <option value="">All Properties</option>
                        @php
                            $properties = Auth::user()->properties;
                        @endphp
                        @foreach ($properties as $property)
                            <option value="{{ $property->id }}">{{ $property->title }}</option>
                        @endforeach
                    </select>

                    <select id="rating-filter"
                        class="rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 text-sm">
                        <option value="">All Ratings</option>
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>

                    <select id="response-filter"
                        class="rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 text-sm">
                        <option value="">All Reviews</option>
                        <option value="responded">Responded</option>
                        <option value="pending">Pending Response</option>
                    </select>
                </div>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse($reviews as $review)
                    <div class="p-6 review-item" data-property="{{ $review->property_id }}"
                        data-rating="{{ floor($review->rating) }}"
                        data-response="{{ $review->landlord_response ? 'responded' : 'pending' }}">
                        <div class="flex flex-col md:flex-row md:justify-between">
                            <div class="mb-4 md:mb-0">
                                <h3 class="text-lg font-medium text-gray-900">{{ $review->property->title }}</h3>
                                <p class="text-sm text-gray-500">
                                    Reviewed by {{ $review->user->name }} on {{ $review->created_at->format('M d, Y') }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Stayed: {{ \Carbon\Carbon::parse($review->booking->check_in)->format('M d, Y') }} -
                                    {{ \Carbon\Carbon::parse($review->booking->check_out)->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @elseif($i - 0.5 <= $review->rating)
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-sm font-medium text-gray-900">{{ $review->rating }}</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="text-gray-800">{{ Str::limit($review->comment, 200) }}</p>
                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            <div>
                                @if ($review->landlord_response)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                            viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Responded
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor"
                                            viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Pending Response
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('landlord.reviews.show', $review->id) }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center">
                        <p class="text-gray-500">No reviews found for your properties.</p>
                        <p class="mt-2 text-sm text-gray-500">Reviews will appear here when guests leave feedback for your
                            properties.</p>
                    </div>
                @endforelse
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const propertyFilter = document.getElementById('property-filter');
                const ratingFilter = document.getElementById('rating-filter');
                const responseFilter = document.getElementById('response-filter');
                const reviewItems = document.querySelectorAll('.review-item');

                function filterReviews() {
                    const propertyValue = propertyFilter.value;
                    const ratingValue = ratingFilter.value;
                    const responseValue = responseFilter.value;

                    reviewItems.forEach(item => {
                        const propertyMatch = !propertyValue || item.dataset.property === propertyValue;
                        const ratingMatch = !ratingValue || item.dataset.rating === ratingValue;
                        const responseMatch = !responseValue || item.dataset.response === responseValue;

                        if (propertyMatch && ratingMatch && responseMatch) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                }

                propertyFilter.addEventListener('change', filterReviews);
                ratingFilter.addEventListener('change', filterReviews);
                responseFilter.addEventListener('change', filterReviews);
            });
        </script>
    @endpush
@endsection
