<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients Booking Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
            color: #333;
            line-height: 1.6;
        }

        h2 {
            text-align: center;
            color: #2e2e2e;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .generated {
            font-size: 12px;
            text-align: right;
            color: #777;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        th {
            background-color: #F07324;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-summary {
            margin-top: 30px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }

        .client-details {
            margin-bottom: 20px;
        }

        .client-details span {
            font-weight: bold;
            margin-right: 10px;
        }

        .client-info {
            margin-top: 15px;
            padding: 8px;
            background-color: #f1f1f1;
            border-radius: 8px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #777;
        }

        @page {
            size: A4 landscape;
            margin: 20mm;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Clients Booking Report</h2>
        <div class="generated">
            Generated on: {{ \Carbon\Carbon::now()->format('F j, Y, g:i a') }}
        </div>
    </div>

 

    <table>
        <thead>
            <tr>
                <th>Client Name</th>
                <th>Email</th>
                <th>Total Bookings</th>
                <th>Total Spent</th>
                <th>Last Booking</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->first_name }} {{ $client->last_name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->total_bookings }}</td>
                    <td>₱{{ number_format($client->total_spent, 2) }}</td>
                    <td>{{ $client->bookings->isEmpty() ? 'N/A' : $client->bookings->last()->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        ARKILA • {{ now()->format('Y') }}
    </div>

</body>
</html>
