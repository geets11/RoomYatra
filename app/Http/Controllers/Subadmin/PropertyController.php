<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:subadmin']);
    }

    /**
     * Display a listing of the properties.
     */
    public function index(Request $request)
    {
        $query = Property::with(['user', 'images', 'propertyType']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('state', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Property type filter
        if ($request->filled('property_type')) {
            $query->where('property_type_id', $request->property_type);
        }

        // Landlord filter
        if ($request->filled('landlord')) {
            $query->where('user_id', $request->landlord);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $properties = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $stats = [
            'total' => Property::count(),
            'active' => Property::where('status', 'active')->count(),
            'pending' => Property::where('status', 'pending')->count(),
            'inactive' => Property::where('status', 'inactive')->count(),
            'average_price' => Property::where('status', 'active')->avg('price'),
        ];

        // Get filter options
        $propertyTypes = PropertyType::all();
        $landlords = User::role('landlord')->select('id', 'name')->get();

        return view('subadmin.properties.index', compact('properties', 'stats', 'propertyTypes', 'landlords'));
    }

    /**
     * Display the specified property.
     */
    public function show(Property $property)
    {
        $property->load(['user', 'images', 'amenities', 'propertyType', 'bookings.user']);

        return view('subadmin.properties.show', compact('property'));
    }

    /**
     * Update property status.
     */
    public function updateStatus(Request $request, Property $property)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,pending,available,booked,undermaintenance',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        // Update is_available based on status
        $isAvailable = $request->status === 'available';
        
        $property->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'is_available' => $isAvailable,
        ]);

        return redirect()->back()->with('success', 'Property status updated successfully.');
    }

    /**
     * Approve property.
     */
    public function approve(Property $property)
    {
        $property->update([
            'status' => 'available',
            'is_available' => true
        ]);

        return redirect()->back()->with('success', 'Property approved and set as available successfully.');
    }

    /**
     * Reject property.
     */
    public function reject(Request $request, Property $property)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $property->update([
            'status' => 'inactive',
            'admin_notes' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Property rejected successfully.');
    }
}
