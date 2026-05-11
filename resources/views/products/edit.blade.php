{{-- filepath: resources/views/products/edit.blade.php --}}
@extends('layouts.dashboard-layout')

@section('title', 'Edit Product')

@section('content')
    <section class="d-product-edit">
        <div class="d-flex mb-3">
            @include('partials._return', ['route' => 'products.index'])
            <h1 class="mx-auto">Edit Product</h1>
        </div>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="crud-card d-flex flex-column flex-lg-row gap-4 align-items-lg-start mx-auto">
                <div class="left-col">
                    <div class="mb-3 d-flex align-items-center">
                        <input type="text" id="product_name" name="product_name" class="form-control fw-bold @error('product_name') is-invalid @enderror"
                            placeholder="Product Name" value="{{ old('product_name', $product->name) }}" required>
                        @error('product_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label for="sku" class="mb-0 me-2"><b>SKU</b></label>
                        <input type="text" id="sku" name="sku" class="form-control @error('sku') is-invalid @enderror" 
                            placeholder="SKU" value="{{ old('sku', $product->sku) }}">
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 d-flex flex-column align-items-center">
                        <label for="description" class="mb-0 me-auto"><b>Description</b></label>
                        <textarea id="description" name="description" rows="4" class="form-control mt-3 @error('description') is-invalid @enderror"
                            placeholder="Description">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 d-flex flex-column flex-lg-row gap-3">
                        <div class="d-flex flex-column  align-items-center">
                            <label for="category" class="mb-0 me-auto"><b>Category</b></label>
                            <select id="category" name="category" class="form-select mt-3 wide-select @error('category') is-invalid @enderror" required>
                                <option value="" disabled>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ old('category', $product->category->name ?? '') == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex flex-column  align-items-center">
                            <label for="subcategory" class="mb-0 me-auto"><b>Sub Category</b></label>
                            <select id="subcategory" name="subcategory" class="form-select mt-3 wide-select @error('subcategory') is-invalid @enderror">
                                <option value="" disabled>Select Sub Category</option>
                                @foreach($subCategories as $subCategory)
                                    <option value="{{ $subCategory->name }}" data-category-id="{{ $subCategory->category_id }}" {{ old('subcategory', $product->subCategory->name ?? '') == $subCategory->name ? 'selected' : '' }}>
                                        {{ $subCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subcategory')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label for="price" class="mb-0 me-2"><b>Price</b></label>
                        <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" 
                            placeholder="0.00" step="0.01" min="0" value="{{ old('price', $product->price) }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label for="quantity" class="mb-0 me-2"><b>Quantity</b></label>
                        <input type="number" id="quantity" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                            placeholder="0" min="0" value="{{ old('quantity', $product->quantity) }}" required style="max-width: 80px;">
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-column align-items-center">
                    <img id="image-preview" src="{{ $product->image_path ? asset('storage/' . $product->image_path) : asset('images/img-placeholder.png') }}" 
                         alt="Product Image" style="max-width: 200px; max-height: 200px;">
                    <div class="d-flex align-items-center gap-2 mt-3 mb-3">
                        <span class="upload d-flex align-items-center">
                            <img src="{{ asset('images/upload.png') }}" alt="Upload">
                            <span class="ms-2 d-none d-lg-block">Upload File</span>
                        </span>
                        <input type="file" id="product_image" name="product_image" class="d-none @error('product_image') is-invalid @enderror" accept="image/*">
                        <button type="button" class="btn btn-light"
                            onclick="document.getElementById('product_image').click();">Change Image</button>
                        @error('product_image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script>
        // Image preview functionality
        document.getElementById('product_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Dynamic subcategory filtering based on selected category
        document.getElementById('category').addEventListener('change', function() {
            const selectedCategory = this.value;
            const subcategorySelect = document.getElementById('subcategory');
            const subcategoryOptions = subcategorySelect.querySelectorAll('option');
            
            const currentSubcategory = subcategorySelect.value;

            subcategoryOptions.forEach(function(option, index) {
                if (index === 0) { 
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
            
            // Show subcategories that belong to selected category
            if (selectedCategory) {
                // Find the category ID based on the selected category name
                const categoryMap = {
                    @foreach($categories as $category)
                        '{{ $category->name }}': {{ $category->id }},
                    @endforeach
                };
                
                const selectedCategoryId = categoryMap[selectedCategory];
                let subcategoryStillValid = false;
                
                subcategoryOptions.forEach(function(option) {
                    if (option.dataset.categoryId == selectedCategoryId) {
                        option.style.display = 'block';
                        if (option.value === currentSubcategory) {
                            subcategoryStillValid = true;
                        }
                    }
                });

                if (!subcategoryStillValid) {
                    subcategorySelect.value = '';
                }
            } else {
                // If no category is selected, reset subcategory
                subcategorySelect.value = '';
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category');
            if (categorySelect.value) {
                categorySelect.dispatchEvent(new Event('change'));
            }
        });

    </script>
@endsection
