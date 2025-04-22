@extends('layouts.admin-settings')

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
                <a class="nav-link {{ request()->routeIs('admin.themeColor') ? 'active' : '' }}" href="{{ route('admin.color-update') }}">
                    Color Update
                </a>
            </li>
        </ul>
        <h2 class="text-2xl font-bold mb-4">🎨 Customize Theme Color</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.updateThemeColor') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="theme_color" class="block font-semibold">Select Theme Color:</label>
                <input type="color" id="theme_color" name="theme_color" value="{{ $themeColor }}"
                    class="border p-2 rounded w-32 h-12 cursor-pointer">
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                💾 Save Theme
            </button>
        </form>
    </div>
@endsection