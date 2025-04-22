<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <title>REGISTER</title>
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
    <script src="{{ asset('assets/js/register.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
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

<body>


    <div class="registration-container">

        <div class="image-container">
            <div class="logo-container">
                <img src="{{ asset('assets/img/whitelogo.png') }}" alt="Logo" class="logo">
                <p class="logo-text">Adventure Awaits!</p>
            </div>
            <img src="{{ asset('assets/img/arkila.gif') }}">

        </div>

        <div class="form-container">


            <form action="{{ route('verification.submit') }}" method="POST">
                @csrf
                <div class="form-header">
                    <h1>Welcome!</h1>
                    <p>Sign up with ARKILA to get moving.</p>
                </div>

                
                <div class="timeline-registration-container">
                    <div class="timeline">
                        <div class="timeline-step" id="step-1">1</div>
                        <div class="timeline-line" id="line-1"></div>
                        <div class="timeline-step" id="step-2">2</div>
                        <div class="timeline-line" id="line-2"></div>
                        <div class="timeline-step" id="step-3">3</div>
                    </div>
                </div>

              
                <div class="verification-section">
                    <h2>Verification Code</h2>
                    <p>II. We have sent you a verification code on your Gmail Account. <br> Please enter the
                        verification code below.</p>

                   
                    <div class="code-input-container">

                        <input type="text" class="code-input" name="code[]" maxlength="1" required />
                        <input type="text" class="code-input" name="code[]" maxlength="1" required />
                        <input type="text" class="code-input" name="code[]" maxlength="1" required />
                        <input type="text" class="code-input" name="code[]" maxlength="1" required />
                        <input type="text" class="code-input" name="code[]" maxlength="1" required />
                        <input type="text" class="code-input" name="code[]" maxlength="1" required />


                    </div>


                    
                    <div class="resend-code-container">
                        <button type="button" class="resend-code" id="resendCodeBtn">Resend Code</button>
                    </div>

                    
                    <div class="button-container">
                        <button type="submit" class="next-button">Next</button>
                        <button type="button" class="back-button" onclick="goToBack()">Back</button>
                    </div>
                </div>
            </form>

        </div>

    </div>



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
        });


        document.getElementById('resendCodeBtn').addEventListener('click', function (event) {
            event.preventDefault(); 

            fetch("{{ route('verification.resend') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({})
            })
                .then(response => {
                    
                    return response.json().catch(() => {
                       
                        return { success: true, message: 'Verification code sent!' }; 
                    });
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Email Sent!',
                            text: data.message || 'The verification email has been resent successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            iconColor: '#F07324',
                            customClass: {
                                popup: 'custom-swal-popup',
                                title: 'custom-swal-title',
                                confirmButton: 'custom-swal-button'
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Failed!',
                            text: data.message || 'Failed to resend the verification email. Please try again later.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            customClass: {
                                popup: 'custom-swal-popup',
                                title: 'custom-swal-title',
                                confirmButton: 'custom-swal-button'
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while resending the email.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        });

        document.addEventListener('DOMContentLoaded', function () {
            @if(session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonText: 'Try Again',
                    iconColor: '#F07324',
                    customClass: {
                        popup: 'custom-swal-popup',
                        title: 'custom-swal-title',
                        confirmButton: 'custom-swal-button'
                    }
                });
            @endif
        });

    </script>



</body>

</html>