@php
    use App\Models\Client;
    use App\Models\Partner;
    use App\Models\Driver;



    $totalDrivers = Driver::count();
    $totalPartners = Partner::count();

    $partnerId = auth()->user()->partner->id ?? null;
@endphp



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">



    <title>Partners Admin Dashboard</title>

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
            background-color: #F07324;
            color: white;
            padding: 15px;
            text-align: center;
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

        .car-ov img {
            object-fit: contain;
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
            background-color: #F07324;
            color: white;
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

        .navbar h2 {
            font-weight: 600;
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
    </style>


</head>

<body>

    <div class="sidebar">
        <img src="{{ asset('assets/img/logomain.png') }}" alt="Arkila Logo">
        <h1>Arkila</h1>
        <ul>
            <h2 class="centered-header">Overview</h2>
            <li class="">
                <i class='bx bx-home'></i>
                <a href="{{ route('partners_admin.dashboard') }}">Dashboard</a>
            </li>
            <h2 class="centered-header">Car Rental Management</h2>
            @php
                $carRentalManagementLinks = [
                    ['url' => route('partners_admin.bookings'), 'icon' => 'bx bx-book', 'text' => 'Bookings'],
                    ['url' => route('partners_admin.transaction_history'), 'icon' => 'bx bx-list-check', 'text' => 'Transaction History'],

                    ['url' => route('partners_admin.cars.index'), 'icon' => 'bx bx-car', 'text' => 'Cars'],
                    
                ];
            @endphp
            @foreach ($carRentalManagementLinks as $link)
                <li>
                    <i class="{{ $link['icon'] }}"></i>
                    <a href="{{ $link['url'] }}">{{ $link['text'] }}</a>
                </li>
            @endforeach
            <h2 class="centered-header">User Management</h2>
            <li><i class='bx bx-user'></i><a href="{{ route('partners_admin.clients.index') }}">Clients</a></li>
            <li><i class='bx bx-car'></i><a href="{{ route('partners_admin.drivers.index') }}">Drivers</a></li>





            <h2 class="centered-header">Others</h2>
            <li><i class='bx bx-cog'></i><a href="/sett">Settings</a></li>
            <li><i class='bx bx-bar-chart'></i><a href="">Reports</a></li>

            <li class="logout-item">
                <form action="{{ route('partners_admin.logout') }}" method="POST">
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
                <div class="admin-profile">

                    @if(Auth::guard('partner_admin')->user()->profile_picture)
                        <img src="{{ asset(Auth::guard('partner_admin')->user()->profile_picture) }}" alt="Admin Profile"
                            class="profile-img">
                    @else
                        <i class="bx bx-user-circle profile-icon"></i>
                    @endif
                    <div class="admin-info">
                        <span class="admin-name">{{ Auth::guard('partner_admin')->user()->firstname }}
                            {{ Auth::guard('partner_admin')->user()->lastname }}</span><br>

                        <span class="admin-role">{{ Auth::guard('partner_admin')->user()->role }}</span>

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
                    <p>
                        {{ \App\Models\DriverAdmin::where('partner_id', Auth::guard('partner_admin')->user()->partner_id)->count() }}
                        <i class='bx bx-id-card'></i>
                    </p>
                </div>


                <div class="stat-item">
                    <h3>Total Cars:</h3><br>
                    <p>{{ \App\Models\Car::where('partner_id', auth()->guard('partner_admin')->user()->partner->id)->count() }}
                        <i class='bx bx-car'></i>
                    </p>
                </div>

            </section>
        </section>



        <section class="car-acc">



        </section>


        <section class="filter">

            <form action="{{ route('partners_admin.filter-cars') }}" method="GET">
                @csrf
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
                                <option value="">All Brands</option>
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
                                <option value="">All Colors</option>
                                <option value="Red" {{ request('color') == 'Red' ? 'selected' : '' }}>Red</option>
                                <option value="Blue" {{ request('color') == 'Blue' ? 'selected' : '' }}>Blue</option>
                                <option value="Black" {{ request('color') == 'Black' ? 'selected' : '' }}>Black</option>
                                <option value="White" {{ request('color') == 'White' ? 'selected' : '' }}>White</option>
                            </select>
                        </div>

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
                                        <h3 class="car-name">{{ $car->name }}</h3>
                                        <p class="car-brand">{{ $car->brand }}</p>
                                        <img src="{{ asset($car->primary_image) }}" alt="{{ $car->name }}" class="car-image"
                                            loading="lazy">
                                    </div>
                                </div>
                                <section class="car-info">
                                    <p><i class='bx bx-user'></i> {{ $car->seating_capacity }}</p>
                                    <p><i class='bx bx-briefcase'></i> {{ $car->num_bags }}</p>
                                    <p><i class='bx bx-gas-pump'></i> {{ $car->gas_type }}</p>
                                    <p><i class='bx bx-cog'></i> {{ $car->transmission }}</p>
                                </section>
                                <div class="view-button-container">
                                    <a href="{{ route('partners_admin.cars.show', ['id' => $car->id]) }}" class="view-icon">
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



    </section>

</body>

</html>