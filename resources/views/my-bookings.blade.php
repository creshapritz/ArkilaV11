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
        .usage-status-in-use {
            color: green;
            font-weight: bold;
        }

        .usage-status-completed {
            color: #888;
            text-decoration: line-through;
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

        .alert {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            background-color: #e9ecef;
            color: #383d41;
            border: 1px solid #ced4da;
            box-sizing: border-box;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #1a5e41;
            border-color: #a7f3d0;
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
            color: #2e2e2e;
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

        .usage-status {
            font-weight: bold;
            padding: 6px 10px;
            margin: 0;
            width: auto !important;
            text-align: center;
            border-radius: 4px;
            font-size: 0.85rem;
            color: #2e2e2e;
            display: inline-block;
            white-space: nowrap;
            min-width: 80px;
        }

        .usage-status-not-yet-started {
            background-color: rgba(255, 193, 7, 0.77);
        }

        .usage-status-in-use {
            background-color: rgba(40, 167, 70, 0.9);

        }

        .usage-status-completed {
            background-color: rgba(14, 105, 185, 0.84);

        }

        .cancel-paid-btn {
            background-color: #dc3545;
            color: #f8f9fa;
            padding: 6px 10px;
            min-width: 80px;
            border-radius: 5px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cancel-booking-btn:hover {
            background-color: #b02a37;
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

        .favorite-drivers-btn {
            background: #F07324;
            color: #f8f9fa;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);

        }

        .favorite-drivers-btn:hover {
            background: linear-gradient(to right, #e35b0d, #f59e0b);
        }

        .favorite-drivers-btn i {
            margin-right: 8px;
        }


        .favorite-drivers-btn i {
            margin-right: 0.5rem;
        }

        .booking-buttons {
            display: flex;
            gap: 10px;
        }

        .cancelled-bookings-btn {
            background: #dc3545;
            color: #fff;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .cancel-free-btn {
            background: rgb(63, 239, 136);
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .cancelled-bookings-btn:hover {
            background: #b02a37;
        }

        .review-booking-btn {
            background: #ccc;
            color: #2e2e2e;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .swal2-popup .fa-star:hover {
            transform: scale(1.2);
            transition: transform 0.2s;
        }






        @media (max-width: 768px) {
            .my-bookings {
                margin-left: 20px;
                height: 100%;

            }

            .cancel-booking-btn,
            .review-booking-btn {
                max-width: 80%;
                padding: 10px;

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

            .favorite-drivers-btn {
                padding: 8px 14px;
                font-size: 0.9rem;
                gap: 6px;
            }

            .booking-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .usage-status-not-yet-started {
                background-color: #ffc107;
                color: #000;
                padding: 6px 10px;
                border-radius: 4px;
                font-weight: 600;
                font-size: 0.85rem;
                white-space: nowrap;
                display: inline-block;
                min-width: 100px;
                text-align: center;
            }

            .swal-star-rating {
                font-size: 24px;
                color: #ccc;
                cursor: pointer;
                margin-bottom: 10px;
            }

            .swal-star-rating .star:hover,
            .swal-star-rating .star:hover~.star {
                color: #FFD700;
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
                    {{ Auth::user()->username }}
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
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(isset($bookings) && $bookings->count() > 0)
                        <div class="booking-details">
                            <div class="booking-header">
                                <h2 class="section-title">My Bookings</h2>
                                <div class="booking-buttons">
                                    <a href="{{ route('client.favorites') }}" class="favorite-drivers-btn">
                                        <i class="fas fa-star"></i> Favorite Drivers
                                    </a>
                                    <a href="{{ route('client.cancelled.bookings') }}" class="cancelled-bookings-btn">
                                        <i class="fas fa-times-circle"></i> Cancelled Bookings
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="bookings-table">
                                    <thead>
                                        <tr>
                                            <th>Car</th>
                                            <th>Pickup Location</th>
                                            <th>Pickup Date</th>
                                            <th>Pickup Time</th>
                                            <th>Dropoff Date</th>
                                            <th>Dropoff Time</th>
                                            <th>Amount Paid (₱)</th>
                                            <th>Payment Status</th>

                                            <th>Usage Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bookings as $booking)
                                                                @if($booking->status != 'cancelled')
                                                                                        <tr>
                                                                                            <td>{{ $booking->car_name ?? 'N/A' }}</td>
                                                                                            <td>{{ $booking->pickup_location }}</td>
                                                                                            <td>{{ $booking->pickup_date }}</td>
                                                                                            <td>{{ date('h:i A', strtotime($booking->pickup_time)) }}</td>
                                                                                            <td>{{ $booking->dropoff_date }}</td>
                                                                                            <td>{{ date('h:i A', strtotime($booking->dropoff_time)) }}</td>
                                                                                            <td>{{ number_format($booking->amount, 2) }}</td>
                                                                                            <td>{{ ucfirst($booking->status) }}</td>

                                                                                            <td>
                                                                                                @php
                                                                                                    $alreadyReviewed = \App\Models\Review::where('booking_id', $booking->id)->exists();
                                                                                                    $pickup = \Carbon\Carbon::parse($booking->pickup_date . ' ' . $booking->pickup_time);
                                                                                                    $dropoff = \Carbon\Carbon::parse($booking->dropoff_date . ' ' . $booking->dropoff_time);
                                                                                                    $now = \Carbon\Carbon::now();

                                                                                             
                                                                                                    $usageStatus = $booking->usage_status;

                                                                                                    if (!$usageStatus) {
                                                                                                        if ($now->lt($pickup)) {
                                                                                                            $usageStatus = 'Not Yet Started';
                                                                                                        } elseif ($now->between($pickup, $dropoff)) {
                                                                                                            $usageStatus = 'In Use';
                                                                                                        } else {
                                                                                                            $usageStatus = 'Completed';
                                                                                                        }
                                                                                                    }

                                                                                                    $createdAt = \Carbon\Carbon::parse($booking->created_at);
                                                                                                    $canCancel = $now->diffInHours($createdAt) <= 60;
                                                                                                @endphp

                                                                                                <span
                                                                                                    class="usage-status usage-status-{{ strtolower(str_replace(' ', '-', $usageStatus)) }}">
                                                                                                    {{ $usageStatus }}
                                                                                                </span>
                                                                                            </td>

                                                                                            <td>
                                                                                                @php
                                                                                                    $createdAt = \Carbon\Carbon::parse($booking->created_at);
                                                                                                    $now = \Carbon\Carbon::now();
                                                                                                    $minutesSinceBooking = $now->diffInMinutes($createdAt);
                                                                                                    $hoursSinceBooking = $now->diffInHours($createdAt);

                                                                                                    $canFreeCancel = $minutesSinceBooking <= 60;
                                                                                                    $canPaidCancel = $minutesSinceBooking > 60 && $hoursSinceBooking <= 24;
                                                                                                @endphp


                                                                                                @if($usageStatus !== 'Completed' && $usageStatus !== 'In Use' && $booking->status !== 'cancelled')
                                                                                                    @if($canFreeCancel)
                                                                                                        <button class="cancel-free-btn" data-booking-id="{{ $booking->id }}">
                                                                                                            Cancel (Free)
                                                                                                        </button>
                                                                                                    @elseif($canPaidCancel)
                                                                                                        <button class="cancel-paid-btn" data-booking-id="{{ $booking->id }}"
                                                                                                            data-amount="1500">
                                                                                                            Cancel Booking
                                                                                                        </button>
                                                                                                    @else
                                                                                                        <span style="color: gray;">Cancellation not allowed</span>
                                                                                                    @endif
                                                                                                @elseif($usageStatus === 'In Use')
                                                                                                    <span style="color: gray;">Cancellation Disabled</span>
                                                                                                @endif


                                                                                                @if($usageStatus === 'Completed' && !$alreadyReviewed)
                                                                                                    <button class="review-booking-btn" data-booking-id="{{ $booking->id }}">
                                                                                                        Leave Review
                                                                                                    </button>
                                                                                                @elseif($usageStatus === 'Completed' && $alreadyReviewed)
                                                                                                    <span style="color: gray;" class="reviewed-label">Review Submitted</span>
                                                                                                @endif


                                                                                            </td>
                                                                                        </tr>
                                                                @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                @else
                    <p class="no-bookings">No booking found.</p>
                @endif
            </div>
        </section>







        @php
            $bookings = \App\Models\Booking::where('client_id', auth()->id())->get();

            $activeBooking = $bookings->filter(function ($booking) {
                $pickup = \Carbon\Carbon::parse($booking->pickup_date . ' ' . $booking->pickup_time);
                $dropoff = \Carbon\Carbon::parse($booking->dropoff_date . ' ' . $booking->dropoff_time);
                return now()->between($pickup, $dropoff);
            })->first();
        @endphp





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
        const gpsUpdateRoute = "{{ route('gps.update') }}";
        const clientId = {{ auth()->user()->id }};
        const carId = {!! $activeBooking ? $activeBooking->car_id : 'null' !!};
        let lastSentLat = null;
        let lastSentLng = null;

        if (carId) {
            trackClient();
        }

        function sendLocationToServer(lat, lng) {
            if (lat === lastSentLat && lng === lastSentLng) return;

            lastSentLat = lat;
            lastSentLng = lng;

            fetch(gpsUpdateRoute, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    latitude: lat,
                    longitude: lng,
                    client_id: clientId,
                    car_id: carId
                })
            })
                .then(res => res.json())
                .then(data => console.log("Location sent:", data))
                .catch(err => console.error("Error sending GPS:", err));
        }
        function trackClient() {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        sendLocationToServer(lat, lng);
                    },
                    (err) => console.warn("Location error", err),
                    {
                        enableHighAccuracy: true,
                        maximumAge: 0,
                        timeout: 10000
                    }
                );
            } else {
                alert("Geolocation not supported by this browser.");
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const freeCancelButtons = document.querySelectorAll('.cancel-free-btn');
            freeCancelButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const bookingId = this.getAttribute('data-booking-id');

                    Swal.fire({
                        title: 'Free Cancellation',
                        html: `
                    <p>You are entitled to a full refund. No cancellation fee will apply.</p>
                    <div style="margin-top: 10px; text-align: left;">
                        <input type="checkbox" id="termsCheck">
                        <label for="termsCheck"> I agree to the <a href="/terms" target="_blank">terms & cancellation policy</a>.</label>
                    </div>
                `,
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Confirm Cancellation',
                        preConfirm: () => {
                            const termsAccepted = document.getElementById('termsCheck').checked;
                            if (!termsAccepted) {
                                Swal.showValidationMessage('You must agree to the terms & cancellation policy.');
                            }
                            return termsAccepted;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Cancelling Booking...',
                                text: 'Please wait...',
                                icon: 'info',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });


                            window.location.href = `/cancel-free-booking/${bookingId}`;
                        }
                    });
                });
            });

            const paidCancelButtons = document.querySelectorAll('.cancel-paid-btn');
            paidCancelButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const bookingId = this.getAttribute('data-booking-id');

                    Swal.fire({
                        title: 'Paid Cancellation',
                        html: `
                <p>This cancellation will cost ₱1500.</p>
                <div style="margin-top: 10px; text-align: left;">
                    <input type="checkbox" id="termsCheckPaid">
                    <label for="termsCheckPaid"> I agree to the <a href="/terms" target="_blank">terms & cancellation policy</a>.</label>
                </div>
            `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Proceed to Payment',
                        preConfirm: () => {
                            const termsAccepted = document.getElementById('termsCheckPaid').checked;
                            if (!termsAccepted) {
                                Swal.showValidationMessage('You must agree to the terms & cancellation policy.');
                            }
                            return termsAccepted;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Redirecting to Payment...',
                                text: 'Please wait...',
                                icon: 'info',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Redirect to initiate payment
                            window.location.href = `/cancel-paid-booking/${bookingId}`;
                        }
                    });
                });
            });

        });

        // document.addEventListener('DOMContentLoaded', function () {
        //     const cancelButtons = document.querySelectorAll('.cancel-booking-btn');

        //     cancelButtons.forEach(button => {
        //         button.addEventListener('click', function () {
        //             const bookingId = this.getAttribute('data-booking-id');
        //             const amount = this.getAttribute('data-amount');

        //             Swal.fire({
        //                 title: 'Are you sure?',
        //                 text: 'A ₱1500 cancellation fee will be charged.',
        //                 icon: 'warning',
        //                 showCancelButton: true,
        //                 confirmButtonColor: ' #F07324',
        //                 cancelButtonColor: '#d33',
        //                 confirmButtonText: 'Yes, cancel it!'
        //             }).then((result) => {
        //                 if (result.isConfirmed) {

        //                     Swal.fire({
        //                         title: 'Confirm Agreement',
        //                         html: `
        //                     <p>You must agree to our Terms & Conditions</a> and the contract before proceeding.</p>
        //                     <input type="checkbox" id="agreeCheckbox">
        //                     <label for="agreeCheckbox"> I agree to the terms and conditions and the contract.</label>
        //                 `,
        //                         icon: 'info',

        //                         showCancelButton: true,
        //                         confirmButtonText: 'Proceed to Payment',
        //                         confirmButtonColor: ' #F07324',
        //                         cancelButtonColor: '#d33',
        //                         cancelButtonText: 'Cancel',
        //                         preConfirm: () => {
        //                             const checkbox = Swal.getPopup().querySelector('#agreeCheckbox');
        //                             if (!checkbox.checked) {
        //                                 Swal.showValidationMessage('You must agree before proceeding.');
        //                                 return false;
        //                             }
        //                         }
        //                     }).then((secondResult) => {
        //                         if (secondResult.isConfirmed) {
        //                             window.location.href = `/cancel-booking/pay/${bookingId}`;
        //                         }
        //                     });
        //                 }
        //             });
        //         });
        //     });
        // });

        document.addEventListener('DOMContentLoaded', function () {
            const reviewButtons = document.querySelectorAll('.review-booking-btn');

            reviewButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const bookingId = this.getAttribute('data-booking-id');

                    Swal.fire({
                        title: 'Leave a Review',
                        html: `
                    <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 1rem;" id="star-rating">
                        ${[1, 2, 3, 4, 5].map(i => `
                            <i class="fa-star fa-regular star" data-value="${i}" 
                               style="font-size: 28px; color: #FFD700; cursor: pointer; margin: 0 4px;"></i>
                        `).join('')}
                    </div>
                    <textarea id="reviewText" class="swal2-textarea" placeholder="Write your review here..." 
                        style="width: 80%; height: 100px; max-height: 100px; resize: none;"></textarea>
                    <input type="hidden" id="reviewRating">
                `,
                        showCancelButton: true,
                        confirmButtonText: 'Submit Review',
                        confirmButtonColor: '#F07324',
                        cancelButtonColor: '#d33',
                        preConfirm: () => {
                            const review = Swal.getPopup().querySelector('#reviewText').value;
                            const rating = Swal.getPopup().querySelector('#reviewRating').value;

                            if (!review || !rating) {
                                Swal.showValidationMessage('Please provide both a rating and a review.');
                                return false;
                            }

                            return { review, rating };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/submit-review`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    booking_id: bookingId,
                                    review: result.value.review,
                                    rating: result.value.rating
                                })
                            })
                                .then(res => res.json())
                                .then(data => {
                                    Swal.fire('Thank you!', 'Your review has been submitted.', 'success');
                                })
                                .catch(() => {
                                    Swal.fire('Oops!', 'Something went wrong.', 'error');
                                });
                        }
                    });

                    setTimeout(() => {
                        const stars = Swal.getPopup().querySelectorAll('.star');
                        const ratingInput = Swal.getPopup().querySelector('#reviewRating');

                        stars.forEach(star => {
                            star.addEventListener('click', function () {
                                const rating = this.getAttribute('data-value');
                                ratingInput.value = rating;

                                stars.forEach(s => {
                                    if (s.getAttribute('data-value') <= rating) {
                                        s.classList.remove('fa-regular');
                                        s.classList.add('fa-solid');
                                    } else {
                                        s.classList.remove('fa-solid');
                                        s.classList.add('fa-regular');
                                    }
                                });
                            });
                        });
                    }, 100);
                });
            });
        });



        document.getElementById('logout-link').addEventListener('click', function (e) {
            e.preventDefault();

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