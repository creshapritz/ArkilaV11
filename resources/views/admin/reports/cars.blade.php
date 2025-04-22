@extends('layouts.admin')

@section('content')
    <div class="client-container">
        <!-- <h2 class="title">Car Booking Report</h2> -->

        <form method="GET" action="{{ route('admin.reports.cars') }}" class="search-form mb-4">
            <input type="text" name="search" placeholder="Search by car model or brand" value="{{ request('search') }}">
            <button type="submit">Search</button>
        </form>

        @if ($cars->isEmpty())
            <div class="alert-info-custom">No car bookings found.</div>
        @else
            <div class="table-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Plate Number</th>
                            <th>Last Booking</th>
                            <th>Total Bookings</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cars as $car)
                            <tr>
                                <td>{{ $car['brand'] }}</td>
                                <td>{{ $car['type'] }}</td>
                                <td>{{ $car['platenum'] }}</td>
                                <td>{{ $car['last_booking'] ? $car['last_booking']->format('Y-m-d H:i') : 'N/A' }}</td>
                                <td>{{ $car['total_bookings'] }}</td> 
                                <td>
                                    <a href="{{ route('admin.reports.cars.exportSpecificPDF', $car['id']) }}" class="export-link">
                                        Export
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    @if ($cars->hasPages())
        <div class="col-md-12 d-flex justify-content-end">
            {{ $cars->links('pagination::bootstrap-5') }}
        </div>
    @endif


    <div class="d-flex justify-content-end mt-3 gap-2">
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary equal-btn">Back</a>
        <a href="{{ route('admin.reports.cars.exportPDF', ['search' => request('search')]) }}"
            class="btn btn-danger equal-btn">
            Export All to PDF
        </a>
    </div>

    <style>
        body {
            font-family: 'Sf Pro display';
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

        .client-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .title {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .input-group-custom {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .input-group-custom input[type="text"] {
            flex: 1;
            padding: 8px;
            font-size: 16px;
        }

        .input-group-custom button {
            padding: 8px 16px;
            font-size: 16px;
            background-color: royalblue;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .input-group-custom button:hover {
            background-color: #274caa;
        }

        .alert-info-custom {
            background-color: #e8f4fd;
            padding: 15px;
            border-left: 5px solid #007bff;
            color: #333;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .custom-table th,
        .custom-table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .custom-table thead {
            background-color: #F07324;
            color: white;
        }

        .highlight {
            background-color: #F9F8F2;
        }

        .view-btn {
            padding: 6px 12px;

            background-color: #90C6AA;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }


        .equal-btn {
            width: 150px;
            text-align: center;
            margin-right: 20px;
            margin-bottom: 20px;
        }

        .equal-btn {
            min-width: 140px;
            text-align: center;
        }

        .pagination-center {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }



        .search-form {
            display: flex;
            gap: 10px;
            align-items: center;
            max-width: 500px;
        }

        .search-form input[type="text"] {
            flex: 1;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        .search-form input[type="text"]:focus {
            border-color: #f07b20;
        }

        .search-form button {
            background-color: #f07b20;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .search-form button:hover {
            background-color: #d96812;
        }

        .export-link {
            color: #2e2e2e;
            font-weight: 500;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .export-link:hover {
            color: #f07b20;
            text-decoration: underline;
        }
    </style>
@endsection