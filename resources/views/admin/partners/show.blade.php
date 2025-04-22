@extends('layouts.admin')

@section('content')
    <style>
        body {

            font-family: 'SF Pro Display', sans-serif;
            background-color: #f4f6f8;
            color: #2e2e2e;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            padding: 40px;
        }

        .header-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .header-section h2 {
            font-size: 28px;
            font-weight: 600;
            color: #2e2e2e;
        }

        .badge-status {
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .badge-status.active {
            background-color: #e0f7e9;
            color: #2e7d32;
        }

        .badge-status.inactive {
            background-color: #ffe0e0;
            color: #c62828;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 35px;
        }

        .info-grid p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .info-grid p strong {
            font-weight: 600;
            color: #333;
        }

        .section-title {
            margin-top: 30px;
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 8px;
        }

        .logo-preview {
            width: 140px;
            height: auto;
            margin-top: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .document-link {
            display: inline-block;
            margin-top: 10px;
            font-size: 15px;
            font-weight: 500;
            color: #2e2e2e;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .document-link:hover {
            color: #d65f1e;
        }

        .btn-back {
            margin-top: 40px;
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background-color: #f07324;
            border: none;
            border-radius: 8px;
            transition: background 0.3s ease;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #d65f1e;
            color: #fff;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container">
        <div class="header-section">
            <h2>Partner Details</h2>
            <span class="badge-status {{ strtolower($partner->status) === 'active' ? 'active' : 'inactive' }}">
                {{ ucfirst($partner->status) }}
            </span>

        </div>

        <div class="info-grid">
            <p><strong>Company Name:</strong> {{ $partner->company_name }}</p>
            <p><strong>Company Owner:</strong> {{ $partner->company_owner }}</p>
            <p><strong>Email:</strong> {{ $partner->company_email }}</p>
            <p><strong>Phone:</strong> {{ $partner->company_phone }}</p>
        </div>

        <div>
            <div class="section-title">Company Logo</div>
            <img src="{{ asset($partner->company_logo) }}" alt="Company Logo" class="logo-preview">
        </div>

        <div>
            <div class="section-title">Company Document</div>
            <a href="{{ asset(path:  $partner->company_document) }}" class="document-link" target="_blank">View
                Document</a>
        </div>

        <a href="{{ route('admin.partners.index') }}" class="btn-back">Back to Partners</a>
    </div>
@endsection