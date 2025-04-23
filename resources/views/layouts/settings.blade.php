<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/welcome_settings.css')); ?>">
    <script src="{{ asset('assets/js/landpage.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        
    </style>
</head>

<body>


    <!-------------------------------------------------------- NAVBAR------------------------------------------------------------->
    <nav class="navbar">
        <div class="navbar-left">
            <img src="<?php echo e(asset('assets/img/whitelogoarkila.png')); ?>" alt="Logo" class="navbar-logo">
        </div>
        <div class="navbar-right">
        <button class="btn-bookings"  onclick="window.location.href='{{ route('my-bookings') }}'">My Bookings</button>
            <button class="btn-partner" onclick="window.location.href='{{ route('welcome_partner') }}'">Become a
                partner</button>
           
            @if(Auth::check())
                <button class="btn-client">
                    <img src="{{ Auth::user()->profile_picture ?? '/assets/img/default-profile.png' }}"
                        alt="Profile Picture" class="navbar-profile-pic">
                    {{ Auth::user()->username }} 
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

            <li><a href="{{ route('welcome_about') }}"><i class='bx bx-info-circle'></i> <span>About Us</span></a></li>

            <li><a href="{{ route('welcome_vehicles') }}"><i class='bx bx-car'></i> <span>Vehicles</span></a></li>

            <li><a href="{{ route('welcome_services') }}"><i class='bx bx-wrench'></i> <span>Services</span></a></li>

            <li><a href="{{ route('welcome_rent') }}"><i class='bx bx-key'></i> <span>Rent</span></a></li>

            <li><a href="{{ route('welcome_contact') }}"><i class='bx bx-envelope'></i> <span>Contact Us</span></a></li>

            <li><a href="{{ route('welcome_partner') }}"><i class='bx bx-user-plus'></i> <span>Partnership</span></a>
            </li>

            <li><a href="{{ route('welcome_settings') }}"><i class='bx bx-cog'></i> <span>Settings</span></a></li>

            <li><a href="javascript:void(0);" id="logout-link"><i class='bx bx-log-out'></i> <span>Logout</span></a>
            </li>
        </ul>
    </div>


    <!-- ------------------------------------------------------------------------------------------------- -->



    <section class="settings-container">
        <!-- Left Sidebar Section -->
        <div class="settings-sidebar">
            <a href="{{ route('settings.profile-management') }}" class="settings-btn">Profile Management</a>
            <!-- <a href="{{ route('settings.account-activity') }}" class="settings-btn">Account Activity</a> -->
            <a href="{{ route('settings.privacy-security') }}" class="settings-btn">Privacy and Security</a>
            <a href="{{ route('settings.help-faqs') }}" class="settings-btn">Help and FAQs</a>
        </div>

    </section>




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