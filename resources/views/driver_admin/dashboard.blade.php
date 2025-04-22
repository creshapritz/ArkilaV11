@php
    use App\Models\Client;
    use App\Models\Partner;
    use App\Models\Driver;

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


    <title>Driver Admin Dashboard</title>

    <style>
        .clients-ov {
            position: relative;
            top: -240px;
            /* Move it up */
            margin-top: -40px !important;
            /* Ensure priority */
            padding-top: 0 !important;
            margin-left: 30px;
        }

        .bookings-ov {
            position: relative;
            top: -250px !important;
            padding-top: 0 !important;
            margin-left: 30px;
        }

        /* Header Container */
        .header-container {
            padding: 5px !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;

        }

        /* Clients Overview Container */
        .clients {
            width: 97%;
            margin-top: 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Heading */
        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Clients Table */
        .clienttbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        /* Table Headers */
        table th {
            background-color: #F07324;
            color: white;
            padding: 15px;
            text-align: center;
        }

        /* Table Cells */
        table td {
            color: #333;
            font-size: 16px;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        /* Alternating Row Colors */
        table tr:nth-child(even) {
            background-color: #ffffff;
        }

        /* Hover Effect */
        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Profile Image */
        .client-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        /* Action Icons */
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



        /* Bookings Overview Container */
        .bookings {
            width: 97%;
            margin-top: 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Table Styling */
        .bookingtbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        /* Table Headers */
        .bookingtbl th {
            background-color: #F07324;
            color: white;
            padding: 15px;
            text-align: center;
        }

        /* Table Cells */
        .bookingtbl td {
            color: #333;
            font-size: 16px;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        /* Alternating Row Colors */
        .bookingtbl tr:nth-child(even) {
            background-color: #ffffff;
        }

        /* Hover Effect */
        .bookingtbl tr:hover {
            background-color: #f1f1f1;
        }

        /* Action Icons */
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

        /* Booking Status Styling */
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

        /* See More Button */
        .see-more-btn {
            text-decoration: none;
            background-color: #F07324;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
        }

        .see-more-btn:hover {
            background-color: #d65a18;
        }
    </style>


</head>

<body>



    <!-- Sidebar -->
    <div class="sidebar">
        <img src="{{ asset('assets/img/arkila_logo.png') }}" alt="Arkila Logo">
        <h1>Arkila</h1>
        <ul>
            <h2 class="centered-header">Overview</h2>
            <li class="">
                <i class='bx bx-home'></i>
                <a href="{{ route('driver_admin.dashboard') }}">Dashboard</a>
            </li>
            <h2 class="centered-header">Car Rental Management</h2>
            @php
                $carRentalManagementLinks = [
                    ['url' => '/admin/bookings', 'icon' => 'bx bx-book', 'text' => 'Bookings'],
                    ['url' => '/admin/vehicles', 'icon' => 'bx bx-car', 'text' => 'Vehicles'],
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
            <li><i class='bx bx-user'></i><a href="/drivers">Drivers</a></li>
            <li><i class='bx bx-user'></i><a href="{{ route('admin.partners.index') }}">Partners</a></li>



            <h2 class="centered-header">Others</h2>
            <li><i class='bx bx-cog'></i><a href="/sett">Settings</a></li>
            <li><i class='bx bx-bar-chart'></i><a href="/reports">Reports</a></li>

            <li class="logout-item">
                <form action="{{ route('driver_admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"><i class='bx bx-log-out'></i> Logout</button>
                </form>
            </li>

        </ul>
    </div>

    <!-- Main Content Area -->
    <section class="content">
        <!-- Navigation bar -->
        <nav class="navbar">
            <div class="navbar-left">
                <h2>Dashboard</h2>
            </div>
            <div class="navbar-right">
                <div class="dropdown">
                    <button class="dropbtn"><i class='bx bx-chevron-down'></i></button>

                    <div class="dropdown-content">
                        <a href="/profile">Profile</a>
                        <a href="/settings">Settings</a>
                        <form action="{{ route('driver_admin.logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout-button"
                                style="background: none; border: none; color: inherit; cursor: pointer; padding: 12px 16px; text-decoration: none; display: block; transition: background-color 0.3s;">
                                Logout
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </nav>

        <!-- Dashboard Content -->
        <section class="dashboard-content">
            <!-- Welcome Message -->
            <h1>Welcome to the Driver Admin Dashboard</h1>

            @auth('driver_admin')
                <p>Welcome, {{ Auth::guard('driver_admin')->user()->firstname }}</p>
            @else
                <p>No Driver Admin logged in.</p>
            @endauth

            <!-- Example Stats Section -->
            <section class="stats">
                <div class="stat-item">
                    <h3>Total Clients:</h3><br>
                    <p>{{ $totalClients }} <i class='bx bx-stats'></i></p>
                </div>
                <div class="stat-item">
                    <h3>Total Drivers:</h3><br>
                    <p> {{ $totalDrivers }}<i class='bx bx-stats'></i></p>
                </div>
                <div class="stat-item">
                    <h3>Total Partners:</h3><br>
                    <p>{{ $totalPartners }} <i class='bx bx-stats'></i></p>
                </div>
            </section>
        </section>
        <!--end of dashboard content-->


        <section class="car-acc">
            <div class="addacc-content">
                <a href="{{ route('admin.create') }}" class="addacc-link">
                    <div class="addacc">
                        <i class='bx bx-user'></i> <!-- Add icon here -->
                        <h3>Add account</h3>
                        <p>To register a new account, click here</p>
                    </div>
                </a>
            </div>
            <div class="addcar-content">
                <a href="{{ route('vehicles.add') }}" class="addcar-link">
                    <div class="addcar">
                        <i class='bx bx-car'></i> <!-- Add icon here -->
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
                    @if (isset($cars) && $cars->isNotEmpty())
                        @foreach ($cars->take(4) as $car)
                            <div class="car-bg">
                                <div class="car-header">
                                    <div class="car-details">
                                        <h3 class="car-name">{{$car->name}}</h3>
                                        <p class="car-brand">{{$car->brand}}</p>
                                        <img src="{{asset('storage/' . $car->primary_image)}}" alt="{{$car->name}}"
                                            class="car-image" loading="lazy">

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
                        <p>No cars found with the applied filters.</p>
                    @endif
                </div>
            </div>

        </section>


        <section class="clients-ov">
            <!-- Clients Overview Header -->
            <div class="header-container">
                <h1>Clients Overview</h1>
                <a href="{{ route('admin.clients') }}" class="see-more-btn">See More</a>
            </div>

            <!-- Clients Table -->
            <div class="clients">
                <table class="clienttbl">

                    <thead>
                        <tr>
                            <th>Client ID</th>
                            <th>Client’s User Name</th>
                            <th>Contact #</th>
                            <th>Email</th>
                            <!-- <th>Client Documents</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(Client::take(5)->get() as $client) <!-- Show only 5 clients -->
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ asset($client->profile_picture) }}" alt="Profile Picture"
                                            class="client-img">
                                        <span>{{ $client->username }}</span>
                                    </div>
                                </td>
                                <td>{{ $client->contact_number }}</td>
                                <td>{{ $client->email }}</td>
                                <!-- <td>
                                        <a href="{{ route('admin.clients.show', ['id' => $client->id]) }}">
                                            View Document
                                        </a>
                                    </td> -->
                                <td>
                                    <div class="action-icons">
                                        <!-- View Icon -->
                                        <a href="{{ route('admin.clients.show', ['id' => $client->id]) }}">
                                            <i class='bx bx-show'></i>
                                        </a>

                                        <!-- Archive Icon -->
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
            <!-- Bookings Overview Header -->
            <div class="header-container">
                <h1>Bookings Overview</h1>
                <a href="" class="see-more-btn">See More</a>
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
                        @foreach(\App\Models\Booking::take(5)->get() as $booking) <!-- Show only 5 bookings -->
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>{{ $booking->client->first_name }}</td> <!-- Assuming relationship exists -->
                                <td>{{ $booking->car->model }}</td> <!-- Assuming relationship exists -->
                                <td>{{ $booking->pickup_date }}</td>
                                <td>{{ $booking->dropoff_date }}</td>
                                <td>
                                    <span class="status-{{ strtolower($booking->status) }}">{{ $booking->status }}</span>
                                </td>
                                <td>
                                    <div class="action-icons">
                                        <!-- View Icon -->
                                        <a href="">
                                            <i class='bx bx-show'></i>
                                        </a>

                                        <!-- Cancel Icon -->
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






    </section> <!-- End of content -->

</body>

</html>