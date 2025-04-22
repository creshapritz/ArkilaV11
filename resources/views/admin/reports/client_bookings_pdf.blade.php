<!DOCTYPE html>
<html>
<head>
    <title>Client Booking Report</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 20mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .sub-header {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
            color: #666;
        }

        .info {
            margin-bottom: 10px;
        }

        .info p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #f07b20;
            color: white;
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #777;
        }
    </style>
</head>
<body>

    <h2>{{ $client->first_name }} {{ $client->last_name }} - Booking Report</h2>
    <div class="sub-header">Generated on: {{ now()->format('F d, Y h:i A') }}</div>

    <div class="info">
        <p><strong>Email:</strong> {{ $client->email }}</p>
        <p><strong>Total Bookings:</strong> {{ $bookings->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Booking Date</th>
                <th>Car</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $index => $booking)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $booking->created_at->format('Y-m-d h:i A') }}</td>
                    <td>{{ $booking->car->name ?? 'N/A' }}</td>
                    <td>₱{{ number_format($booking->amount, 2) }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        ARKILA Car Rental System • {{ now()->format('Y') }}
    </div>

</body>
</html>
