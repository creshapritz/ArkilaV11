@php
    $client = Auth::guard('client')->user();
@endphp

@php
    $partnerId = $car->partner_id;
@endphp
@php
    $percentage = getSetting('downpayment_percentage', 50); // fallback to 50%
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <title>Bookings</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="{{ asset('assets/js/landpage.js') }}"></script>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/welcome.css')); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <style>
        body {
            position: relative;
        }

        body.swal2-shown {
            overflow: hidden !important;
            padding-right: 0 !important;
        }

        .swal2-popup-custom {
            margin: 0 auto !important;
            top: auto !important;
            transform: none !important;
        }



        .container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            width: 100%;
            padding-left: 10%;
            padding-top: 10%;
            flex: 1;
            padding-right: 20px;
        }

        .booking-container {
            width: 60%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);


        }

        .booking-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #eee;
            margin-bottom: 20px;
        }

        .car-info {
            text-align: left;
            flex-grow: 1;
            margin-right: 20px;

        }

        .car-name {
            font-size: 2.2rem;
            font-weight: 600;
            margin-top: 0;
            margin-bottom: 5px;
            color: #333;


        }

        .car-type {
            font-size: 1.4rem;
            font-weight: normal;
            color: #777;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .car-details {
            margin-bottom: 25px;

        }

        .car-features {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .feature {
            display: flex;
            align-items: center;
            border-radius: 6px;
            font-size: 0.9rem;
            padding: 5px 12px;
            background-color: #f9f9f9;
            border: 1px solid #eee;
            color: #555;
        }

        .feature i {
            font-size: 1.2rem;
            margin-right: 6px;
            color: #F07324;
        }


        .company-name {
            font-size: 1.1rem;
            font-weight: normal;
            margin-top: 15px;
            color: #555;
        }

        .car-image {
            width: 250px;
            height: 250px;
            object-fit: contain;
            border-radius: 8px;

        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group input[type="time"] {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }


        .btn-confirm {
            width: 100%;
            background: #F07324;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }


        .btn-confirm:hover {
            background-color: #d65a1f;
        }

        .reviews-underline {
            border: none;
            border-top: 2px solid #F07324;
            margin: 20px 0;
        }

        .review-card {
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #eee;
            border-radius: 6px;
            background-color: #fff;
        }

        .review-card strong {
            font-weight: bold;
            color: #555;
        }

        .review-card p {
            margin-top: 5px;
            margin-bottom: 5px;
            color: #666;
        }

        .review-card small {
            color: #999;
            display: block;
            margin-top: 8px;
        }

        .pickup-dropoff-form {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 10px 0;

        }

        .pickup-dropoff-form .form-group {
            width: calc(50% - 10px);

            margin: 10px 0;
        }


        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }


        .btn-confirm {
            width: 100%;
            background: #F07324;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 18px;

        }

        .btn-confirm:hover {
            background-color: #d65a1f;

        }

        @media (max-width: 768px) {


            .container {
                flex-direction: column;
                padding-top: 100px;
            }

            .price-container {
                display: block;
                width: 100%;
                margin-bottom: 20px;
                margin-top: 280%;
            }

            .container1 {
                width: 100%;
                margin-left: 0;

            }


            .booking-container {
                width: 100%;
            }

            .pickup-dropoff-form .form-group {
                width: 100%;
            }

            .car-image {
                width: 100%;
                height: auto;
                object-fit: contain;

            }

            .booking-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .terms-container {

                display: none;
            }

        }



        .container1 {
            display: flex;
            align-items: flex-start;
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            margin-bottom: 40px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 60%;
            margin-left: 154px;

        }


        .description-item {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .description-row {
            display: flex;
            align-items: center;


        }

        .description-row h3 {
            font-size: 1rem;
            margin: 0;
            width: 30%;
            font-weight: normal;
            margin-left: 20px;
            color: #555;

        }

        .description-row button {
            background: #F9F8F2;
            border-radius: 5px;
            border: #F07324 1px solid;
            color: #F07324;
            cursor: pointer;
            padding: 10px 15px;
            font-size: 14px;
            white-space: nowrap;
            height: 40px;

            align-items: center;
        }


        .button-group {
            display: flex;
            gap: 10px;
        }

        .button-group button {
            flex: 1 1 calc(50% - 10px);
            max-width: 80%;

        }


        .price-container {
            width: 350px;
            padding: 20px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            position: absolute;

            top: 20%;
            right: 20px;
            margin-left: auto;
        }

        .price-container h2 {
            font-size: 1.5rem;
            margin-top: 0;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }


        .price-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            font-size: 1rem;
            color: #555;
        }

        .price-item:last-child {
            border-bottom: none;

        }

        .price-item.total {
            font-size: 1.2rem;
            font-weight: bold;
            color: #F07324;
            border-top: 2px solid #F07324;
            padding-top: 15px;
            margin-top: 15px;
            border-bottom: none;

        }

        .price-item span:first-child {
            font-weight: 600;
        }

        .price-item span:last-child {
            color: #2e2e2e;
        }


        .service-option {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            margin-bottom: 25px;
        }

        .driver-option {
            flex-grow: 1;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: #f9f9f9;
            color: #555;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .driver-option.selected {
            background-color: #F07324;
            color: white;
            border-color: #F07324;
        }



        .terms-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            margin-bottom: 40px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 60%;
            margin-left: 154px;
        }

        .terms-container h3 {
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: bold;
        }

        .terms-content {
            display: flex;
            width: 100%;
        }

        .terms-sidebar {
            display: flex;
            flex-direction: column;
            width: 30%;
        }

        .terms-btn {
            background: #ff7f2a;
            height: 50px;
            color: white;
            border: none;
            padding: 10px;
            margin: 5px 0;
            text-align: left;
            font-size: 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .terms-btn:hover,
        .terms-btn.active {
            background: #f07324;
        }

        .terms-details {
            width: 70%;
            padding-left: 20px;
        }

        .terms-text {
            display: none;
        }

        .terms-text.active {
            display: block;
        }

        .terms-text h4 {
            margin-top: 10px;
        }

        .btn btn-success a {
            background-color: #F07324;
            text-decoration: none !important;

        }

        .text {
            font-size: 15px;
            display: ;
            padding-bottom: 10px;
            color: #555;
        }

        .driver-dropdown-section {
            margin-top: 1rem;
        }

        .driver-label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
            font-size: 16px;
        }

        .driver-select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        .driver-select:focus {
            border-color: #F07324;
            outline: none;
            background-color: #fff;
        }

        .fav-button {
            background-color: #f3f4f6;
            border: none;
            border-radius: 25px;
            padding: 8px 16px;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .fav-button:hover {
            background-color: rgb(230, 156, 110);
            transform: scale(1.05);
        }

        .fav-button:focus {
            outline: none;
        }


        #heart-icon {
            font-size: 1.25rem;
            transition: color 0.3s ease;
        }

        .fav-button.favorited #heart-icon {
            color: #e11d48;

        }

        .fav-button:not(.favorited) #heart-icon {
            color: #F07324;

        }



        .driver-preview {
            margin-top: 20px;
            text-align: center;
        }

        .driver-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .driver-name {
            font-weight: bold;
            font-size: 1.1rem;
        }

        .driver-contact {
            color: #6b7280;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .fav-button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-top: 20px;

        }


        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            10% {
                opacity: 1;
                transform: translateY(0);
            }

            90% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-10px);
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

        <!---------------------------------------------------- BOOKING CONTAINER------------------------------------------------------>

        <div class="container">
            <div class="booking-container">
                <div class="booking-card">
                    <div class="car-info">
                        <h3 class="car-name">{{ $car->name }}</h3>
                        <h4 class="car-type">{{ $car->type }}</h4>
                        <div class="car-details">
                            <div class="car-features">
                                <div class="feature">
                                    <i class='bx bx-user'></i>
                                    <p>{{ $car->seating_capacity }} Seater</p>
                                </div>
                                <div class="feature">
                                    <i class='bx bx-briefcase'></i>
                                    <p>{{ $car->num_bags }} Bags</p>
                                </div>
                                <div class="feature">
                                    <i class='bx bx-cog'></i>
                                    <p>{{ $car->transmission }}</p>
                                </div>
                                <div class="feature">
                                    <i class='bx bx-gas-pump'></i>
                                    <p>{{ $car->gas_type }}</p>
                                </div>
                            </div>
                        </div>


                        <p class="company-name">Service Provided by <strong>{{ $car->company_name }} </strong>Car Rental
                            Services.</p>
                    </div>

                    <img src="{{ asset($car->primary_image) }}" alt="{{ $car->name }}" class="car-image">
                </div>



                <hr class="reviews-underline">

                <h2>Pick-Up & Drop-Off</h2>
                <form action="{{ route('bookings.store') }}" method="POST" class="pickup-dropoff-form">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                    <div class="form-group">
                        <label for="pickup_location">Pick-Up Location:</label>
                        <input type="text" name="pickup_location" value="{{ $car->location }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="pickup_date">Pick-Up Date:</label>
                        <input type="date" name="pickup_date" value="{{ request('start_date') }}" required>

                    </div>
                    <div class="form-group">
                        <label for="pickup_time">Pick-Up Time:</label>
                        <input type="time" name="pickup_time" required>
                    </div>

                    <div class="form-group">
                        <label for="dropoff_location">Drop-off Location:</label>
                        <input type="text" name="dropoff_location" value="{{ $car->location }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="dropoff_date">Drop-Off Date:</label>
                        <input type="date" name="dropoff_date" value="{{ request('end_date') }}" required>

                    </div>
                    <div class="form-group">
                        <label for="dropoff_time">Drop-Off Time:</label>
                        <input type="time" name="dropoff_time" required>
                    </div>


                    <h3>Do you need a driver?</h3>
                    <p class="text">Please choose whether you'd prefer a <strong>Self-Drive</strong> option or <br>one
                        with a <strong>Driver</strong> and click the button to select your option.</p>

                    <div class="service-option">
                        <button type="button" class="driver-option selected"
                            data-option="Self-Drive">Self-Drive</button>
                        <button type="button" class="driver-option" data-option="With Driver">With Driver</button>
                    </div>

                    <input type="hidden" name="driver_option" id="driver-option-input">


                    <input type="hidden" name="driver_id" id="driver-id-input">

                    <div class="container1 driver-dropdown-section" style="display: none;">
                        <label for="driver_id" class="driver-label">Select a Driver</label>
                        <select name="driver_id" id="driver_id" class="driver-select">
                            <option value="">Choose your Driver</option>
                            @foreach ($drivers as $driver)
                                @continue($driver->status !== 'Active')

                                <option value="{{ $driver->id }}" data-name="{{ $driver->name }}"
                                    data-contact="{{ $driver->contact_number }}"
                                    data-picture="{{ asset($driver->profile_picture) }}"
                                    data-favorited="{{ $client->favoriteDrivers->contains($driver->id) ? 'true' : 'false' }}">
                                    {{ $driver->name }}
                                </option>
                            @endforeach

                        </select>


                        <!-- Driver Preview Section -->
                        <div id="driver-preview" class="driver-preview" style="display: none; text-align: center;">
                            <img id="driver-image" src="" alt="Driver Image" class="driver-image">
                            <p><strong>Name:</strong> <span id="driver-name" class="driver-name"></span></p>
                            <p><strong>Contact:</strong> <span id="driver-contact" class="driver-contact"></span></p>

                            <div class="fav-button-container">
                                <button type="button" onclick="toggleFavorite()" id="fav-button" class="fav-button">
                                    <i id="heart-icon" class="far fa-heart"></i> <span id="fav-text">Add to
                                        Favorites</span>
                                </button>

                            </div>
                        </div>



                    </div>



                    <input type="hidden" name="company_name" value="{{ $car->company_name }}">
                    <input type="hidden" name="car_name" value="{{ $car->name }}">
                    <input type="hidden" name="car_type" value="{{ $car->type }}">
                    <!-- Hidden fields for GPS coordinates -->
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">


                    <button type="submit" class="btn-confirm">Review Payment</button>
                </form>







            </div>
        </div>
        <!-- ---------------------------------Description--------------------------------- -->




        <!-- Right: Price Breakdown Container -->
        <div class="price-container">
            <h2>Price Breakdown</h2>

            <div class="price-item">
                <span>Number of Days:</span>
                <span><span id="num-days">0</span> day(s)</span>
            </div>

            <div class="price-item">
                <span>Car Price Per Day:</span>
                <span>₱<span id="car-price">{{ number_format($car->price_per_day, 2) }}</span></span>
            </div>

            <div class="price-item">
                <span>Pay Online ({{ $percentage }}% Downpayment):</span>
                <span>₱<span id="pay-online">0</span></span>
            </div>  

         

            <div class="price-item">
                <span>Driver Fee (₱500/day):</span>
                <span>₱<span id="driver-fee">0</span></span>
            </div>
            <div class="price-item">
                <span>Remaining Balance:</span>
                <span>₱<span id="remaining-balance">0</span></span>
            </div>

            <div class="price-item total">
                <span><strong>Total Price:</strong></span>
                <span><strong>₱<span id="total-price">0</span></strong></span>
            </div>
        </div>


        <div class="terms-container">
            <h3>Terms and Conditions</h3>
            <div class="terms-content">

                <div class="terms-sidebar">
                    <button class="terms-btn active" onclick="showContent('pickup')">Required documents for
                        pick-up</button>
                    <button class="terms-btn" onclick="showContent('age')">Driver’s age and driving age
                        requirements</button>
                    <button class="terms-btn" onclick="showContent('precautions')">Self-driving precautions</button>
                </div>

                <div class="terms-details">
                    <div id="pickup" class="terms-text active">
                        <h4><i class="fas fa-id-card"></i> ID Type</h4>
                        <p>A valid identity card</p>

                        <h4><i class="fas fa-address-card"></i> Driver’s License</h4>
                        <p>During pick-up, all drivers must provide their driver’s license for assurance and security
                            purposes. The license must match the main driver’s name and needs to be valid for at least
                            six months.</p>
                    </div>

                    <div id="age" class="terms-text">
                        <h4><i class="fas fa-user-clock"></i> Driver's Age Requirements</h4>
                        <p>Drivers must be at least 18 years old. Some vehicle categories may require the driver to be
                            25 or older.</p>
                    </div>

                    <div id="precautions" class="terms-text">
                        <h4><i class="fas fa-car"></i> Self-Driving Precautions</h4>
                        <p>Ensure you are familiar with local traffic laws and always drive responsibly.</p>
                    </div>
                </div>
            </div>
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
        const downpaymentPercentage = {{ $percentage }};
        let selectedDriverId = null;

        document.getElementById('driver_id').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];

            const name = selectedOption.getAttribute('data-name');
            const contact = selectedOption.getAttribute('data-contact');
            const picture = selectedOption.getAttribute('data-picture');
            const favorited = selectedOption.getAttribute('data-favorited') === 'true';
            selectedDriverId = selectedOption.value;


            document.getElementById('driver-name').textContent = name;
            document.getElementById('driver-contact').textContent = contact;
            document.getElementById('driver-image').src = picture;
            document.getElementById('driver-preview').style.display = 'block';

            const heartIcon = document.getElementById('heart-icon');
            const favButton = document.getElementById('fav-button');
            const favText = document.getElementById('fav-text');


            if (favorited) {
                heartIcon.classList = 'fas fa-heart text-red-500 text-2xl';
                favButton.classList.add('favorited');
                favText.textContent = 'Added to Favorites';
            } else {
                heartIcon.classList = 'far fa-heart text-gray-600 text-2xl';
                favButton.classList.remove('favorited');
                favText.textContent = 'Add to Favorites';
            }
        });



        function toggleFavorite() {
            if (!selectedDriverId) return;

            fetch(`/client/favorite-driver/toggle`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ driver_id: selectedDriverId }),
            })
                .then(res => res.json())
                .then(data => {
                    const heartIcon = document.getElementById('heart-icon');
                    const favButton = document.getElementById('fav-button');
                    const favText = document.getElementById('fav-text');
                    const favToast = document.getElementById('favorite-toast');
                    const favMsg = document.getElementById('favorite-message');

                    // Update UI based on the new favorite status
                    if (data.status === 'favorited') {
                        favButton.classList.add('favorited');
                        heartIcon.classList = 'fas fa-heart text-red-500';
                        favText.textContent = 'Added to Favorites';
                    } else {
                        favButton.classList.remove('favorited');
                        heartIcon.classList = 'far fa-heart text-gray-600';
                        favText.textContent = 'Add to Favorites';
                    }

                    // Update the driver option's attribute
                    const selectedOption = document.querySelector(`#driver_id option[value="${selectedDriverId}"]`);
                    if (selectedOption) {
                        selectedOption.setAttribute('data-favorited', data.status === 'favorited' ? 'true' : 'false');
                    }

                    // Show toast
                    favMsg.textContent = data.status === 'favorited' ? 'Added to favorites!' : 'Removed from favorites';
                    favToast.classList.add('show');

                    setTimeout(() => {
                        favToast.classList.remove('show');
                    }, 2500);
                });
        }




        ////////////end driver

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
                    let days = Math.ceil((dropoffDate - pickupDate) / (1000 * 60 * 60 * 24)) + 1;
                    numDaysElem.innerText = days;

                    let totalCarPrice = carPricePerDay * days;
                    let driverCharge = selectedDriverOption === "With Driver" ? driverFeePerDay * days : 0;

                    driverFeeElem.innerText = driverCharge.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

                    let subtotal = totalCarPrice + driverCharge;

                    // Apply discount based on percentage (this serves as "downpayment" in your term)
                    let downpayment = subtotal * (downpaymentPercentage / 100);

                    // Remaining balance after discount
                    let remainingBalance = subtotal - downpayment;

                    // Show original total price (before discount)
                    totalPriceElem.innerText = subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

                    // Show discount amount as "Pay Online"
                    payOnlineElem.innerText = downpayment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

                    // Show remaining balance
                    remainingBalanceElem.innerText = remainingBalance.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                } else {
                    numDaysElem.innerText = "0";
                    totalPriceElem.innerText = "0.00";
                    payOnlineElem.innerText = "0.00";
                    remainingBalanceElem.innerText = "0.00";
                    driverFeeElem.innerText = "0.00";
                }
            }


            driverOptionButtons.forEach(button => {
                button.classList.remove("selected");
            });

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



        document.querySelectorAll('.driver-option').forEach(button => {
            button.addEventListener('click', function () {
                let driverOption = this.getAttribute('data-option');
                document.getElementById('driver-option-input').value = driverOption;

                if (driverOption === 'With Driver') {
                    document.querySelector('.driver-dropdown-section').style.display = 'block';
                } else {
                    document.querySelector('.driver-dropdown-section').style.display = 'none';
                }
            });
        });

        document.getElementById('driver_id').addEventListener('change', function () {
            var driverId = this.value;
            document.getElementById('driver-id-input').value = driverId;
        });

        document.addEventListener("DOMContentLoaded", function () {

            let today = new Date().toISOString().split("T")[0];
            document.querySelector('input[name="pickup_date"]').setAttribute("min", today);
            document.querySelector('input[name="dropoff_date"]').setAttribute("min", today);


            function restrictTime(input) {
                input.addEventListener("input", function () {
                    let time = this.value;
                    if (time < "08:00" || time > "22:00") {
                        alert("Please select a time between 8:00 AM and 10:00 PM.");
                        this.value = "";
                    }
                });
            }

            restrictTime(document.querySelector('input[name="pickup_time"]'));
            restrictTime(document.querySelector('input[name="dropoff_time"]'));
        });

        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.driver-option');
            const container = document.querySelector('.container1');
            const hiddenInput = document.getElementById('driver-option-input');

            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    buttons.forEach(btn => btn.classList.remove('selected'));
                    button.classList.add('selected');
                    hiddenInput.value = button.dataset.option;

                    if (button.dataset.option === 'With Driver') {
                        container.style.display = 'block';
                    } else {
                        container.style.display = 'none';
                    }
                });
            });



            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {

                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;


                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;

                }, function (error) {

                    alert("Unable to retrieve your location. Please enable geolocation.");
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }




        });



        document.getElementById('booking-form').addEventListener('submit', function (e) {
            e.preventDefault();

            if (navigator.geolocation) {
                console.log("Geolocation is supported.");
                navigator.geolocation.getCurrentPosition(function (position) {
                    console.log("Latitude:", position.coords.latitude);
                    console.log("Longitude:", position.coords.longitude);
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    console.log("Latitude input value:", document.getElementById('latitude').value);
                    console.log("Longitude input value:", document.getElementById('longitude').value);


                    setTimeout(() => {
                        e.target.submit();
                    }, 300);
                }, function (error) {
                    console.error("Error getting location:", error);
                    alert("Please enable location to continue booking.");
                });
            } else {
                console.log("Geolocation is not supported by your browser.");
                alert("Geolocation is not supported by your browser.");
            }
        });








    </script>

</body>

</html>