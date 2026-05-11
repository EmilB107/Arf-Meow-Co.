@extends('layouts.dashboard-layout')
<script src="{{ asset('js/filter.js') }}"></script>

@section('title', 'Products')

@section('content')
    <section class="d-product">
        <div class="d-flex mb-3">
            <h1>Products</h1>
            <div class="product-search-bar ms-auto">
                <form action="{{ route('products.index') }}" method="GET" class="search-form">
                    <div class="search-input-wrapper">
                        <img src="{{ asset('images/search.png') }}" alt="Search" class="search-icon">
                        <input type="text" name="query" class="search-input"
                            placeholder="Search Product Name, SKU, Quantity, Stock" value="{{ request('query') }}">
                    </div>
                    <button type="submit" class="search-btn ms-3">SEARCH</button>
                </form>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col col-lg-10">
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th style="width: 15%; min-width: 120px;">Product Name</th>
                                <th style="width: 25%; min-width: 200px;">Description</th>
                                <th style="width: 8%; min-width: 80px;">Image</th>
                                <th style="width: 12%; min-width: 100px;">SKU</th>
                                <th style="width: 12%; min-width: 100px;">Category</th>
                                <th style="width: 10%; min-width: 80px;">Price</th>
                                <th style="width: 10%; min-width: 80px;">Quantity</th>
                                <th style="width: 8%; min-width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td class="img-col">
                                        @if ($product->image_path)
                                            <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : asset('images/img-placeholder.png') }}" alt="Product Image"
                                                width="60">
                                        @else
                                            <img src="{{ asset('images/img-placeholder.png') }}" alt="No Image"
                                                width="60">
                                        @endif
                                    </td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    <td>₱{{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->quantity ?? 'N/A' }}</td>
                                    <td>
                                        <div class="icon-col">
                                            <a href="{{ route('products.show', $product) }}" title="View">
                                                <img class="icon" src="{{ asset('images/view.png') }}" alt="View">
                                            </a>
                                            <a href="{{ route('products.edit', $product) }}" title="Edit">
                                                <img class="icon" src="{{ asset('images/edit.png') }}" alt="Edit">
                                            </a>
                                            <a href=""
                                                onclick="openDeleteModal('{{ route('products.destroy', $product->id) }}'); return false;">
                                                <img class="icon" src="{{ asset('images/delete.png') }}" alt="Delete">
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-2 mb-5 text-end">
                    <a href="{{ route('products.create') }}" role="button" class="add-btn">Add Product</a>
                </div>
            </div>

            <div class="col-lg-2 d-none d-lg-flex flex-column">
                <img id="filterIconShow" class="ms-auto" src="{{ asset('images/filter.png') }}" alt="Filter"
                    width="24" style="cursor:pointer;" onclick="showFilterPanel()">

                <div id="filterPanel" class="p-3 bg-white rounded shadow-sm d-none"
                    style="background: #fff; border: 1px solid #eaeaea;">
                    <div class="d-flex align-items-center mb-3">
                        <strong class="me-2">Filter By:</strong>
                        <img id="filterIconHide" src="{{ asset('images/filter.png') }}" alt="Filter" width="24"
                            class="ms-auto" style="cursor:pointer;" onclick="hideFilterPanel()">
                    </div>
                    <form method="GET" action="{{ route('products.index') }}">
                        <div class="mb-3">
                            <div class="fw-bold mb-1">Category</div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="category[]" value="Dog"
                                    id="dogSupplies"
                                    {{ in_array('Dog', request('category', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="dogSupplies">Dog</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="category[]" value="Cat"
                                    id="catSupplies"
                                    {{ in_array('Cat', request('category', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="catSupplies">Cat</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="category[]" value="Other Pets"
                                    id="otherSupplies"
                                    {{ in_array('Other Pets', request('category', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="catSupplies">Other Pets</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="fw-bold mb-1">Price</div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="price[]" value="1000-5000"
                                    id="p1" {{ in_array('1000-5000', request('price', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="p1">₱ 1000 - ₱ 5000</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="price[]" value="500-999"
                                    id="p2" {{ in_array('500-999', request('price', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="p2">₱ 500 - ₱ 999</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="price[]" value="0-499"
                                    id="p3" {{ in_array('0-499', request('price', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="p3">Below ₱ 499</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="fw-bold mb-1">Quantity</div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="stock[]" value="Low Stock"
                                    id="lowStock" {{ in_array('Low Stock', request('stock', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lowStock">Low Stock</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="stock[]" value="In Stock"
                                    id="inStock" {{ in_array('In Stock', request('stock', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="inStock">In Stock</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="stock[]" value="Out of Stock"
                                    id="outStock" {{ in_array('Out of Stock', request('stock', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="outStock">Out of Stock</label>
                            </div>
                        </div>
                        <button type="submit" class="add-btn w-100 mt-2">Apply Filters</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
