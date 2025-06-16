@extends('website.layouts.app')

@section('title', 'Page Not Found - RoomYatra')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <!-- 404 Icon -->
            <div class="mx-auto h-32 w-32 text-indigo-600 mb-8">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.562M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </div>

            <!-- 404 Text -->
            <h1 class="text-9xl font-bold text-gray-900 mb-4">404</h1>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Page Not Found</h2>
            <p class="text-lg text-gray-600 mb-8">
                Sorry, we couldn't find the page you're looking for. The page might have been moved, deleted, or you entered the wrong URL.
            </p>

            <!-- Action Buttons -->
            <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Go Home
                </a>
                
                <a href="{{ route('rooms') }}" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Browse Rooms
                </a>
            </div>

            <!-- Help Text -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    Need help? 
                    <a href="{{ route('contact') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Contact our support team
                    </a>
                </p>
            </div>

            <!-- Popular Links -->
            <div class="mt-8 border-t border-gray-200 pt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Popular Pages</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <a href="{{ route('properties.index') }}" class="text-indigo-600 hover:text-indigo-500">
                        All Properties
                    </a>
                    <a href="{{ route('howitworks') }}" class="text-indigo-600 hover:text-indigo-500">
                        How It Works
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500">
                            Register
                        </a>
                    @else
                        <a href="{{ route('profile') }}" class="text-indigo-600 hover:text-indigo-500">
                            Dashboard
                        </a>
                        <a href="{{ route('tenant-resources') }}" class="text-indigo-600 hover:text-indigo-500">
                            Resources
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
