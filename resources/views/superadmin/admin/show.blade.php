<script defer src="{{ asset('js/password.js') }}"></script>
@extends('layouts.superadmin-layout')

@section('title', 'Admin')

@section('content')
    <section class="container admin-list mt-3">
        <div class="d-flex mb-3">
            @include('partials._return', ['route' => 'admin.index'])
            <h1 class="mx-auto">View Admin</h1>
        </div>
        <div class="card mx-auto p-4">
            <div class="mb-4">
                <h2 class="fw-bold mb-4">{{ $admin['name'] }}</h2>
                <div class="mb-2">
                    <span class="tamad-baloo fw-bold">Email:</span>
                    <span class="tamad-nunito text-muted">{{ $admin['email'] ?? 'N/A' }}</span>
                </div>
                <div class="mb-2">
                    <span class="tamad-baloo fw-bold">Username:</span>
                    <span class="tamad-nunito text-muted">{{ $admin['username'] ?? 'N/A' }}</span>
                </div>
                <div class="mb-2 d-flex align-items-center">
                    <span class="tamad-baloo fw-bold">Password:</span>
                    <span class="tamad-nunito text-muted ms-2" id="password-field" style="letter-spacing:2px;">
                        ••••••••
                    </span>
                    <input type="hidden" id="real-password" value="{{ $admin['password'] }}">
                    <span class="ms-2" style="font-size: 1.2em; cursor:pointer;" id="toggle-password">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#222" viewBox="0 0 24 24">
                            <path d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12c-4.418 0-8-3.582-8-5s3.582-5 8-5 8 3.582 8 5-3.582 5-8 5zm0-8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 4c-.552 0-1-.447-1-1s.448-1 1-1 1 .447 1 1-.448 1-1 1z"/>
                        </svg>
                    </span>
                </div>
                <div class="tamad-baloo fw-bold mt-4 mb-2">Permissions:</div>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($admin['permissions'] as $permission)
                        <span class="badge rounded-pill px-4 py-2" style="background:#f7bcbc; color:#222; font-weight:500;">{{ $permission }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection