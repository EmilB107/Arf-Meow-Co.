@extends('layouts.dashboard-layout')

@section('title', 'Update Inventory')

@section('content')
    <section class="d-inventory-update">
        <div class="d-flex mb-3">
            @include('partials._return', ['route' => 'inventory.index'])
            <h1 class="mx-auto">Update Inventory</h1>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Error Messages --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col col-lg-10">
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Image</th>
                                <th>SKU</th>
                                <th>Quantity</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventory as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td class="img-col">
                                    @if ($item->image_path)
                                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="Product Image" width="40">
                                    @else
                                        <img src="{{ asset('images/img-placeholder.png') }}" alt="No Image" width="40">
                                    @endif
                                </td>
                                <td>{{ $item->sku }}</td>
                                <td>
                                    <form method="POST" action="{{ route('inventory.update', $item->id) }}" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        
                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ $item->quantity }}"
                                            min="0"
                                            class="form-control text-center"
                                            required>
                                </td>
                                <td>
                                    {{-- Dynamic Stock Status --}}
                                    @php
                                        $stockQuantity = (int) $item->quantity;
                                        $stockStatusText = '';
                                        $stockColor = '';

                                        if ($stockQuantity === 0) {
                                            $stockStatusText = 'Out of Stock';
                                            $stockColor = 'red';
                                        } elseif ($stockQuantity > 0 && $stockQuantity <= 10) {
                                            $stockStatusText = 'Low Stock';
                                            $stockColor = 'orange';
                                        } else {
                                            $stockStatusText = 'In Stock';
                                            $stockColor = 'green';
                                        }
                                    @endphp
                                    <span style="color: {{ $stockColor }}; font-weight: bold;">
                                        {{ $stockStatusText }}
                                    </span>
                                </td>
                                <td>
                                    <button type="submit">Save</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                    <form method="GET" action="{{ route('inventory.edit') }}">
                        <div class="mb-3">
                            <div class="fw-bold mb-1">Quantity</div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="quantity[]" value="1-10" id="q1"
                                    {{ in_array('1-10', request('quantity', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="q1">1-10</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="quantity[]" value="11-20" id="q2"
                                    {{ in_array('11-20', request('quantity', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="q2">11-20</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="quantity[]" value="21+" id="q3"
                                    {{ in_array('21+', request('quantity', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="q3">21 +</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="fw-bold mb-1">Stock</div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="stock[]" value="low" id="lowStock"
                                    {{ in_array('low', request('stock', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="lowStock">Low Stock</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="stock[]" value="in" id="inStock"
                                    {{ in_array('in', request('stock', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="inStock">In Stock</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="stock[]" value="out" id="outStock"
                                    {{ in_array('out', request('stock', [])) ? 'checked' : '' }}>
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
