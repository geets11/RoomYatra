@extends('website.layouts.app')

@section('title', 'About Us - RoomYatra')

@section('content')
    <div class="bg-white">

        <div class=" bg-rose-600">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold text-white sm:text-5xl">About RoomYatra</h1>
                    <p class="mt-4 text-xl text-rose-100">Everything you need to know about renting with RoomYatra</p>
                </div>
            </div>
        </div>

        <!-- Mission Section -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-rose-600 font-semibold tracking-wide uppercase">Our Mission</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Connecting People with Perfect Spaces
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                        RoomYatra was founded with the belief that finding the right room shouldn't be complicated. We've
                        built a platform that brings transparency, trust, and convenience to the rental process.
                    </p>
                </div>
            </div>
        </div>

        <!-- Story Section -->
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                            Our Story
                        </h2>
                        <p class="mt-3 text-lg text-gray-500">
                            Founded in 2023, RoomYatra emerged from the personal experiences of our founders who struggled
                            to find quality rental accommodations. We recognized the need for a platform that prioritizes
                            transparency, safety, and user experience.
                        </p>
                        <p class="mt-3 text-lg text-gray-500">
                            Today, we've helped thousands of tenants find their perfect rooms and enabled landlords to
                            connect with reliable tenants. Our platform continues to evolve based on user feedback and
                            changing market needs.
                        </p>
                    </div>
                    <div class="mt-8 lg:mt-0">
                        <img class="rounded-lg shadow-lg" src="/placeholder.svg?height=400&width=600" alt="Our team">
                    </div>
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-gray-900">Our Values</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-rose-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                            <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Trust & Transparency</h3>
                        <p class="text-gray-600">We believe in honest communication and transparent processes. Every listing
                            is verified and every interaction is secure.</p>
                    </div>

                    <div class="text-center">
                        <div class="bg-blue-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Community First</h3>
                        <p class="text-gray-600">We're building a community where landlords and tenants can connect with
                            confidence and mutual respect.</p>
                    </div>

                    <div class="text-center">
                        <div class="bg-green-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Innovation</h3>
                        <p class="text-gray-600">We continuously innovate to make the rental process easier, faster, and
                            more enjoyable for everyone.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-gray-900">Meet Our Team</h2>
                    <p class="mt-4 text-lg text-gray-500">The passionate people behind RoomYatra</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="text-center">
                            <img class="mx-auto h-40 w-40 rounded-full" src="/placeholder.svg?height=160&width=160"
                                alt="Team member">
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-gray-900">John Doe</h3>
                                <p class="text-sm text-gray-500">Co-Founder & CEO</p>
                                <p class="mt-2 text-sm text-gray-600">Passionate about creating solutions that make a real
                                    difference in people's lives.</p>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-gray-900">Our Impact</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-bold text-rose-600">5,000+</div>
                        <div class="text-sm text-gray-600 mt-2">Properties Listed</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-rose-600">10,000+</div>
                        <div class="text-sm text-gray-600 mt-2">Happy Tenants</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-rose-600">50+</div>
                        <div class="text-sm text-gray-600 mt-2">Cities Covered</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-rose-600">99%</div>
                        <div class="text-sm text-gray-600 mt-2">Customer Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-rose-600">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-white">Join the RoomYatra Community</h2>
                    <p class="mt-4 text-xl text-rose-100">Whether you're looking for a room or have one to rent, we're here
                        to help.</p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/rooms"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-rose-600 bg-white hover:bg-rose-50">
                            Find a Room
                        </a>
                        <a href="/register"
                            class="inline-flex items-center px-6 py-3 border border-white text-base font-medium rounded-md text-white bg-transparent hover:bg-rose-700">
                            List Your Property
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
