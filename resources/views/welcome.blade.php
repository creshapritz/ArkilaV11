@php
    use App\Models\Car;
    use App\Models\Review;
    use Illuminate\Support\Facades\DB;

    $cars = Car::all();
    $partners = DB::table('partners')->get();
    $reviews = Review::with('client')->orderBy('created_at', 'desc')->get(); 

@endphp



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <title>{{ strtoupper($companyName) }}</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/welcome.css')); ?>">
    <script src="{{ asset('assets/js/landpage.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <style>
        /* Chatbot Button */
        #chatbot-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(236, 233, 233, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        #chatbot-btn:hover {
            transform: scale(1.1);
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
        }

        #chatbot-btn img {
            width: 80%;
            height: 80%;
            border-radius: 50%;
        }

        /* Chatbot Container */
        #chatbot-container {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 350px;
            height: 500px;
            /* Set a fixed height for the chatbot */
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
            border: 1px solid #ddd;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
            visibility: hidden;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.8);
        }

        /* Chatbot Container active state */
        #chatbot-container.active {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }

        /* Chatbot Header */
        #chatbot-header {
            background: #F07324;
            color: white;
            padding: 15px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            border-radius: 12px 12px 0 0;
            font-family: 'sf pro display', sans-serif;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #bot-profile {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        #chatbot-header .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        /* Chatbot Messages */
        #chatbot-messages {
            flex: 1;
            /* Allow the messages to take up all available space */
            overflow-y: auto;
            /* Enable scrolling for message area */
            padding: 15px;
            font-family: 'sf pro display', sans-serif;
            font-size: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-height: 350px;
            /* Limit height of the message area */
        }

        /* User and Bot Messages */
        .message {
            max-width: 80%;
            padding: 10px 14px;
            border-radius: 18px;
            font-size: 14px;
            word-wrap: break-word;
        }

        .user-message {
            align-self: flex-end;
            background: #F07324;
            color: white;
            border-radius: 18px 18px 0 18px;
        }

        .bot-message {
            align-self: flex-start;
            background: #F1F1F1;
            color: black;
            border-radius: 18px 18px 18px 0;
        }

        /* Chatbot Input */
        #chatbot-input {
            display: flex;
            border-top: 1px solid #ddd;
            padding: 10px;
            background: #ffffff;
        }

        #chatbot-input input {
            flex: 1;
            padding: 12px;
            border: none;
            outline: none;
            border-radius: 8px;
            font-family: 'sf pro display', sans-serif;
            font-size: 14px;
            background: #F5F5F5;
        }

        #chatbot-input button {
            background: #F07324;
            color: white;
            border: none;
            padding: 12px 14px;
            cursor: pointer;
            font-family: 'sf pro display', sans-serif;
            font-size: 14px;
            border-radius: 8px;
            margin-left: 8px;
            transition: background 0.3s ease;
        }

        #chatbot-input button:hover {
            background: #E0611D;
        }

        .btn-confirm {

            color: #F07324;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'sf pro display', sans-serif;
            font-size: 18px;
            text-decoration: none;

        }

        .btn-confirm:hover {
            color: #2e2e2e;
        }

        #quick-replies {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 15px;
            max-height: 100px;
            overflow-x: none !important;
            overflow-y: auto;
            padding-bottom: 10px;
        }

        .quick-reply {
            background: #F07324;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 20px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            font-family: 'sf pro display', sans-serif;
            text-align: center;
        }

        .quick-reply:hover {
            background: #E0611D;
            transform: scale(1.05);
        }

        .quick-reply:focus {
            outline: none;
        }

        .quick-reply:active {
            background: #D15716;
        }
    </style>

</head>


