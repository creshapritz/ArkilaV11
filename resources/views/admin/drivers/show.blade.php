@extends('layouts.admin')

@section('content')
    <style>
        body {
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f8f9fa;
            color: #2e2e2e;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px 30px;
        }

        h2 {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 40px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .col-md-4,
        .col-md-8,
        .col-md-6 {
            padding: 10px;
            box-sizing: border-box;
        }

        .col-md-4 {
            flex: 0 0 33.3333%;
            max-width: 33.3333%;
            text-align: center;
        }

        .col-md-8 {
            flex: 0 0 66.6666%;
            max-width: 66.6666%;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            text-align: center;
        }

        .img-fluid {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        h4 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            margin-bottom: 6px;
            color: #555;
        }

        p strong {
            color: #2c3e50;
        }

        hr {
            margin: 40px 0;
            border-top: 1px solid #dee2e6;
        }

        h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2e2e2e;
        }

        .document-section {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .document-img {
            width: 280px;
            height: 160px;
            object-fit: contain;
            border-radius: 10px;
            background-color: #f0f0f0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }


        .btn {
            padding: 10px 24px;
            font-size: 16px;
            font-weight: 600;
            background-color: #2c3e50;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-top: 30px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #1e2a35;
            color: #fff;
        }

        .badge-status {
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            display: inline-block;
        }

        .badge-status.active {
            background-color: #e0f7e9;
            color: #2e7d32;
        }

        .badge-status.inactive {
            background-color: #ffe0e0;
            color: #c62828;
        }

        @media (max-width: 768px) {

            .col-md-4,
            .col-md-8,
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
                text-align: center;
            }

            .document-img {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>

    <div class="container mt-4">
        <div>
            <h2>Driver Details</h2>

            <div class="row">
            <div class="col-md-4 text-center">
    <img src="{{ asset($driver->profile_picture) }}" alt="Profile Picture" 
         class="rounded-circle img-fluid" 
         style="width: 150px; height: 150px; object-fit: cover;">
</div>


                <div class="col-md-8">
                    <h4>{{ $driver->name }}</h4>
                    <p><strong>Email:</strong> {{ $driver->email }}</p>
                    <p><strong>Contact Number:</strong> {{ $driver->contact_number }}</p>
                    <p><strong>Company Name:</strong> {{ $driver->company_name ?? 'N/A' }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge-status {{ strtolower($driver->status) === 'active' ? 'active' : 'inactive' }}">
                            {{ ucfirst($driver->status) }}
                        </span>
                    </p>

                </div>
            </div>

            <hr>

            <div class="row mt-3">
                <div class="col-md-6">
                    <h5>Driver License</h5>
                    <div class="document-section">
                        <img src="{{ asset($driver->license_front) }}" alt="License Front"
                            class="document-img">
                        <img src="{{ asset($driver->license_back) }}" alt="License Back" class="document-img">
                    </div>
                </div>

                <div class="col-md-6">
                    <h5>Second ID</h5>
                    <div class="document-section">
                        <img src="{{ asset($driver->second_id_front) }}" alt="Second ID Front"
                            class="document-img">
                        <img src="{{ asset($driver->second_id_back) }}" alt="Second ID Back"
                            class="document-img">
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="/drivers" class="btn">Back to List</a>
            </div>
        </div>
    </div>
@endsection