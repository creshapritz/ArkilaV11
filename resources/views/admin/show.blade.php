@extends('layouts.admin')

@section('content')
    <div class="admin-details-container">
        <div class="details-card">
            <h1 class="title">Admin Details</h1>

            <div class="detail-item"><strong>First Name:</strong> {{ $admin->firstname }}</div>
            <div class="detail-item"><strong>Last Name:</strong> {{ $admin->lastname }}</div>
            <div class="detail-item"><strong>Role:</strong> {{ ucfirst($admin->role) }}</div>
            <div class="detail-item"><strong>Status:</strong>
                <span class="status-badge {{ $admin->status == 'Active' ? 'active' : 'inactive' }}">
                    {{ $admin->status }}
                </span>
            </div>
            <div class="detail-item"><strong>Created At:</strong> {{ $admin->created_at->format('F d, Y') }}</div>

            <a href="{{ route('admin.accounts') }}" class="back-btn">← Back to Admin List</a>
        </div>
    </div>

    <style>
        body {
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f8f9fa;
        }

        .admin-details-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .details-card {
            background: #ffffff;
            margin-top: 60px;
            padding: 30px 50px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 25px;
            color: #333;
            text-align: center;
        }

        .detail-item {
            font-size: 16px;
            margin-bottom: 15px;
            color: #555;
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .status-badge.active {
            background-color: #28a745;
            color: #fff;
        }

        .status-badge.inactive {
            background-color: #dc3545;
            color: #fff;
        }


        <style>body {
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f8f9fa;
        }

        .admin-details-container {

            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .details-card {
            background: #ffffff;
            margin-top: 60px;
            padding: 30px 50px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 25px;
            color: #333;
            text-align: center;
        }

        .detail-item {
            font-size: 16px;
            margin-bottom: 15px;
            color: #555;
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .status-badge.active {
            background-color: #28a745;
            color: #fff;
        }

        .status-badge.inactive {
            background-color: #dc3545;
            color: #fff;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #F07324;
            color: #fff;
            border-radius: 8px;
            text-decoration: none !important;
            font-weight: bold;
           
        }
        .back-btn:hover {
            background-color: #d65f1e;
            color: #fff;
            transition: background-color 0.3s ease;
        }
 
        
    </style>
@endsection