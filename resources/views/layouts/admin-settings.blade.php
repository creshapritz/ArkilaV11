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


    <style>
        :root {
            --primary-color:
                {{ $primaryColor }}
            ;
            --primary-color-dark:
                {{ $primaryColorDark }}
            ;
            --secondary-color:
                {{ $secondaryColor }}
            ;
        }

        body {
            font-family: 'Sf Pro display';
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
            color: #2e2e2e;
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
            color: #2e2e2e;
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
            color: #333;
        }

       
        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .sidebar ul li:hover i,
        .sidebar ul li:hover a {
            color: #333;
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
            color:
                #2e2e2e;
            transition: color 0.3s ease;
        }

        .logout-item button:hover {
            color:
                #2e2e2e;
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
            color:
                {{ $primaryColor }}
            ;
        }

        .sidebar h1 {
            color:
                {{ $primaryColor }}
            ;
            font-size: 30px;
            font-weight: bold;
        }


        .btn-theme {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-theme:hover {
            filter: brightness(90%);
        }


        a {
            color: #2e2e2e;
        }

        a:hover {
            text-decoration: underline;
        }


        .bg-theme {
            background-color: var(--primary-color) !important;
            color: white;
        }


        .border-theme {
            border: 2px solid var(--primary-color);
        }

        .text-theme {
            color: var(--primary-color);
        }



        .setting-sidebar {
            display: flex;
            width: 100%;
        }

        .sidebar1 {
            background-color: #fff;
            width: 280px;
            height: 675px;
            padding: 30px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.08);
        }



        .sidebar-item {
            display: block;
            padding: 12px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            color: #555;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar-item.active {
            background-color: var(--primary-color);
            color: #fff;
            font-weight: 500;
        }

        .sidebar-item:hover {
            background-color: var(--primary-color);
            color: #333;
            text-decoration: none;
            color: #fff;

        }

        .flex-grow-1 {
            flex-grow: 1;
            padding: 30px;
            background-color: #f4f4f4;
        }

        .fw-bold {
            color: #333;
            font-size: 2rem;
            margin-bottom: 25px;
        }

        .nav-tabs {
            border-bottom: 2px solid #ddd;
            margin-bottom: 30px;
        }

        .nav-tabs .nav-item .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #777;
            padding: 10px 20px;
            transition: color 0.3s ease, border-bottom 0.3s ease;
            border-radius: 6px 6px 0 0;
        }

        .nav-tabs .nav-item .nav-link.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
            font-weight: 500;
            background-color: #fff;
        }

        .nav-tabs .nav-item .nav-link:hover {
            color: #333;
        }
    </style>

</head>

<body>

    <div class="sidebar">
        <img src="{{ asset($currentLogo) }}" alt="Logo" class="navbar-logo">



        <h1>ARKILA</h1>
        <ul>
            <h2 class="centered-header">Overview</h2>
            <li><i class='bx bx-home'></i><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>

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
            <li><i class='bx bx-bar-chart'></i><a href="/reports">Reports</a></li>

            <li class="logout-item">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"><i class='bx bx-log-out'></i> Logout</button>
                </form>
            </li>
        </ul>
    </div>


    <section class="content" style="flex-grow: 1;">
        <nav class="navbar">
            <div class="navbar-left">
                <h2>Welcome!</h2>
            </div>





            <div class="navbar-right">
                <div class="admin-profile">

                    @if(Auth::guard('admin')->user()->profile_picture)
                        <img src="{{ asset(Auth::guard('admin')->user()->profile_picture) }}" alt="Admin Profile"
                            class="profile-img">
                    @else
                        <i class="bx bx-user-circle profile-icon"></i>
                    @endif
                    <div class="admin-info">
                        <span class="admin-name">{{ Auth::guard('admin')->user()->firstname }}
                            {{ Auth::guard('admin')->user()->lastname }}</span><br>
                        <span class="admin-role">{{ Auth::guard('admin')->user()->role }}</span>
                    </div>
                </div>
            </div>
        </nav>
        <section class="setting-sidebar">
            <div class="sidebar1">
                <a href="{{ route('admin.admin-settings') }}"
                    class="sidebar-item {{ request()->routeIs('admin.admin-settings') ? 'active' : '' }}">
                    General Settings
                </a>

                <a href="{{ route('admin.companyManagement') }}"
                    class="sidebar-item {{ request()->routeIs('admin.companyManagement') ? 'active' : '' }}">
                    Company Management
                </a>

                <a href="{{ route('admin.feedbackReviews') }}"
                    class="sidebar-item {{ request()->is('admin/feedback-reviews') ? 'active' : '' }}">
                    Feedback and Reviews
                </a>

                
                <a href="{{ route('admin.archives') }}"
                    class="sidebar-item {{ request()->is('admin/archives') ? 'active' : '' }}">
                    Archives
                </a>
                <a href="{{ route('admin.change-downpayment') }}"
                    class="sidebar-item {{ request()->is('admin.change-downpayment') ? 'active' : '' }}">
                    Payment Settings
                </a>
            </div>
            @yield('content')
        </section>
    </section>
</body>

</html>