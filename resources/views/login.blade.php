<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <script src="{{ asset('assets/js/login.js') }}" defer></script>
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
 
    .custom-swal-popup {
        background-color: #F9F8F2;
        color: #2e2e2e;
    }
    .custom-swal-title {
        color: #F07324;
        font-weight: bold;
    }

    .custom-swal-button {
        background-color: #F07324;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }

    .custom-swal-button:hover {
        background-color: #F07324;
    }
</style>

</head>

<body>
    <section class="login-section">
       
        <div class="login-form">
            <h2>LOG IN</h2>
            <p>Let’s Hit the Road – Log In and Start Your Journey with ARKILA!</p>


            <form action="{{ route('login.post') }}" method="post">
                @csrf
                <label for="email">Email:</label>
                <input type="email" name="email" required placeholder="Enter your email">
                <label for="password">Password:</label>
                <div class="input-container">
                    <input type="password" name="password" id="password" required placeholder="Enter your password">
                    <i class="bx bx-hide" id="togglePassword"></i> 
                </div>

                <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                <button type="submit" name="login">Login</button>
            </form>



            <p class="login-signup">Don't have an account? <a href="/register">Sign up</a></p>
        </div>

       
        <div class="video-background">
            <video autoplay muted loop>
                <source src="{{ asset('assets/img/output.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="video-text">Get there with <span class="highlight">ARKILA!</span></div>
        </div>
    </section>

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: '{{ session("error") }}',
            iconColor: '#F07324',
            customClass: {
                    popup: 'custom-swal-popup',
                    title: 'custom-swal-title',
                    confirmButton: 'custom-swal-button'
                }
        });
    </script>
@endif

</body>

</html>