@extends('layouts.admin.admin')

@section('content')
   <div class="bg-white shadow">
       <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
           <div class="flex items-center justify-between">
               <h1 class="text-3xl font-bold text-gray-900">{{ $property->title }} Details</h1>
               <div class="flex space-x-3">
                   <button id="status_button" type="button"
                       class="items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                       Edit Status
                   </button>
                   <button id="save" type="button"
                       class="hidden items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                       Save
                   </button>
                   <select name="status" id="status" required
                       class="hidden items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                       <option value="" selected>Select a status</option>
                       <option value="approved">Approved</option>
                       <option value="rejected">Rejected</option>
                       <option value="pending">Pending</option>
                       <option value="available">Available</option>
                       <option value="booked">Booked</option>
                       <option value="undermaintenance">Under Maintenance</option>
                   </select>
                   <a href="{{ route('admin.properties') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                       Back to Properties
                   </a>
               </div>
           </div>
       </div>
   </div>

   <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
       <!-- Current Booking Information -->
       <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
           <div class="px-4 py-5 sm:px-6">
               <h3 class="text-lg leading-6 font-medium text-gray-900">🏠 Current Booking Status</h3>
               <p class="mt-1 max-w-2xl text-sm text-gray-500">Real-time occupancy information</p>
           </div>

           @php
               $currentBooking = $property->bookings()
                   ->where('status', 'approved')
                   ->where('check_in', '<=', now())
                  
                   ->with('user')
                   ->first();

               $upcomingBooking = $property->bookings()
                   ->where('status', 'approved')
                   ->where('check_in', '>', now())
                   ->with('user')
                   ->orderBy('check_in')
                   ->first();
           @endphp

           <div class="px-4 pb-5 sm:px-6">
               @if($currentBooking)
                   <!-- Currently Occupied -->
                   <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                       <div class="flex items-center justify-between">
                           <div class="flex items-center">
                               <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                               <h4 class="text-lg font-medium text-red-800">Currently Occupied</h4>
                           </div>
                           <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">OCCUPIED</span>
                       </div>

                       <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                           <div>
                               <h5 class="font-medium text-gray-900 mb-2">👤 Current Tenant</h5>
                               <div class="space-y-1 text-sm">
                                   <p><strong>Name:</strong> {{ $currentBooking->user->name }}</p>
                                   <p><strong>Email:</strong> {{ $currentBooking->user->email }}</p>
                                   <p><strong>Phone:</strong> {{ $currentBooking->user->phone ?? 'Not provided' }}</p>
                               </div>
                           </div>
                           <div>
                               <h5 class="font-medium text-gray-900 mb-2">📅 Booking Details</h5>
                               <div class="space-y-1 text-sm">
                                   <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($currentBooking->check_in)->format('M d, Y') }}</p>
                                  
                                   <!-- <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse($currentBooking->check_in)->diffInDays(\Carbon\Carbon::parse($currentBooking->check_out)) }} days</p>
                                   <p><strong>Amount:</strong> NPR {{ number_format($currentBooking->total_amount, 2) }}</p> -->
                               </div>
                           </div>
                       </div>

                       <div class="mt-4 flex space-x-3">
                           <a href="{{ route('admin.bookings.show', $currentBooking->id) }}"
                              class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                               View Booking Details
                           </a>
                           <a href="{{ route('admin.users.show', $currentBooking->user->id) }}"
                              class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                               View Tenant Profile
                           </a>
                       </div>
                   </div>
               @elseif($upcomingBooking)
                   <!-- Upcoming Booking -->
                   <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                       <div class="flex items-center justify-between">
                           <div class="flex items-center">
                               <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                               <h4 class="text-lg font-medium text-yellow-800">Upcoming Booking</h4>
                           </div>
                           <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">RESERVED</span>
                       </div>

                       <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                           <div>
                               <h5 class="font-medium text-gray-900 mb-2">👤 Incoming Tenant</h5>
                               <div class="space-y-1 text-sm">
                                   <p><strong>Name:</strong> {{ $upcomingBooking->user->name }}</p>
                                   <p><strong>Email:</strong> {{ $upcomingBooking->user->email }}</p>
                                   <p><strong>Phone:</strong> {{ $upcomingBooking->user->phone ?? 'Not provided' }}</p>
                               </div>
                           </div>
                           <div>
                               <h5 class="font-medium text-gray-900 mb-2">📅 Booking Details</h5>
                               <div class="space-y-1 text-sm">
                                   <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($upcomingBooking->check_in)->format('M d, Y') }}</p>
                                   
                                   <p><strong>Days until check-in:</strong> {{ now()->diffInDays(\Carbon\Carbon::parse($upcomingBooking->check_in)) }} days</p>
                                   <!-- <p><strong>Amount:</strong> NPR {{ number_format($upcomingBooking->total_amount, 2) }}</p> -->
                               </div>
                           </div>
                       </div>

                       <div class="mt-4 flex space-x-3">
                           <a href="{{ route('admin.bookings.show', $upcomingBooking->id) }}"
                              class="inline-flex items-center px-3 py-2 border border-yellow-300 shadow-sm text-sm leading-4 font-medium rounded-md text-yellow-700 bg-white hover:bg-yellow-50">
                               View Booking Details
                           </a>
                           <a href="{{ route('admin.users.show', $upcomingBooking->user->id) }}"
                              class="inline-flex items-center px-3 py-2 border border-yellow-300 shadow-sm text-sm leading-4 font-medium rounded-md text-yellow-700 bg-white hover:bg-yellow-50">
                               View Tenant Profile
                           </a>
                       </div>
                   </div>
               @else
                   <!-- Available -->
                   <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                       <div class="flex items-center justify-between">
                           <div class="flex items-center">
                               <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                               <h4 class="text-lg font-medium text-green-800">Available for Booking</h4>
                           </div>
                           <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">AVAILABLE</span>
                       </div>
                       <p class="mt-2 text-sm text-green-700">This property is currently available and ready for new bookings.</p>
                   </div>
               @endif
           </div>
       </div>

       <div class="bg-white shadow overflow-hidden sm:rounded-lg">
           <!-- Property Status -->
           <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
               <div>
                   <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $property->title }}</h3>
                   <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $property->propertyType->name }} in
                       {{ $property->city }}, {{ $property->state }}</p>
               </div>
               <span class="@class([
                   'px-2 py-1 text-xs font-semibold rounded-full',
                   'bg-green-100 text-green-800' => $property->status === 'approved' || $property->status === 'available',
                   'bg-red-100 text-red-800' => $property->status === 'rejected' || $property->status === 'undermaintenance',
                   'bg-blue-100 text-blue-800' => $property->status === 'booked',
                   'bg-yellow-100 text-yellow-800' => !in_array($property->status, [
                       'approved',
                       'rejected',
                       'available',
                       'booked',
                       'undermaintenance',
                   ]),
               ])">
                   {{ ucfirst($property->status) }}
               </span>
           </div>

           <!-- Property Images -->
           <div class="border-t border-gray-200">
               <div class="px-4 py-5 sm:px-6">
                   <h3 class="text-lg leading-6 font-medium text-gray-900">Images</h3>
               </div>
               <div class="px-4 pb-5 sm:px-6">
                   <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                       @forelse ($property->images as $image)
                           <div class="relative">
                               <img src="{{ asset('storage/' . $image->image_path) }}" alt="Property image"
                                   class="h-24 w-full object-cover rounded">
                               @if ($image->is_primary)
                                   <div class="absolute top-0 right-0 bg-rose-500 text-white text-xs px-2 py-1 rounded-bl">
                                       Primary
                                   </div>
                               @endif
                           </div>
                       @empty
                           <div class="col-span-full text-center py-4 text-gray-500">
                               No images available
                           </div>
                       @endforelse
                   </div>
               </div>
           </div>

           <!-- Property Details -->
           <div class="border-t border-gray-200">
               <dl>
                   <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                       <dt class="text-sm font-medium text-gray-500">Price</dt>
                       <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">NPR{{ number_format($property->price) }}
                           / {{ $property->price_type }}</dd>
                   </div>
                   <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                       <dt class="text-sm font-medium text-gray-500">Description</dt>
                       <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $property->description }}</dd>
                   </div>
                   <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                       <dt class="text-sm font-medium text-gray-500">Address</dt>
                       <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                           {{ $property->address }}<br>
                           {{ $property->city }}, {{ $property->state }} {{ $property->zip_code }}<br>
                           {{ $property->country }}
                       </dd>
                   </div>
                   <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                       <dt class="text-sm font-medium text-gray-500">Property Details</dt>
                       <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                           <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                               <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                   <div class="w-0 flex-1 flex items-center">
                                       <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                           viewBox="0 0 20 20" fill="currentColor">
                                           <path
                                               d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                       </svg>
                                       <span class="ml-2">Bedrooms</span>
                                   </div>
                                   <div class="ml-4 flex-shrink-0">
                                       <span>{{ $property->bedrooms }}</span>
                                   </div>
                               </li>
                               <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                   <div class="w-0 flex-1 flex items-center">
                                       <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                           viewBox="0 0 20 20" fill="currentColor">
                                           <path fill-rule="evenodd"
                                               d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                               clip-rule="evenodd" />
                                       </svg>
                                       <span class="ml-2">Bathrooms</span>
                                   </div>
                                   <div class="ml-4 flex-shrink-0">
                                       <span>{{ $property->bathrooms }}</span>
                                   </div>
                               </li>
                               <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                   <div class="w-0 flex-1 flex items-center">
                                       <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                           viewBox="0 0 20 20" fill="currentColor">
                                           <path fill-rule="evenodd"
                                               d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                               clip-rule="evenodd" />
                                       </svg>
                                       <span class="ml-2">Size</span>
                                   </div>
                                   <div class="ml-4 flex-shrink-0">
                                       <span>{{ $property->size ? $property->size . ' sq ft' : 'Not specified' }}</span>
                                   </div>
                               </li>
                               <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                   <div class="w-0 flex-1 flex items-center">
                                       <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                           viewBox="0 0 20 20" fill="currentColor">
                                           <path
                                               d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                       </svg>
                                       <span class="ml-2">Furnished</span>
                                   </div>
                                   <div class="ml-4 flex-shrink-0">
                                       <span>{{ $property->is_furnished ? 'Yes' : 'No' }}</span>
                                   </div>
                               </li>
                               <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                   <div class="w-0 flex-1 flex items-center">
                                       <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                           viewBox="0 0 20 20" fill="currentColor">
                                           <path fill-rule="evenodd"
                                               d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                               clip-rule="evenodd" />
                                       </svg>
                                       <span class="ml-2">Available From</span>
                                   </div>
                                   <div class="ml-4 flex-shrink-0">
                                       <span>{{ $property->available_from ? $property->available_from->format('M d, Y') : 'Immediately' }}</span>
                                   </div>
                               </li>
                           </ul>
                       </dd>
                   </div>
                   <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                       <dt class="text-sm font-medium text-gray-500">Amenities</dt>
                       <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                           <div class="flex flex-wrap gap-2">
                               @forelse ($property->amenities as $amenity)
                                   <span
                                       class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                       {{ $amenity->name }}
                                   </span>
                               @empty
                                   <span class="text-gray-500">No amenities specified</span>
                               @endforelse
                           </div>
                       </dd>
                   </div>
                   <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                       <dt class="text-sm font-medium text-gray-500">Created At</dt>
                       <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                           {{ $property->created_at->format('F j, Y, g:i a') }}</dd>
                   </div>
                   <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                       <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                       <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                           {{ $property->updated_at->format('F j, Y, g:i a') }}</dd>
                   </div>
               </dl>
           </div>

           <!-- Bookings Information -->
           <div class="border-t border-gray-200">
               <div class="px-4 py-5 sm:px-6">
                   <h3 class="text-lg leading-6 font-medium text-gray-900">Booking History</h3>
                   <p class="mt-1 max-w-2xl text-sm text-gray-500">All bookings for this property</p>
               </div>
               <div class="px-4 pb-5 sm:px-6">
                   @if($property->bookings->count() > 0)
                       <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                           <table class="min-w-full divide-y divide-gray-300">
                               <thead class="bg-gray-50">
                                   <tr>
                                       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                           Tenant
                                       </th>
                                       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                           Check-in
                                       </th>
                                       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                           Check-out
                                       </th>
                                       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                           Duration
                                       </th>
                                       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                           Amount
                                       </th>
                                       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                           Status
                                       </th>
                                       <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                           Booked On
                                       </th>
                                       <th scope="col" class="relative px-6 py-3">
                                           <span class="sr-only">Actions</span>
                                       </th>
                                   </tr>
                               </thead>
                               <tbody class="bg-white divide-y divide-gray-200">
                                   @foreach($property->bookings->sortByDesc('created_at') as $booking)
                                       <tr class="hover:bg-gray-50">
                                           <td class="px-6 py-4 whitespace-nowrap">
                                               <div class="flex items-center">
                                                   <div class="flex-shrink-0 h-10 w-10">
                                                       <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                           <span class="text-sm font-medium text-gray-700">
                                                               {{ substr($booking->user->name, 0, 2) }}
                                                           </span>
                                                       </div>
                                                   </div>
                                                   <div class="ml-4">
                                                       <div class="text-sm font-medium text-gray-900">
                                                           {{ $booking->user->name }}
                                                       </div>
                                                       <div class="text-sm text-gray-500">
                                                           {{ $booking->user->email }}
                                                       </div>
                                                       @if($booking->user->phone)
                                                           <div class="text-sm text-gray-500">
                                                               {{ $booking->user->phone }}
                                                           </div>
                                                       @endif
                                                   </div>
                                               </div>
                                           </td>
                                           <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                               {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                                           </td>
                                           <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                               {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                                           </td>
                                           <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                               {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} days
                                           </td>
                                           <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                               NPR {{ number_format($booking->total_amount) }}
                                           </td>
                                           <td class="px-6 py-4 whitespace-nowrap">
                                               <span class="@class([
                                                   'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                   'bg-green-100 text-green-800' => $booking->status === 'approved' || $booking->status === 'completed',
                                                   'bg-red-100 text-red-800' => $booking->status === 'rejected' || $booking->status === 'cancelled',
                                                   'bg-blue-100 text-blue-800' => $booking->status === 'confirmed',
                                                   'bg-yellow-100 text-yellow-800' => $booking->status === 'pending',
                                               ])">
                                                   {{ ucfirst($booking->status) }}
                                               </span>
                                           </td>
                                           <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                               {{ $booking->created_at->format('M d, Y') }}
                                           </td>
                                           <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                               <a href="{{ route('admin.bookings.show', $booking) }}" 
                                                  class="text-rose-600 hover:text-rose-900">
                                                   View Details
                                               </a>
                                           </td>
                                       </tr>
                                   @endforeach
                               </tbody>
                           </table>
                       </div>
                   @else
                       <div class="text-center py-12">
                           <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                           </svg>
                           <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings</h3>
                           <p class="mt-1 text-sm text-gray-500">This property has not been booked yet.</p>
                       </div>
                   @endif
               </div>
           </div>
       </div>
   </div>
@endsection

@push('scripts')
   <script>
       $(document).ready(function() {
           $('#status_button').click(function() {
               $('#status').removeClass('hidden');
               $('#status_button').addClass('hidden');
               $('#status').on('change', function(e) {
                   $('#save').removeClass('hidden');
               });
               
               $('#save').on('click', function() {
                   var status = $('#status').val();
                   if (!status) {
                       alert('Please select a status');
                       return;
                   }
                   
                   $.ajax({
                       url: "{{ route('admin.properties.update-status') }}",
                       method: 'POST',
                       data: {
                           id: {{ $property->id }},
                           status: status,
                           _token: '{{ csrf_token() }}'
                       },
                       success: function(response) {
                           if (response.success) {
                               window.location.reload();
                           } else {
                               alert(response.message || 'An error occurred. Please try again.');
                           }
                       },
                       error: function(xhr, status, error) {
                           console.error('Error details:', xhr.responseText);
                           alert('An error occurred. Please try again.');
                       }
                   });
               });
           });
       });
   </script>
@endpush
