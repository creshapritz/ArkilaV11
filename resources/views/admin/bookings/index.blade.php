@extends('layouts.admin')

@section('content')

    <section class="bookings-ov">
        <div class="header-container">
            <h1>Bookings Management</h1>



        </div>

        <div class="bookings">
            <table class="bookingtbl">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Car</th>
                        <th>Pickup Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                                    <tr>

                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->client->username ?? 'N/A' }}</td>
                                        <td>{{ $booking->car->brand ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->pickup_date . ' ' . $booking->pickup_time)->format('F j, Y g:i A') }}
                                        </td>
                                        <td>
                                            @php
                                                $statusClasses = [
                                                    'partially paid' => 'badge-warning',
                                                    'Paid' => 'badge-success',
                                                    'Returned' => 'badge-neutral',
                                                    'cancelled' => 'badge-danger',
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusClasses[$booking->status] ?? 'badge-default' }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-primary">
                                                View Details
                                            </a>
                                        </td>

                                    </tr>
                    @endforeach
                </tbody>

            </table>
            <div class="pagination-links">
                {{ $bookings->links('pagination::bootstrap-5') }}

            </div>



            @if($bookings->isEmpty())
                <div class="no-records">
                    <p>No bookings found for the selected filter.</p>
                </div>
            @endif
        </div>

    </section>


    <style>
        .btn-primary{
            background-color: transparent !important;
            color: #F07324 !important;

        }
        .btn-primary:hover{
            text-decoration: underline;

        }
        body {
            font-family: 'SF Pro Display';
        }

        .header-container {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .bookings {
            width: 97%;
            margin: 20px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;

        }

        .bookingtbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }



        table th {
            background-color: #F07324;
            color: white;
            padding: 15px;
            text-align: center;
        }

        table td {
            color: #333;
            font-size: 16px;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table tr:nth-child(even) {
            background-color: #ffffff;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            font-size: 14px;
            border-radius: 12px;
            font-weight: 600;
            color: white;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #333;
        }

        .badge-neutral {
            background-color: rgb(10, 125, 225);
        }

        .badge-danger {
            background-color: #dc3545 ;
        }



        .badge-default {
            background-color: #999;
        }

        .form-select {
            padding: 6px 12px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

      
        .no-records {
            text-align: center;
            padding: 20px;
            font-size: 16px;
            color: #666;
        }

        .bookings-ov {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-select {
            padding: 6px 12px;
            margin-right: 10px;
            border-radius: 6px;
        }

        .bookingtbl {
            background-color: #f1f1f1;
        }

        .bookings {
            background-color: #ffffff;
        }

        .sidebar {
            background-color: #ffffff;
            width: 350px;

        }

        .pagination-links {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .pagination .page-link {
            color: #F07324;
            border: none;
        }

        .pagination .active .page-link {
            background-color: #F07324;
            color: white;
        }
    </style>


@endsection