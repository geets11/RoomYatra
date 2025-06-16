<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function admin()
    {
        // User statistics
        $totalUsers = User::count();
        $lastWeekUsers = User::where('created_at', '<=', Carbon::now()->subWeek())->count();
        $userGrowth = $lastWeekUsers > 0 ? round((($totalUsers - $lastWeekUsers) / $lastWeekUsers) * 100, 1) : 0;
        $newUsersThisWeek = User::where('created_at', '>=', Carbon::now()->subWeek())->count();
        
        // Property statistics
        $totalProperties = Property::count();
        $lastWeekProperties = Property::where('created_at', '<=', Carbon::now()->subWeek())->count();
        $propertyGrowth = $lastWeekProperties > 0 ? round((($totalProperties - $lastWeekProperties) / $lastWeekProperties) * 100, 1) : 0;
        $newPropertiesThisWeek = Property::where('created_at', '>=', Carbon::now()->subWeek())->count();
        $pendingProperties = Property::where('status', 'pending')->count();
        
        // Booking statistics
        $totalBookings = Booking::count();
        $lastWeekBookings = Booking::where('created_at', '<=', Carbon::now()->subWeek())->count();
        $bookingGrowth = $lastWeekBookings > 0 ? round((($totalBookings - $lastWeekBookings) / $lastWeekBookings) * 100, 1) : 0;
        $newBookingsThisWeek = Booking::where('created_at', '>=', Carbon::now()->subWeek())->count();
        
        // Calculate revenue based on property price since bookings don't have total_amount
        $totalRevenue = Booking::join('properties', 'bookings.property_id', '=', 'properties.id')
            ->where('bookings.status', 'approved')
            ->sum('properties.price');
        
        // User role statistics
        $activeLandlords = User::where('role', 'landlord')->where('status', 'active')->count();
        $activeTenants = User::where('role', 'tenant')->where('status', 'active')->count();
        
        // Support tickets
        $openTickets = \App\Models\SupportTicket::where('status', 'open')->count();
        
        // Recent data
        $recentUsers = User::latest()->limit(5)->get();
        $recentBookings = Booking::with(['property', 'user'])
            ->latest()
            ->limit(5)
            ->get();
        
        $recentProperties = Property::with(['user', 'propertyType'])
            ->latest()
            ->limit(5)
            ->get();

        // Monthly revenue statistics
        $monthlyRevenue = Booking::join('properties', 'bookings.property_id', '=', 'properties.id')
            ->where('bookings.status', 'approved')
            ->where('bookings.created_at', '>=', Carbon::now()->startOfMonth())
            ->sum('properties.price');

        $lastMonthRevenue = Booking::join('properties', 'bookings.property_id', '=', 'properties.id')
            ->where('bookings.status', 'approved')
            ->where('bookings.created_at', '>=', Carbon::now()->subMonth()->startOfMonth())
            ->where('bookings.created_at', '<', Carbon::now()->startOfMonth())
            ->sum('properties.price');

        $revenueGrowth = $lastMonthRevenue > 0 ? round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) : 0;

        $completedBookings = Booking::where('status', 'approved')
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();

        return view('dashboard.admin', compact(
            'totalUsers',
            'userGrowth',
            'newUsersThisWeek',
            'totalProperties', 
            'propertyGrowth',
            'newPropertiesThisWeek',
            'totalBookings',
            'bookingGrowth',
            'newBookingsThisWeek',
            'totalRevenue',
            'monthlyRevenue',
            'revenueGrowth',
            'completedBookings',
            'activeLandlords',
            'activeTenants',
            'pendingProperties',
            'openTickets',
            'recentUsers',
            'recentBookings',
            'recentProperties'
        ));
    }

    /**
     * Subadmin Dashboard
     */
    public function subadmin()
    {
        $totalProperties = Property::count();
        $pendingProperties = Property::where('status', 'pending')->count();
        $approvedProperties = Property::where('status', 'approved')->count();
        $totalBookings = Booking::count();
        
        $recentBookings = Booking::with(['property', 'user'])
            ->latest()
            ->limit(5)
            ->get();
            
        $pendingPropertiesList = Property::with(['user', 'propertyType'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.subadmin', compact(
            'totalProperties',
            'pendingProperties',
            'approvedProperties',
            'totalBookings',
            'recentBookings',
            'pendingPropertiesList'
        ));
    }

    /**
     * Landlord Dashboard
     */
    public function landlord()
    {
        $user = Auth::user();
        
        $totalProperties = Property::where('user_id', $user->id)->count();
        $availableProperties = Property::where('user_id', $user->id)
            ->where('status', 'available')
            ->count();
        $bookedProperties = Property::where('user_id', $user->id)
            ->where('status', 'booked')
            ->count();

        $pendingProperties = Property::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        
        $totalBookings = Booking::whereHas('property', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();
        
        $pendingBookings = Booking::whereHas('property', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'pending')->count();
        
        // Calculate approved bookings (Active Leases)
        $approvedBookings = Booking::whereHas('property', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'approved')->count();

        $totalRevenue = Booking::join('properties', 'bookings.property_id', '=', 'properties.id')
            ->where('bookings.status', 'approved')
            ->where('properties.user_id', $user->id)
            ->sum('properties.price');
        
        $recentBookings = Booking::with(['property', 'user'])
            ->whereHas('property', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->limit(5)
            ->get();
            
        $myProperties = Property::with(['propertyType', 'bookings'])
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.landlord', compact(
            'totalProperties',
            'availableProperties',
            'bookedProperties',
            'totalBookings',
            'pendingBookings',
            'pendingProperties',
            'approvedBookings',
            'totalRevenue',
            'recentBookings',
            'myProperties'
        ));
    }

    /**
     * Tenant Dashboard
     */
    public function tenant()
    {
        $user = Auth::user();
        
        $totalBookings = Booking::where('user_id', $user->id)->count();
        $pendingBookings = Booking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $approvedBookings = Booking::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();
        $upcomingBookings = Booking::where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('check_in', '>', now())
            ->count();
        
        $currentBooking = Booking::with(['property'])
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('check_in', '<=', now())
            
            ->first();
        
        $recentBookings = Booking::with(['property'])
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();
            
        $totalReviews = Review::where('user_id', $user->id)->count();
        
        $favoriteProperties = Property::with(['propertyType', 'images'])
            ->whereIn('status', ['available', 'approved'])
            ->latest()
            ->limit(6)
            ->get();

        return view('dashboard.tenant', compact(
            'totalBookings',
            'pendingBookings',
            'approvedBookings',
            'upcomingBookings',
            'currentBooking',
            'recentBookings',
            'totalReviews',
            'favoriteProperties'
        ));
    }
}
