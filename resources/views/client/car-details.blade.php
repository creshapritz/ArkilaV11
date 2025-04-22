<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <title>Deals</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/welcome.css')); ?>">
    <script src="{{ asset('assets/js/landpage.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .car-details-container {
            padding: 40px 20px;
            margin-top: 150px;

        }

        .car-details-section {
            max-width: 1100px;

            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease-in-out;

        }

        .car-details-section:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        .car-details-section h2 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 30px;
            border-bottom: 2px solid #eaeaea;
            padding-bottom: 10px;
        }

        .car-details {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            align-items: flex-start;
        }

        .car-image {
            flex: 1 1 350px;
            max-width: 500px;
            width: 100%;
            border-radius: 12px;
            object-fit: contain;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .car-info {
            flex: 1 1 300px;
            font-size: 16px;
            color: #444;
        }

        .car-info h3 {
            font-size: 24px;
            color: #34495e;
            margin-bottom: 20px;
        }

        .car-info p {
            margin-bottom: 12px;
        }

        .car-info strong {
            color: #2c3e50;
        }

        .car-booking {
            flex: 1 1 220px;
            background: #f9fafc;
            border: 1px solid #e0e0e0;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .car-booking p {
            font-size: 18px;
            font-weight: bold;
            color: #16a085;
            margin-bottom: 20px;
        }

        .book-now-button {
            background-color: #F07324;
            color: white;
            padding: 12px 28px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .book-now-button:hover {
            background-color: #D15716;
        }

        @media (max-width: 768px) {
            .car-details {
                flex-direction: column;
            }

            .car-image,
            .car-info,
            .car-booking {
                flex: 1 1 100%;
            }
        }

        /* Modern Review Form Styles */
        .review-form {
            margin-top: 40px;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
        }

        .review-form h3 {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #F07324;
            box-shadow: 0 0 6px rgba(240, 115, 36, 0.2);
        }

        .form-control select {
            appearance: none;
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg fill="%2334495e" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>');
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
        }

        .form-control textarea {
            resize: vertical;
        }

        .btn-primary {
            background-color: #F07324;
            color: white;
            padding: 12px 24px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 4px rgba(240, 115, 36, 0.1);
        }

        .btn-primary:hover {
            background-color: #D15716;
            box-shadow: 0 4px 6px rgba(240, 115, 36, 0.2);
        }


        p[style*="margin-top"] {
            margin-top: 30px !important;
            padding: 20px;
            background-color:rgba(226, 114, 10, 0.05);
            border: 1px solid rgba(235, 98, 13, 0.8);
           
            color: #2e2e2e;
            text-align: center;
        }
    </style>


</head>


<body>




    <div>
        <!-------------------------------------------------------- NAVBAR------------------------------------------------------------->
        <nav class="navbar">
            <div class="navbar-left">
                <img src="<?php echo e(asset('assets/img/whitelogoarkila.png')); ?>" alt="Logo" class="navbar-logo">
            </div>
            <div class="navbar-right">
                <button class="btn-bookings" onclick="window.location.href='{{ route('my-bookings') }}'">My
                    Bookings</button>
                <button class="btn-partner" onclick="window.location.href='{{ route('welcome_partner') }}'">Become a
                    partner</button>

                @if(Auth::check())
                <button class="btn-client">
                    @if(Auth::user()->profile_picture)
                    <img src="{{ Auth::user()->profile_picture }}" alt="Profile Picture" class="navbar-profile-pic">
                    @else
                    <i class='bx bxs-user-circle profile-icon'></i>
                    @endif
                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                </button>
                @else
                <a href="{{ route('login') }}" class="btn-client-login">Login</a>
                @endif

            </div>
        </nav>

        <!--------------------------------------------------------------- SIDEBAR--------------------------------------------->
        <div class="sidebar">
            <a href="#menu" class="menu-link" id="menu-button">
                <i class='bx bx-menu' id="menu-icon"></i>
                <span class="menu-text">ARKILA</span>
            </a>
            <ul>
                <li><a href="{{ route('welcome') }}"><i class='bx bx-home'></i> <span>Home</span></a></li>

                <li><a href="{{ route('welcome_about') }}"><i class='bx bx-info-circle'></i> <span>About Us</span></a>
                </li>

                <li><a href="{{ route('welcome_vehicles') }}"><i class='bx bx-car'></i> <span>Vehicles</span></a></li>

                <li><a href="{{ route('welcome_services') }}"><i class='bx bx-wrench'></i> <span>Services</span></a>
                </li>

                <li><a href="{{ route('welcome_rent') }}"><i class='bx bx-key'></i> <span>Rent</span></a></li>

                <li><a href="{{ route('welcome_contact') }}"><i class='bx bx-envelope'></i> <span>Contact Us</span></a>
                </li>

                <li><a href="{{ route('welcome_partner') }}"><i class='bx bx-user-plus'></i>
                        <span>Partnership</span></a></li>

                <li><a href="{{ route('welcome_settings') }}"><i class='bx bx-cog'></i> <span>Settings</span></a></li>

                <li><a href="javascript:void(0);" id="logout-link"><i class='bx bx-log-out'></i> <span>Logout</span></a>
                </li>


            </ul>
        </div>



        <!----------------------------------------------------- CAR DETAILS -------------------------------------------------------->





        <section class="car-details-container">

            <section class="car-details-section">
                <h2>{{ $car->brand }} {{ $car->name }}</h2>
                <div class="car-details">
                    <img src="{{ asset($car->primary_image) }}" alt="{{ $car->name }}" class="car-image">

                    <div class="car-info">
                        <h3>{{ $car->brand }} {{ $car->name }}</h3>
                        <p><strong>Type:</strong> {{ $car->type }}</p>
                        <p><strong>Location:</strong> {{ $car->location }}</p>
                        <p><strong>Seating Capacity:</strong> {{ $car->seating_capacity }} adult passengers</p>
                        <p><strong>Bags Capacity:</strong> {{ $car->num_bags }} suitcase(s)</p>
                        <p><strong>Fuel Type:</strong> {{ $car->gas_type }}</p>
                        <p><strong>Transmission:</strong> {{ $car->transmission }}</p>
                    </div>

                    <div class="car-booking">
                        <p>PHP {{ number_format($car->price_per_day, 2) }} / day</p>
                        <button class="book-now-button" onclick="window.location.href='{{ route('welcome_rent') }}'">
                            Book Now
                        </button>
                    </div>
                </div>
            </section>
        </section>


        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(auth('client')->check() && isset($canReview) && $canReview)
            <div class="review-form">
                <h3>Leave a Review</h3>
                <form action="{{ route('client.review.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                    <div class="form-group">
                        <label for="rating">Rating:</label>
                        <select name="rating" id="rating" required class="form-control">
                            <option value="">Choose rating</option>
                            <option value="5">★★★★★ - Excellent</option>
                            <option value="4">★★★★ - Good</option>
                            <option value="3">★★★ - Average</option>
                            <option value="2">★★ - Poor</option>
                            <option value="1">★ - Terrible</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="review">Your Review:</label>
                        <textarea name="review" id="review" rows="4" class="form-control"
                            placeholder="Share your experience..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
        @elseif(auth('client')->check())
            <p style="margin-top: 20px;">You can only review this car after completing a booking.</p>
        @endif
        <!----------------------------------------------------- VIDEO 2 -------------------------------------------------------->
        <section class="video2">
            <div class="video2">
                <video src="<?php echo e(asset('assets/img/output.mp4')); ?>" autoplay loop muted></video>
            </div>
        </section>

        <!----------------------------------------------------- FOOTER -------------------------------------------------------->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-section">
                    <img src="<?php echo e(asset('assets/img/whitelogoarkila.png')); ?>" alt="Arkila Logo"
                        class="footer-logo">
                    <div class="footer-links">
                        <a href="#" class="footer-link">Home</a>
                        <span class="footer-link">About Us</span>
                        <span class="footer-link">Vehicles</span>
                        <span class="footer-link">Services</span>
                        <span class="footer-link">Rent</span>
                        <span class="footer-link">Contact Us</span>
                        <span class="footer-link">Partnership</span>
                    </div>
                </div>
                <div class="footer-section center-section">
                    <h3 class="footer-title">Payment Method</h3>
                    <div class="footer-links">
                        <span class="payment-method-link">Cash</span>
                        <span class="payment-method-link">E-Wallet</span>
                        <span class="payment-method-link">Card</span>
                        <span class="payment-method-link">Cheque</span>
                    </div>
                </div>
                <div class="footer-section right-section">
                    <h3 class="footer-title">Permits</h3>
                    <div class="footer-links">
                        <span class="payment-method-link">Business Permit</span>
                        <span class="payment-method-link">DTI Permit</span>
                        <span class="payment-method-link">Barangay Permit</span>
                    </div>
                </div>
            </div>
            <div class="footer-bottom-links">
                <a href="#" class="footer-bottom-link">Terms and Condition</a>
                <a href="#" class="footer-bottom-link">Privacy Policy</a>
                <a href="#" class="footer-bottom-link">FAQ's</a>
            </div>
            <hr class="footer-line">
            <div class="footer-social-media">
                <p>&copy; 2024-2025 ARKILA. All Rights Reserved.</p>
                <a href="#" class="social-media-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-media-link"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-media-link"><i class="fab fa-google"></i></a>
                <a href="#" class="social-media-link"><i class="fab fa-instagram"></i></a>
            </div>
        </footer>
    </div>
    </section>
    </div>


    <script>




        // Logout confirmation
        document.getElementById('logout-link').addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default link action

            Swal.fire({
                title: 'Are you sure you want to logout?',
                text: "You will need to log in again to continue.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F07324',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('logout') }}';

                    var csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });



    </script>

</body>

</html>