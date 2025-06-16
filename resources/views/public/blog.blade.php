@extends('website.layouts.app')

@section('title', 'Blog - RoomYatra')

@section('content')
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="bg-rose-600">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold text-white sm:text-5xl">RoomYatra Blog</h1>
                    <p class="mt-4 text-xl text-purple-100">Tips, guides, and insights for landlords and tenants</p>
                </div>
            </div>
        </div>

        <!-- Featured Post -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Featured Article</h2>
                </div>

                <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="lg:grid lg:grid-cols-2 lg:gap-0">
                        <div class="relative">
                            <img class="w-full h-64 lg:h-full object-cover" src="/placeholder.svg?height=400&width=600"
                                alt="Featured post">
                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-rose-600 text-white px-3 py-1 rounded-full text-sm font-medium">Featured</span>
                            </div>
                        </div>
                        <div class="p-8 lg:p-12">
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <span>December 15, 2024</span>
                                <span class="mx-2">•</span>
                                <span>5 min read</span>
                                <span class="mx-2">•</span>
                                <span class="text-rose-600">Tenant Tips</span>
                            </div>
                            <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">
                                The Ultimate Guide to Finding Your Perfect Room in 2025
                            </h3>
                            <p class="text-gray-600 mb-6">
                                Discover the essential tips and strategies for finding the ideal rental room that fits your
                                budget, lifestyle, and preferences. From setting your budget to negotiating lease terms, we
                                cover everything you need to know.
                            </p>
                            <a href="#"
                                class="inline-flex items-center text-rose-600 hover:text-rose-700 font-medium">
                                Read Full Article
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Filter -->
        <div class="bg-gray-50 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap justify-center gap-4">
                    <button class="bg-rose-600 text-white px-6 py-2 rounded-full font-medium">All Posts</button>
                    <button class="bg-white text-gray-700 px-6 py-2 rounded-full font-medium hover:bg-gray-100">Tenant
                        Tips</button>
                    <button class="bg-white text-gray-700 px-6 py-2 rounded-full font-medium hover:bg-gray-100">Landlord
                        Guides</button>
                    <button class="bg-white text-gray-700 px-6 py-2 rounded-full font-medium hover:bg-gray-100">Market
                        Insights</button>
                    <button class="bg-white text-gray-700 px-6 py-2 rounded-full font-medium hover:bg-gray-100">Legal
                        Advice</button>
                    <button
                        class="bg-white text-gray-700 px-6 py-2 rounded-full font-medium hover:bg-gray-100">Technology</button>
                </div>
            </div>
        </div>

        <!-- Blog Posts Grid -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    <!-- Blog Post 1 -->
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="/placeholder.svg?height=200&width=400" alt="Blog post" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <span>December 10, 2024</span>
                                <span class="mx-2">•</span>
                                <span class="text-blue-600">Legal Advice</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                Understanding Your Rental Agreement: Key Terms Explained
                            </h3>
                            <p class="text-gray-600 mb-4">
                                Learn about the most important clauses in rental agreements and what to look out for before
                                signing your lease.
                            </p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">Read More →</a>
                        </div>
                    </article>

                    <!-- Blog Post 2 -->
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="/placeholder.svg?height=200&width=400" alt="Blog post" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <span>December 8, 2024</span>
                                <span class="mx-2">•</span>
                                <span class="text-green-600">Landlord Guides</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                Maximizing Your Rental Property ROI: 10 Proven Strategies
                            </h3>
                            <p class="text-gray-600 mb-4">
                                Discover effective ways to increase your rental income and property value while keeping
                                tenants happy.
                            </p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">Read More →</a>
                        </div>
                    </article>

                    <!-- Blog Post 3 -->
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="/placeholder.svg?height=200&width=400" alt="Blog post" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <span>December 5, 2024</span>
                                <span class="mx-2">•</span>
                                <span class="text-purple-600">Tenant Tips</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                Moving Day Checklist: Everything You Need to Know
                            </h3>
                            <p class="text-gray-600 mb-4">
                                A comprehensive guide to ensure your moving day goes smoothly, from packing tips to utility
                                transfers.
                            </p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">Read More →</a>
                        </div>
                    </article>

                    <!-- Blog Post 4 -->
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="/placeholder.svg?height=200&width=400" alt="Blog post" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <span>December 3, 2024</span>
                                <span class="mx-2">•</span>
                                <span class="text-orange-600">Market Insights</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                2025 Rental Market Trends: What to Expect
                            </h3>
                            <p class="text-gray-600 mb-4">
                                Analyze the latest rental market trends and predictions for the upcoming year across major
                                cities.
                            </p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">Read More →</a>
                        </div>
                    </article>

                    <!-- Blog Post 5 -->
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="/placeholder.svg?height=200&width=400" alt="Blog post" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <span>November 30, 2024</span>
                                <span class="mx-2">•</span>
                                <span class="text-indigo-600">Technology</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                Smart Home Features That Attract Modern Tenants
                            </h3>
                            <p class="text-gray-600 mb-4">
                                Explore the latest smart home technologies that can make your rental property more appealing
                                to tech-savvy tenants.
                            </p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">Read More →</a>
                        </div>
                    </article>

                    <!-- Blog Post 6 -->
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="/placeholder.svg?height=200&width=400" alt="Blog post"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <span>November 28, 2024</span>
                                <span class="mx-2">•</span>
                                <span class="text-green-600">Landlord Guides</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                Tenant Screening Best Practices for Landlords
                            </h3>
                            <p class="text-gray-600 mb-4">
                                Learn how to effectively screen potential tenants while staying compliant with fair housing
                                laws.
                            </p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">Read More →</a>
                        </div>
                    </article>

                    <!-- Blog Post 7 -->
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="/placeholder.svg?height=200&width=400" alt="Blog post"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <span>November 25, 2024</span>
                                <span class="mx-2">•</span>
                                <span class="text-purple-600">Tenant Tips</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                How to Budget for Your First Rental: A Complete Guide
                            </h3>
                            <p class="text-gray-600 mb-4">
                                Master the art of rental budgeting with our step-by-step guide covering all hidden costs and
                                expenses.
                            </p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">Read More →</a>
                        </div>
                    </article>

                    <!-- Blog Post 8 -->
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="/placeholder.svg?height=200&width=400" alt="Blog post"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <span>November 22, 2024</span>
                                <span class="mx-2">•</span>
                                <span class="text-green-600">Landlord Guides</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                Essential Property Maintenance Tips for New Landlords
                            </h3>
                            <p class="text-gray-600 mb-4">
                                Keep your rental property in top condition with these essential maintenance tips and
                                preventive measures.
                            </p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">Read More →</a>
                        </div>
                    </article>

                    <!-- Blog Post 9 -->
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="/placeholder.svg?height=200&width=400" alt="Blog post"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <span>November 20, 2024</span>
                                <span class="mx-2">•</span>
                                <span class="text-purple-600">Tenant Tips</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">
                                Living with Roommates: Setting Boundaries and Expectations
                            </h3>
                            <p class="text-gray-600 mb-4">
                                Navigate shared living spaces successfully with our guide to roommate etiquette and
                                communication.
                            </p>
                            <a href="#" class="text-rose-600 hover:text-rose-700 font-medium">Read More →</a>
                        </div>
                    </article>
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <button class="px-3 py-2 text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button class="px-4 py-2 bg-rose-600 text-white rounded-md">1</button>
                        <button class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">2</button>
                        <button class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">3</button>
                        <span class="px-4 py-2 text-gray-500">...</span>
                        <button class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">10</button>
                        <button class="px-3 py-2 text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Newsletter Subscription -->
        <div class="bg-gray-900 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-white">Stay Updated</h2>
                    <p class="mt-4 text-lg text-gray-300">Get the latest rental tips and market insights delivered to your
                        inbox.</p>
                    <div class="mt-8 max-w-md mx-auto">
                        <form class="flex">
                            <input type="email" placeholder="Enter your email"
                                class="flex-1 px-4 py-3 rounded-l-md border-0 focus:ring-2 focus:ring-rose-500">
                            <button type="submit"
                                class="px-6 py-3 bg-rose-600 text-white rounded-r-md hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500">
                                Subscribe
                            </button>
                        </form>
                        <p class="mt-2 text-sm text-gray-400">No spam, unsubscribe at any time.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Tags -->
        <div class="bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Popular Tags</h3>
                <div class="flex flex-wrap gap-3">
                    <span
                        class="bg-white px-4 py-2 rounded-full text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">#RentalTips</span>
                    <span
                        class="bg-white px-4 py-2 rounded-full text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">#PropertyManagement</span>
                    <span
                        class="bg-white px-4 py-2 rounded-full text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">#TenantRights</span>
                    <span
                        class="bg-white px-4 py-2 rounded-full text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">#RealEstate</span>
                    <span
                        class="bg-white px-4 py-2 rounded-full text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">#RentalMarket</span>
                    <span
                        class="bg-white px-4 py-2 rounded-full text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">#LandlordAdvice</span>
                    <span
                        class="bg-white px-4 py-2 rounded-full text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">#MovingTips</span>
                    <span
                        class="bg-white px-4 py-2 rounded-full text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">#RoomSharing</span>
                    <span
                        class="bg-white px-4 py-2 rounded-full text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">#RentalAgreement</span>
                    <span
                        class="bg-white px-4 py-2 rounded-full text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">#PropertyInvestment</span>
                </div>
            </div>
        </div>

        <!-- Recent Comments Section -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-8">Recent Comments</h3>
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm border">
                        <div class="flex items-start space-x-4">
                            <img src="/placeholder.svg?height=40&width=40" alt="Commenter"
                                class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h4 class="font-semibold text-gray-900">Sarah Johnson</h4>
                                    <span class="text-sm text-gray-500">2 hours ago</span>
                                </div>
                                <p class="text-gray-600 mt-1">Great article! The tips about budgeting really helped me plan
                                    for my first rental.</p>
                                <p class="text-sm text-gray-500 mt-2">on <a href="#"
                                        class="text-rose-600 hover:text-rose-700">How to Budget for Your First Rental</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border">
                        <div class="flex items-start space-x-4">
                            <img src="/placeholder.svg?height=40&width=40" alt="Commenter"
                                class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h4 class="font-semibold text-gray-900">Mike Chen</h4>
                                    <span class="text-sm text-gray-500">5 hours ago</span>
                                </div>
                                <p class="text-gray-600 mt-1">As a landlord, the tenant screening guide was incredibly
                                    helpful. Thanks for the detailed breakdown!</p>
                                <p class="text-sm text-gray-500 mt-2">on <a href="#"
                                        class="text-rose-600 hover:text-rose-700">Tenant Screening Best Practices</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border">
                        <div class="flex items-start space-x-4">
                            <img src="/placeholder.svg?height=40&width=40" alt="Commenter"
                                class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h4 class="font-semibold text-gray-900">Emily Rodriguez</h4>
                                    <span class="text-sm text-gray-500">1 day ago</span>
                                </div>
                                <p class="text-gray-600 mt-1">The moving checklist saved me so much stress! Everything went
                                    smoothly thanks to your guide.</p>
                                <p class="text-sm text-gray-500 mt-2">on <a href="#"
                                        class="text-rose-600 hover:text-rose-700">Moving Day Checklist</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Category filter functionality
            document.addEventListener('DOMContentLoaded', function() {
                const categoryButtons = document.querySelectorAll('button[class*="bg-"]');

                categoryButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Remove active class from all buttons
                        categoryButtons.forEach(btn => {
                            btn.classList.remove('bg-rose-600', 'text-white');
                            btn.classList.add('bg-white', 'text-gray-700');
                        });

                        // Add active class to clicked button
                        this.classList.remove('bg-white', 'text-gray-700');
                        this.classList.add('bg-rose-600', 'text-white');

                        // Here you would typically filter the blog posts
                        // For now, we'll just log the selected category
                        console.log('Selected category:', this.textContent);
                    });
                });
            });
        </script>
    @endpush
@endsection
