@extends('layouts.superadmin-layout')

@section('title', 'Users')

@section('content')
    <section class="container admin-list mt-3">
        <div class="d-flex mb-3">
            @include('partials._return', ['route' => 'superadmin.index'])
            <h1 class="mx-auto">Users</h1>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>RoleID</th>
                        <th>Role</th>
                        <th>Name</th>
                        <th class="permission-col">Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user['id'] }}</td>
                            <td>{{ $user['role'] }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>
                                <div
                                    class="d-flex flex-wrap flex-grow-1 justify-content-center align-items-center gap-2 px-3">
                                    @foreach ($user['permissions'] as $permission)
                                        <span class="badge bg-primary p-1 my-1">{{ $permission }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-2 icon-col">
                                    <a href="{{ route('user.show', $user['id']) }}" title="View">
                                        <img class="icon" src="{{ asset('images/view.png') }}" alt="View">
                                    </a>
                                    <a href="{{ route('user.edit', $user['id']) }}" title="Edit">
                                        <img class="icon" src="{{ asset('images/edit.png') }}" alt="Edit">
                                    </a>
                                    <a href="#"
                                        onclick="openDeleteModal('{{ route('user.destroy', $user['id']) }}'); return false;">
                                        <img class="icon" src="{{ asset('images/delete.png') }}" alt="Delete">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2 mb-5 text-end">
            <a href="{{ route('user.create') }}" role="button" class="add-btn">
                Create User
            </a>
        </div>
    </section>
@endsection
