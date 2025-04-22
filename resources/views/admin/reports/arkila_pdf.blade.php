<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ARKILA Earnings Report</title>
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

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
            color: #F07324;
        }

        .summary {
            margin-bottom: 20px;
            padding: 10px;
            border-left: 5px solid #F07324;
            background-color: #f5f5f5;
        }

        .summary strong {
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            padding: 10px 8px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #F07324;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            position: absolute;
            bottom: 20px;
            left: 20px;
            font-size: 11px;
            color: #666;
        }

        .text-right {
            text-align: right;
        }

        

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
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
        <h2>ARKILS Earnings Report</h2>
        <div class="date">Generated on: {{ \Carbon\Carbon::now()->format('F j, Y - h:i A') }}</div>
    </div>
    <div class="header clearfix">
   
        <div><small>Year: {{ $year }}</small></div>
    </div>

    <div class="summary">
        <strong>Total ARKILA Earnings (20% of all paid bookings):</strong>
        <span>₱{{ number_format($arkilaShare, 2) }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Company Name</th>
                <th>Car</th>
                <th>Total Amount</th>
                <th>ARKILA Share (20%)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->car->partner->company_name ?? 'N/A' }}</td>

                    <td>{{ $booking->car->brand }} {{ $booking->car->type }}</td>
                    <td>₱{{ number_format($booking->amount, 2) }}</td>
                    <td>₱{{ number_format($booking->amount * 0.20, 2) }}</td>
                    <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        ARKILA • {{ \Carbon\Carbon::now()->year }}
    </div>
</body>

</html>