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
                    href="{{ route('admin.color-update') }}">Color Update</a>
            </li>
        </ul>

        <h2 class="text-2xl font-bold mb-4"> Privacy and Legal</h2>
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.updatePrivacyLegal') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf


            <div class="mb-4">
                <label for="terms_conditions" class="font-semibold">Terms and Conditions PDF</label>
                <input type="file" name="terms_conditions" id="terms_conditions" class="block mt-1"
                    accept="application/pdf">
            </div>

            <div class="mb-4">
                <label for="privacy_policy" class="font-semibold">Privacy Policy PDF</label>
                <input type="file" name="privacy_policy" id="privacy_policy" class="block mt-1" accept="application/pdf">
            </div>


            <button type="submit" class="btn-theme">Save Changes</button>
        </form>
    </div>

    <style>
    .settings-section {
        background: #fff;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
        max-width: 860px;
        margin: auto;
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: {{ $primaryColor }};
    }

    .form-label {
        display: block;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-textarea {
        width: 100%;
        padding: 14px 16px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        background-color: #f9fafb;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        resize: vertical;
    }

    .form-textarea:focus {
        border-color: {{ $primaryColor }};
        background-color: #fff;
        box-shadow: 0 0 0 2px rgba({{($primaryColor) }}, 0.25);
        outline: none;
    }

    .btn-primary {
        background-color: {{ $primaryColor }};
        color: #fff;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: {{ $primaryColorDark }};
        transform: translateY(-1px);
    }

    .btn-secondary {
        color: #6b7280;
        font-weight: 500;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-secondary:hover {
        color: {{ $primaryColor }};
        text-decoration: underline;
    }
</style>
@endsection