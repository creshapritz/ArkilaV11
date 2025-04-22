@php
    $percentage = getSetting('downpayment_percentage', 50); // fallback to 50%
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <title>Payment</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="{{ asset('assets/js/landpage.js') }}"></script>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/welcome.css')); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.paymongo.com/v1/paymongo.js"></script>

    <style>
        .container {
            max-width: 960px;
            margin: 80px auto;
            padding: 30px;


            align-items: center;




        }

        h2 {
            color: #2e2e2e;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2.2em;
        }

        .content-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .box {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
        }

        .client-section h3,
        .price-section h2 {
            color: #555;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.6em;
        }

        .client-section p {
            line-height: 1.6;
            color: #666;
            margin-bottom: 10px;
        }

        .price-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            /* More vertical padding */
            border-bottom: 1px solid #eee;
            color: #444;
        }

        .price-item span:first-child {
            font-weight: 500;
            /* Slightly bolder labels */
        }

        .price-item strong {
            color: #F07324;
            /* Highlight important prices */
            font-size: 1.1em;
        }

        .btn-primary {
            display: inline-block;
            /* Adjust to content width */
            text-align: center;
            justify-content: center;
            margin-top: 40px;
            /* More top margin */
            padding: 12px 24px;
            /* More padding */
            background: #F07324;
            color: white;
            border: none;
            /* Remove default border */
            border-radius: 8px;
            /* More rounded */
            text-decoration: none;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
            /* Smooth hover effect */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background-color: #e06820;
            /* Darker shade on hover */
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            h2 {
                font-size: 1.8em;
                margin-bottom: 20px;
            }

            .content-wrapper {
                grid-template-columns: 1fr;
                /* Stack boxes on smaller screens */
                gap: 20px;
            }

            .box {
                padding: 20px;
            }

            .form-row {
                width: 100%;
                /* Make form rows full width on smaller screens */
                margin-bottom: 15px;
            }
        }
    </style>
