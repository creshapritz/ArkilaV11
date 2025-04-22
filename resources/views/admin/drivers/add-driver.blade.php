@extends('layouts.admin')

@section('content')
    <style>
        body {
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }


        .page-title {
            margin-top: 25px;
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
        }

        .driver-form .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 8px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            transition: box-shadow 0.3s ease;
            padding: 0.5rem 1rem; /* Added padding to match input fields */
            font-size: 1rem; /* Added font-size to match input fields */
            line-height: 1.5; /* Added line-height to match input fields */
            border: 1px solid #ced4da; /* Added border to match input fields */
        }

        .form-control:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            border-color: #80bdff; /* Added border color on focus to match input fields */
            outline: 0; /* Added outline reset on focus to match input fields */
        }

        .image-container {
            width: 100%;
            background-color: #ffffff;
            max-width: 300px;
            height: 200px;
            border: 2px dashed #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            margin-top: 10px;
            border-radius: 8px;

        }

        .img-preview {
            max-width: 100%;
            max-height: 100%;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            margin-top: 15px;
        }

        .submit-btn {
            background-color: #F07324;
            color: #fff;
            border-radius: 8px;
            padding: 10px 50px;
            transition: background-color 0.3s ease;
            margin: 0;
        }

        .submit-btn:hover {
            background-color: #d65e14;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 50px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .alert-danger {
            margin-top: 20px;
            border-radius: 8px;
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
        }

        .custom-file-upload {
            position: relative;
            display: inline-block;
            margin-top: 10px;
        }

        .file-upload-button {
            background-color: #F07324;
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .file-upload-button:hover {
            background-color: #d65e14 !important;
        }
    </style>
    <div class="container">
        <h2 class="page-title">Add New Driver</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.drivers.store') }}" enctype="multipart/form-data" class="driver-form">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contact_number">Contact Number:</label>
                        <input type="tel" class="form-control" id="contact_number" name="contact_number" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="driver_admin_id" class="form-label">Assigned Driver Admin:</label>
                        <select name="driver_admin_id" id="driver_admin_id" class="form-control" required>
                            <option value="">--Select Driver Admin--</option>
                            @foreach($driverAdmins as $admin)
                                <option value="{{ $admin->id }}">{{ $admin->firstname }} {{ $admin->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="partner_id" class="form-label">Company Name:</label>
                        <select name="partner_id" id="partner_id" class="form-control" required>
                            <option value="">-- Select Company --</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->id }}">{{ $partner->company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
            </div>

            <div class="row">
            <div class="col-md-6">
                    <div class="form-group">
                        <label for="profile_picture">Profile Picture:</label>
                        <div class="image-container" id="profile_picture_preview">
                            <img src="#" alt="Profile Picture Preview" class="img-preview" style="display: none;">
                        </div>
                        <div class="custom-file-upload">
                            <label for="profile_picture_upload" class="file-upload-button">Choose File</label>
                            <input type="file" class="form-control-file" id="profile_picture_upload" name="profile_picture"
                                   accept="image/*"
                                   onchange="previewImage('profile_picture_upload', 'profile_picture_preview')" required
                                   style="display: none;">
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="license_front">License Front:</label>
                        <div class="image-container" id="license_front_preview">
                            <img src="#" alt="License Front Preview" class="img-preview" style="display: none;">
                        </div>
                        <div class="custom-file-upload">
                            <label for="license_front_upload" class="file-upload-button">Choose File</label>
                            <input type="file" class="form-control-file" id="license_front_upload" name="license_front"
                                   accept="image/*" onchange="previewImage('license_front_upload', 'license_front_preview')"
                                   required style="display: none;">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="license_back">License Back:</label>
                        <div class="image-container" id="license_back_preview">
                            <img src="#" alt="License Back Preview" class="img-preview" style="display: none;">
                        </div>
                        <div class="custom-file-upload">
                            <label for="license_back_upload" class="file-upload-button">Choose File</label>
                            <input type="file" class="form-control-file" id="license_back_upload" name="license_back"
                                   accept="image/*" onchange="previewImage('license_back_upload', 'license_back_preview')"
                                   required style="display: none;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="second_id_front">Second ID Front:</label>
                        <div class="image-container" id="second_id_front_preview">
                            <img src="#" alt="Second ID Front Preview" class="img-preview" style="display: none;">
                        </div>
                        <div class="custom-file-upload">
                            <label for="second_id_front_upload" class="file-upload-button">Choose File</label>
                            <input type="file" class="form-control-file" id="second_id_front_upload" name="second_id_front"
                                   accept="image/*"
                                   onchange="previewImage('second_id_front_upload', 'second_id_front_preview')" required
                                   style="display: none;">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="second_id_back">Second ID Back:</label>
                        <div class="image-container" id="second_id_back_preview">
                            <img src="#" alt="Second ID Back Preview" class="img-preview" style="display: none;">
                        </div>
                        <div class="custom-file-upload">
                            <label for="second_id_back_upload" class="file-upload-button">Choose File</label>
                            <input type="file" class="form-control-file" id="second_id_back_upload" name="second_id_back"
                                   accept="image/*" onchange="previewImage('second_id_back_upload', 'second_id_back_preview')"
                                   required style="display: none;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="button-container">
                <button type="submit" class="btn btn-primary mt-3 submit-btn">Add Driver</button>
                <button type="button" class="btn btn-secondary mt-3 ml-2" onclick="window.history.back()">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(inputId, previewId) {
            const file = document.getElementById(inputId).files[0];
            const reader = new FileReader();
            const preview = document.getElementById(previewId).querySelector('img');

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection