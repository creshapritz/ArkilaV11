@extends('layouts.settings')

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile Management</title>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/welcome_settings.css')); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Settings</title>
</head>

<body>


    
    <div class="profile-management">
        <h2>Profile Management</h2>


        
        <div class="profile-picture-container">
            <img src="{{ Auth::guard('client')->user()->profile_picture ?? '/assets/img/default-profile.png' }}"
                alt="Profile Picture" id="profile-pic">

            <form method="POST" id="profile-pic-form" enctype="multipart/form-data"
                action="{{ route('profile.picture.update') }}">
                @csrf
                <input type="file" id="profile-pic-input" name="profile_picture" style="display: none;"
                    accept="image/*">
                <button type="button" id="change-pic-btn">Change Profile Picture</button>
                <button type="submit" id="submit-btn" style="display: none;">Upload</button>
            </form>
        </div>


      
        <form class="profile-form">
            <div class="form-row">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first-name"
                    value="{{ Auth::guard('client')->user()->first_name }}" readonly>
            </div>
            <div class="form-row">
                <label for="middle-name">Middle Name</label>
                <input type="text" id="middle-name" name="middle-name"
                    value="{{ Auth::guard('client')->user()->middle_name }}" readonly>
            </div>
            <div class="form-row">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last-name"
                    value="{{ Auth::guard('client')->user()->last_name }}" readonly>
            </div>
            <div class="form-row">
                <label for="extension-name">Extension Name</label>
                <input type="text" id="extension-name" name="extension-name"
                    value="{{ Auth::guard('client')->user()->extension_name }}" readonly>
            </div>
            <div class="form-row">
                <label for="age">Age</label>
                <input type="text" id="age" name="age" value="{{ Auth::guard('client')->user()->age }}" readonly>
            </div>
            <div class="form-row">
                <label for="birthday">Birthday</label>
                <input type="date" id="birthday" name="birthday" value="{{ Auth::guard('client')->user()->dob }}"
                    readonly>
            </div>
           
            <div class="form-row">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ Auth::guard('client')->user()->email }}" readonly>
            </div>
            <div class="form-row">
                <label for="contact_number">Contact Number</label>
                <input type="text" id="contact_number" name="contact_number"
                    value="{{ Auth::guard('client')->user()->contact_number }}" readonly>
            </div>
           
            <div class="emergency-contact-section">
                <h2>Emergency Contact</h2>
                <div class="emergency-contact-row">
                    <label for="emergency-contact-number">Emergency Contact Number</label>
                    <input type="text" id="emergency-contact-number" name="emergency-contact-number"
                        value="{{ Auth::guard('client')->user()->emergency_contact }}" readonly>
                    <label for="emergency-contact-relationship">Relationship</label>
                    <input type="text" id="emergency-contact-relationship" name="emergency-contact-relationship"
                        value="{{ Auth::guard('client')->user()->emergency_contact_relationship }}" readonly>
                </div>
            </div>
        </form>

    
        <div class="update-info-note">
            <p>If you need to update your information, please contact us at <a
                    href="mailto:arkilacarrental123@gmail.com">arkilacarrental123@gmail.com</a>.</p>
        </div>
    </div>


    <script>
        $(document).ready(function () {
          
            $('#change-pic-btn').on('click', function () {
                $('#profile-pic-input').click(); 
            });

          
            $('#profile-pic-input').on('change', function (event) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#profile-pic').attr('src', e.target.result); 
                    };
                    reader.readAsDataURL(this.files[0]);
                    $('#submit-btn').show(); 
                }
            });

            $('#profile-pic-form').on('submit', function (e) {
                e.preventDefault(); 

                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('profile.picture.update') }}', 
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#profile-pic').attr('src', response.new_picture_url); 
                            $('.navbar-profile-pic').attr('src', response.new_picture_url); 
                            $('#submit-btn').hide();
                        } else {
                            alert('Failed to update profile picture: ' + response.error);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + error);
                    },
                });
            });
        });

    </script>


</body>

</html>