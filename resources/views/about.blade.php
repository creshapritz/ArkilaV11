@php
    $faqs = App\Models\Faq::all();
@endphp
@php
    $aboutUs = \App\Models\Setting::where('key', 'about_us')->value('value');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <title>About Us</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/about.css')); ?>">
    <script src="{{ asset('assets/js/landpage.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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




    <div>
        <!-------------------------------------------------------- NAVBAR------------------------------------------------------------->
        <nav class="navbar">
            <div class="navbar-left">
                <img src="<?php echo e(asset('assets/img/whitelogoarkila.png')); ?>" alt="Logo" class="navbar-logo">
            </div>
            <div class="navbar-right">
                <button class="btn-partner desktop-only" onclick="window.location.href='{{ route('partner') }}'">Become
                    a
                    partner</button>
                <a href="{{ route('register') }}" class="btn-text desktop-only">Sign Up</a>
                <button class="btn-login desktop-only"
                    onclick="window.location.href='{{ route('login') }}'">Login</button>
            </div>
        </nav>
        <!---------------------------------------------------- SIDEBAR------------------------------------------------------>
        <div class="sidebar">
            <a href="#menu" class="menu-link" id="menu-button">
                <i class='bx bx-menu' id="menu-icon"></i>
                <span class="menu-text">ARKILA</span>
            </a>
            <ul>
                <li><a href="{{ route('landingpage') }}"><i class='bx bx-home'></i> <span>Home</span></a></li>
                <li><a href="{{ route('about') }}"><i class='bx bx-info-circle'></i> <span>About Us</span></a></li>
                <li><a href="{{ route('vehicles') }}"><i class='bx bx-car'></i> <span>Vehicles</span></a></li>
                <li><a href="{{ route('services') }}"><i class='bx bx-wrench'></i> <span>Services</span></a></li>
                <li><a href="{{ route('rent') }}"><i class='bx bx-key'></i> <span>Rent</span></a></li>
                <li><a href="{{ route('contact') }}"><i class='bx bx-envelope'></i> <span>Contact Us</span></a></li>
                <li><a href="{{ route('partner') }}" class="mobile-only-link"><i class='bx bx-user-plus'></i>
                        <span>Partnership</span></a></li>
                <li><a href="{{ route('register') }}" class="mobile-only-link"><i class='bx bx-user'></i> <span>Sign
                            Up</span></a></li>
                <li><a href="{{ route('login') }}" class="mobile-only-link"><i class='bx bx-log-in'></i>
                        <span>Login</span></a></li>
            </ul>
        </div>
        <!----------------------------------------ABOUT US ----------------------------------------------------------------------->
        <!----------------------------------------ABOUT US ----------------------------------------------------------------------->
        <section class="aboutus">
            <div class="aboutus-content">
                <h1>About Us</h1>

            </div>
        </section>
        <!---------------------------------------- IMAGE 1 ----------------------------------------------------------------------->
        <section class="about-square">
            <div class="square">
                <img src="{{ asset('assets/img/auimg2.jpg') }}" alt="Square Image">

                {{-- This will render the rich HTML content from the admin settings --}}
                {!! $aboutUs !!}
            </div>
        </section>
        <!---------------------------------------- COMPLETE BOOKINGS ----------------------------------------------------------------------->

        <div class="center-box">
            <div class="left">
                <h2>200+</h2>
                <p>Positive Reviews
                </p>
            </div>
            <div class="center">
                <h2>2,500+</h2>
                <p>Completed Bookings</p>
            </div>
            <div class="right">
                <h2>250+</h2>
                <p>Rented Cars</p>
            </div>
        </div>

        <!---------------------------------------- OUR SERVICES ----------------------------------------------------------------------->

        <div class="our-services">
            <h1>Our Services</h1>
            <h2>We work for your comfort</h2>
            <p>At ARKILA, we’re dedicated to providing a seamless and enjoyable car rental experience.
                Whether you're traveling for business, planning a family vacation, or need a vehicle for a special
                event,
                our services are designhed to meet your unique needs with flexibility, convenience, and affordability.
            </p>
        </div>


        <!-- Add the service boxes -->
        <div class="service-boxes">
            <div class="service-box">
                <h3>Personal Cars</h3>
                <p>We offer a wide range of options for you to choose from. From a van rental to a small Toyota Wigo.
                </p>
            </div>
            <div class="service-box">
                <h3>Affordable Prices</h3>
                <p>Quality car rentals at rates that fit your budget, with no hidden costs—just great value and
                    exceptional
                    service.</p>
            </div>
            <div class="service-box">
                <h3>Wide Selection of Vehicles</h3>
                <p>From compact cars for city driving to luxury SUVs for special occasions, we offer a wide variety of
                    vehicles to suit your style and budget.</p>
            </div>
            <div class="service-box">
                <h3>Convenient Pickup & Drop-off</h3>
                <p>Satisfaction by providing flexibility, accessibility, and smooth transitions for users throughout
                    their
                    rental journey.</p>
            </div>
            <div class="service-box">
                <h3>Self-Drive Option</h3>
                <p>Users can rent a car and drive it themselves, giving them full control over their journey.</p>
            </div>
            <div class="service-box">
                <h3>Real-Time Vehicle Tracking</h3>
                <p>Provide users with real-time vehicle tracking for safety and convenience, allowing users or the admin
                    to
                    track the location.</p>
            </div>
        </div>
        <!---------------------------------------- FAQ SECTION ----------------------------------------------------------------------->
        <div class="faq-box">
            <div
                class="relative w-full bg-white px-6 pt-10 pb-8 mt-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-2xl sm:rounded-lg sm:px-10">
                <div class="mx-auto px-5">
                    <div class="faqs-header">
                        <h2 class="freq">ABOUT US</h2>
                        <p class="ffreq">Frequently Asked Questions</p>
                    </div>
                    <div class="mx-auto mt-8 grid max-w-xl divide-y divide-neutral-200">
                        @foreach($faqs as $faq)
                        <div class="py-5">
                            <details class="group">
                                <summary class="flex cursor-pointer list-none items-center justify-between font-medium">
                                    <span>{{ $faq->question }}</span>
                                    <span class="transition group-open:rotate-180">
                                        <svg fill="none" height="24" shape-rendering="geometricPrecision"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                            <path d="M6 9l6 6 6-6"></path>
                                        </svg>
                                    </span>
                                </summary>
                                <p class="group-open:animate-fadeIn mt-3 text-neutral-600">{{ $faq->answer }}</p>
                            </details>
                        </div>
                        @endforeach
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
                <a href="{{ asset('documents/terms.pdf') }}" target="_blank" class="footer-bottom-link">Terms and
                    Condition</a>
                <a href="{{ asset('documents/terms.pdf') }}" target="_blank" class="footer-bottom-link">Privacy
                    Policy</a>
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
    </div>

    <script>

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

    </script>
</body>

</html>