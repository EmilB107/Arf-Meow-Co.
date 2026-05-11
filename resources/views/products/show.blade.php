@extends('layouts.dashboard-layout')

@section('title', 'View Product')

@section('content')
    <section class="d-product-show">
        <div class="d-flex mb-3">
            @include('partials._return', ['route' => 'products.index'])
            <h1 class="mx-auto">View Product</h1>
        </div>
        <div class="crud-card d-flex gap-4 align-items-start mx-auto">
            <div>
                <h2>{{ $product->name }}</h2>
                <div class="mt-3">
                    <div><b>SKU</b> &nbsp; <span>{{ $product->sku }}</span></div>
                    <div class="mt-2"><b>Description</b> &nbsp; <span>{{ $product->description }}</span></div>
                    <div class="d-flex flex-column flex-lg-row gap-lg-4">
                        <div class="d-flex flex-column mt-2 me-auto"><b>Category</b>
                            <span>{{ $product->category->name ?? 'N/A' }}</span>
                        </div>
                        <div class="d-flex flex-column mt-2 me-auto"><b>Sub Category</b>
                            <span>{{ $product->subCategory->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="mt-2"><b>Price</b> &nbsp; <span>₱{{ number_format($product->price, 2) }}</span></div>
                    {{-- Keep the left side showing the numeric stock --}}
                    <div class="mt-2"><b>Quantity</b> &nbsp; <span>{{ $product->quantity }}</span></div>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center">
                <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : asset('images/img-placeholder.png') }}"
                    alt="Product Image">
                <div class="mt-auto">
                    {{-- Display stock status below the image with color coding --}}
                    @php
                        $stockQuantity = (int) $product->quantity; // Ensure it's an integer
                        $stockStatusText = '';
                        $stockColor = '';

                        if ($stockQuantity === 0) {
                            $stockStatusText = 'Out of Stock';
                            $stockColor = 'red';
                        } elseif ($stockQuantity > 0 && $stockQuantity <= 10) { // Assuming 1-10 is 'Low Stock'
                            $stockStatusText = 'Low Stock';
                            $stockColor = 'orange'; // Use 'yellow' if you have a defined yellow in your CSS
                        } else {
                            $stockStatusText = 'In Stock';
                            $stockColor = 'green';
                        }
                    @endphp
                    <p class="mt-3 mb-2 text-center" style="color: {{ $stockColor }}; font-weight: bold;">
                        {{ $stockStatusText }}
                    </p>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success">
                        Edit this Product
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
