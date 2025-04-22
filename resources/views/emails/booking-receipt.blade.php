<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Receipt</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">

    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table width="500px"
                    style="background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">

                    <!-- Logo -->
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">

                        </td>
                    </tr>


                    <tr>
                        <td align="center">
                            <h2 style="color: #333;">Hello, {{ Auth::user()->first_name }}! </h2>
                            <p style="color: #666; font-size: 16px;">Thank you for your payment. Here’s your booking
                                receipt.</p>
                        </td>
                    </tr>


                    <tr>
                        <td style="padding: 15px 20px;">
                            <h3 style="color: #ff7f00; border-bottom: 2px solid #ff7f00; padding-bottom: 5px;">Booking
                                Details</h3>
                            <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
                            <p><strong>Customer Name:</strong> {{ Auth::user()->first_name }}
                                {{ Auth::user()->last_name }}</p>
                            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                            <p><strong>Phone:</strong> {{ Auth::user()->contact_number }}</p>
                            <p><strong>Car Brand:</strong> {{ $booking->car->brand }}</p>
                            <p><strong>Car Type:</strong> {{ $booking->car->type }}</p>
                            <p><strong>Pickup Location:</strong> {{ $booking->pickup_location }}</p>
                            <p><strong>Pickup Date & Time:</strong> {{ $booking->pickup_date }} at
                                {{ $booking->pickup_time }}</p>
                            <p><strong>Dropoff Date & Time:</strong> {{ $booking->dropoff_date }} at
                                {{ $booking->dropoff_time }}</p>
                        </td>
                    </tr>


                    <tr>
                        <td style="padding: 15px 20px;">
                            <h3 style="color: #ff7f00; border-bottom: 2px solid #ff7f00; padding-bottom: 5px;">Payment
                                Summary</h3>


                            <p><strong>Amount Paid:</strong> <span style="font-size: 18px; color: #28a745;">PHP
                                    {{ number_format($booking->amount, 2) }}</span></p>
                            <p><strong>Booking Date:</strong> {{ $booking->created_at->format('F d, Y') }}</p>
                            <p><strong>Booking Status:</strong> <span
                                    style="color: green; font-weight: bold;">Confirmed</span></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px 20px;">
                            <h3 style="color: #ff7f00; border-bottom: 2px solid #ff7f00; padding-bottom: 5px;">Important
                                Notice</h3>
                            <p style="color: #444; font-size: 14px; line-height: 1.6;">
                                We would like to inform you that cancellations are only permitted within <strong>one (1)
                                    hour</strong> from the time this receipt is issued.
                                Requests made beyond this period will be subject to a <strong>₱1,500 cancellation
                                    fee</strong>.
                                <br><br>
                                Please be advised that all <strong>downpayments are strictly non-refundable</strong>,
                                regardless of the reason for cancellation.
                                <br><br>
                                We appreciate your understanding and cooperation. Should you have any concerns, feel
                                free to contact our support team.
                            </p>
                        </td>
                    </tr>





                    <tr>
                        <td align="center" style="padding: 20px; font-size: 12px; color: #999;">
                            Need help? Contact us at <a href="mailto:support@arkila.com"
                                style="color: #ff7f00;">arkilacarrental1232gmail.com</a> <br>
                            &copy; 2025 ARKILA Car Rental. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>