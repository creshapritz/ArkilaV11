@php
    $terms = \App\Models\PrivacyLegal::where('key', 'terms_conditions')->value('value');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <title>REGISTER</title>
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .backend-error {
            color: red;
            font-size: 0.8em;
            margin-top: 0.25em;
        }
    </style>
</head>

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

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if (is_object($errors) && $errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form id="registrationForm" action="{{ route('register.store') }}" method="POST">
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

                <div class="registration-heading">
                    <h2>Registration</h2>
                    <p>I. Complete your registration and gain access to our wide range of vehicles and services.</p>
                </div>




                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" placeholder="Enter your first name"
                            value="{{ old('first_name') }}">
                        @error('first_name')
                            <div class="backend-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" placeholder="Enter your middle name"
                            value="{{ old('middle_name') }}">
                        @error('middle_name')
                            <div class="backend-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" placeholder="Enter your last name"
                            value="{{ old('last_name') }}">
                        @error('last_name')
                            <div class="backend-error">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="extension_name">Extension Name</label>
                        <input type="text" id="extension_name" name="extension_name"
                            placeholder="e.g., Jr., Sr., III (optional)" value="{{ old('extension_name') }}">
                        @error('extension_name')
                            <div class="backend-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="form-row">


                    <div class="form-row">
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="dob" placeholder="Enter your date of birth"
                                value="{{ old('dob') }}">
                            @error('dob')
                                <div class="backend-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" id="age" name="age" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            placeholder="Enter your age" value="{{ old('age') }}">
                        @error('age')
                            <div class="backend-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="tel" id="contact_number" name="contact_number"
                            placeholder="Enter your contact number" value="{{ old('contact_number') }}">
                        @error('contact_number')
                            <div class="backend-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" placeholder="Enter your address"
                            value="{{ old('address') }}">
                        @error('address')
                            <div class="backend-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group">
                        <label for="emergency_contact">Emergency Contact</label>
                        <input type="tel" id="emergency_contact" name="emergency_contact"
                            placeholder="Enter emergency contact number" value="{{ old('emergency_contact') }}">
                        @error('emergency_contact')
                            <div class="backend-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="emergency_contact_relationship">Relationship</label>
                        <input type="text" id="emergency_contact_relationship" name="emergency_contact_relationship"
                            placeholder="Relationship with emergency contact"
                            value="{{ old('emergency_contact_relationship') }}">
                        @error('emergency_contact_relationship')
                            <div class="backend-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="form-row">

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username"
                            value="{{ old('username') }}">
                        @error('username')
                            <div class="backend-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your gmail"
                            value="{{ old('email') }}">
                        @error('email')
                            <div class="backend-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-container">
                            <input type="password" id="password" name="password" placeholder="Enter your password">
                            <span class="eye-icon" onclick="togglePassword('password', this)">
                                <i class="bx bx-hide"></i>
                            </span>
                        </div>
                        @error('password')
                            <div class="backend-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <div class="input-container">
                            <input type="password" id="confirm_password" name="password_confirmation"
                                placeholder="Confirm your password">
                            <span class="eye-icon" onclick="togglePassword('confirm_password', this)">
                                <i class="bx bx-hide"></i>
                            </span>
                        </div>
                        @error('password_confirmation')
                            <div class="backend-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>



                @if ($terms)
                    <div class="form-group terms">
                        <input type="checkbox" id="terms" name="terms" class="custom-checkbox" required>
                        <label for="terms">I have read and agreed to the
                            <a href="{{ $terms }}" target="_blank">Terms and Conditions</a>
                        </label>
                    </div>
                @endif


                <button class="reg-button" type="submit">Sign Up</button>

                <div class="reg-login">
                    <p>Already have an account? <a href="/login">Login</a></p>
                </div>

            </form>



        </div>

    </div>


    <script src="{{ asset('assets/js/register.js') }}"></script>
    <script>
        document.getElementById('dob').addEventListener('change', function () {
            var birthDate = new Date(this.value);
            var today = new Date();
            var age = today.getFullYear() - birthDate.getFullYear();
            var monthDifference = today.getMonth() - birthDate.getMonth();

            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            document.getElementById('age').value = age;
        });
    </script>



</body>

</html>