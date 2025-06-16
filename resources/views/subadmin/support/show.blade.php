@extends('layouts.subadmin.subadmin')

@section('title', 'Support Ticket Details')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header with Back Button -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('subadmin.support.index') }}" class="mr-3 text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-2xl font-semibold text-gray-800">Ticket #{{ $ticket->id }}</h1>
            </div>
            <div class="flex space-x-2">
                @if ($ticket->status !== 'closed')
                    <form action="{{ route('subadmin.support.update-status', $ticket) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="closed">
                        <button type="submit"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Close Ticket
                        </button>
                    </form>
                @endif

                @if ($ticket->status !== 'resolved' && $ticket->status !== 'closed')
                    <form action="{{ route('subadmin.support.update-status', $ticket) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="resolved">
                        <button type="submit"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Mark Resolved
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Ticket Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-800">Ticket Details</h3>
                        <div>
                            <span
                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $ticket->status === 'resolved'
                                ? 'bg-green-100 text-green-800'
                                : ($ticket->status === 'in_progress'
                                    ? 'bg-blue-100 text-blue-800'
                                    : ($ticket->status === 'open'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                            <span
                                class="ml-2 px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $ticket->priority === 'urgent'
                                ? 'bg-red-100 text-red-800'
                                : ($ticket->priority === 'high'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : ($ticket->priority === 'medium'
                                        ? 'bg-blue-100 text-blue-800'
                                        : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($ticket->priority) }} Priority
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $ticket->subject }}</h2>
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Created {{ $ticket->created_at->diffForHumans() }}
                                    ({{ $ticket->created_at->format('M d, Y H:i') }})</span>
                            </div>
                            <div class="prose max-w-none text-gray-700">
                                <p>{{ $ticket->message }}</p>
                            </div>
                        </div>

                        @if ($ticket->admin_response)
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-medium text-gray-800 mb-3">Admin Response</h3>
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <div class="prose max-w-none text-gray-700">
                                        <p>{{ $ticket->admin_response }}</p>
                                    </div>
                                    @if ($ticket->resolved_at)
                                        <div class="mt-2 text-sm text-gray-500">
                                            <span>Resolved on {{ $ticket->resolved_at->format('M d, Y H:i') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($ticket->status !== 'closed')
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-medium text-gray-800 mb-3">Respond to Ticket</h3>
                                <form action="{{ route('subadmin.support.respond', $ticket) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="response" class="block text-sm font-medium text-gray-700 mb-1">Your
                                            Response</label>
                                        <textarea id="response" name="response" rows="4"
                                            class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            placeholder="Type your response here...">{{ old('response') }}</textarea>
                                        @error('response')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Send Response
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-800">User Information</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div
                                class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-900">{{ $ticket->user->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $ticket->user->email }}</p>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">User ID</span>
                                <span class="text-sm font-medium text-gray-900">#{{ $ticket->user->id }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">Role</span>
                                <span class="text-sm font-medium text-gray-900">
                                    @if ($ticket->user->roles && $ticket->user->roles->count() > 0)
                                        @foreach ($ticket->user->roles as $role)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            User
                                        </span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">Joined</span>
                                <span
                                    class="text-sm font-medium text-gray-900">{{ $ticket->user->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">Total Tickets</span>
                                <span class="text-sm font-medium text-gray-900">{{ $userTicketsCount }}</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('subadmin.users.show', $ticket->user) }}"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">
                                View User Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Ticket Information -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-800">Ticket Information</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-500">Ticket ID</span>
                            <span class="text-sm font-medium text-gray-900">#{{ $ticket->id }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-500">Created</span>
                            <span
                                class="text-sm font-medium text-gray-900">{{ $ticket->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-500">Last Updated</span>
                            <span
                                class="text-sm font-medium text-gray-900">{{ $ticket->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                        @if ($ticket->resolved_at)
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">Resolved</span>
                                <span
                                    class="text-sm font-medium text-gray-900">{{ $ticket->resolved_at->format('M d, Y H:i') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-500">Status</span>
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $ticket->status === 'resolved'
                                ? 'bg-green-100 text-green-800'
                                : ($ticket->status === 'in_progress'
                                    ? 'bg-blue-100 text-blue-800'
                                    : ($ticket->status === 'open'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-500">Priority</span>
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $ticket->priority === 'urgent'
                                ? 'bg-red-100 text-red-800'
                                : ($ticket->priority === 'high'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : ($ticket->priority === 'medium'
                                        ? 'bg-blue-100 text-blue-800'
                                        : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
