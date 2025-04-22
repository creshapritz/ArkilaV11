@php
    $faqs = App\Models\Faq::all();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <title>Become a Partner</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/partner.css')); ?>">
    <script src="{{ asset('assets/js/landpage.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
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


        #chatbot-messages {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            font-family: 'sf pro display', sans-serif;
            font-size: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-height: 350px;
        }


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


    <section>
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
        <section class="partnership">
            <div class="partnership-content">
                <h1>Partnership</h1>

            </div>
        </section>

        <section class="partner-content">
            <h1>Partner with ARKILA</h1>
            <p>
                Interested in partnering with us? At ARKILA, we’re always looking to collaborate with businesses and
                individuals who share our commitment to quality and customer satisfaction. Connect with us to explore
                mutually beneficial opportunities and join us in delivering exceptional car rental services.</p>
        </section>

        <section class="partner-with-us">
            <div class="partner-with-us-content">
                <div class="image-container">
                    <img src="assets/img/partner2.jpg" alt="Why Partner with Us" class="partner-image">
                </div>
                <div class="text-container">
                    <h2>Why Partner with Us?</h2>
                    <p>
                        Choosing ARKILA as your partner means aligning with a trusted name in car rentals dedicated to
                        excellence and customer satisfaction. We offer a proven track record of reliable service, a
                        diverse fleet, and flexible solutions tailored to meet both client and partner needs. By
                        partnering with us, you gain access to a supportive team, expanded business opportunities, and a
                        shared commitment to delivering quality and convenience to customers.
                    </p>
                </div>
            </div>
        </section>



        <section class="become-partner">
            <div class="become-partner-content">
                <div class="text-container1">
                    <h2>Become a Partner?</h2>
                    <p>
                        We're always looking to expand with like-minded partners who share our vision for top-notch car
                        rental services. If you're passionate about delivering exceptional experiences and want to grow
                        together, let’s join forces. Partner with ARKILA and be part of a trusted name in the industry.
                        Are you ready to be the next one? Reach out to us today!
                    </p>
                    <div class="button-container">
                        <button class="partner-button"
                            onclick="window.open('{{ asset('documents/REQUIREMENTS_ARKILA.pdf') }}', '_blank')">Requirements</button>
                        <button class="partner-button"
                            onclick="window.open('{{ asset('documents/PARTNERPROPOSALFORM_ARKILA.pdf') }}', '_blank')">Send
                            Application</button>
                    </div>
                </div>
                <div class="image-container1">
                    <img src="assets/img/partner3.jpg" alt="Become a Partner" class="partner-image1">
                </div>
            </div>
        </section>















        <!---------------------------------------- FAQ SECTION ----------------------------------------------------------------------->
        <!----------------------------------------------------- PALAGAY PO NG FAQS -------------------------------------------------------->
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
                <a href="{{ asset('documents/terms.pdf') }}" target="_blank" class="footer-bottom-link">Terms
                    and
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


    </section>
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