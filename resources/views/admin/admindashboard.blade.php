@php
    use App\Models\Client;
    use App\Models\Partner;
    use App\Models\Driver;
    use App\Models\Setting;

    $totalClients = Client::count();
    $totalDrivers = Driver::count();
    $totalPartners = Partner::count();
@endphp


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-eCaLCkoAAyyk5EdvWywaN2X5j3xJP1nkKYcQRGMnVcA=" crossorigin="" />



    <title>Super Admin Dashboard</title>

    <style>
        body {
            font-family: 'SF Pro Display';
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .clients-ov {
            position: relative;
            top: -220px;
            margin-top: -40px !important;
            padding-top: 0 !important;
            margin-left: 30px;
        }

        .bookings-ov {
            position: relative;
            top: -220px !important;
            padding-top: 0 !important;
            margin-left: 30px;
        }


        .header-container {
            padding: 5px !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;

        }


        .clients {
            width: 97%;
            margin-top: 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        .sidebar h1 {
            font-size: 30px;
            color: #F07324;

        }


        .clienttbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }


        table th {
            background-color: #f1f1f1;
            color: white;
            padding: 15px;
            text-align: center;
            color: #2e2e2e;
        }


        table td {
            color: #333;
            font-size: 16px;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table tr:nth-child(even) {
            background-color: #ffffff;
        }


        table tr:hover {
            background-color: #f1f1f1;
        }


        .client-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }


        .action-icons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .action-icons a,
        .action-icons button {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 20px;
            color: #F07324;
        }

        .action-icons button:hover {
            color: red;
        }

        .see-more-btn {
            text-decoration: none;

            color: #F07324;
            padding: 8px 20px;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
            margin-right: 15px;
            margin-top: 10px;
        }

        .see-more-btn:hover {
            text-decoration: underline;
        }


        .bookings {
            width: 97%;
            margin-top: 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        .bookingtbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .bookingtbl th {
            background-color: #f1f1f1;
            color: #2e2e2e;
            padding: 15px;
            text-align: center;
        }

        .bookingtbl td {
            color: #333;
            font-size: 16px;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .bookingtbl tr:nth-child(even) {
            background-color: #ffffff;
        }


        .bookingtbl tr:hover {
            background-color: #f1f1f1;
        }


        .action-icons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .action-icons a,
        .action-icons button {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 20px;
            color: #F07324;
        }

        .action-icons button:hover {
            color: red;
        }

        .action-icons a i,
        .action-icons button i {
            font-size: 20px;
            transition: color 0.3s ease-in-out, transform 0.2s ease-in-out;
        }


        .action-icons button i {
            color: red;

        }


        .action-icons a:hover i {
            color: rgb(162, 83, 34);
            transform: scale(1.2);
        }

        .action-icons button:hover i {
            color: darkred;
            transform: scale(1.2);
        }



        .status-pending {
            color: orange;
            font-weight: bold;
        }

        .status-confirmed {
            color: green;
            font-weight: bold;
        }

        .status-cancelled {
            color: red;
            font-weight: bold;
        }

        .see-more-btn {
            text-decoration: none;
            color: #F07324;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
        }

        .see-more-btn:hover {
            text-decoration: underline;
        }

        .filter-box {
            margin: 20px 0;
            padding: 20px;
            background-color: #ffffff;

            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .car-ov-container {
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            background: #ffffff;
            box-shadow: 0 2px 5px rgba(10, 9, 9, 0.1);
        }

        .navbar-right {
            display: flex;
            align-items: center;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-icon {
            font-size: 40px;
            color: #777;
            background-color: #ddd;
            border-radius: 50%;
            padding: 10px;
        }

        .admin-info {
            display: flex;
            padding-top: 10px;
            flex-direction: column;
        }

        .admin-name {
            font-weight: bold;
            color: #333;
        }

        .admin-role {
            font-size: 14px;
            color: #2e2e2e;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }



        .sidebar ul li i {
            font-size: 20px;
            margin-right: 10px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }




        .logout-item form {
            display: flex;
            justify-content: flex-start;
        }

        .logout-item button {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
        }

        .sidebar {

            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(10, 9, 9, 0.1);
        }



        .sidebar img {
            width: 100%;
            max-width: 120px;
            margin: 20px;
            display: block;
            margin-bottom: 10px;
        }

        .centered-header {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .car-bg {
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .clients {
            background-color: #ffffff;
        }

        .bookings {
            background-color: #ffffff;
        }

        .header-container h1 {
            color: #F07324;
            text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);
        }


        .notifications-dropdown {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background-color: white;
            border: 1px solid #ddd;
            padding: 10px;
            width: 200px;
            max-height: 300px;
            overflow-y: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 10;
            
        }

        .notifications-dropdown.show {
            display: block;
        }

        .notification-bell {
            position: relative;
            cursor: pointer;
            margin-left: 50px;
        }

        .notification-bell .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 50%;
        }

        .notification {
            padding: 5px;
            margin: 5px 0;
            border-bottom: 1px solid #ddd;
        }
    </style>


</head>

<body>




    <div class="sidebar">
    <img src="{{ asset($currentLogo) }}" alt="Logo" class="navbar-logo">
        <h1>ARKILA</h1>
        <ul>
            <h2 class="centered-header">Overview</h2>
            <li class="">
                <i class='bx bx-home'></i>
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>

            <h2 class="centered-header">Car Rental Management</h2>
            @php
                $carRentalManagementLinks = [
                    ['url' => '/admin/bookings', 'icon' => 'bx bx-book', 'text' => 'Bookings'],
                    ['url' => '/admin/vehicles', 'icon' => 'bx bx-car', 'text' => 'Cars'],
                    ['url' => '/admin/gps', 'icon' => 'bx bx-map', 'text' => 'GPS Tracking']
                ];
            @endphp
            @foreach ($carRentalManagementLinks as $link)
                <li>
                    <i class="{{ $link['icon'] }}"></i>
                    <a href="{{ $link['url'] }}">{{ $link['text'] }}</a>
                </li>
            @endforeach

            <h2 class="centered-header">User Management</h2>
            <li><i class='bx bx-user'></i><a href="{{ route('admin.clients') }}">Clients</a></li>
            <li><i class='bx bx-car'></i><a href="/drivers">Drivers</a></li>
            <li><i class='bx bx-user-plus'></i><a href="{{ route('admin.partners.index') }}">Partners</a></li>
            <li><i class='bx bxs-user-account'></i><a href="{{ route('admin.accounts') }}">Accounts</a></li>

            <h2 class="centered-header">Others</h2>
            <li><i class='bx bx-cog'></i><a href="{{ route('admin.admin-settings') }}">Settings</a></li>
            <li><i class='bx bx-bar-chart'></i> <a href="{{ route('admin.reports.index') }}">Reports</a></li>

            <li class="logout-item">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"><i class='bx bx-log-out'></i> Logout</button>
                </form>
            </li>
        </ul>
    </div>



    <section class="content">

        <nav class="navbar">
            <div class="navbar-left">
                <h2>Dashboard</h2>
            </div>


            <div class="navbar-right">

                <!-- @if(Auth::guard('admin')->check())
                                @php
                                    $admin = Auth::guard('admin')->user();
                                    $unreadNotifications = $admin->unreadNotifications;
                                @endphp
                                <div class="notification-bell" id="notification-bell">
                                    <i class="bx bx-bell"></i>
                                    @if(count($unreadNotifications) > 0)
                                        <span class="badge">{{ count($unreadNotifications) }}</span>
                                    @endif
                                </div>

                                <div class="notifications-dropdown" id="notifications-dropdown">
                                    @if(count($unreadNotifications) > 0)
                                        @foreach ($unreadNotifications as $notification)
                                            <a href="{{ route('notification.details', ['id' => $notification->id]) }}" class="notification">
                                                {{ $notification->data['message'] }}
                                            </a>
                                        @endforeach
                                    @else
                                        <p>No new notifications.</p>
                                    @endif
                                </div>
                @else
                    <p>No notifications available. Please log in first.</p>
                @endif -->

                <div class="admin-profile">
                    @php
                        $admin = Auth::guard('admin')->user();
                    @endphp

                    @if($admin && $admin->profile_picture)
                        <img src="{{ asset($admin->profile_picture) }}" alt="Admin Profile" class="profile-img">
                    @else
                        <i class="bx bx-user-circle profile-icon"></i>
                    @endif

                    <div class="admin-info">
                        <span class="admin-name">
                            {{ $admin ? $admin->firstname . ' ' . $admin->lastname : 'Guest' }}
                        </span><br>
                        <span class="admin-role">
                            {{ $admin ? $admin->role : 'Not logged in' }}
                        </span>
                    </div>
                </div>



            </div>
        </nav>





        <section class="dashboard-content">




            <section class="stats">
                <div class="stat-item">
                    <h3>Total Clients:</h3><br>
                    <p>{{ $totalClients }} <i class='bx bx-user'></i></p>
                </div>
                <div class="stat-item">
                    <h3>Total Drivers:</h3><br>
                    <p> {{ $totalDrivers }}<i class='bx bx-car'></i></p>
                </div>
                <div class="stat-item">
                    <h3>Total Partners:</h3><br>
                    <p>{{ $totalPartners }} <i class='bx bx-user-plus'></i></p>
                </div>
            </section>

        </section>


        <section class="car-acc">
            <div class="addacc-content">
                <a href="{{ route('admin.create') }}" class="addacc-link">
                    <div class="addacc">
                        <i class='bx bx-user'></i>
                        <h3>Add account</h3>
                        <p>To register a new account, click here</p>
                    </div>
                </a>
            </div>
            <div class="addcar-content">
                <a href="{{ route('vehicles.add') }}" class="addcar-link">
                    <div class="addcar">
                        <i class='bx bx-car'></i>
                        <h3>Add Car</h3>
                        <p>To register a new car, click here</p>
                    </div>
                </a>
            </div>
        </section>


        <section class="filter">

            <form action="{{ route('admin.filter-cars') }}" method="GET">

                <div class="filter-box">
                    <h3>Car Availability</h3>
                    <div class="filterbg">
                        <div class="filter-item">
                            <label for="car-type">Car Type:</label>
                            <select id="car-type" name="type">
                                <option value="">All Types</option>
                                <option value="sedan" {{ request('type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="suv" {{ request('type') == 'suv' ? 'selected' : '' }}>SUV</option>
                                <option value="hatchback" {{ request('type') == 'hatchback' ? 'selected' : '' }}>Hatchback
                                </option>
                                <option value="truck" {{ request('type') == 'truck' ? 'selected' : '' }}>Truck</option>
                            </select>
                        </div>

                        <div class="filter-item">
                            <label for="car-brand">Brand:</label>
                            <select id="car-brand" name="brand">
                                <option value="">All Brands</option> <!-- This is the "All" option -->
                                <option value="Toyota" {{ request('brand') == 'Toyota' ? 'selected' : '' }}>Toyota
                                </option>
                                <option value="Honda" {{ request('brand') == 'Honda' ? 'selected' : '' }}>Honda</option>
                                <option value="Ford" {{ request('brand') == 'Ford' ? 'selected' : '' }}>Ford</option>
                                <option value="Suzuki" {{ request('brand') == 'Suzuki' ? 'selected' : '' }}>Suzuki
                                </option>
                            </select>
                        </div>

                        <div class="filter-item">
                            <label for="car-color">Car Color:</label>
                            <select id="car-color" name="color">
                                <option value="">All Colors</option> <!-- This is the "All" option -->
                                <option value="Red" {{ request('color') == 'Red' ? 'selected' : '' }}>Red</option>
                                <option value="Blue" {{ request('color') == 'Blue' ? 'selected' : '' }}>Blue</option>
                                <option value="Black" {{ request('color') == 'Black' ? 'selected' : '' }}>Black</option>
                                <option value="White" {{ request('color') == 'White' ? 'selected' : '' }}>White</option>
                            </select>
                        </div>

                        <!-- <div class="filter-item">
                            <label for="date-availability">Date Availability:</label>
                            <input type="date" id="date-availability" name="availability"
                                value="{{ request('availability') }}">

                        </div> -->



                        <div class="filter-button-container">
                            <button type="submit" class="filter-button">Check</button>

                        </div>
                    </div>
                </div>

            </form>
        </section>

        <section class="car-ov">
    <div class="car-ov-container">
        <h3>Car Overview</h3>
        <div class="trycon">
            @php
                $availableCars = isset($cars) ? $cars->filter(fn($car) => !$car->archived && $car->status !== 'maintenance')->take(4) : collect();
            @endphp

            @if ($availableCars->isNotEmpty())
                @foreach ($availableCars as $car)
                    <div class="car-bg">
                        <div class="car-header">
                            <div class="car-details">
                                <h3 class="car-name">{{ $car->name }}</h3>
                                <p class="car-brand">{{ $car->brand }}</p>
                                <img src="{{ asset($car->primary_image) }}" alt="{{ $car->name }}" class="car-image" loading="lazy">
                            </div>
                        </div>
                        <section class="car-info">
                            <p><i class='bx bx-user'></i> {{ $car->seating_capacity }}</p>
                            <p><i class='bx bx-briefcase'></i> {{ $car->num_bags }}</p>
                            <p><i class='bx bx-gas-pump'></i> {{ $car->gas_type }}</p>
                            <p><i class='bx bx-cog'></i> {{ $car->transmission }}</p>
                        </section>
                        <div class="view-button-container">
                            <a href="{{ route('vehicles.show', ['id' => $car->id]) }}" class="view-icon">
                                <button class="view-button">View</button>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No available cars found.</p>
            @endif
        </div>
    </div>
</section>




        <section class="clients-ov">

            <div class="header-container">
                <h1>Clients Overview</h1>
                <a href="{{ route('admin.clients') }}" class="see-more-btn">See More</a>
            </div>


            <div class="clients">
                <table class="clienttbl">

                    <thead>
                        <tr>
                            <th>Client ID</th>
                            <th>Client’s Name</th>
                            <th>Contact Number</th>
                            <th>Email</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(Client::take(5)->get() as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>
                                    <span>{{ $client->first_name }} {{ $client->last_name }}</span>
                                </td>

                                <td>{{ $client->contact_number }}</td>
                                <td>{{ $client->email }}</td>

                                <td>
                                    <div class="action-icons">

                                        <a href="{{ route('admin.clients.show', ['id' => $client->id]) }}">
                                            <i class='bx bx-show'></i>
                                        </a>


                                        <form action="{{ route('admin.clients.archive', $client->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to archive this client?')">
                                                <i class='bx bx-archive'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>



        <section class="bookings-ov">

            <div class="header-container">
                <h1>Bookings Overview</h1>

                <a href="{{ route('admin.bookings') }}" class="see-more-btn">See More</a>
            </div>

            <!-- Bookings Table -->
            <div class="bookings">
                <table class="bookingtbl">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Client Name</th>
                            <th>Car Rented</th>
                            <th>Pickup Date</th>
                            <th>Return Date</th>

                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Booking::take(5)->get() as $booking)
                                                <tr>
                                                    <td>{{ $booking->id }}</td>
                                                    <td>{{ $booking->client->first_name }}</td>
                                                    <td>{{ $booking->car->brand }}</td>
                                                    <td>{{ $booking->pickup_date }}</td>
                                                    <td>{{ $booking->dropoff_date }}</td>
                                                    <td>
                                                        @php
                                                            $statusClasses = [
                                                                'Partially Paid' => 'badge-warning', // Yellow
                                                                'Paid' => 'badge-success', // Green
                                                                'Returned' => 'badge-info', // Blue
                                                                'Cancelled' => 'badge-danger', // Red
                                                            ];
                                                        @endphp
                                                        <span class="badge {{ $statusClasses[$booking->status] ?? 'badge-default' }}">
                                                            {{ $booking->status }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <div class="action-icons">

                                                            <a href="">
                                                                <i class='bx bx-show'></i>
                                                            </a>


                                                            <form action="" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                                    <i class='bx bx-archive'></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <script>
            document.getElementById('notification-bell').addEventListener('click', function () {
                const notificationsDropdown = document.getElementById('notifications-dropdown');
                notificationsDropdown.classList.toggle('show');
            });
        </script>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20vVS0KoJitRdV1t1PBnZmAzT8yazhJlGGjAgAgSemw=" crossorigin=""></script>







    </section> <!-- End of content -->

</body>

</html>