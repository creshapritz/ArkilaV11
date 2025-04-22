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
    <script src="{{ asset('assets/js/landpage.js') }}"></script>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/welcome.css')); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Favorite Drivers</title>
    
    <style>
      
        .max-w-4xl {
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            padding-top: 10rem;
            padding-bottom: 2rem;
            padding-left: 1rem;
            padding-right: 1rem;

        }

        .text-2xl {
            font-size: 1.5rem;
        }

        .font-bold {
            font-weight: bold;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .text-gray-500 {
            color: #718096;
        }

        .grid {
            display: grid;
        }

        .md\:grid-cols-2 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .gap-4 {
            gap: 1rem;
        }

        .bg-white {
            background-color: #fff;
        }

        .rounded-xl {
            border-radius: 0.75rem;
        }

        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .p-4 {
            padding: 1rem;
        }

        .flex {
            display: flex;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .space-x-4 {
            margin-left: 1rem;
            margin-right: 1rem;
        }

        .space-x-4> :not(:first-child) {
            margin-left: 1rem;
        }

        .w-16 {
            width: 4rem;
        }

        .h-16 {
            height: 4rem;
        }

        .object-cover {
            object-fit: cover;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .text-lg {
            font-size: 1.125rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-sm {
            font-size: 0.875rem;
        }


        .max-w-4xl h2 {
            color: #374151;
            border-bottom: 2px solid #e0e6ed;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .grid .bg-white {
            border: 1px solid #f3f4f6;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .grid .bg-white:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.10);
        }

        .grid .bg-white img {
            border: 2px solid #f9fafb;
        }

        .grid .bg-white h3 {
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .grid .bg-white p {
            color: #4b5563;
        }

        img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }


        .driver-button {
            font-weight: 500;
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s ease-in-out, transform 0.1s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .driver-button:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.5);
        }

        .driver-button-remove {
            background-color: #dc2626;
            color: #f8f9fa;
        }

        .driver-button-remove:hover {
            background-color: #b91c1c;
            transform: scale(1.02);
            color: #f8f9fa;
        }

        .driver-button-rate {
            background-color: #F07324;
            color: #f8f9fa;
            padding: 0.5rem 1rem;
        }

        .driver-button-rate:hover {
            background-color: #d65f1e;
            transform: scale(1.02);
        }

        .driver-button-view {
            background-color: rgb(58, 118, 214);
            color: #f8f9fa;
            padding: 0.5rem 1rem;
        }

        .driver-button-view:hover {
            background-color: rgb(32, 67, 143);
            color: #f8f9fa;
            transform: scale(1.02);
        }

        .driver-buttons-container {
            display: flex;
            flex-direction: row;
            gap: 0.5rem;
            align-items: center;
        }

        .driver-buttons-container.justify-end {
            justify-content: flex-end;
        }

        .driver-buttons-container form {
            display: inline-block;

        }

        .custom-confirm-btn {
            background-color: #F07324 !important;
            color: white !important;
            font-weight: bold;
            padding: 0.5rem 1.25rem;
            border-radius: 3px;
        }

        .custom-cancel-btn {
            background-color: #d1d5db !important;
            color: #111827 !important;
            font-weight: bold;
            padding: 0.5rem 1.25rem;
            border-radius: 3px;
            margin-left: 0.5rem;
        }

        @media (max-width: 767px) {
            .grid.md\:grid-cols-2 {
                grid-template-columns: 1fr !important;
            }

            .flex.items-center.space-x-4 {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .driver-buttons-container {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
            }

            .driver-buttons-container form,
            .driver-buttons-container button {
                width: 100%;
            }

            .driver-button {
                padding: 0.5rem;
                font-size: 0.875rem;
            }
        }

        @media (max-width: 480px) {
            .flex.items-center.space-x-4 {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .flex.items-center.space-x-4 img {
                margin-bottom: 0.5rem;
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
        <div class="max-w-4xl mx-auto py-8">
            @php
                $firstName = explode(' ', auth('client')->user()->first_name)[0];
            @endphp

            <h2 class="text-2xl font-bold mb-4 text-center">{{ $firstName }}'s Favorite Drivers</h2>

            @if($favoriteDrivers->isEmpty())
                <div class="text-gray-500 text-center">You haven't favorited any drivers yet.</div>
            @else
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($favoriteDrivers as $driver)
                        <div class="bg-white rounded-xl shadow p-4 flex flex-col gap-4">
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $driver->picture) }}" alt="{{ $driver->name }}"
                                    class="w-16 h-16 object-cover rounded-full">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ $driver->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $driver->contact }}</p>
                                </div>
                            </div>

                            <div class="driver-buttons-container @if($favoriteDrivers->count() === 1) justify-end @endif">
                                <form method="POST" action="{{ route('client.favorites.remove', $driver->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="driver-button driver-button-remove">
                                        Remove
                                    </button>
                                </form>

                                <button onclick="openRatingModal({{ $driver->id }}, '{{ $driver->name }}')"
                                    class="driver-button driver-button-rate">
                                    Rate Driver
                                </button>
                                <button onclick="showRatings({{ $driver->id }}, '{{ $driver->name }}')"
                                    class="driver-button driver-button-view">
                                    View Ratings
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
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


    </section>


    <script>

        function openRatingModal(driverId, driverName) {
            Swal.fire({
                title: `Rate ${driverName}`,
                html: `
            <div id="star-rating" style="display: flex; justify-content: center; align-items: center; margin-bottom: 1rem;">
                ${[1, 2, 3, 4, 5].map(i =>
                    `<i class="fa-regular fa-star" data-rating="${i}" style="font-size: 28px; color: #d1d5db; cursor: pointer; margin: 0 4px;"></i>`
                ).join('')}
            </div>
            <textarea id="comment" class="swal2-textarea" placeholder="Leave a comment..." 
                style="width: 80%; height: 100px; max-height: 100px; resize: none;"></textarea>
        `,
                showCancelButton: true,
                confirmButtonText: 'Submit Rating',
                customClass: {
                    confirmButton: 'custom-confirm-btn',
                    cancelButton: 'custom-cancel-btn'
                }


            }).then((result) => {
                if (result.isConfirmed) {
                    const rating = document.querySelectorAll('.fa-star.checked').length;
                    const comment = document.getElementById('comment').value;

                    if (!rating) {
                        Swal.showValidationMessage('Please select a star rating');
                        return false;
                    }

                    fetch("{{ route('client.rate.driver.submit') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ driver_id: driverId, rating, comment })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thank you!',
                                    text: 'Your rating has been submitted.',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Hold on!',
                                    text: data.message,
                                    confirmButtonColor: '#F07324',
                                });
                            }
                        })
                        .catch(() => {
                            Swal.fire('Oops!', 'Could not connect to the server.', 'error');
                        });

                }
            });

            setTimeout(() => {
                document.querySelectorAll('#star-rating i').forEach(star => {
                    star.addEventListener('click', function () {
                        const rating = this.getAttribute('data-rating');
                        document.querySelectorAll('#star-rating i').forEach(s => {
                            s.classList.remove('fa-solid', 'checked');
                            s.classList.add('fa-regular');
                            s.style.color = '#d1d5db'; // Gray
                        });
                        for (let i = 0; i < rating; i++) {
                            const starEl = document.querySelectorAll('#star-rating i')[i];
                            starEl.classList.remove('fa-regular');
                            starEl.classList.add('fa-solid', 'checked');
                            starEl.style.color = '#facc15'; // Yellow
                        }
                    });
                });
            }, 100);
        }



        function showRatings(driverId, driverName) {
            fetch(`/client/driver/${driverId}/ratings`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        Swal.fire({
                            text: `${driverName} has no ratings yet.`,

                            confirmButtonColor: '#F07324'
                        });

                        return;
                    }


                    const ratingHtml = data.map(rating => {
                        const stars = '★'.repeat(rating.rating) + '☆'.repeat(5 - rating.rating);
                        return `
        <div style="margin-bottom: 1rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 0.5rem;">
            <div style="color: #facc15; font-size: 1.2rem; font-weight: 600;">${stars}</div>
            <div style="font-style: italic; color: #374151; margin-top: 4px;">${rating.comment || 'No comment'}</div>
            ${rating.client ? `<div style="font-size: 0.75rem; color: #6b7280; margin-top: 2px;">By: ${rating.client.firstname || 'Anonymous'}</div>` : ''}
        </div>
    `;
                    }).join('');

                    Swal.fire({
                        title: `Ratings for ${driverName}`,
                        html: `
        <div style="
            max-height: 300px; 
            overflow-y: auto; 
            padding: 1rem; 
            text-align: center;
        ">
            ${ratingHtml}
        </div>
    `,
                        width: 600,
                        showConfirmButton: true,
                        confirmButtonColor: '#F07324',
                    });

                })
                .catch(() => {
                    Swal.fire('Oops!', 'Could not fetch ratings.', 'error');
                });
        }


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