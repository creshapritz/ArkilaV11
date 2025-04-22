<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Cancellation & Refund Receipt</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
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
            color:  #F07324; 
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
        .greeting {
            font-size: 16px;
            margin-bottom: 15px;
        }
        .confirmation {
            font-size: 16px;
            margin-bottom: 15px;
        }
        .info-list {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }
        .info-list li {
            font-size: 16px;
            margin-bottom: 8px;
        }
        .info-list li strong {
            font-weight: bold;
            color: #555;
            margin-right: 5px;
        }
        .refund-info {
            padding: 15px;
            background-color:rgb(231, 162, 120); 
            color: #2e2e2e;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .refund-info strong {
            font-weight: bold;
        }
        .contact-us {
            font-size: 16px;
            margin-bottom: 15px;
            color: #777;
        }
        .thank-you {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .support-team {
            font-size: 16px;
            color: #777;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="receipt-box">
       
        <div class="header">
            <h2>Booking Cancelled & Refunded</h2>
            <p>ARKILA Car Rental</p>
        </div>
        <div class="line"></div>

        <p class="greeting">Hi {{ $booking->client->first_name }},</p>

        <p class="confirmation">We're confirming that your booking with the following details has been <strong>cancelled</strong> and a full refund has been processed:</p>

        <ul class="info-list">
            <li><strong>Booking ID:</strong> {{ $booking->id }}</li>
            <li><strong>Vehicle:</strong> {{ $booking->car->name ?? 'N/A' }}</li>
            <li><strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($booking->created_at)->format('F j, Y - h:i A') }}</li>
            <li class="refund-info"><strong>Refund Amount:</strong> ₱{{ number_format($booking->amount / 2, 2) }}</li>
        </ul>

        <p class="contact-us">If you have any questions, feel free to contact us at <a href="mailto:arkilacarrental123@gmail.com" style="color: #007bff; text-decoration: none;">support@arkila.com</a>.</p>

        <p class="thank-you">Thank you for choosing <strong>ARKILA Car Rental</strong>!</p>

        <p class="support-team">Best regards,<br>ARKILA Support Team</p>
    </div>
</body>
</html>