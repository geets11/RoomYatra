<?php

namespace App\Components;

use Illuminate\View\Component;
use App\Models\PropertyImage as PropertyImageModel;
use Illuminate\Support\Facades\Storage;

class PropertyImage extends Component
{
    public $image;
    public $property;
    public $size;
    public $class;
    public $alt;

    /**
     * Create a new component instance.
     *
     * @param  mixed  $image
     * @param  mixed  $property
     * @param  string  $size
     * @param  string  $class
     * @param  string  $alt
     * @return void
     */
    public function __construct($image = null, $property = null, $size = 'medium', $class = '', $alt = '')
    {
        $this->image = $image;
        $this->property = $property;
        $this->size = $size;
        $this->class = $class;
        $this->alt = $alt;
    }

    /**
     * Get the image URL.
     *
     * @return string
     */
    public function getImageUrl()
    {
        // If image is a PropertyImage model
        if ($this->image instanceof PropertyImageModel) {
            return $this->image->getImageUrl();
        }
        
        // If image is a string path
        if (is_string($this->image)) {
            // Check if it's already a URL
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            
            // Check if the image exists in storage
            if (Storage::disk('public')->exists($this->image)) {
                return Storage::url($this->image);
            }
        }
        
        // If property is provided, get its featured image
        if ($this->property) {
            $featuredImage = $this->property->images()->where('is_featured', true)->first();
            if ($featuredImage) {
                return $featuredImage->getImageUrl();
            }
            
            // If no featured image, get the first image
            $firstImage = $this->property->images()->first();
            if ($firstImage) {
                return $firstImage->getImageUrl();
            }
        }
        
        // Return placeholder if no image found
        return asset('images/placeholder.jpg');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.property-image', [
            'imageUrl' => $this->getImageUrl(),
        ]);
    }
}