<body>

    <button id="chatbot-btn">
        <img src="{{ asset('assets/img/arkilot1.gif') }}" alt="Chatbot Logo" id="chatbot-logo">
    </button>

    <div id="chatbot-container">

        <div id="chatbot-header">
            <img src="{{ asset('assets/img/arkilothead.gif') }}" alt="Bot Profile" id="bot-profile">
            ARKILA Support Agent
        </div>
        <div id="chatbot-messages"></div>
        <div id="quick-replies"></div>

    </div>

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif


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
                    {{ Auth::user()->username }}
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

        <!---------------------------------------- VIDEO1 ----------------------------------------------------------------------->
        <section class="home">
        <video autoplay muted loop id="background-video">
                <source src="{{ asset($videoPath) }}" type="video/mp4">
            </video>
            <div class="video-overlay"></div>
            <div class="home-content">
                <h1>Welcome to <span>ARKILA</span></h1>
            </div>
        </section>

        <!---------------------------------------------------------- IMG1 ------------------------------------------------------->
        <div class="content">
        <img src="{{ asset($bannerPath) }}" alt="Advertisement" class="advertisement">
        </div>

        <!--------------------------------------------------- AVAILABLE CAR BRANDS ----------------------------------------------->
        <section class="available-cars">
            <h2>Available Car Brands</h2>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><img src="<?php echo e(value: asset(path: 'assets/img/brand1.png'))?>"
                            alt="Brand 1" class="brand-img"></div>
                    <div class="swiper-slide"><img src="<?php echo e(value: asset(path: 'assets/img/brand2.png'))?>"
                            alt="Brand 2" class="brand-img"></div>
                    <div class="swiper-slide"><img src="<?php echo e(value: asset(path: 'assets/img/brand3.png'))?>"
                            alt="Brand 3" class="brand-img"></div>
                    <div class="swiper-slide"><img src="<?php echo e(value: asset(path: 'assets/img/brand4.png'))?>"
                            alt="Brand 4" class="brand-img"></div>
                    <div class="swiper-slide"><img src="<?php echo e(value: asset(path: 'assets/img/brand5.png'))?>"
                            alt="Brand 5" class="brand-img"></div>
                    <div class="swiper-slide"><img src="<?php echo e(value: asset(path: 'assets/img/brand6.png'))?>"
                            alt="Brand 6" class="brand-img"></div>
                    <div class="swiper-slide"><img src="<?php echo e(value: asset(path: 'assets/img/brand7.png'))?>"
                            alt="Brand 7" class="brand-img"></div>
                </div>
            </div>
        </section>


        <!-------------------------------------------------- OUR PARTNERS --------------------------------------------------------->
        <section class="our-partners">
            <h2>Our Partners</h2>
            <div class="partners">
                @foreach($partners as $partner)
                @if($partner->status === 'Active')
                <div class="partner-box">
                    <img src="{{ asset($partner->company_logo) }}" alt="Partner Logo">
                </div>
                @endif
                @endforeach
            </div>
        </section>



        <!------------------------------------------------------- WHY CHOOSE US? ----------------------------------------->

        <section class="reviews-section">
            <h2>WHY CHOOSE US?</h2>
            <h3>Top-Rated Service</h3>


            <div class="reviews-container">
                <div class="arrow-container">
                    <div class="arrow left-arrow"><i class="bx bx-chevron-left"></i></div>
                </div>
                <div class="reviews-wrapper">

                    @forelse ($reviews as $review)
                    <div class="review-box">
                        <strong>{{ $review->client->first_name ?? 'Anonymous' }}</strong>
                        <p>{{ $review->review }}</p>
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++) <i
                                class="bx {{ $i <= $review->rating ? 'bxs-star' : 'bx-star' }}"></i>
                                @endfor
                        </div>
                    </div>
                    @empty
                    <p>No reviews yet. Be the first to leave one!</p>
                    @endforelse
                </div>
                <div class="arrow-container">
                    <div class="arrow right-arrow"><i class="bx bx-chevron-right"></i></div>
                </div>
            </div>

            <div class="buttons-container">

                <a href="{{ route('reviews.index') }}" class="btn-confirm">View All Reviews</a>
            </div>
        </section>





        <!------------------------------------------------ HOW TO BOOK ----------------------------------------------------->

        <section class="booking-section">
            <h1>HOW TO BOOK YOUR CAR RENTAL?</h1>
            <h2>Easy Process</h2>
            <p>Booking your car rental with us is quick and hassle-free! Simply choose from our wide selection of
                cars—whether you prefer a self-drive option for full freedom or
                a with-driver service for a more relaxed experience. Once you've picked your car, just select your
                pick-up
                and return dates, and confirm your reservation. Payment can be made after booking, ensuring a secure and
                easy transaction. When your booking is
                complete, simply pick up your car on the scheduled date and enjoy a smooth, stress-free ride.
            </p>
            <div class="steps-container">
                <div class="step-box">
                    <i class='bx bx-car'></i>

                    <h3>Choose a Car</h3>
                    <p><a href="{{ route('welcome_vehicles') }}" class="reserve-link">Reserve Now!</a>
                    </p>
                </div>

                <div class="step-box center-box">
                    <i class='bx bx-calendar'></i>
                    <h3>Book a date</h3>
                    <p><a href="{{ route('welcome_vehicles') }}" class="reserve-link">Reserve Now!</a>
                    </p>
                </div>

                <div class="step-box">
                    <i class='bx bx-phone-call'></i>

                    <h3>Let Us Know!</h3>
                    <p><a href="{{ route('welcome_vehicles') }}" class="reserve-link">Reserve Now!</a>
                    </p>
                </div>
            </div>
        </section>


        <!----------------------------------------------------- WANNA RENT A CAR ------------------------------------------------>
        <section class="wanna">
            <div class="content-wanna">
                <h3>WANNA RENT A CAR A ROUND RIZAL?</h3>
                <h1>Trust ARKILA <br>for Your Journey</h1>
                <p>Whether you're exploring the scenic routes of Rizal or heading to a special event,
                    ARKILA has you covered with exceptional service and trusted staff.
                    Here’s why ARKILA is the go-to choice for car rentals around Rizal:</p>

                <div class="lorem-container">
                    <div class="timeline-item">
                        <p>Friendly Staff</p>
                        <hr class="lorem-line">
                    </div>
                    <div class="timeline-item">
                        <p>Timely Query Responses</p>
                        <hr class="lorem-line">
                    </div>
                    <div class="timeline-item">
                        <p>Reliable Service</p>
                        <hr class="lorem-line">
                    </div>
                    <div class="timeline-item">
                        <p>Top-Notch Driver</p>
                        <hr class="lorem-line">
                    </div>
                </div>

            </div>

            <div class="boxes-wanna">
                <div class="box-wanna1">
                    <img src="<?php echo e(asset('assets/img/imgwanna.png')); ?>" alt="Image1">
                </div>

                <div class="box-wanna2"></div>
                <div class="box-wanna3"></div>

                <div class="box-wanna4">
                    <img src="<?php echo e(asset('assets/img/imgwanna1.png')); ?>" alt="Image2">
                </div>

                <div class="box-wanna5">
                    <img src="<?php echo e(asset('assets/img/imgwanna2.png')); ?>" alt="Image3">
                </div>
                <div class="box-wanna6"></div>
                <div class="box-wanna7"></div>
                <div class="box-wanna8">
                    <img src="<?php echo e(asset('assets/img/imgwanna3.png')); ?>" alt="Image4">
                </div>
            </div>


        </section>

        <!----------------------------------------------------- CHEAP CAR -------------------------------------------------------->
        <section class="cheap-car">
            <h2>Cheap Car Rental Deals in Rizal</h2>
            <div class="info-box">
                <i class="bx bx-error-circle warning-icon"></i>
                <p>Discover the best prices and deals for you by selecting your travel dates.
                    <span class="hover-bold">Choose your dates.</span>
                </p>
            </div>

            <div class="car-deals-wrapper">
                <div class="car-deals-container">
                    <div class="car-deals">
                        @foreach ($cars as $car)
                            @if (!$car->archived && $car->status != 'maintenance')

                                <div class="car-box">
                                    <img src="{{ asset($car->primary_image) }}" alt="Car Primary Image" class="car-image">


                                    <div class="logo-line">
                                        <img src="{{ asset($car->company_logo) }}" alt="Partner Logo" class="partner-logo">
                                        <hr class="logo-line-separator">
                                    </div>
                                    <h3 class="car-title">{{ $car->brand }} {{ $car->name }}</h3>
                                    <p class="car-description">{{ $car->type }} - {{ $car->location }}</p>
                                    <div class="car-details">
                                        <div class="detail-item">
                                            <i class="bx bx-user detail-icon"></i>
                                            <span class="detail-text">{{ $car->seating_capacity }} adult passengers</span>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bx bx-briefcase detail-icon"></i>
                                            <span class="detail-text">{{ $car->num_bags }} suitcase(s)</span>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bx bx-gas-pump detail-icon"></i>
                                            <span class="detail-text">{{ $car->gas_type }} fuel</span>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bx bx-cog detail-icon"></i>
                                            <span class="detail-text">{{ $car->transmission }}</span>
                                        </div>
                                    </div>
                                    <button class="car-button"
                                        onclick="window.location.href='{{ route('car.viewDeal', ['car' => $car->id]) }}'">
                                        View Deal
                                    </button>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
                <div class="nav-buttons">
                    <button class="arrow left-arrow" onclick="scrollDeals(-1)">&#10094;</button>
                    <button class="arrow right-arrow" onclick="scrollDeals(1)">&#10095;</button>
                </div>
            </div>
        </section>
        <!----------------------------------------------------- VIDEO 2 -------------------------------------------------------->
        <section class="video2">
            <div class="video2">
            <video src="{{ asset($footervideoPath) }}" autoplay loop muted></video>
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
        const gpsUpdateRoute = "{{ route('gps.update') }}";
        const clientId = @json(auth('client')->check() ? auth('client')->user()->id : null);
        const carId = {!! isset($activeBooking) && $activeBooking ? $activeBooking->car_id : 'null' !!};

        if (carId) {
            trackClient();
        }

        function sendLocationToServer(lat, lng) {
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



        // chatbot
        document.addEventListener('DOMContentLoaded', function () {
            const chatbotBtn = document.getElementById('chatbot-btn');
            const chatbotContainer = document.getElementById('chatbot-container');
            const chatMessages = document.getElementById('chatbot-messages');
            const chatInput = document.getElementById('chatbot-text');
            const sendButton = document.getElementById('chatbot-send');
            const quickRepliesContainer = document.getElementById('quick-replies');
            chatbotBtn.addEventListener('click', function () {
                chatbotContainer.classList.toggle('active');
                if (chatbotContainer.classList.contains('active')) {
                    loadQuickReplies();
                }
            });

            function addMessage(sender, message, color, alignment) {
                let time = new Date().toLocaleTimeString();
                let messageHtml = `
            <div style="display: flex; flex-direction: column; align-items: ${alignment}; margin-bottom: 10px;">
                <div style="max-width: 70%; padding: 10px; border-radius: 10px; background-color: ${color}; color: white;">
                    <strong>${sender}:</strong> ${message}
                </div>
                <span style="font-size: 12px; color: gray; margin-top: 5px;">${time}</span>
            </div>
        `;
                chatMessages.innerHTML += messageHtml;
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }


            function createQuickReplies(options) {
                quickRepliesContainer.innerHTML = '';
                options.forEach(option => {
                    const button = document.createElement('button');
                    button.classList.add('quick-reply');
                    button.textContent = option.text;
                    button.addEventListener('click', function () {
                        sendMessage(option.value);
                    });
                    quickRepliesContainer.appendChild(button);
                });
            }


            function loadQuickReplies() {
                const initialReplies = [
                    { text: "How can i rent a car", value: "how to rent a car?" },
                    { text: "What are the available cars?", value: "What are the available cars?" },

                ];
                createQuickReplies(initialReplies);
            }

            function sendMessage(message) {
                let userMessage = message.trim().toLowerCase();

                if (userMessage === "") return;

                addMessage("You", userMessage, "#2e2e2e", "flex-end");

                fetch('/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message: userMessage })
                })
                    .then(response => response.json())
                    .then(data => {
                        let botMessage = data.reply ? data.reply : "No response received";
                        addMessage("ARKILA", botMessage, "#F07324", "flex-start");


                        if (data.quickReplies) {
                            createQuickReplies(data.quickReplies);
                        } else {
                            quickRepliesContainer.innerHTML = '';
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        addMessage("ARKILA", "Error: Unable to process request.", "#dc3545", "flex-start");
                    });
            }

            sendButton.addEventListener('click', function () {
                sendMessage(chatInput.value);
                chatInput.value = '';
            });

            chatInput.addEventListener('keypress', function (event) {
                if (event.key === 'Enter') {
                    sendMessage(chatInput.value);

                    chatInput.value = '';
                }
            });





        });
        // Close button functionality

        //////// chatbot

        function scrollDeals(direction) {
            var container = document.querySelector('.car-deals-container');

            // Calculate the scroll amount based on the width of a car deal box
            var carBoxWidth = document.querySelector('.car-box').offsetWidth;
            var scrollAmount = direction * (carBoxWidth + 20); // The 20 is for margin between items

            // Scroll the container horizontally
            container.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }



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