</head>


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


    <!-- -------------------------------------------------------------------------------------------------- -->

    <div class="container">
        <h2>Review Payment</h2>

        <div class="content-wrapper">
            <!-- Client and Booking Info -->
            <div class="box client-section">
                <h3>Client Information</h3>
                <p><strong>Name:</strong> {{ $client->first_name }} {{ $client->last_name }}</p>
                <p><strong>Email:</strong> {{ $client->email }}</p>
                <p><strong>Contact:</strong> {{ $client->contact_number }}</p>

                <h3>Booking Details</h3>
                @if (session('booking'))
                            @php $booking = session('booking'); @endphp

                            <p><strong>Company:</strong> {{ $booking['company_name'] }}</p>
                            <p><strong>Car:</strong> {{ $booking['car_name'] }} ({{ $booking['car_type'] }})</p>
                            <p><strong>Pick-up Location:</strong> {{ $booking['pickup_location'] }}</p>
                            <p><strong>Pick-up Date:</strong>
                                {{ $booking['pickup_date'] ?? 'Not Set' }}
                                at
                                {{ isset($booking['pickup_time']) ? date('h:i A', strtotime($booking['pickup_time'])) : 'Not Set' }}
                            </p>
                            <p><strong>Drop-off Location:</strong> {{ $booking['dropoff_location'] }}</p>
                            <p><strong>Drop-off Date:</strong>
                                {{ $booking['dropoff_date'] ?? 'Not Set' }}
                                at
                                {{ isset($booking['dropoff_time']) ? date('h:i A', strtotime($booking['dropoff_time'])) : 'Not Set' }}
                            </p>
                            <p><strong>Driver Option:</strong> {{ $booking['driver_option'] ?? 'Not Set' }}</p>

                            @if(!empty($booking['driver_id']))
                                        @php
                                            $driver = \App\Models\Driver::find($booking['driver_id']);
                                        @endphp
                                        @if($driver)
                                            <div>
                                                <h4>Driver Details:</h4>

                                                <p><strong>Name:</strong> {{ $driver->name }}</p>
                                                <p><strong>Contact:</strong> {{ $driver->contact_number }}</p>
                                            </div>
                                        @endif
                            @endif

                @else
                    <p>No booking details found.</p>
                @endif


            </div>

            <!-- Price Breakdown -->
            <div class="box price-section">
                <h2>Price Breakdown</h2>

                @if (session('booking'))
                                @php
                                    $num_days = $booking['num_days'];
                                    $car_price_per_day = $booking['price_per_day'];
                                    $driver_fee_per_day = 500;

                                    // Driver fee calculation
                                    $driver_fee = ($booking['driver_option'] === 'With Driver') ? ($num_days * $driver_fee_per_day) : 0;

                                    // Total price before any discount
                                    $total_price = ($num_days * $car_price_per_day) + $driver_fee;

                                    // Discount amount (used as downpayment in your terms)
                                    $downpayment = $total_price * ($percentage / 100);

                                    // Final balance after discount
                                    $remaining_balance = $total_price - $downpayment;
                                @endphp

                                <div class="price-item"><span>Number of Days:</span> <span>{{ $num_days }} day(s)</span></div>
                                <div class="price-item"><span>Car Price Per Day:</span>
                                    <span>₱{{ number_format($car_price_per_day, 2) }}</span>
                                </div>
                                <div class="price-item"><span>Driver Fee (₱500/day):</span>
                                    <span>₱{{ number_format($driver_fee, 2) }}</span>
                                </div>
                               
                                <div class="price-item"><span>Pay Online ({{ $percentage }}% Downpayment):</span>
                                    <span>₱{{ number_format($downpayment, 2) }}</span>
                                </div>
                                <div class="price-item"><span>Remaining Balance:</span>
                                    <span>₱{{ number_format($remaining_balance, 2) }}</span>
                                </div>
                                <div class="price-item"><strong>Total Price:</strong>
                                    <strong>₱{{ number_format($total_price, 2) }}</strong>
                                </div>
                @else
                    <p>No payment details found.</p>
                @endif
            </div>
        </div>

        <a href="javascript:void(0);" onclick="confirmBeforePayment()" class="btn btn-primary">Confirm and Pay</a>
    </div>



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

    document.addEventListener("DOMContentLoaded", function () {
        let pickupDateInput = document.querySelector('input[name="pickup_date"]');
        let dropoffDateInput = document.querySelector('input[name="dropoff_date"]');
        let carPriceElem = document.getElementById("car-price");
        let driverFeeElem = document.getElementById("driver-fee");
        let totalPriceElem = document.getElementById("total-price");
        let payOnlineElem = document.getElementById("pay-online");
        let remainingBalanceElem = document.getElementById("remaining-balance");
        let numDaysElem = document.getElementById("num-days");
        let driverOptionButtons = document.querySelectorAll(".driver-option");

        let selectedDriverOption = "Self - Drive";
        let carPricePerDay = parseFloat(carPriceElem.innerText.replace(/,/g, "")) || 0;
        let driverFeePerDay = 500;

        function calculateTotal() {
            let pickupDate = new Date(pickupDateInput.value);
            let dropoffDate = new Date(dropoffDateInput.value);

            if (pickupDate.toString() !== "Invalid Date" && dropoffDate.toString() !== "Invalid Date" && dropoffDate > pickupDate) {
                let days = Math.ceil((dropoffDate - pickupDate) / (1000 * 60 * 60 * 24));
                numDaysElem.innerText = days;

                let totalCarPrice = carPricePerDay * days;
                let driverCharge = selectedDriverOption === "With Driver" ? driverFeePerDay * days : 0;
                driverFeeElem.innerText = driverCharge.toLocaleString();
                let subtotal = totalCarPrice + driverCharge;
                let payOnline = totalCarPrice * 0.50;
                let remainingBalance = totalCarPrice - payOnline;
                let totalAfterDownpayment = subtotal - payOnline;

                totalPriceElem.innerText = totalAfterDownpayment.toLocaleString();
                payOnlineElem.innerText = payOnline.toLocaleString();
                remainingBalanceElem.innerText = remainingBalance.toLocaleString();
            } else {
                numDaysElem.innerText = "0";
                totalPriceElem.innerText = "0";
                payOnlineElem.innerText = "0";
                remainingBalanceElem.innerText = "0";
                driverFeeElem.innerText = "0";
            }
        }

        pickupDateInput.addEventListener("input", calculateTotal);
        dropoffDateInput.addEventListener("input", calculateTotal);

        driverOptionButtons.forEach(button => {
            button.addEventListener("click", function () {
                selectedDriverOption = this.dataset.option;
                driverOptionButtons.forEach(btn => btn.classList.remove("selected"));
                this.classList.add("selected");
                calculateTotal();
            });
        });
    });

    function showContent(id) {
        document.querySelectorAll('.terms-text').forEach(el => el.classList.remove('active'));
        document.getElementById(id).classList.add('active');

        document.querySelectorAll('.terms-btn').forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');
    }
    // POPUP TERMS AND CONDITIONS
    function confirmBeforePayment() {
        Swal.fire({
            title: 'Before proceeding to payment',
            html: `
            <p>You must agree to the following terms:</p>
            <div style="text-align: left;">
                <input type="checkbox" id="agree1" name="terms" onclick="checkAgreements()">
                <label for="agree1">I agree to the terms and conditions.</label><br>

                <input type="checkbox" id="agree2" name="terms" onclick="checkAgreements()">
                <label for="agree2">I agree that I cannot change the car or dates once the payment is done.</label><br>

                <input type="checkbox" id="agree3" name="terms" onclick="checkAgreements()">
                <label for="agree3">I agree that cancellations will have an additional fee.</label>
            </div>
            <br>
            <div style="display: flex; justify-content: center; gap: 10px;">
                <button id="cancelBtn" class="swal2-cancel swal2-styled" onclick="Swal.close()">Cancel</button>
                <button id="proceedBtn" class="swal2-confirm swal2-styled custom-proceed-btn" disabled onclick="redirectToPayment()">Proceed to Payment</button>
            </div>
        `,
            showConfirmButton: false,
            didOpen: () => {
                document.getElementById('proceedBtn').disabled = true;
            }
        });


        setTimeout(() => {
            document.querySelector('.custom-proceed-btn').style.backgroundColor = '#F07324';
            document.querySelector('.custom-proceed-btn').style.color = 'white';
            document.querySelector('.custom-proceed-btn').style.padding = '10px 15px';
            document.querySelector('.custom-proceed-btn').style.borderRadius = '5px';
        }, 100);
    }

    function checkAgreements() {
        const checkboxes = document.querySelectorAll('input[name="terms"]:checked');
        const proceedBtn = document.getElementById('proceedBtn');

        proceedBtn.disabled = checkboxes.length !== 3;
    }

    function redirectToPayment() {
        window.location.href = "{{ route('payment.pay') }}";
    }









</script>

</>

</html>