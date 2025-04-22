@extends('layouts.settings')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy and Security</title>
    <style>
        body {
            font-family: 'Sf Pro display';
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
           
            height: 100vh;
        }
        
        .form-container {
            position: absolute;
            top: 170px; 
            left: 60%;
            transform: translateX(-50%);
            width: 50%;
            background: #fff;
            padding: 35px;
           
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        }

       
        .form-group {
            margin-bottom: 20px;
            padding-right: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            background-color: #F07324;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
        }

        button:hover {
            background-color: #d95e1a;
        }

     
        .success-message {
            color: green;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2 style="text-align: center;">Update Password</h2>
        <p style="text-align: center;">Ensure your account is secure by updating your password regularly.</p>
        
        <form method="POST" action="{{ route('update-password') }}">
            @csrf
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" required>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="new_password_confirmation" required>
            </div>
            <button type="submit">Update Password</button>
        </form>

        @if (session('success'))
            <p class="success-message">{{ session('success') }}</p>
        @endif
        @if ($errors->any())
            <p class="error-message">{{ $errors->first() }}</p>
        @endif
    </div>

</body>

</html>
