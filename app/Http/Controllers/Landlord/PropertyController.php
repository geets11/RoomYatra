<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::where('user_id', Auth::id())
            ->with(['propertyType', 'images'])
            ->latest()
            ->get();

        return view('landlord.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $propertyTypes = PropertyType::all();
        $amenities = Amenity::all();

        return view('landlord.properties.create', compact('propertyTypes', 'amenities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'property_type_id' => 'required|exists:property_types,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|in:daily,weekly,monthly',
            'size' => 'nullable|numeric|min:0',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'is_furnished' => 'nullable|boolean',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after_or_equal:available_from',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        try {
            // Create property
            $property = new Property();
            $property->user_id = Auth::id();
            $property->title = $request->title;
            $property->property_type_id = $request->property_type_id;
            $property->description = $request->description;
            $property->price = $request->price;
            $property->price_type = $request->price_type;
            $property->size = $request->size;
            $property->address = $request->address;
            $property->city = $request->city;
            $property->state = $request->state;
            $property->zip_code = $request->zip_code;
            $property->country = $request->country;
            $property->bedrooms = $request->bedrooms;
            $property->bathrooms = $request->bathrooms;
            $property->is_furnished = $request->has('is_furnished');
            $property->available_from = $request->available_from;
            $property->available_to = $request->available_to;
            $property->status = Property::STATUS_PENDING;
            $property->slug = Str::slug($request->title);
            $property->save();

            // Attach amenities
            if ($request->has('amenities')) {
                $property->amenities()->attach($request->amenities);
            }

            // Handle images with improved storage
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $index => $image) {
                    try {
                        // Create unique filename with proper extension
                        $extension = $image->getClientOriginalExtension();
                        $filename = 'property_' . $property->id . '_' . time() . '_' . $index . '.' . $extension;
                        
                        // Store in property_images directory
                        $path = $image->storeAs('property_images', $filename, 'public');

                        if ($path) {
                            $propertyImage = new PropertyImage();
                            $propertyImage->property_id = $property->id;
                            $propertyImage->image_path = $path;
                            $propertyImage->is_primary = ($index === 0);
                            $propertyImage->sort_order = $index;
                            $propertyImage->save();

                            Log::info("Image saved successfully: {$path}");
                        }
                    } catch (\Exception $e) {
                        Log::error("Error saving image: " . $e->getMessage());
                    }
                }
            }

            return redirect()->route('landlord.properties.index')
                ->with('success', 'Property created successfully. It will be reviewed by an admin before being listed.');

        } catch (\Exception $e) {
            Log::error('Error creating property: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error creating the property. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        if ($property->user_id !== Auth::id()) {
            return redirect()->route('landlord.properties.index')
                ->with('error', 'You do not have permission to view this property.');
        }

        $property->load(['propertyType', 'amenities', 'images']);

        return view('landlord.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        if ($property->user_id !== Auth::id()) {
            return redirect()->route('landlord.properties.index')
                ->with('error', 'You do not have permission to edit this property.');
        }

        $propertyTypes = PropertyType::all();
        $amenities = Amenity::all();
        $property->load(['propertyType', 'amenities', 'images']);

        return view('landlord.properties.edit', compact('property', 'propertyTypes', 'amenities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        if ($property->user_id !== Auth::id()) {
            return redirect()->route('landlord.properties.index')
                ->with('error', 'You do not have permission to update this property.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'property_type_id' => 'required|exists:property_types,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'price_type' => 'required|in:daily,weekly,monthly',
            'size' => 'nullable|numeric|min:0',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'is_furnished' => 'nullable|boolean',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after_or_equal:available_from',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:property_images,id',
            'primary_image' => 'nullable|exists:property_images,id',
        ]);

        try {
            // Update property
            $property->update([
                'title' => $request->title,
                'property_type_id' => $request->property_type_id,
                'description' => $request->description,
                'price' => $request->price,
                'price_type' => $request->price_type,
                'size' => $request->size,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
                'bedrooms' => $request->bedrooms,
                'bathrooms' => $request->bathrooms,
                'is_furnished' => $request->has('is_furnished'),
                'available_from' => $request->available_from,
                'available_to' => $request->available_to,
                'status' => Property::STATUS_PENDING, // Reset to pending after update
            ]);

            // Sync amenities
            if ($request->has('amenities')) {
                $property->amenities()->sync($request->amenities);
            } else {
                $property->amenities()->detach();
            }

            // Handle image deletion
            if ($request->has('delete_images')) {
                $imagesToDelete = PropertyImage::where('property_id', $property->id)
                    ->whereIn('id', $request->delete_images)
                    ->get();

                foreach ($imagesToDelete as $image) {
                    // Delete the file from storage
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    $image->delete();
                }
            }

            // Set primary image
            if ($request->has('primary_image')) {
                PropertyImage::where('property_id', $property->id)
                    ->update(['is_primary' => false]);
                PropertyImage::where('id', $request->primary_image)
                    ->update(['is_primary' => true]);
            }

            // Handle new images
            if ($request->hasFile('new_images')) {
                $images = $request->file('new_images');
                $hasPrimary = PropertyImage::where('property_id', $property->id)
                    ->where('is_primary', true)
                    ->exists();

                foreach ($images as $index => $image) {
                    try {
                        $extension = $image->getClientOriginalExtension();
                        $filename = 'property_' . $property->id . '_' . time() . '_' . $index . '.' . $extension;
                        
                        $path = $image->storeAs('property_images', $filename, 'public');

                        if ($path) {
                            $propertyImage = new PropertyImage();
                            $propertyImage->property_id = $property->id;
                            $propertyImage->image_path = $path;
                            $propertyImage->is_primary = (!$hasPrimary && $index === 0);
                            $propertyImage->sort_order = $index;
                            $propertyImage->save();

                            if (!$hasPrimary && $index === 0) {
                                $hasPrimary = true;
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error('Error saving new image: ' . $e->getMessage());
                    }
                }
            }

            return redirect()->route('landlord.properties.show', $property)
                ->with('success', 'Property updated successfully.');

        } catch (\Exception $e) {
            Log::error('Error updating property: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error updating the property. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        if ($property->user_id !== Auth::id()) {
            return redirect()->route('landlord.properties.index')
                ->with('error', 'You do not have permission to delete this property.');
        }

        try {
            // Delete property images from storage
            foreach ($property->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }

            $property->delete();

            return redirect()->route('landlord.properties.index')
                ->with('success', 'Property deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Error deleting property: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'There was an error deleting the property. Please try again.');
        }
    }
}
