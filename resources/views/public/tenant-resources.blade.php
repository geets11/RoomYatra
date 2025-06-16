@extends('website.layouts.app')

@section('title', 'Tenant Resources - RoomYatra')

@section('content')
    <div class="bg-white">
        <!-- Hero Section -->
        <div class=" bg-rose-600">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold text-white sm:text-5xl">Tenant Resources</h1>
                    <p class="mt-4 text-xl text-rose-100">Everything you need to know about renting with RoomYatra</p>
                </div>
            </div>
        </div>

        <!-- Resources Grid -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    <!-- Rental Guide -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-100 rounded-lg p-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-lg font-semibold text-gray-900">Rental Guide</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Complete guide to renting your first room, including what to look
                                for and questions to ask.</p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">Read Guide →</a>
                        </div>
                    </div>

                    <!-- Legal Rights -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-green-100 rounded-lg p-3">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-lg font-semibold text-gray-900">Tenant Rights</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Know your rights as a tenant, including privacy, repairs, and
                                deposit protection.</p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">Learn More →</a>
                        </div>
                    </div>

                    <!-- Safety Tips -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-yellow-100 rounded-lg p-3">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-lg font-semibold text-gray-900">Safety Tips</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Essential safety tips for viewing properties and protecting
                                yourself from scams.</p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">View Tips →</a>
                        </div>
                    </div>

                    <!-- Budget Calculator -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-purple-100 rounded-lg p-3">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-lg font-semibold text-gray-900">Budget Calculator</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Calculate how much you can afford to spend on rent based on your
                                income.</p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">Calculate →</a>
                        </div>
                    </div>

                    <!-- Moving Checklist -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-red-100 rounded-lg p-3">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-lg font-semibold text-gray-900">Moving Checklist</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Step-by-step checklist to ensure a smooth move to your new room.
                            </p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">Get Checklist →</a>
                        </div>
                    </div>

                    <!-- FAQ -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-indigo-100 rounded-lg p-3">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-lg font-semibold text-gray-900">FAQ</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Frequently asked questions about renting, booking, and using
                                RoomYatra.</p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">View FAQ →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Section -->
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Need More Help?</h2>
                    <p class="text-lg text-gray-600 mb-8">Our support team is here to help you with any questions.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/contact"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700">
                            Contact Support
                        </a>
                        <a href="#"
                            class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Live Chat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
