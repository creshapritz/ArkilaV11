@extends('layouts.admin-settings')

@section('content')
    <style>
        .form {
            background-color:
                {{ $primaryColor }}
            ;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
        }

        .form:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color:
                {{ $primaryColor }}
            ;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        label {
            font-weight: 600;
            color:
                {{ $primaryColor }}
            ;
            margin-bottom: 0.5rem;
            display: block;
        }

        .logo-preview {
            height: 100px;
            width: 100%;
            object-fit: contain;
            border-radius: 0.5rem;
            margin: 1rem 0;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 0.5rem;
            border: 2px dashed rgba(255, 255, 255, 0.3);
        }

        .try {
            padding: 20px;
        }

        .btn-submit {
            background-color: white;
            color:
                {{ $primaryColor }}
            ;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-submit:hover {
            background-color:
                {{ $primaryColorDark }}
            ;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .choose-file-btn {
            display: inline-block;
            padding: 1rem 2rem;
            color: #2e2e2e;
            font-weight: bold;
            font-size: 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            text-transform: uppercase;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: white;
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
        }

        ::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
    </style>

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
        <h2 class="text-2xl font-bold mb-4">Change Logo</h2>

        @if ($currentLogo)
            <div class="mb-4">
                <label class="block font-semibold mb-2">Current Logo:</label>
                <img src="{{ asset($currentLogo) }}" alt="Current Logo" class="logo-preview">
            </div>
        @endif


        <form class="form1" action="{{ route('admin.updateLogo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <label for="site_logo" class="block font-semibold mb-2">Upload New Logo:</label>
                <input type="file" name="site_logo" id="site_logo" class="choose-file-btn" accept="image/*"
                    onchange="previewLogo()" required>
            </div>


            <div id="logoPreview" class="mb-4" style="display: none;">
                <label class="block font-semibold mb-2">New Logo Preview:</label>
                <img id="previewImage" src="#" alt="Logo Preview" class="logo-preview">
            </div>

            <button type="submit" class="btn-submit">
                Update Logo
            </button>
        </form>
    </div>

    <script>
        function previewLogo() {
            const input = document.getElementById('site_logo');
            const previewContainer = document.getElementById('logoPreview');
            const previewImage = document.getElementById('previewImage');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection