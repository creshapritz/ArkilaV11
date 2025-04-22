@extends('layouts.admin-settings')

<style>
    body {
        font-family: 'Sf Pro display';
        background-color: #f8f9fa;
        color: #333;
        margin: 0;
        padding: 0;
        display: flex;
        min-height: 100vh;
    }

    .text-center {
        text-align: center;
        margin-bottom: 30px;
    }

    .text-center div {
        display: inline-block;
        padding: 10px;
        border-radius: 50%;
        background-color: #f3f3f3;
    }

    .text-center img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }

    .text-center p {
        margin-top: 5px;
        color: #555;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 400;
    }

    .form-control {
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 12px;
        font-size: 1rem;
        margin-bottom: 20px;
    }

    .btn-warning {
        background-color: #fff;
        color: #ff8c00;
        border: 1px solid #ff8c00;
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 1rem;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-warning:hover {
        background-color: #ffe0b2;
        color: #333;
        border-color: #e67e00;
    }
</style>

@section('content')

    <div class="flex-grow-1 p-4">
        <h5 class="fw-bold">General Settings</h5>

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.admin-settings') ? 'active' : '' }}"
                    href="{{ route('admin.admin-settings') }}">
                    Account Management
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.admin-settings-PL') ? 'active' : '' }}"
                    href="{{ route('admin.admin-settings-PL') }}">
                    Privacy and Legal
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.themeColor') ? 'active' : '' }}"
                    href="{{ route('admin.color-update') }}">
                    Color Update
                </a>
            </li>
        </ul>


        <!-- Profile Picture Section -->
        <div class="text-center mb-3">
    @if(auth('admin')->check() && auth('admin')->user()->profile_picture)
        <div>
            <img src="{{ asset('storage/drivers/' . auth('admin')->user()->profile_picture) }}" alt="Profile Picture">
        </div>
    @else
        <div>
            <img src="{{ asset('default-avatar.png') }}" alt="Default Avatar">
        </div>
    @endif
    <p>Admin</p>
</div>


        <!-- Account Form -->
        <form action="{{ route('admin.updateAccount') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>First Name</label>
                    <input type="text" name="firstname" value="{{ old('first_name', auth('admin')->user()->firstname) }}"
                        class="form-control" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Last Name</label>
                    <input type="text" name="lastname" value="{{ old('last_name', auth('admin')->user()->lastname) }}"
                        class="form-control" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', auth('admin')->user()->email) }}"
                        class="form-control" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Change Password</label><br>
                    <a href="{{ route('admin.password.edit') }}" class="btn btn-warning">Update Password</a>
                </div>
            </div>
        </form>
    </div>
@endsection