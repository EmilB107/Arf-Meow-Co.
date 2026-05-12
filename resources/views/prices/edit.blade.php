@extends('layouts.dashboard-layout')

@section('title', 'Edit Price')

@section('content')
    <section class="d-prices-edit">
        <div class="d-flex mb-3">
            @include('partials._return', ['route' => 'prices.index'])
            <h1 class="mx-auto">Edit Price</h1>
        </div>
        <div class="table-responsive">
            {{-- Form action to the update route, passing the product ID --}}
            <form action="{{ route('prices.update', $price->id) }}" method="POST">
                @csrf {{-- CSRF token for security --}}
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $price->name }}</td> {{-- Access name using object property --}}
                            <td>
                                {{-- Input for price, pre-filled with current price --}}
                                <input type="number" name="price" class="form-control text-center"
                                    value="{{ old('price', $price->price) }}" step="0.01" required>
                                @error('price') {{-- Display validation errors for price --}}
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <button type="submit">Save</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </section>
@endsection