@extends('layouts.partners_admin')

@section('content')
    <section class="transaction-history-section">
        <div class="container">
            <div class="header-container">
                <h1 class="main-title">Transaction History</h1>
            </div>

            <div class="transactions-table-wrapper">
                @if ($bookings->isEmpty())
                    <p class="no-transactions">No transactions found for this company.</p>
                @else
                    <table class="transactions-table">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Client Name</th>
                                <th>Car</th>
                                <th>Company</th>
                                <th>Pickup Location</th>
                                <th>Dropoff Location</th>
                                <th>Pickup Date</th>
                                <th>Dropoff Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->client->first_name ?? 'N/A' }} {{ $booking->client->last_name ?? '' }}</td>
                                    <td>{{ $booking->car->brand ?? 'N/A' }}</td>
                                    <td>{{ $booking->car->company_name ?? 'N/A' }}</td>
                                    <td>{{ $booking->pickup_location }}</td>
                                    <td>{{ $booking->dropoff_location }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $booking->pickup_date . ' ' . $booking->pickup_time)->format('F j, Y g:i A') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $booking->dropoff_date . ' ' . $booking->dropoff_time)->format('F j, Y g:i A') }}
                                    </td>
                                    <td>₱{{ number_format($booking->amount, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $booking->status === 'Paid' ? 'status-paid' : ($booking->status === 'Returned' ? 'status-returned' : 'status-pending') }}">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $bookings->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    <style>
        body {
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f4f6f8; /* Light grey background */
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .transaction-history-section {
            padding: 30px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e6ed;
        }

        .main-title {
            font-size: 2.2rem;
            color: #2d3748; /* Dark grey title */
            font-weight: 600;
            margin-bottom: 0;
        }

        .transactions-table-wrapper {
            overflow-x: auto; /* Enable horizontal scrolling for smaller screens */
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .transactions-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .transactions-table th {
            background-color: #f97316;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .transactions-table td {
            color: #4a5568;
            font-size: 0.95rem;
            padding: 12px 15px;
            border-bottom: 1px solid #edf2f7; /* Light grey border */
            text-align: center; /* Center align data for better readability */
        }

        .transactions-table tr:last-child td {
            border-bottom: none;
        }

        .transactions-table tbody tr:hover {
            background-color: #f7fafc; /* Very light grey on hover */
        }

        .no-transactions {
            color: #718096;
            font-size: 1rem;
            padding: 20px;
            text-align: center;
        }

        .badge {
            padding: 8px 12px;
            border-radius: 6px;
            color: white;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .status-paid {
            background-color: #28a745; /* Green for Paid */
        }

        .status-returned {
            background-color: #007bff; /* Blue for Returned */
        }

        .status-pending {
            background-color: #ffc107; /* Yellow for Pending/Partially Paid */
            color: #212529; /* Dark text for better contrast on yellow */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header-container {
                margin-bottom: 20px;
                padding-bottom: 15px;
            }

            .main-title {
                font-size: 2rem;
            }

            .transactions-table th, .transactions-table td {
                padding: 8px 10px;
                font-size: 0.85rem;
            }
        }
    </style>
@endsection