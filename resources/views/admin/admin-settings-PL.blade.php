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
                <a class="nav-link {{ request()->routeIs('admin.privacyLegal') ? 'active' : '' }}"
                    href="{{ route('admin.admin-settings-PL') }}">Privacy and Legal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.userRequirements') ? 'active' : '' }}"
                    href="{{ route('admin.color-update') }}">Color
                    Update</a>
            </li>
        </ul>

        <h2>Privacy and Legal</h2>

        {{-- Terms and Conditions --}}
        <div class="border border-gray-300 p-4 rounded mt-2">
            <h4 class="font-semibold">Terms and Conditions</h4>
            <div class="border border-gray-200 p-4 rounded bg-gray-100 mt-2">
                {!! nl2br(e($terms)) !!}
            </div>
        </div>

        {{-- Privacy Policy --}}
        <div class="border border-gray-300 p-4 rounded mt-4">
            <h4 class="font-semibold">Privacy Policy</h4>
            <div class="border border-gray-200 p-4 rounded bg-gray-100 mt-2">
                {!! nl2br(e($privacy)) !!}
            </div>
        </div>

        {{-- Edit Button --}}
        <div class="mt-4">
            <a href="{{ route('admin.PL-edit') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                ✏️ Edit
            </a>

        </div>
    </div>
    <style>
        /* Settings Section */
        .settings-section {
            background: rgb(255, 255, 255);
            padding: 20px;
            border-radius: 10px;
            width: 890px;
        }

        .settings-section h2 {
            color: #333;
            margin-bottom: 15px;
        }
    </style>
@endsection