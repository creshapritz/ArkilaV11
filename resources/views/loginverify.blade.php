<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <title>Verification</title>
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
    <script src="{{ asset('assets/js/register.js') }}" defer></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="registration-container">

        <div class="image-container">
            <div class="logo-container">
                <img src="{{ asset('assets/img/whitelogoarkila.png') }}" alt="Logo" class="logo">
                <p class="logo-text">Adventure Awaits!</p>
            </div>
            <img src="{{ asset('assets/img/arkila.gif') }}">
           
        </div>

       
        <div class="form-container">


            <form action="{{ route('verify') }}" method="POST">
                @csrf
                <div class="form-header">
                <h1>Hello, {{ session('client_name') }}!</h1>

                    <p>Enter your Code!</p>
                </div>


                
                <div class="verification-section">
                    <h2>Verify Authentication</h2>
                    <p>Enter the authentication code that we sent at your email.</p>

                  
                    <div class="code-input-container">

                        <input type="text" class="code-input" name="code[]" maxlength="1" required />
                        <input type="text" class="code-input" name="code[]" maxlength="1" required />
                        <input type="text" class="code-input" name="code[]" maxlength="1" required />
                        <input type="text" class="code-input" name="code[]" maxlength="1" required />
                        <input type="text" class="code-input" name="code[]" maxlength="1" required />
                        <input type="text" class="code-input" name="code[]" maxlength="1" required />

                    </div>

                   
                    <div class="resend-code-container">
                        <a href="{{ route('verification.send') }}" class="resend-code" id="resend-btn">Resend Code</a>

                    </div>

                    
                    <div class="button-container">
                        <button type="submit" class="next-button">Next</button>
                        <button type="button" class="back-button" onclick="goToBack()">Back</button>


                    </div>
                </div>
            </form>




        </div>

    </div>


    @if (session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#F07324',
                    background: '#F9F8F2',
                    iconColor: '#F07324',
                });
            });
        </script>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const codeInputs = document.querySelectorAll('.code-input');

            codeInputs.forEach((input, index) => {
               
                if (index === 0) {
                    input.focus();
                }

               
                input.addEventListener('input', (e) => {
                    const value = e.target.value;
                    if (value.length === 1) {
                        
                        if (index < codeInputs.length - 1) {
                            codeInputs[index + 1].focus();
                        }
                    } else {
                        
                        e.target.value = value.charAt(0);
                    }
                });

                
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && e.target.value === '') {
                       
                        if (index > 0) {
                            codeInputs[index - 1].focus();
                        }
                    }
                });

               
                input.addEventListener('keypress', (e) => {
                    if (!/[0-9]/.test(e.key)) {
                        e.preventDefault();
                    }
                });
            });

            const resendButton = document.getElementById('resend-btn');

            resendButton.addEventListener('click', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Verification Sent!',
                    text: 'A new verification code has been sent to your email.',
                    icon: 'success',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: '#F07324',
                    background: '#F9F8F2',
                    iconColor: '#F07324',
                    timer: 5000,
                }).then(() => {

                    window.location.href = resendButton.href;
                });
            });



        });



    </script>

</body>

</html>