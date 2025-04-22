<!DOCTYPE html>
<html>
<head>
    <title>Partner Admin Login Details</title>
</head>
<body>
    <h2>Welcome to ARKILA!</h2>
    <p>Hello {{ $partnerAdmin->email }},</p>
    <p>Your partner admin account has been created. Below are your login details:</p>
    <p><strong>Email:</strong> {{ $partnerAdmin->email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>You can log in here: <a href="{{ route('partners_admin.login') }}">Login to Partner Dashboard</a></p>
    <p>We recommend changing your password after login.</p>
    <br>
    <p>Best regards,</p>
    <p>ARKILA Team</p>
</body>
</html>
