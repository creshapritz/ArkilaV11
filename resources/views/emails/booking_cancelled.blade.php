<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Cancellation Receipt</title>
    <style>
        body {
            font-family: 'Sf Pro display';
            color: #333;
            background-color: #f4f6f8;
            padding: 30px;
            display: flex;
            justify-content: center;
        }
        .receipt-box {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            padding: 30px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 150px;
            height: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h2 {
            color: #F07324;
            margin-bottom: 5px;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            color: #777;
            font-size: 14px;
            margin: 0;
        }
        .line {
            border-top: 1px solid #eee;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .info-row span:first-child {
            color: #555;
            font-weight: bold;
        }
        .amount-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: bold;
        }
        .amount-row span:first-child {
            color: #333;
        }
        .status-row {
            text-align: center;
            padding: 15px 0;
            background-color: #ffe0b2; 
            color: #d84315; 
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 18px;
        }
        .thank-you {
            text-align: center;
            margin-top: 25px;
            font-size: 16px;
            color: #777;
        }
        .arkila-team {
            text-align: center;
            font-weight: bold;
            color: #555;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="receipt-box">
        
        <div class="header">
            <h2>Booking Cancellation Receipt</h2>
            <p>ARKILA Car Rental</p>
        </div>
        <div class="line"></div>

        <div class="info-row">
            <span>Booking ID:</span>
            <span>{{ $booking->id }}</span>
        </div>
        <div class="info-row">
            <span>Client Name:</span>
            <span>{{ $booking->client->first_name }} {{ $booking->client->last_name }}</span>
        </div>
        <div class="info-row">
            <span>Car:</span>
            <span>{{ $booking->car->name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span>Booked At:</span>
            <span>{{ \Carbon\Carbon::parse($booking->created_at)->format('F d, Y h:i A') }}</span>
        </div>
        <div class="info-row">
            <span>Cancelled At:</span>
            <span>{{ now()->format('F d, Y h:i A') }}</span>
        </div>

        <div class="line"></div>

        <div class="amount-row">
            <span>Total Amount Paid:</span>
            <span>₱{{ number_format($booking->amount, 2) }}</span>
        </div>
        <div class="amount-row">
            <span>Refund Amount:</span>
            <span>₱{{ number_format($booking->amount / 2, 2) }}</span>
        </div>
        <div class="amount-row">
            <span>Cancellation Fee:</span>
            <span>₱1,500.00</span>
        </div>

        <div class="status-row">
            Status: Cancelled
        </div>

        <div class="line"></div>

        <p class="thank-you">Thank you for using ARKILA Car Rental. We hope to serve you again in the future.</p>
        <p class="arkila-team">~ ARKILA Team</p>
    </div>
</body>
</html>