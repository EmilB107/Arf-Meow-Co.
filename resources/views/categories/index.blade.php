@extends('layouts.dashboard-layout')

@section('title', 'Categories')

@section('content')
    @php
        // Set this to 'Admin' or 'PM' to test different roles
        $role = 'Admin';
    @endphp

    <section class="d-category">
        <div class="d-flex mb-3">
            <h1>Category & Sub Categories</h1>
            <div class="product-search-bar ms-auto">
                <form action="{{ route('categories.index') }}" method="GET" class="search-form">
                    <div class="search-input-wrapper">
                        <img src="{{ asset('images/search.png') }}" alt="Search" class="search-icon">
                        <input type="text" name="query" class="search-input"
                            placeholder="Search Categories or Sub Categories" value="{{ request('query') }}">
                    </div>
                    <button type="submit" class="search-btn ms-3 ">SEARCH</button>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Number of Products (Sub Category)</th>
                        @if ($role === 'Admin')
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        @forelse ($category->subCategories as $subCategory)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $subCategory->name }}</td>
                                <td>{{ $subCategory->products->count() }}</td> {{-- Products directly associated with this subCategory --}}
                                @if ($role === 'Admin')
                                    <td class="icon-col">
                                        <a href="{{ route('categories.show', $category->id) }}" title="View Products in Category">
                                            <img class="icon" src="{{ asset('images/view.png') }}" alt="View">
                                        </a>
                                        <a href="{{ route('categories.edit', $subCategory->id) }}" title="Edit Sub Category">
                                            <img class="icon" src="{{ asset('images/edit.png') }}" alt="Edit">
                                        </a>
                                        <a href="#"
                                            onclick="openDeleteModal('{{ route('categories.destroy', $subCategory->id) }}'); return false;" title="Delete Sub Category">
                                            <img class="icon" src="{{ asset('images/delete.png') }}" alt="Delete">
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            {{-- If a category has no subcategories, you might still want to display it --}}
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>No Sub Categories</td>
                                <td>{{ $category->products_count }}</td> {{-- Total products in category --}}
                                @if ($role === 'Admin')
                                    <td class="icon-col">
                                        <a href="{{ route('categories.show', $category->id) }}" title="View Products in Category">
                                            <img class="icon" src="{{ asset('images/view.png') }}" alt="View">
                                        </a>
                                        {{-- No edit/delete for category directly here, as per controller --}}
                                        <span class="text-muted">N/A</span>
                                    </td>
                                @endif
                            </tr>
                        @endforelse
                    @empty
                        <tr>
                            <td colspan="{{ $role === 'Admin' ? 4 : 3 }}">No categories or sub-categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($role === 'Admin')
            <div class="mt-2 mb-5 text-end">
                <a href="{{ route('categories.create') }}" role="button" class="add-btn">
                    Add Sub Category
                </a>
            </div>
        @endif
    </section>
@endsection