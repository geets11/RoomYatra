@extends('layouts.tenant.tenant')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('tenant.support.index') }}" 
                       class="text-gray-600 hover:text-gray-900 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Support Ticket #{{ $ticket->id }}</h1>
                        <p class="mt-2 text-gray-600">{{ $ticket->subject }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                        @if($ticket->status == 'open') bg-yellow-100 text-yellow-800
                        @elseif($ticket->status == 'in_progress') bg-blue-100 text-blue-800
                        @elseif($ticket->status == 'resolved') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                        @if($ticket->priority == 'low') bg-green-100 text-green-800
                        @elseif($ticket->priority == 'medium') bg-yellow-100 text-yellow-800
                        @elseif($ticket->priority == 'high') bg-orange-100 text-orange-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($ticket->priority) }} Priority
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Ticket Details -->
                <div class="bg-white shadow-sm rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Ticket Details</h3>
                        <div class="prose max-w-none">
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $ticket->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Update Ticket (if not resolved/closed) -->
                @if(!in_array($ticket->status, ['resolved', 'closed']))
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Ticket</h3>
                            <form action="{{ route('tenant.support.update', $ticket) }}" method="POST" class="space-y-4">
                                @csrf  $ticket) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                
                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                    <input type="text" name="subject" id="subject" value="{{ $ticket->subject }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                                    <select name="priority" id="priority" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="urgent" {{ $ticket->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea name="description" id="description" rows="4" required
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $ticket->description }}</textarea>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors duration-200">
                                        Update Ticket
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Ticket Information -->
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Ticket Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created</dt>
                                <dd class="text-sm text-gray-900">{{ $ticket->created_at->format('M d, Y \a\t g:i A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="text-sm text-gray-900">{{ $ticket->updated_at->format('M d, Y \a\t g:i A') }}</dd>
                            </div>
                            @if($ticket->assignedTo)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Assigned To</dt>
                                    <dd class="text-sm text-gray-900">{{ $ticket->assignedTo->name }}</dd>
                                </div>
                            @endif
                            @if($ticket->resolved_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Resolved</dt>
                                    <dd class="text-sm text-gray-900">{{ $ticket->resolved_at->format('M d, Y \a\t g:i A') }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Actions -->
                @if(in_array($ticket->status, ['open', 'in_progress']))
                    <div class="bg-white shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                            <form action="{{ route('tenant.support.cancel', $ticket) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors duration-200"
                                        onclick="return confirm('Are you sure you want to cancel this ticket?')">
                                    Cancel Ticket
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
