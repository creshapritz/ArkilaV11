@extends('layouts.admin')

@section('content')
    <style>
        body {
            font-family: 'Sf Pro display';
        }
      

        .report-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        .report-container a{
            font-size: 16px;
        }

        .report-button {
            flex: 1 1 calc(50% - 20px);
            background-color: #F9F8F2;
            border: 1px solid #D2D2D2;
            display: flex;
            border-radius: 8px;
            padding: 30px 20px;
            text-align: center;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: #2e2e2e;
            font-weight: 600;
            transition: all 0.3s ease;

        }

        .report-button a {
            font-size: 30px;
        }

        .report-button:hover {
            text-decoration: none;
            color: #2e2e2e;

        }

        .report-button i {
            font-size: 25px;
            margin-top: 3px;
            display: block;

        }

        @media (max-width: 768px) {
            .report-button {
                flex: 1 1 100%;
            }
        }
    </style>
    <div class="container py-4">
    <h1 class="h2 mb-4">Reports</h1>

    <div class="report-container">
        <a href="{{ route('admin.reports.sales') }}" class="report-button">
            <i class="bx bx-dollar-circle"></i>
            Overall Sales Reports
        </a>

      
        <a href="{{ route('admin.reports.arkila_earnings') }}" class="report-button">
            <i class="bx bx-coin-stack"></i>
            ARKILA Earnings
        </a>

        <a href="{{ route('admin.reports.bookings') }}" class="report-button">
            <i class='bx bx-book-content'></i>
            Booking Reports 
        </a>

        <a href="{{ route('admin.reports.clients') }}" class="report-button">
            <i class="bx bx-user"></i>
            Clients Accounts
        </a>

        <a href="{{ route('admin.reports.cars') }}" class="report-button">
            <i class="bx bx-car"></i>
            Cars Reports
        </a>

        <a href="{{ route('admin.reports.drivers') }}" class="report-button">
            <i class="bx bx-id-card"></i>
            Driver Activity Report
        </a>
    </div>
</div>

@endsection