<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Show the home page with featured properties
     */
    public function index()
    {
        try {
            // Get featured properties
            $featuredProperties = Property::with(['images', 'propertyType', 'user'])
                ->where('is_featured', true)
                ->where('is_available', true)
                ->where(function($q) {
                    $q->where('status', '!=', Property::STATUS_REJECTED);
                })
                ->take(6)
                ->get();
                
            // Debug the featured properties
            Log::info('Featured properties count: ' . $featuredProperties->count());
            
            // If no featured properties, get some regular properties
            if ($featuredProperties->count() < 3) {
                $regularProperties = Property::with(['images', 'propertyType', 'user'])
                    ->where('is_available', true)
                    ->where(function($q) {
                        $q->where('status', '!=', Property::STATUS_REJECTED);
                    })
                    ->take(6 - $featuredProperties->count())
                    ->get();
                    
                $featuredProperties = $featuredProperties->merge($regularProperties);
            }
            
            // Get property types for the search form
            $propertyTypes = PropertyType::all();
            
            return view('website.landing.home', compact('featuredProperties', 'propertyTypes'));
        } catch (\Exception $e) {
            Log::error('Error in HomeController@index: ' . $e->getMessage());
            return view('website.landing.home', [
                'featuredProperties' => collect(),
                'propertyTypes' => PropertyType::all(),
            ]);
        }
    }
}
