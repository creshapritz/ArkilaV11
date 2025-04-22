@extends('layouts.admin-settings')

@section('content')
    <section class="settings-section">
        <h2 class="section-title">Edit Privacy & Legal</h2>

        <form action="{{ route('admin.updatePrivacyLegal') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Terms and Conditions --}}
            <div>
                <label for="terms_conditions" class="form-label">Terms and Conditions</label>
                <textarea id="terms_conditions" name="terms_conditions" rows="8"
                    class="form-textarea">{{ $terms }}</textarea>
            </div>

            {{-- Privacy Policy --}}
            <div>
                <label for="privacy_policy" class="form-label">Privacy Policy</label>
                <textarea id="privacy_policy" name="privacy_policy" rows="8"
                    class="form-textarea">{{ $privacy }}</textarea>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn-primary">
                    ✅ Save Changes
                </button>
                <a href="{{ route('admin.admin-settings-PL') }}" class="btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </section>

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
            color: #1f2937;
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
            border-color: #60a5fa;
            background-color: #fff;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25);
            outline: none;
        }

        .btn-primary {
            background-color:  #ff8c00;
            color: #fff;
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 8px;
            transition: background-color 0.2s ease;
            border: none;
        }

        .btn-primary:hover {
            background-color:rgb(255, 119, 0);
        }

        .btn-secondary {
            color: #6b7280;
            font-weight: 500;
            font-size: 0.95rem;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .btn-secondary:hover {
            color: #374151;
            text-decoration: underline;
        }
    </style>
@endsection