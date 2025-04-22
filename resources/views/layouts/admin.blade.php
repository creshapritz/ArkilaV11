@php
    use App\Models\Setting;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/list-vehicle.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />


    <style>
        body {
            font-family: 'SF Pro Display';
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
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

        .sidebar {
            width: 310px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(10, 9, 9, 0.1);
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
            width: 350px;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
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

        .sidebar h1 {
            color: #F07324;
            font-size: 30px;
            font-weight: bold;
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
                <h2>Welcome!</h2>
            </div>





            <div class="navbar-right">
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

        @yield('content')

    </section>

    @stack('scripts')




</body>

</html>