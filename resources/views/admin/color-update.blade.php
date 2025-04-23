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
                <a class="nav-link {{ request()->routeIs('admin.color-update') ? 'active' : '' }}"
                    href="{{ route('admin.color-update') }}">
                    Color Update
                </a>
            </li>
        </ul>
        <h2 class="section-title">Customize Theme Color</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.updateThemeColor') }}" method="POST" class="space-y-6">
            @csrf

            
            <div class="color-selection">
                <label class="form-label">Primary Color</label>
                <div class="color-picker-container">
                    <input type="color" name="theme_color" value="{{ old('theme_color', $themeColor) }}"
                        class="color-picker">
                    <div class="color-quick-selection">
                        <button type="button" class="quick-color" style="background-color: #F07324;"
                            onclick="setColor('#F07324')"></button>
                        <button type="button" class="quick-color" style="background-color: #33c3ff;"
                            onclick="setColor('#33c3ff')"></button>
                        <button type="button" class="quick-color" style="background-color: #8e44ad;"
                            onclick="setColor('#8e44ad')"></button>
                        <button type="button" class="quick-color" style="background-color: #2ecc71;"
                            onclick="setColor('#2ecc71')"></button>
                    </div>
                </div>
            </div>

            
            <div class="color-selection">
                <label class="form-label">Secondary Color</label>
                <div class="color-picker-container">
                    <input type="color" name="secondary_color" value="{{ old('secondary_color', $secondaryColor) }}"
                        class="color-picker">
                    <div class="color-quick-selection">
                        <button type="button" class="quick-color" style="background-color: #2e2e2e;"
                            onclick="setSecondaryColor('#2e2e2e')"></button>
                        <button type="button" class="quick-color" style="background-color: #e74c3c;"
                            onclick="setSecondaryColor('#e74c3c')"></button>
                        <button type="button" class="quick-color" style="background-color: #34495e;"
                            onclick="setSecondaryColor('#34495e')"></button>
                        <button type="button" class="quick-color" style="background-color: #1abc9c;"
                            onclick="setSecondaryColor('#1abc9c')"></button>
                    </div>
                </div>
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
            color:
                {{ $primaryColor }}
            ;
        }

        .color-selection {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .color-picker-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .color-picker {
            padding: 0;
            width: 100%;
            height: 40px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .color-picker:focus {
            outline: none;
            border-color:
                {{ $primaryColor }}
            ;
            box-shadow: 0 0 0 2px rgba({{($primaryColor)}}, 0.25);
        }

        .color-quick-selection {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .quick-color {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
        }

        .btn-theme {
            background-color:
                {{ $primaryColor }}
            ;
            color: #fff;
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .btn-theme:hover {
            background-color:
                {{ $primaryColorDark }}
            ;
            transform: translateY(-1px);
        }
    </style>

    <script>
      
        function setColor(color) {
            document.querySelector('input[name="theme_color"]').value = color;
        }

       
        function setSecondaryColor(color) {
            document.querySelector('input[name="secondary_color"]').value = color;
        }
    </script>
@endsection