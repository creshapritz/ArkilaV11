<!DOCTYPE html>
<html>
<head>
    <title>Bookings Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #F07324;
        }
        .header .date {
            font-size: 11px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 7px;
            text-align: left;
        }
        th {
            background-color: #F07324;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f1f1f1;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Bookings Report</h2>
        <div class="date">Generated on: {{ \Carbon\Carbon::now()->format('F j, Y - h:i A') }}</div>
    </div>

    <table>
        <thead>
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
                   <td>{{ $booking->client->first_name }} {{ $booking->client->last_name }}</td>

                    <td>{{ $booking->car->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->pickup_date)->format('M d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->dropoff_date)->format('M d, Y') }}</td>
                    <td>{{ $booking->status }}</td>
                    <td>PHP {{ number_format($booking->amount, 2) }}</td>
                    <td>{{ $booking->created_at->format('M d, Y - h:i A') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        ARKILA • {{ \Carbon\Carbon::now()->year }}
    </div>
</body>
</html>
