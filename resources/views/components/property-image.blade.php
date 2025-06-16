@props(['image', 'class' => '', 'alt' => 'Property Image', 'showFallback' => true])

@if($image && $image->exists)
    <img src="{{ $image->image_url }}" 
         alt="{{ $alt }}" 
         class="{{ $class }}"
         loading="lazy"
         onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';">
@elseif($showFallback)
    <img src="{{ asset('images/placeholder.jpg') }}" 
         alt="{{ $alt ?: 'Property image' }}" 
         class="{{ $class }}"
         loading="lazy">
@endif
