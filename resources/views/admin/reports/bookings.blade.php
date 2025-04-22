@extends('layouts.admin')

@section('content')
    <style>
        body {
            font-family: 'Sf Pro Display', sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;

        }

        .custom-thead {
            background-color: #F07324;
            color: #fff;
            font-weight: bold;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
           
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .pagination .page-link {
            color: #F07324;
            border: 1px solid #ddd;
            padding: 8px 16px;
            margin: 0 4px;
            border-radius: 4px;
        }

        .pagination .active .page-link {
            background-color: #F07324;
            color: white;
        }

        .filter-form select,
        .filter-form input {
            border: 1px solid #ccc;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
            width: 100%;
        }

        .filter-form button {
            background-color: #F07324;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: #d5631d;
        }

        .filter-form a.btn-secondary {
            background-color: #6c757d;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            text-decoration: none;
        }

        .filter-form a.btn-secondary:hover {
            background-color: #5a6268;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
        }

        .badge {
            padding: 4px 8px;
            font-size: 14px;
            border-radius: 4px;
        }

        .bg-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .bg-primary {
            background-color: #007bff;
            color: white;
        }

        .bg-success {
            background-color: #28a745;
            color: white;
        }

        .bg-danger {
            background-color: #dc3545 !important;
            color: white;
        }

        .bg-secondary {
            background-color: #6c757d;
            color: white;
        }

        .equal-btn {
            width: 150px;
            text-align: center;
            margin-right: 10px;
            margin-bottom: 20px;
        }

        .equal-btn {
            min-width: 140px;
            text-align: center;
        }




        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .filter-form .col-md-3 {
                margin-bottom: 10px;
            }

            .d-flex {
                flex-direction: column;
                gap: 10px;
            }

            .filter-form button {
                width: 100%;
            }
        }
    </style>

    <div class="container mt-4">
     

   
        <form method="GET" action="{{ route('admin.reports.bookings') }}" class="filter-form row mb-4 g-2">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">-- Filter by Status --</option>
                    <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Returned" {{ request('status') == 'Returned' ? 'selected' : '' }}>Returned</option>
                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="col-md-3">
                <input type="date" name="pickup_date" class="form-control" value="{{ request('pickup_date') }}">
            </div>

            <div class="col-md-3">
                <select name="car_id" class="form-select">
                    <option value="">-- Filter by Car --</option>
                    @foreach ($cars as $car)
                        <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                            {{ $car->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.reports.bookings') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        @if ($bookings->isEmpty())
            <div class="alert alert-info">No bookings found.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="custom-thead">
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Car</th>
                            <th>Pickup Date</th>
                            <th>Dropoff Date</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>{{ $booking->client->first_name ?? 'N/A' }} {{ $booking->client->last_name ?? '' }}</td>
                                <td>{{ $booking->car->name ?? 'N/A' }}</td>
                                <td>{{ $booking->pickup_date }}</td>
                                <td>{{ $booking->dropoff_date }}</td>
                                <td>
                                    <span class="badge 
                                                                                        @if ($booking->status === 'Paid') bg-primary
                                                                                        @elseif ($booking->status === 'Returned') bg-success
                                                                                        @elseif ($booking->status === 'Cancelled') bg-danger
                                                                                            @else bg-secondary
                                                                                        @endif">
                                        {{ $booking->status }}
                                    </span>
                                </td>

                                <td>₱{{ number_format($booking->amount, 2) }}</td>
                                <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row align-items-center mt-4">
                <div class="col-md-12 d-flex justify-content-end">
                    {{ $bookings->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>


        @endif
    </div>

    <div class="d-flex justify-content-end mt-3 gap-2">
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary equal-btn">Back</a>
        <a href="{{ route('admin.reports.bookings.exportPdf', request()->query()) }}"
            class="btn btn-danger equal-btn">Export to PDF</a>
    </div>

@endsection