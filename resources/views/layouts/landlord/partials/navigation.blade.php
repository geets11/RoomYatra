<nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-xl font-bold text-rose-600">RoomYatra</a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('landlord.dashboard') }}"
                            class="{{ Route::currentRouteName() == 'landlord.dashboard' ? 'border-rose-500' : 'border-transparent' }} text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="{{ route('landlord.properties.index') }}"
                            class="{{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'landlord.properties') ? 'border-rose-500 text-gray-900' : 'border-transparent text-gray-500' }} text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            My Properties
                        </a>
                        <a href="{{ route('landlord.bookings.index') }}"
                            class="{{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'landlord.bookings') ? 'border-rose-500 text-gray-900' : 'border-transparent text-gray-500' }} text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Bookings
                        </a>
                        <a href="{{ route('landlord.reviews.index') }}"
                            class="{{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'landlord.reviews') ? 'border-rose-500 text-gray-900' : 'border-transparent text-gray-500' }} text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Reviews
                        </a>
                        <a href="{{ route('landlord.support.index') }}"
                            class="{{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'landlord.support') ? 'border-rose-500 text-gray-900' : 'border-transparent text-gray-500' }} text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Support
                        </a>
                        <!-- <a href="/landlord/messages"
                            class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Messages
                        </a> -->
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                    <div class="relative">
                        <button type="button"
                            class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
