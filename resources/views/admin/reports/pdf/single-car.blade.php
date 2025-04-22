<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Car Report</title>
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

        .car-info, .bookings-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .car-info th, .car-info td,
        .bookings-table th, .bookings-table td {
            border: 1px solid #ddd;
            padding: 10px;
        }

      
        .bookings-table th {
            background-color: #f07b20;
            color: white;
            text-align: left;
        }
        .car-info th{
            background-color: #D4D8DD;
            color: #2e2e2e;
            text-align: left;
        }

        .car-info td,
        .bookings-table td {
            background-color: #f9f9f9;
        }

        .section-title {
            margin-top: 40px;
            font-size: 14px;
            font-weight: bold;
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
        <h2>Car Report: {{ $car['brand'] }} {{ $car['type'] }}</h2>
    </header>

    <div class="generated-date">
        Generated on {{ $dateNow }}
    </div>

    <table class="car-info">
        <tr>
            <th>Plate Number</th>
            <td>{{ $car['platenum'] }}</td>
        </tr>
        <tr>
            <th>Last Booking</th>
            <td>{{ $car['last_booking'] ? $car['last_booking']->format('Y-m-d H:i') : 'N/A' }}</td>
        </tr>
        <tr>
            <th>Total Bookings</th>
            <td>{{ $car['total_bookings'] }}</td>
        </tr>
    </table>

    @if($bookings->count())
        <div class="section-title">All Bookings</div>
        <table class="bookings-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Booking Date</th>
                    <th>Pickup</th>
                    <th>Drop-off</th>
                    <th>Price per day</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $index => $booking)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $booking->client->first_name ?? 'N/A' }} {{ $booking->client->last_name ?? '' }}</td>
                        <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $booking->pickup_location ?? 'N/A' }}</td>
                        <td>{{ $booking->dropoff_location ?? 'N/A' }}</td>
                        <td>₱{{ number_format($booking->car->price_per_day ?? 0, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="margin-top: 30px;">No bookings found for this car.</p>
    @endif

    <div class="footer">
        ARKILA Car Rental System • {{ now()->format('Y') }}
    </div>
</body>
</html>
