@extends('website.layouts.app')

@section('title', 'Tenant Reviews - RoomYatra')

@section('content')
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="bg-rose-600">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold text-white sm:text-5xl">Tenant Reviews</h1>
                    <p class="mt-4 text-xl text-blue-100">Sees say about their RoomYatra experience</p>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-3xl font-bold text-gray-900">4.8</div>
                        <div class="text-sm text-gray-600">Average Rating</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">2,500+</div>
                        <div class="text-sm text-gray-600">Total Reviews</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">95%</div>
                        <div class="text-sm text-gray-600">Satisfaction Rate</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900">1,200+</div>
                        <div class="text-sm text-gray-600">Happy Tenants</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">What Our Tenants Say</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <div class="flex items-center mb-4">
                                <img src="/placeholder.svg?height=50&width=50" alt="Reviewer"
                                    class="w-12 h-12 rounded-full">
                                <div class="ml-4">
                                    <h4 class="font-semibold text-gray-900">Nitesh Karki</h4>
                                    <div class="flex items-center">
                                        @for ($j = 1; $j <= 5; $j++)
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600">"Amazing experience with RoomYatra! Found the perfect room in downtown
                                within a week. The landlord was responsive and the booking process was seamless."</p>
                            <div class="mt-4 text-sm text-gray-500">
                                Rented in Downtown • 2 months ago
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Review Categories -->
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Review Breakdown</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900 mb-2">4.9</div>
                        <div class="text-sm text-gray-600 mb-2">Cleanliness</div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 98%"></div>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900 mb-2">4.8</div>
                        <div class="text-sm text-gray-600 mb-2">Communication</div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 96%"></div>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900 mb-2">4.7</div>
                        <div class="text-sm text-gray-600 mb-2">Location</div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 94%"></div>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900 mb-2">4.8</div>
                        <div class="text-sm text-gray-600 mb-2">Value</div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-600 h-2 rounded-full" style="width: 96%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-blue-600">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-white">Ready to Join Our Happy Tenants?</h2>
                    <p class="mt-4 text-xl text-blue-100">Start your room search today and experience the RoomYatra
                        difference.</p>
                    <div class="mt-8">
                        <a href="/rooms"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50">
                            Find Your Room
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
