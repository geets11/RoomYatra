<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Amenity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class PropertyController extends Controller
{
    /**
     * Display a listing of the properties.
     */
    public function index(Request $request)
    {
        $query = Property::with(['user', 'propertyType', 'images']);

        // Apply filters
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('property_type_id') && $request->property_type_id) {
            $query->where('property_type_id', $request->property_type_id);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $properties = $query->latest()->paginate(15);
        $propertyTypes = PropertyType::all();
        $landlords = User::role('landlord')->get();
        
        return view('admin.properties.index', compact('properties', 'propertyTypes', 'landlords'));
    }

    /**
     * Display the specified property.
     */
    public function show(Property $property)
    {
        $property->load(['user', 'propertyType', 'amenities', 'images', 'bookings.user']);
        
        return view('admin.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified property.
     */
    public function edit(Property $property)
    {
        $propertyTypes = PropertyType::all();
        $amenities = Amenity::all();
        $landlords = User::role('landlord')->get();
        $property->load(['propertyType', 'amenities', 'images']);
        
        return view('admin.properties.edit', compact('property', 'propertyTypes', 'amenities', 'landlords'));
    }

    /**
     * Update the specified property in storage.
     */
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'property_type_id' => 'required|exists:property_types,id',
            'user_id' => 'required|exists:users,id',
            'price' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'status' => 'required|in:pending,approved,rejected',
            'is_available' => 'required|boolean',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update property
        $property->update([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'property_type_id' => $request->property_type_id,
            'price' => $request->price,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'status' => $request->status,
            'is_available' => $request->is_available,
        ]);

        // Sync amenities
        if ($request->has('amenities')) {
            $property->amenities()->sync($request->amenities);
        } else {
            $property->amenities()->detach();
        }

        // Handle new images
        if ($request->hasFile('new_images')) {
            $hasExistingImages = $property->images()->exists();
            
            foreach ($request->file('new_images') as $imageFile) {
                $path = ImageHelper::saveImage($imageFile, 'property_images');
                
                $property->images()->create([
                    'image_path' => $path,
                    'is_featured' => !$hasExistingImages,
                    'caption' => $request->title . ' image',
                ]);
                
                $hasExistingImages = true;
            }
        }

        return redirect()->route('admin.properties')
            ->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified property from storage.
     */
    public function destroy(Property $property)
    {
        // Delete property images from storage
        foreach ($property->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        // Delete the property (this will cascade delete related records)
        $property->delete();

        return redirect()->route('admin.properties')
            ->with('success', 'Property deleted successfully.');
    }

    /**
     * Update the status of a property.
     */
    public function updateStatus(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:properties,id',
                'status' => 'required|string',
            ]);

            $property = Property::findOrFail($request->id);
            
            // Check if the status is valid
            if (!array_key_exists($request->status, Property::getStatusOptions())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid status selected'
                ]);
            }
            
            $property->update(['status' => $request->status]);
            
            return response()->json([
                'success' => true,
                'message' => 'Property status updated successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating property status: ' . $e->getMessage(), [
                'property_id' => $request->id ?? 'unknown',
                'status' => $request->status ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the property status'
            ], 500);
        }
    }

    /**
     * Approve a property.
     */
    public function approve(Property $property)
    {
        $property->update(['status' => 'approved']);
        
        // Notify the landlord
        $property->user->notify(new \App\Notifications\PropertyApprovedNotification($property));

        return redirect()->back()->with('success', 'Property approved successfully.');
    }

    /**
     * Reject a property.
     */
    public function reject(Request $request, Property $property)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $property->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);
        
        // Notify the landlord
        $property->user->notify(new \App\Notifications\PropertyRejectedNotification($property));

        return redirect()->back()->with('success', 'Property rejected successfully.');
    }

    /**
     * View a property (detailed view).
     */
    public function view(Property $property)
    {
        $property->load(['user', 'propertyType', 'amenities', 'images', 'bookings.user', 'reviews.user']);
        
        return view('admin.properties.view', compact('property'));
    }
}
