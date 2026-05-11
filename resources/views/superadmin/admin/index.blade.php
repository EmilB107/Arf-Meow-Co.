@extends('layouts.superadmin-layout')

@section('title', 'Admin')

@section('content')
    <section class="container admin-list mt-3">
        <div class="d-flex mb-3">
            @include('partials._return', ['route' => 'superadmin.index'])
            <h1 class="mx-auto">Admins</h1>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>AdminID</th>
                        <th>Name</th>
                        <th class="permission-col">Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admin as $admin)
                        <tr>
                            <td>{{ $admin['id'] }}</td>
                            <td>{{ $admin['name'] }}</td>
                            <td>
                                <div
                                    class="d-flex flex-wrap flex-grow-1 justify-content-center align-items-center gap-2 px-3">
                                    @foreach ($admin['permissions'] as $permission)
                                        <span class="badge bg-primary p-1 my-1">{{ $permission }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div class="icon-col">
                                    <a href="{{ route('admin.show', $admin['id']) }}" title="View">
                                        <img class="icon" src="{{ asset('images/view.png') }}" alt="View">
                                    </a>
                                    <a href="{{ route('admin.edit', $admin['id']) }}" title="Edit">
                                        <img class="icon" src="{{ asset('images/edit.png') }}" alt="Edit">
                                    </a>
                                    <a href="#"
                                        onclick="openDeleteModal('{{ route('admin.destroy', $admin['id']) }}'); return false;">
                                        <img class="icon" src="{{ asset('images/delete.png') }}" alt="Delete">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No admin found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2 mb-5 text-end">
            <a href="{{ route('admin.create') }}" role="button" class="add-btn">
                Create Admin
            </a>
        </div>
    </section>
@endsection
