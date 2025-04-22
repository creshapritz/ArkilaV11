<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>All Cars Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        .generated-date {
            text-align: right;
            font-size: 11px;
            margin-bottom: 10px;
            color: #666;
        }

        h2 {
            margin: 0;
            color: #f07b20;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f07b20;
            color: white;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td {
            text-align: center;
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
    <header>
        <h2>All Cars Booking Report</h2>
    </header>

    <div class="generated-date">
        Generated on {{ $dateNow }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Brand</th>
                <th>Model</th>
                <th>Plate Number</th>
                <th>Last Booking</th>
                <th>Total Bookings</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        ARKILA Car Rental System • {{ now()->format('Y') }}
    </div>
</body>
</html>
