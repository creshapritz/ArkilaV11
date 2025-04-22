<!DOCTYPE html>
<html>
<head>
    <title>Verification Code - ARKILA</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f2f4f7;
            font-family: 'Sf Pro display', sans-serif;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
            text-align: center;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #F07324;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #2E2E2E;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .code-box {
            display: inline-block;
            background-color: #F07324;
            color: #fff;
            font-size: 26px;
            font-weight: bold;
            padding: 14px 30px;
            border-radius: 8px;
            letter-spacing: 4px;
            margin: 20px 0;
        }

        .footer {
            font-size: 13px;
            color: #999;
            margin-top: 40px;
        }

        .footer a {
            color: #F07324;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .container {
                padding: 25px;
            }

            .code-box {
                font-size: 22px;
                padding: 12px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">ARKILA</div>
        <h1>Hello, {{ $first_name }}!</h1>
        <p>We're glad you're here. To continue, please use the verification code below:</p>

        <div class="code-box">{{ $verificationCode }}</div>

        <p>Enter this code on the verification page to proceed with your login.</p>
        <p>If you did not request this code, please ignore this message.</p>

        <div class="footer">
            <p>Need help? <a href="mailto:support@arkila.com">Contact Support</a></p>
            <p>&copy; {{ date('Y') }} ARKILA. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
