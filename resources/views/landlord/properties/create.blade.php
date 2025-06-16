@extends('layouts.landlord.landlord')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center">
                    <h1 class="text-3xl font-bold text-gray-900">Add New Property</h1>
                    <a href="{{ route('landlord.properties.index') }}"
                        class="ml-4 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                        Back to Properties
                    </a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">Please check the form for errors.</span>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Property Form -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('landlord.properties.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <!-- Basic Information -->
                        <div class="col-span-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Basic Information</h3>
                            <p class="mt-1 text-sm text-gray-500">Provide basic details about your property.</p>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="title" class="block text-sm font-medium text-gray-700">Property Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="property_type_id" class="block text-sm font-medium text-gray-700">Property
                                Type</label>
                            <select id="property_type_id" name="property_type_id"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500 sm:text-sm">
                                <option value="">Select a property type</option>
                                @foreach ($propertyTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('property_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description') }}</textarea>
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">NPR</span>
                                </div>
                                <input type="number" name="price" id="price" value="{{ old('price') }}"
                                    class="focus:ring-rose-500 focus:border-rose-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md"
                                    placeholder="0.00" step="0.01" min="0">
                            </div>
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="price_type" class="block text-sm font-medium text-gray-700">Price Type</label>
                            <select id="price_type" name="price_type"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-rose-500 focus:border-rose-500 sm:text-sm">
                                <option value="monthly" {{ old('price_type') == 'monthly' ? 'selected' : '' }}>Monthly
                                </option>
                                <option value="weekly" {{ old('price_type') == 'weekly' ? 'selected' : '' }}>Weekly
                                </option>
                                <!-- <option value="daily" {{ old('price_type') == 'daily' ? 'selected' : '' }}>Daily</option> -->
                            </select>
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="size" class="block text-sm font-medium text-gray-700">Size (sq ft)</label>
                            <input type="number" name="size" id="size" value="{{ old('size') }}"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- Location Information -->
                        <div class="col-span-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Location</h3>
                            <p class="mt-1 text-sm text-gray-500">Where is your property located?</p>
                        </div>

                        <div class="col-span-6">
                            <label for="address" class="block text-sm font-medium text-gray-700">Street Address</label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" id="city" value="{{ old('city') }}"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="state" class="block text-sm font-medium text-gray-700">State / Province</label>
                            <input type="text" name="state" id="state" value="{{ old('state') }}"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="zip_code" class="block text-sm font-medium text-gray-700">ZIP / Postal
                                Code</label>
                            <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code') }}"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6">
                            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                            <input type="text" name="country" id="country"
                                value="{{ old('country', 'NEPAL') }}"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- Property Details -->
                        <div class="col-span-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Property Details</h3>
                            <p class="mt-1 text-sm text-gray-500">Additional details about your property.</p>
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="bedrooms" class="block text-sm font-medium text-gray-700">Bedrooms</label>
                            <input type="number" name="bedrooms" id="bedrooms" value="{{ old('bedrooms', 1) }}"
                                min="0"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="bathrooms" class="block text-sm font-medium text-gray-700">Bathrooms</label>
                            <input type="number" name="bathrooms" id="bathrooms" value="{{ old('bathrooms', 1) }}"
                                min="0" step="0.5"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <div class="flex items-start mt-6">
                                <div class="flex items-center h-5">
                                    <input id="is_furnished" name="is_furnished" type="checkbox" value="1"
                                        {{ old('is_furnished') ? 'checked' : '' }}
                                        class="focus:ring-rose-500 h-4 w-4 text-rose-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_furnished" class="font-medium text-gray-700">Furnished</label>
                                    <p class="text-gray-500">Is this property furnished?</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="available_from" class="block text-sm font-medium text-gray-700">Available
                                From</label>
                            <input type="date" name="available_from" id="available_from"
                                value="{{ old('available_from') }}"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <!-- <div class="col-span-6 sm:col-span-3">
                            <label for="available_to" class="block text-sm font-medium text-gray-700">Available To
                                (Optional)</label>
                            <input type="date" name="available_to" id="available_to"
                                value="{{ old('available_to') }}"
                                class="mt-1 focus:ring-rose-500 focus:border-rose-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div> -->

                        <!-- Amenities -->
                        <div class="col-span-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Amenities</h3>
                            <p class="mt-1 text-sm text-gray-500">Select the amenities available at your property.</p>
                        </div>

                        <div class="col-span-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach ($amenities->groupBy('category') as $category => $categoryAmenities)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">{{ ucfirst($category) }}</h4>
                                        @foreach ($categoryAmenities as $amenity)
                                            <div class="flex items-start mb-2">
                                                <div class="flex items-center h-5">
                                                    <input id="amenity_{{ $amenity->id }}" name="amenities[]"
                                                        type="checkbox" value="{{ $amenity->id }}"
                                                        {{ is_array(old('amenities')) && in_array($amenity->id, old('amenities')) ? 'checked' : '' }}
                                                        class="focus:ring-rose-500 h-4 w-4 text-rose-600 border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="amenity_{{ $amenity->id }}"
                                                        class="font-medium text-gray-700">{{ $amenity->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="col-span-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Property Images</h3>
                            <p class="mt-1 text-sm text-gray-500">Upload images of your property. The first image will be
                                used as the
                                main image.</p>
                        </div>

                        <div class="col-span-6">
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="images"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-rose-600 hover:text-rose-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-rose-500">
                                            <span>Upload images</span>
                                            <input id="images" name="images[]" type="file" multiple
                                                accept="image/*" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, GIF, JPEG up to 100MB each
                                    </p>
                                </div>
                            </div>
                            <div id="image-preview"
                                class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                        Create Property
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Image preview functionality
        document.getElementById('images').addEventListener('change', function(event) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';

            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (!file.type.match('image.*')) continue;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'h-24 w-full object-cover rounded';
                    div.appendChild(img);

                    if (i === 0) {
                        const badge = document.createElement('div');
                        badge.className =
                            'absolute top-0 right-0 bg-rose-500 text-white text-xs px-2 py-1 rounded-bl';
                        badge.textContent = 'Primary';
                        div.appendChild(badge);
                    }

                    preview.appendChild(div);
                };

                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
