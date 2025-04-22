<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <script src="{{ asset('assets/js/landpage.js') }}"></script>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/welcome.css')); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>My bookings</title>



    <style>
        body {
            font-family: 'Sf Pro display', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .my-bookings {
            margin-top: 100px;
            padding: 40px 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
            box-sizing: border-box;
            padding-left: 80px;
        }

        .container {
            padding-top: 60px;
            max-width: 1300px;
            margin: 0 auto;
            padding: 20px;

        }

      
        .booking-details {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            text-align: left;
            margin-bottom: 30px;
            color: #333;
            font-size: 2rem;
            font-weight: 600;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-radius: 6px;
            overflow: hidden;

        }

        .bookings-table th,
        .bookings-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .bookings-table th {
            background-color: #f8f9fa;
            color: #555;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .bookings-table tbody tr:last-child td {
            border-bottom: none;
        }

        .bookings-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .bookings-table tbody tr:hover {
            background-color: #f5f5f5;
            transition: background-color 0.2s ease-in-out;
        }

 


        .no-bookings {
            text-align: center;
            padding: 20px;
            font-size: 1rem;
            color: #777;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }




        @media (max-width: 768px) {
            .my-bookings {
                margin-left: 20px;
                height: 100%;

            }

            .booking-details {
                padding: 20px;
            }
            .section-title {
                font-size: 1.75rem;
                margin-bottom: 20px;
            }

            .bookings-table th,
            .bookings-table td {
                padding: 10px;
                font-size: 0.85rem;
            }

            .booking-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            



        }
    </style>


</head>

<body>
    <section>
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


        <!---------------------------------------------------- SIDEBAR------------------------------------------------------>
        <div class="sidebar">
            <a href="#menu" class="menu-link" id="menu-button">
                <i class='bx bx-menu' id="menu-icon"></i>
                <span class="menu-text">ARKILA</span>
            </a>
            <ul>
                <li><a href="{{ route('welcome') }}"><i class='bx bx-home'></i> <span>Home</span></a></li>

                <li><a href="{{ route('welcome_about') }}"><i class='bx bx-info-circle'></i> <span>About
                            Us</span></a></li>

                <li><a href="{{ route('welcome_vehicles') }}"><i class='bx bx-car'></i> <span>Vehicles</span></a>
                </li>

                <li><a href="{{ route('welcome_services') }}"><i class='bx bx-wrench'></i> <span>Services</span></a>
                </li>

                <li><a href="{{ route('welcome_rent') }}"><i class='bx bx-key'></i> <span>Rent</span></a></li>

                <li><a href="{{ route('welcome_contact') }}"><i class='bx bx-envelope'></i> <span>Contact
                            Us</span></a></li>

                <li><a href="{{ route('welcome_partner') }}"><i class='bx bx-user-plus'></i><span>Partnership</span></a>
                </li>

                <li><a href="{{ route('welcome_settings') }}"><i class='bx bx-cog'></i> <span>Settings</span></a>
                </li>

                <li><a href="javascript:void(0);" id="logout-link"><i class='bx bx-log-out'></i>
                        <span>Logout</span></a>
                </li>

            </ul>
        </div>


        <!-- ---------------------------------------------------- MAIN ------------------------------------------------------>





        <section class="my-bookings">
            <div class="container">
                <div class="booking-header">
                    <h2 class="section-title">Cancelled Bookings</h2>
                
                    </a>
                </div>

                @if($cancelledBookings->count() > 0)
                    <div class="table-responsive">
                        <table class="bookings-table">
                            <thead>
                                <tr>
                                    <th>Car</th>
                                    <th>Pickup Location</th>
                                    <th>Pickup Date</th>
                                    <th>Dropoff Date</th>
                                    <th>Amount Paid</th>
                                    <th>Cancelled At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cancelledBookings as $booking)
                                    <tr>
                                        <td>{{ $booking->car_name ?? 'N/A' }}</td>
                                        <td>{{ $booking->pickup_location }}</td>
                                        <td>{{ $booking->pickup_date }}</td>
                                        <td>{{ $booking->dropoff_date }}</td>
                                        <td>₱{{ number_format($booking->amount, 2) }}</td>
                                        <td>{{ $booking->updated_at->format('F j, Y g:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="no-bookings">No cancelled bookings found.</p>
                @endif
            </div>
        </section>


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


    </section>


    <script>



        document.getElementById('logout-link').addEventListener('click', function (e) {
            e.preventDefault(); // Prevent the default link action

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
                    // Submit the logout form using POST
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