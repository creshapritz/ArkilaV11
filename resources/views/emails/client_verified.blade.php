<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Verified</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family:'Sf Pro display';
            background: linear-gradient(135deg, #f0f4f8, #d9e8ff);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            text-align: center;
        }

        .container h2 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .container p {
            font-size: 16px;
            color: #555;
            margin: 12px 0;
            line-height: 1.6;
        }

        .highlight {
            color: #27ae60;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 15px;
            color: #888;
        }

        .footer strong {
            color: #2c3e50;
        }

        @media screen and (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello {{ $client->first_name }}!</h2>

        <p>We're thrilled to inform you that your <span class="highlight">ARKILA account has been successfully verified</span>.</p>

        <p>You now have full access to all our features. Browse, book, and explore at your convenience with confidence and ease.</p>

        <p>Thanks for being a part of our journey. We’re excited to serve you better!</p>

        <div class="footer">
            <p>Best regards,<br><strong>ARKILA Team</strong></p>
        </div>
    </div>
</body>
</html>
