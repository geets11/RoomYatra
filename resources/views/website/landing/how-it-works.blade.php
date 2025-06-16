@extends('website.layouts.app')

@section('content')
    <!-- Page Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">How It Works</h1>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-rose-600 tracking-wide uppercase">Simple Process</h2>
                <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                    Find your perfect space in minutes
                </p>
                <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">
                    Whether you're a tenant looking for a room or a landlord with a property to rent, our platform makes the
                    process simple, secure, and stress-free.
                </p>
            </div>
        </div>
    </div>

    <!-- For Tenants Section -->
    <div class="bg-gray-50 py-16 overflow-hidden">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative">
                <h2 class="text-center text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    For Tenants
                </h2>
                <p class="mt-4 max-w-3xl mx-auto text-center text-xl text-gray-500">
                    Finding your next home should be exciting, not stressful. Here's how our platform helps you find the
                    perfect room.
                </p>
            </div>

            <!-- Step 1: Create Your Profile -->
            <div class="relative mt-12 lg:mt-20">
                <div class="lg:grid lg:grid-flow-row-dense lg:grid-cols-2 lg:gap-8 lg:items-center">
                    <div class="lg:col-start-2">
                        <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight sm:text-3xl">
                            1. Create Your Profile
                        </h3>
                        <p class="mt-3 text-lg text-gray-500">
                            Sign up and create your tenant profile. Tell landlords about yourself, your preferences, and
                            what you're looking for in a rental.
                        </p>

                        <dl class="mt-10 space-y-10">
                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Personalized Profile</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Add details about your lifestyle, occupation, and rental preferences to help landlords
                                    get to know you.
                                </dd>
                            </div>

                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Verified Account</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Verify your identity to build trust with landlords and increase your chances of securing
                                    your preferred room.
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-10 -mx-4 relative lg:mt-0 lg:col-start-1">
                        <img class="relative mx-auto rounded-lg shadow-lg"
                            src="https://images.unsplash.com/photo-1556761175-b413da4baf72?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&h=667&q=80" 
                            alt="Person creating their rental profile on laptop"
                            loading="lazy"
                            width="600" 
                            height="400">
                    </div>
                </div>
            </div>

            <!-- Step 2: Search and Filter -->
            <div class="relative mt-12 sm:mt-16 lg:mt-24">
                <div class="lg:grid lg:grid-flow-row-dense lg:grid-cols-2 lg:gap-8 lg:items-center">
                    <div class="lg:col-start-1">
                        <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight sm:text-3xl">
                            2. Search and Filter
                        </h3>
                        <p class="mt-3 text-lg text-gray-500">
                            Use our powerful search tools to find rooms that match your criteria. Filter by location, price,
                            room type, and amenities.
                        </p>

                        <dl class="mt-10 space-y-10">
                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Advanced Filters</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Find exactly what you're looking for with filters for property type, room size,
                                    furnishings, and more.
                                </dd>
                            </div>

                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Location-Based Search</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Search by neighborhood, proximity to public transport, or distance from your workplace
                                    or school.
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-10 -mx-4 relative lg:mt-0 lg:col-start-2">
                        <img class="relative mx-auto rounded-lg shadow-lg"
                            src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&h=667&q=80" 
                            alt="Person using search filters on rental website"
                            loading="lazy"
                            width="600" 
                            height="400">
                    </div>
                </div>
            </div>

            <!-- Step 3: Connect and View -->
            <div class="relative mt-12 lg:mt-24">
                <div class="lg:grid lg:grid-flow-row-dense lg:grid-cols-2 lg:gap-8 lg:items-center">
                    <div class="lg:col-start-2">
                        <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight sm:text-3xl">
                            3. Connect and View
                        </h3>
                        <p class="mt-3 text-lg text-gray-500">
                            Contact landlords directly through our secure messaging system. Schedule viewings at times that
                            work for you.
                        </p>

                        <dl class="mt-10 space-y-10">
                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Secure Messaging</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Communicate with landlords without sharing your personal contact information until
                                    you're ready.
                                </dd>
                            </div>

                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Viewing Scheduler</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Book property viewings directly through the platform with our integrated calendar
                                    system.
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-10 -mx-4 relative lg:mt-0 lg:col-start-1">
                        <img class="relative mx-auto rounded-lg shadow-lg"
                            src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&h=667&q=80" 
                            alt="Person messaging landlord and scheduling property viewing"
                            loading="lazy"
                            width="600" 
                            height="400">
                    </div>
                </div>
            </div>

            <!-- Step 4: Apply and Secure -->
            <div class="relative mt-12 sm:mt-16 lg:mt-24">
                <div class="lg:grid lg:grid-flow-row-dense lg:grid-cols-2 lg:gap-8 lg:items-center">
                    <div class="lg:col-start-1">
                        <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight sm:text-3xl">
                            4. Apply and Secure
                        </h3>
                        <p class="mt-3 text-lg text-gray-500">
                            Found the perfect room? Submit your application through our platform and secure your new home.
                        </p>

                        <dl class="mt-10 space-y-10">
                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Digital Applications</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Submit rental applications online with all your documents in one place.
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-10 -mx-4 relative lg:mt-0 lg:col-start-2">
                        <img class="relative mx-auto rounded-lg shadow-lg"
                            src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&h=667&q=80" 
                            alt="Person completing rental application and making secure payment"
                            loading="lazy"
                            width="600" 
                            height="400">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- For Landlords Section -->
    <div class="bg-white py-16 overflow-hidden">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative">
                <h2 class="text-center text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    For Landlords
                </h2>
                <p class="mt-4 max-w-3xl mx-auto text-center text-xl text-gray-500">
                    List your property, find reliable tenants, and manage your rentals all in one place.
                </p>
            </div>

            <!-- Step 1: Create Your Listing -->
            <div class="relative mt-12 lg:mt-20">
                <div class="lg:grid lg:grid-flow-row-dense lg:grid-cols-2 lg:gap-8 lg:items-center">
                    <div class="lg:col-start-2">
                        <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight sm:text-3xl">
                            1. Create Your Listing
                        </h3>
                        <p class="mt-3 text-lg text-gray-500">
                            List your property with detailed information, high-quality photos, and virtual tours to attract
                            the right tenants.
                        </p>

                        <dl class="mt-10 space-y-10">
                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Professional Listings</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Create attractive listings with our easy-to-use tools. Add photos, videos, and detailed
                                    descriptions.
                                </dd>
                            </div>

                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Maximum Visibility</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Your listings are optimized for search engines and promoted to relevant tenants on our
                                    platform.
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-10 -mx-4 relative lg:mt-0 lg:col-start-1">
                        <img class="relative mx-auto rounded-lg shadow-lg"
                            src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&h=667&q=80" 
                            alt="Landlord creating property listing with photos and details"
                            loading="lazy"
                            width="600" 
                            height="400">
                    </div>
                </div>
            </div>

            <!-- Step 2: Screen Tenants -->
            <div class="relative mt-12 sm:mt-16 lg:mt-24">
                <div class="lg:grid lg:grid-flow-row-dense lg:grid-cols-2 lg:gap-8 lg:items-center">
                    <div class="lg:col-start-1">
                        <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight sm:text-3xl">
                            2. Screen Tenants
                        </h3>
                        <p class="mt-3 text-lg text-gray-500">
                            Review tenant profiles, verify their information, and select the best match for your property.
                        </p>

                        <dl class="mt-10 space-y-10">
                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Tenant Verification</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Access background checks, credit scores, and rental history for potential tenants.
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-10 -mx-4 relative lg:mt-0 lg:col-start-2">
                        <img class="relative mx-auto rounded-lg shadow-lg"
                            src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&h=667&q=80" 
                            alt="Landlord reviewing tenant applications and profiles"
                            loading="lazy"
                            width="600" 
                            height="400">
                    </div>
                </div>
            </div>

            <!-- Step 3: Manage Your Rental -->
            <div class="relative mt-12 lg:mt-24">
                <div class="lg:grid lg:grid-flow-row-dense lg:grid-cols-2 lg:gap-8 lg:items-center">
                    <div class="lg:col-start-2">
                        <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight sm:text-3xl">
                            3. Manage Your Rental
                        </h3>
                        <p class="mt-3 text-lg text-gray-500">
                            Use our landlord dashboard to manage your properties, collect rent, and handle maintenance
                            requests.
                        </p>

                        <dl class="mt-10 space-y-10">
                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Rent Collection</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Collect rent from your tenant by your own.
                                </dd>
                            </div>

                            <div class="relative">
                                <dt>
                                    <div
                                        class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-rose-500 text-white">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Maintenance Requests</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">
                                    Receive and manage maintenance requests from tenants through our platform.
                                </dd>
                            </div>
                        </dl>  
                    </div>

                    <div class="mt-10 -mx-4 relative lg:mt-0 lg:col-start-1">
                        <img class="relative mx-auto rounded-lg shadow-lg"
                            src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&h=667&q=80" 
                            alt="Landlord using dashboard to manage properties and collect rent"
                            loading="lazy"
                            width="600" 
                            height="400">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto divide-y-2 divide-gray-200">
                <h2 class="text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Frequently Asked Questions
                </h2>
                <dl class="mt-6 space-y-6 divide-y divide-gray-200">
                    <div class="pt-6">
                        <dt class="text-lg">
                            <button
                                class="text-left w-full flex justify-between items-start text-gray-400 focus:outline-none faq-toggle"
                                data-target="faq-1">
                                <span class="font-medium text-gray-900">
                                    Is there a fee to list my property?
                                </span>
                                <span class="ml-6 h-7 flex items-center">
                                    <svg class="h-6 w-6 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                        </dt>
                        <dd class="mt-2 pr-12 hidden" id="faq-1">
                            <p class="text-base text-gray-500">
                                Basic listings are free. We offer premium listing options with enhanced visibility and
                                features for a small fee. You only pay when you find a tenant through our platform.
                            </p>
                        </dd>
                    </div>

                    <div class="pt-6">
                        <dt class="text-lg">
                            <button
                                class="text-left w-full flex justify-between items-start text-gray-400 focus:outline-none faq-toggle"
                                data-target="faq-2">
                                <span class="font-medium text-gray-900">
                                    How are tenants verified?
                                </span>
                                <span class="ml-6 h-7 flex items-center">
                                    <svg class="h-6 w-6 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                        </dt>
                        <dd class="mt-2 pr-12 hidden" id="faq-2">
                            <p class="text-base text-gray-500">
                                We verify tenant identities through a combination of ID verification, credit checks, and
                                references from previous landlords. Landlords can also request additional verification if
                                needed.
                            </p>
                        </dd>
                    </div>

                    <div class="pt-6">
                        <dt class="text-lg">
                            <button
                                class="text-left w-full flex justify-between items-start text-gray-400 focus:outline-none faq-toggle"
                                data-target="faq-3">
                                <span class="font-medium text-gray-900">
                                    How secure are payments through the platform?
                                </span>
                                <span class="ml-6 h-7 flex items-center">
                                    <svg class="h-6 w-6 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                        </dt>
                        <dd class="mt-2 pr-12 hidden" id="faq-3">
                            <p class="text-base text-gray-500">
                                All payments are in between tenant and landlord. We
                                offer protection for both parties.
                            </p>
                        </dd>
                    </div>

                    <div class="pt-6">
                        <dt class="text-lg">
                            <button
                                class="text-left w-full flex justify-between items-start text-gray-400 focus:outline-none faq-toggle"
                                data-target="faq-4">
                                <span class="font-medium text-gray-900">
                                    What if there's a dispute between landlord and tenant?
                                </span>
                                <span class="ml-6 h-7 flex items-center">
                                    <svg class="h-6 w-6 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                        </dt>
                        <dd class="mt-2 pr-12 hidden" id="faq-4">
                            <p class="text-base text-gray-500">
                                We offer a mediation service to help resolve disputes between landlords and tenants. Our
                                team will work with both parties to find a fair resolution based on the rental agreement and
                                platform policies.
                            </p>
                        </dd>
                    </div>

                    <div class="pt-6">
                        <dt class="text-lg">
                            <button
                                class="text-left w-full flex justify-between items-start text-gray-400 focus:outline-none faq-toggle"
                                data-target="faq-5">
                                <span class="font-medium text-gray-900">
                                    Can I list multiple properties?
                                </span>
                                <span class="ml-6 h-7 flex items-center">
                                    <svg class="h-6 w-6 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                        </dt>
                        <dd class="mt-2 pr-12 hidden" id="faq-5">
                            <p class="text-base text-gray-500">
                                Yes, you can list as many properties as you want. We offer special tools and dashboard views
                                for landlords with multiple properties to make management easier.
                            </p>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-rose-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Ready to get started?</span>
                <span class="block text-rose-200">Join our platform today.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-rose-600 bg-white hover:bg-rose-50 transition-colors duration-200">
                        Sign Up
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('about') }}"
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-rose-600 hover:bg-rose-500 transition-colors duration-200">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqToggles = document.querySelectorAll('.faq-toggle');
            
            faqToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetElement = document.getElementById(targetId);
                    const icon = this.querySelector('svg');
                    
                    if (targetElement.classList.contains('hidden')) {
                        // Close all other FAQs
                        faqToggles.forEach(otherToggle => {
                            const otherTargetId = otherToggle.getAttribute('data-target');
                            const otherTargetElement = document.getElementById(otherTargetId);
                            const otherIcon = otherToggle.querySelector('svg');
                            
                            if (otherTargetId !== targetId) {
                                otherTargetElement.classList.add('hidden');
                                otherIcon.classList.remove('rotate-180');
                            }
                        });
                        
                        // Open clicked FAQ
                        targetElement.classList.remove('hidden');
                        icon.classList.add('rotate-180');
                    } else {
                        // Close clicked FAQ
                        targetElement.classList.add('hidden');
                        icon.classList.remove('rotate-180');
                    }
                });
            });
        });
    </script>
@endsection