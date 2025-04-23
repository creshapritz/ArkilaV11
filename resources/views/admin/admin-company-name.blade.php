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
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.media-settings') ? 'active' : '' }}"
                    href="{{ route('admin.media-settings') }}">Media Settings</a>
            </li>
        </ul>
        <h2 class="change-title">Change Company Name</h2>

@if (session('success'))
    <div class="alert success-alert">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('admin.update-company-name') }}" method="POST" class="company-form">
    @csrf
    <div class="form-group">
        <label for="company_name" class="form-label">Company Name:</label>
        <input type="text" name="company_name" id="company_name" class="form-input"
            value="{{ old('company_name', $companyName) }}" required>
    </div>

    <button type="submit" class="submit-btn">Update</button>
</form>

<style>
    
    .change-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    
    .alert {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 1rem;
        line-height: 1.5;
    }

    .success-alert {
        background-color: #d4edda;
        color: #155724;
    }

    .company-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-width: 400px;
        margin-top: 20px;
     
        padding: 20px;
        border-radius: 8px;
        
    }


    .form-label {
        font-weight: 600;
        font-size: 1rem;
        color: #333;
        margin-bottom: 8px;
    }

    
    .form-input {
        width: 100%;
        height: 40px;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 8px;
        background-color: transparent;
        transition: border 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color:#F07324;
    }

 
    .submit-btn {
        padding: 12px 24px;
        background-color:#F07324;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #0056b3;
    }
</style>

@endsection