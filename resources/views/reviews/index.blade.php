<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/welcome_about.css')); ?>">
    <script src="{{ asset('assets/js/landpage.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        .reviews-container {
            max-width: 900px;
            margin: 100px auto 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .reviews-title {
            text-align: center;
            font-size: 40px;
            margin-bottom: 20px;
            color: #333;
        }

        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
        }

        .review-card {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        .reviewer-name {
            font-weight: bold;
            color: #444;
        }

        .car-brand,
        .car-type {
            font-weight: bold;
            color: #F07324;
        }

        .rating {
            color: #ffb400;
        }

        .review-text {
            margin: 10px 0;
            font-size: 14px;
            color: #555;
        }

        .review-date {
            font-size: 12px;
            color: #888;
        }


        .no-reviews {
            text-align: center;
            font-size: 16px;
            color: #777;
        }

      

        .custom-pagination {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .custom-pagination .page-link,
        .custom-pagination .active,
        .custom-pagination .disabled {
            padding: 8px 12px;
            border: 1px solid #ccc;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
        }

        .custom-pagination .active {
            background-color: #333;
            color: #fff;
            font-weight: bold;
        }

        .custom-pagination .disabled {
            color: #aaa;
            pointer-events: none;
        }
    </style>
</head>

<body>
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
            <!-- Check if the user is logged in -->
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


    <!----------------------------------------------------- CONTENT -------------------------------------------------------->

    <div class="reviews-container">
        <h2 class="reviews-title">All Reviews</h2>

        @if($reviews->count() > 0)
            <div class="reviews-grid">
                @foreach($reviews as $review)
                    <div class="review-card">
                        <p class="reviewer-name">
                            <strong>{{ $review->client->first_name ?? 'Anonymous' }}</strong> reviewed
                            <span class="car-brand">{{ $review->car->brand ?? 'Unknown Car' }}</span>
                            <span class="car-type">{{ $review->car->type ?? 'Unknown Car' }}</span>
                            - <span class="rating">⭐ {{ $review->rating }}</span>
                        </p>
                        <p class="review-text">{{ $review->review }}</p>
                        <small class="review-date">Reviewed on {{ $review->created_at->format('F d, Y') }}</small>
                    </div>
                @endforeach
            </div>


            <div class="custom-pagination">
                @if ($reviews->onFirstPage())
                    <span class="disabled">Previous</span>
                @else
                    <a href="{{ $reviews->previousPageUrl() }}" class="page-link">Previous</a>
                @endif

                @foreach ($reviews->getUrlRange(1, $reviews->lastPage()) as $page => $url)
                    @if ($page == $reviews->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($reviews->hasMorePages())
                    <a href="{{ $reviews->nextPageUrl() }}" class="page-link">Next</a>
                @else
                    <span class="disabled">Next</span>
                @endif
            </div>

        @else
            <p class="no-reviews">No reviews yet. Be the first to leave a review!</p>
        @endif
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
    </script>


</body>

</html>