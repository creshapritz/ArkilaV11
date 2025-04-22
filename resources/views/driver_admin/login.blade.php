<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/admin/login.css') }}">
    <script src="{{ asset('assets/js/admin/login.js') }}" defer></script>
    <title>Partner Admin</title>
</head>

<body data-errors="{{ $errors->any() ? $errors->first() : '' }}">
    <div class="left-side">
        <h2>Hello, <span>Partner Admin</span></h2>
        <p>Log in and manage your fleet with <span>ARKILA</span>.</p>

        <form method="POST" action="{{ route('driver_admin.login.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                    required>
            </div>
            <div class="form-group">
                <div class="password-container">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <i class='bx bx-hide' id="togglePassword"></i>
                </div>
            </div>

            <a href="" class="forgot-password">Forgot Password?</a>

            <button type="submit" class="login-button">Login</button>
        </form>
    </div>

    <div class="right-side">
        <img src="{{ asset('assets/img/whitelogo.png') }}" alt="Logo" class="logo-top">
        <p class="right-side-text">Empowering your business with ARKILA!</p>
    </div>

    <script>
        let error = "{{ session('error') ?? $errors->first() }}";

        if (error) {
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: error,
            });
        }
    </script>
</body>

</html>
