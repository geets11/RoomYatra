@extends('layouts.subadmin.subadmin')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Settings</h1>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Settings Navigation -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Settings</h3>
                        </div>
                        <nav class="space-y-1">
                            <a href="#profile" onclick="showTab('profile')"
                                class="tab-link bg-rose-50 border-r-2 border-rose-500 text-rose-700 block pl-3 pr-4 py-2 text-sm font-medium">
                                Profile Settings
                            </a>
                            <a href="#security" onclick="showTab('security')"
                                class="tab-link text-gray-600 hover:bg-gray-50 hover:text-gray-900 block pl-3 pr-4 py-2 text-sm font-medium">
                                Security
                            </a>
                            <a href="#notifications" onclick="showTab('notifications')"
                                class="tab-link text-gray-600 hover:bg-gray-50 hover:text-gray-900 block pl-3 pr-4 py-2 text-sm font-medium">
                                Notifications
                            </a>
                            <a href="#system" onclick="showTab('system')"
                                class="tab-link text-gray-600 hover:bg-gray-50 hover:text-gray-900 block pl-3 pr-4 py-2 text-sm font-medium">
                                System Settings
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Settings Content -->
                <div class="lg:col-span-2">
                    <!-- Profile Settings -->
                    <div id="profile-tab" class="tab-content">
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
                                <p class="text-sm text-gray-500">Update your account's profile information and email address.</p>
                            </div>
                            <div class="px-6 py-4">
                                <form action="{{ route('subadmin.settings.profile') }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                            <input type="text" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <button type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div id="security-tab" class="tab-content hidden">
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Change Password</h3>
                                <p class="text-sm text-gray-500">Ensure your account is using a long, random password to stay secure.</p>
                            </div>
                            <div class="px-6 py-4">
                                <form action="{{ route('subadmin.settings.password') }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6">
                                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                            <input type="password" name="current_password" id="current_password"
                                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                            <input type="password" name="password" id="password"
                                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <button type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                            Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Settings -->
                    <div id="notifications-tab" class="tab-content hidden">
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Notification Preferences</h3>
                                <p class="text-sm text-gray-500">Configure how you want to receive notifications.</p>
                            </div>
                            <div class="px-6 py-4">
                                <form action="{{ route('subadmin.settings.notifications') }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <div class="space-y-6">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="email_notifications" name="email_notifications" type="checkbox" 
                                                    {{ Auth::user()->email_notifications ?? true ? 'checked' : '' }}
                                                    class="focus:ring-rose-500 h-4 w-4 text-rose-600 border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="email_notifications" class="font-medium text-gray-700">Email Notifications</label>
                                                <p class="text-gray-500">Receive email notifications for important updates.</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="new_user_notifications" name="new_user_notifications" type="checkbox"
                                                    {{ Auth::user()->new_user_notifications ?? true ? 'checked' : '' }}
                                                    class="focus:ring-rose-500 h-4 w-4 text-rose-600 border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="new_user_notifications" class="font-medium text-gray-700">New User Registrations</label>
                                                <p class="text-gray-500">Get notified when new users register.</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="property_notifications" name="property_notifications" type="checkbox"
                                                    {{ Auth::user()->property_notifications ?? true ? 'checked' : '' }}
                                                    class="focus:ring-rose-500 h-4 w-4 text-rose-600 border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="property_notifications" class="font-medium text-gray-700">Property Submissions</label>
                                                <p class="text-gray-500">Get notified when new properties are submitted for approval.</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="support_notifications" name="support_notifications" type="checkbox"
                                                    {{ Auth::user()->support_notifications ?? true ? 'checked' : '' }}
                                                    class="focus:ring-rose-500 h-4 w-4 text-rose-600 border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="support_notifications" class="font-medium text-gray-700">Support Tickets</label>
                                                <p class="text-gray-500">Get notified about new support tickets.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <button type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                            Save Preferences
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- System Settings -->
                    <div id="system-tab" class="tab-content hidden">
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">System Information</h3>
                                <p class="text-sm text-gray-500">View system information and application settings.</p>
                            </div>
                            <div class="px-6 py-4">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Application Version</dt>
                                        <dd class="mt-1 text-sm text-gray-900">1.0.0</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Laravel Version</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ app()->version() }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">PHP Version</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ phpversion() }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Environment</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ app()->environment() }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Database</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ config('database.default') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Cache Driver</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ config('cache.default') }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Remove active class from all tab links
            document.querySelectorAll('.tab-link').forEach(link => {
                link.classList.remove('bg-rose-50', 'border-r-2', 'border-rose-500', 'text-rose-700');
                link.classList.add('text-gray-600', 'hover:bg-gray-50', 'hover:text-gray-900');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-tab').classList.remove('hidden');
            
            // Add active class to selected tab link
            event.target.classList.add('bg-rose-50', 'border-r-2', 'border-rose-500', 'text-rose-700');
            event.target.classList.remove('text-gray-600', 'hover:bg-gray-50', 'hover:text-gray-900');
        }
    </script>
@endsection
