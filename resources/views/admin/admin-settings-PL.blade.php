@extends('layouts.admin-settings')

@section('content')
    <div class="flex-grow-1 p-4">
        <h5 class="fw-bold">General Settings</h5>

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.admin-settings') ? 'active' : '' }}"
                    href="{{ route('admin.admin-settings') }}">Account Management</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.admin-settings-PL') ? 'active' : '' }}"
                    href="{{ route('admin.admin-settings-PL') }}">Privacy and Legal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.color-update') ? 'active' : '' }}"
                    href="{{ route('admin.color-update') }}">Color
                    Update</a>
            </li>
        </ul>

        <h2 class="section-title">Privacy and Legal</h2>

        <div class="content-section">
            <label class="section-label">Terms and Conditions:</label>
            @if ($terms)
                <a href="{{ $terms }}" target="_blank" class="link">Terms and Conditions</a>
            @else
                <p class="no-file">No file uploaded yet.</p>
            @endif
        </div>

        <div class="content-section">
            <label class="section-label">Privacy Policy:</label>
            @if ($privacy)
                <a href="{{ $privacy }}" target="_blank" class="link">Privacy Policy</a>
            @else
                <p class="no-file">No file uploaded yet.</p>
            @endif
        </div>

        <a href="{{ route('admin.PL-edit') }}" class="btn-edit">Edit</a>

        <style>
            .section-title {
                font-size: 1.5rem;
                font-weight: bold;
                color: #333;
                margin-bottom: 20px;
            }


            .content-section {
                margin-bottom: 20px;
            }

            .section-label {
                font-weight: 600;
                color: #333;
                margin-bottom: 8px;
                display: block;
            }


            .link {
                color: #F07324;
                ;
                text-decoration: none;
                transition: color 0.3s ease;
            }

            .link:hover {
                color: #F07324;
                ;
            }


            .no-file {
                color: #888;
                font-style: italic;
            }


            .btn-edit {
                display: inline-block;
                background-color: #F07324;
                color: white;
                padding: 10px 45px;
                border-radius: 8px;
                text-decoration: none;
                font-weight: 600;
                transition: background-color 0.3s ease;
                margin-top: 20px;
            }

            .btn-edit:hover {
                text-decoration: none;
                background-color: #D65F1E;
                color: #fff;
            }
        </style>

@endsection