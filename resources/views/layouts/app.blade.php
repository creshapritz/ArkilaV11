<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <title>Rent</title>
    <link rel="stylesheet" href="{{ asset('assets/css/searchcars.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="{{ asset('assets/js/landpage.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-calendar {
            background: #f9f9f9;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-family: 'Sf Pro display';

        }

        .flatpickr-month {
            background: #333;
            color: white;
            padding: 0.5em;
        }

        .flatpickr-prev-icon,
        .flatpickr-next-icon {
            fill: white;
        }


        .flatpickr-weekday {
            color: #666;
            font-weight: bold;
            border-color: #F07324;
        }


        .flatpickr-day {
            border: 1px solid transparent;
            color: #333;
            background-color: #F07324;
        }

        .flatpickr-day.today {
            background: #F07324;
            border-color: #F07324;
        }


        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange,
        .flatpickr-day.selected:hover,
        .flatpickr-day.startRange:hover,
        .flatpickr-day.endRange:hover {
            background: #F07324;
            color: white;
            border-color: #F07324;
        }

        .flatpickr-day:hover {
            background: #d0d0d0;
            border-color: #F07324;
        }
    </style>
</head>

<body>
    <header>
        <section>

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

                    <li><a href="{{ route('welcome_partner') }}"><i class='bx bx-user-plus'></i>
                            <span>Partnership</span></a>
                    </li>

                    <li><a href="{{ route('welcome_settings') }}"><i class='bx bx-cog'></i> <span>Settings</span></a>
                    </li>

                    <li><a href="javascript:void(0);" id="logout-link"><i class='bx bx-log-out'></i>
                            <span>Logout</span></a></li>

                </ul>
            </div>
        </section>
    </header>


    <main>

        <div class="search-cars-container">
            <div class="booking-form-container">
                <div class="booking-form">
                    <form action="{{ route('cars.search') }}" method="GET">
                        @csrf
                        <div class="input-group">
                            <label for="destination">Destination</label>
                            <input type="text" name="destination" id="destination" placeholder="Enter place" required
                                value="{{ request('destination') }}">
                        </div>
                        <div class="input-group">
                            <label for="start_date">Start Date</label>
                            <input type="text" id="start_date" name="start_date" placeholder="Start Date"
                                value="{{ request('start_date') }}" required>
                        </div>
                        <div class="input-group">
                            <label for="end_date">End Date</label>
                            <input type="text" id="end_date" name="end_date" placeholder="End Date"
                                value="{{ request('end_date') }}" required>
                        </div>

                        <button type="submit" class="btn-search">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <section class="filter-section">
            <form method="GET" action="{{ route('cars.search') }}">

                <!-- Car Type -->
                <select name="type">
                    <option value="">Car Type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>

                <!-- Capacity -->
                <select name="capacity">
                    <option value="">Capacity</option>
                    @foreach ($capacities as $capacity)
                        <option value="{{ $capacity }}" {{ request('capacity') == $capacity ? 'selected' : '' }}>
                            {{ $capacity }}-Seater
                        </option>
                    @endforeach
                </select>

                <!-- Transmission -->
                <select name="transmission">
                    <option value="">Transmission</option>
                    @foreach ($transmissions as $transmission)
                        <option value="{{ $transmission }}" {{ request('transmission') == $transmission ? 'selected' : '' }}>
                            {{ $transmission }}
                        </option>
                    @endforeach
                </select>

                <select name="price_range">
                    <option value="">Price Range</option>
                    <option value="4000-5000" {{ request('price_range') == '4000-5000' ? 'selected' : '' }}>₱4,000 -
                        ₱5,000</option>
                    <option value="6000-8000" {{ request('price_range') == '6000-8000' ? 'selected' : '' }}>₱6,000 -
                        ₱8,000</option>
                    <option value="10000-15000" {{ request('price_range') == '3000-5000' ? 'selected' : '' }}>₱10,000 -
                        ₱15,000</option>
                  
                </select>




                <!--              
                 <select name="location">
                    <option value="">Location</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                            {{ $location }}
                        </option>
                    @endforeach
                </select>  -->

                <button type="submit" id="filterButton" class="btn-filter">Apply Filters</button>
            </form>
        </section>






        @if(isset($cars))
            <div class="search-results">
                <h2>Available Cars</h2>
                @if($cars->isEmpty())
                    <p class="no-cars-message">No cars available for the selected criteria.</p>
                @else
                    <div class="car-list">
                        @foreach($cars as $car)
                                <div class="car-card">

                                <div class="car-left">
    <img src="{{ asset($car->primary_image) }}" alt="{{ $car->name }}" class="car-image">
    <div class="logo-wrapper">
        <img src="{{ asset($car->company_logo) }}" alt="Logo" class="partner-logo">
    </div>
</div>


                                    <div class="car-center">
                                        <h3>{{ $car->name }}</h3>


                                        <div class="car-info">
                                            <div class="info-item">
                                                <i class="bx bx-car"></i>
                                                <span>{{ $car->seating_capacity }} Seats</span>
                                            </div>
                                            <div class="info-item">
                                                <i class='bx bx-shopping-bag'></i>
                                                <span>{{ $car->num_bags }} Bags</span>
                                            </div>
                                            <div class="info-item">
                                                <i class="bx bx-gas-pump"></i>
                                                <span>{{ $car->gas_type }}</span>
                                            </div>
                                            <div class="info-item">
                                                <i class='bx bx-cog'></i>
                                                <span>{{ $car->transmission }}</span>
                                            </div>
                                        </div>




                                        <p class="location"> <i class='bx bx-map'></i> {{ $car->location }}</p>


                                        <ul class="features">
                                            <li><i class="bx bx-check-circle"></i> Free cancellation (1hr)</li>
                                            <li><i class="bx bx-check-circle"></i> Fuel policy: same-to-same</li>
                                            <li><i class="bx bx-check-circle"></i> Unlimited mileage included</li>
                                            <li><i class="bx bx-check-circle"></i> Theft protection waiver</li>
                                            <li><i class="bx bx-check-circle"></i> Third-party coverage</li>
                                            <li><i class="bx bx-check-circle"></i> Collision damage waiver</li>
                                        </ul>
                                    </div>


                                    <div class="car-right">
                                        <p class="price">₱{{ number_format($car->price_per_day, 2) }}</p>
                                        <a href="{{ route('booking.form', [
                                'id' => $car->id,
                                'start_date' => request('start_date'), // passing start date
                                'end_date' => request('end_date') // passing end date
                            ]) }}">
                                            <button class="btn-book">Select</button>
                                        </a>
                                    </div>

                                </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

    </main>




    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


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
            <p>&copy;{{ date('Y') }} ARKILA. All Rights Reserved.</p>
            <a href="#" class="social-media-link"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-media-link"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-media-link"><i class="fab fa-google"></i></a>
            <a href="#" class="social-media-link"><i class="fab fa-instagram"></i></a>
        </div>
    </footer>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const startInput = document.getElementById('start_date');
            const endInput = document.getElementById('end_date');

            flatpickr(startInput, {
                mode: "range",
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: function (selectedDates) {
                    if (selectedDates.length === 2) {
                        const [start, end] = selectedDates;
                        startInput.value = flatpickr.formatDate(start, "Y-m-d");
                        endInput.value = flatpickr.formatDate(end, "Y-m-d");
                    }
                },
                onOpen: function () {
                    // Sync values if they exist
                    if (startInput.value && endInput.value) {
                        this.setDate([startInput.value, endInput.value], true);
                    }
                }
            });

            // Open the calendar when user clicks end date input too
            endInput.addEventListener('focus', () => {
                startInput._flatpickr.open();
            });
        });

        document.getElementById('filterButton').addEventListener('click', function () {
            var form = document.querySelector('.filter-section');
            form.submit();
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

        document.addEventListener('DOMContentLoaded', function () {
            const today = new Date().toISOString().split('T')[0];

            document.getElementById('start_date').setAttribute('min', today);
            document.getElementById('end_date').setAttribute('min', today);
        });

    </script>


</body>


</html>