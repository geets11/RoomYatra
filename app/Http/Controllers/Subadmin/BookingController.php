<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:subadmin']);
    }

    /**
     * Display a listing of the bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['property', 'property.images', 'user']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('property', function($propertyQuery) use ($search) {
                      $propertyQuery->where('title', 'like', "%{$search}%")
                                   ->orWhere('city', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Property filter
        if ($request->filled('property')) {
            $query->where('property_id', $request->property);
        }

        // Date range filter
        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'upcoming':
                    $query->where('check_in', '>', now());
                    break;
                case 'current':
                    $query->where('check_in', '<=', now())
                          ->where('check_out', '>=', now());
                    break;
                case 'past':
                    $query->where('check_out', '<', now());
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->month);
                    break;
            }
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'approved' => Booking::where('status', 'approved')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'rejected' => Booking::where('status', 'rejected')->count(),
        ];

        // Get properties for filter
        $properties = Property::select('id', 'title')->get();

        return view('subadmin.bookings.index', compact('bookings', 'stats', 'properties'));
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $booking->load(['property', 'property.images', 'property.amenities', 'user']);

        return view('subadmin.bookings.show', compact('booking'));
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,cancelled,completed',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $booking->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Booking status updated successfully.');
    }

    /**
     * Get booking statistics for dashboard.
     */
    public function getStats()
    {
        return [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'approved_bookings' => Booking::where('status', 'approved')->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'monthly_revenue' => Booking::where('status', 'completed')
                                      ->whereMonth('created_at', now()->month)
                                      ->sum('total_price'),
            'recent_bookings' => Booking::with(['property', 'user'])
                                       ->latest()
                                       ->take(5)
                                       ->get(),
        ];
    }
}
