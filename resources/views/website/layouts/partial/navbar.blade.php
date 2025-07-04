<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-xl font-bold text-rose-600">RoomYatra</span>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('home') }}"
                        class="border-rose-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Home
                    </a>
                    <a href="{{ route('rooms') }}"
                        class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Rooms
                    </a>
                    <a href="{{ route('howitworks') }}"
                        class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        How It Works
                    </a>
                    <a href="{{ route('contact') }}"
                        class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Contact
                    </a>
                </div>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                @if (Auth::check())
                    @php
                        $dashboardRoute = route('home');
                        $user = auth()->user();
                        
                        if ($user->hasRole('admin')) {
                            $dashboardRoute = route('admin.dashboard');
                        } elseif ($user->hasRole('landlord')) {
                            $dashboardRoute = route('landlord.dashboard');
                        } elseif ($user->hasRole('tenant')) {
                            $dashboardRoute = route('tenant.dashboard');
                        } elseif ($user->hasRole('subadmin')) {
                            $dashboardRoute = route('subadmin.dashboard');
                        }
                    @endphp
                    <a href="{{ $dashboardRoute }}"
                        class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-rose-600 text-white hover:bg-rose-700 px-4 py-2 rounded-md text-sm font-medium">
                        Sign Up
                    </a>
                @endif
            </div>
            <div class="-mr-2 flex items-center sm:hidden">
                <button type="button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-rose-500"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
