@extends('layouts.admin-settings')

@section('content')
    <div class="flex-grow-1 p-4">
        <h5 class="fw-bold">Company Management</h5>

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.companyManagement') ? 'active' : '' }}"
                    href="{{ route('admin.companyManagement') }}">Company Logo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.admin-company-name') ? 'active' : '' }}"
                    href="{{ route('admin.admin-company-name') }}">Company Name</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.faqs.index') ? 'active' : '' }}"
                    href="{{ route('admin.faqs.index') }}">FAQS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.about-us-settings') ? 'active' : '' }}"
                    href="{{ route('admin.about-us-settings') }}">About Us</a>
            </li>
        </ul>
        <h2 class="text-2xl font-bold mb-4">Edit About Us</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.about.update') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="about_us" class="font-semibold">About Us Content</label>
                <textarea name="about_us" id="about_us" rows="8"
                    class="form-textarea">{{ old('about_us', $aboutUs) }}</textarea>
            </div>

            <button type="submit" class="btn-theme">Save Changes</button>
        </form>
    </div>
@endsection