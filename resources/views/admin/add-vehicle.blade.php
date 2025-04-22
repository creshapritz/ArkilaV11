@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="page-title">Add New Car</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('vehicles.store') }}" enctype="multipart/form-data" class="car-form">
            @csrf


            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Car Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="brand">Car Brand:</label>
                        <select class="form-control" id="brand" name="brand" required>
                            <option value="">Select a Brand</option>
                            <option value="Toyota">Toyota</option>
                            <option value="Mitsubishi">Mitsubishi</option>
                            <option value="Honda">Honda</option>
                            <option value="Nissan">Nissan</option>
                            <option value="Ford">Ford</option>
                            <option value="Suzuki">Suzuki</option>
                            <option value="Hyundai">Hyundai</option>
                            <option value="Kia">Kia</option>
                            <option value="Chevrolet">Chevrolet</option>
                            <option value="Mazda">Mazda</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="Sedan">Sedan</option>
                            <option value="SUV">SUV</option>
                            <option value="Truck">Truck</option>
                            <option value="MPV">MPV</option>
                            <option value="Hatchback">Hatchback</option>
                            <option value="Coupe">Coupe</option>
                            <option value="Convertible">Convertible</option>
                            <option value="Minivan">Minivan</option>
                            <option value="Van">Van</option>
                            <option value="Crossover">Crossover</option>
                            <option value="Wagon">Wagon</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="price_per_day">Price Per Day:</label>
                        <input type="number" class="form-control" id="price_per_day" name="price_per_day" step="0.01"
                            required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="seating_capacity">Seating Capacity:</label>
                        <input type="number" class="form-control" id="seating_capacity" name="seating_capacity" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="gas_type">Gas Type:</label>
                        <select class="form-control" id="gas_type" name="gas_type" required>
                            <option value="">Select Gas Type</option>
                            <option value="Gasoline">Gasoline</option>
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Electric">Electric</option>
                            <option value="Hybrid">Hybrid</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="transmission">Transmission:</label>
                        <select class="form-control" id="transmission" name="transmission" required>
                            <option value="">Select Transmission</option>
                            <option value="Automatic">Automatic</option>
                            <option value="Manual">Manual</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="platenum">Plate Number:</label>
                        <input type="text" class="form-control" id="platenum" name="platenum">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mileage">Mileage:</label>
                        <input type="number" class="form-control" id="mileage" name="mileage">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="color">Color:</label>
                        <input type="text" class="form-control" id="color" name="color">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="regexpiry">Registration Expiry:</label>
                        <input type="date" class="form-control" id="regexpiry" name="regexpiry">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="num_bags">Number of Bags:</label>
                        <input type="number" class="form-control" id="num_bags" name="num_bags">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="partner_id">Assign to Partner</label>
                        <select name="partner_id" class="form-control" required>
                            <option value="">-- Select Partner --</option>
                            @foreach ($partners as $partnerAdmin)
                                <option value="{{ $partnerAdmin->id }}">
                                    {{ $partnerAdmin->firstname }} —
                                    {{ $partnerAdmin->partner->company_name ?? 'No Company' }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>


            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="primary_image">Primary Image:</label>
                        <div class="image-container" id="primary_preview">
                            <img src="#" alt="Primary Image Preview" class="img-preview" style="display: none;">
                        </div>
                        <div class="custom-file-upload">
                            <label for="primary_image_upload" class="file-upload-button">Choose File</label>
                            <input type="file" class="form-control-file" id="primary_image_upload" name="primary_image"
                                accept="image/*" onchange="previewImage('primary_image_upload', 'primary_preview')"
                                style="display: none;">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="company_logo">Company Logo:</label>
                        <div class="image-container" id="logo_preview">
                            <img src="#" alt="Company Logo Preview" class="img-preview" style="display: none;">
                        </div>
                        <div class="custom-file-upload">
                            <label for="company_logo_upload" class="file-upload-button">Choose File</label>
                            <input type="file" class="form-control-file" id="company_logo_upload" name="company_logo"
                                accept="image/*" onchange="previewImage('company_logo_upload', 'logo_preview')"
                                style="display: none;">
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="additional_image">Additional Images (choose up to 3):</label>
                        <div class="additional-images-wrapper">
                            <div class="additional-images-container" id="additional_preview">
                            </div>
                        </div>
                        <div class="custom-file-upload">
                            <label for="additional_image_upload" class="file-upload-button">Choose Files</label>
                            <input type="file" class="form-control-file mt-2" id="additional_image_upload"
                                name="additional_image[]" accept="image/*" multiple onchange="previewAdditionalImages()"
                                style="display: none;">
                        </div>
                    </div>
                </div>




            </div>

            <div class="button-container">
                <button type="submit" class="btn btn-primary mt-3 submit-btn">Add Car</button>
                <button type="button" class="btn btn-secondary mt-3 ml-2" onclick="window.history.back()">Cancel</button>
            </div>
        </form>
    </div>
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

        .car-form .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 8px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            transition: box-shadow 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
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

        .additional-images-wrapper {

            width: 500px !important;

            background-color: #ffffff;



            height: 200px;

            border: 2px dashed #e0e0e0;

            display: flex;

            justify-content: center;

            align-items: center;

            overflow: hidden;
            margin-top: 10px;
            border-radius: 8px;

        }

        .additional-images-container {
            display: flex;
            gap: 10px;
        }

        .image-container:hover {
            border-color: #c0c0c0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .image-box {
            width: 100px;
            height: 100px;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;

            border-radius: 8px;

            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);

            transition: border-color 0.3s ease, box-shadow 0.3s ease;

        }

        .image-box:hover {
            border-color: #c0c0c0;

            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

        }

        .image-box img {
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
        function previewAdditionalImages() {
            const previewContainer = document.getElementById('additional_preview');

            const files = document.getElementById('additional_image_upload').files;

            const maxFiles = 3;



            previewContainer.innerHTML = '';



            for (let i = 0; i < Math.min(files.length, maxFiles); i++) {

                const file = files[i];

                const reader = new FileReader();

                const imgElement = document.createElement('img');
                const imageBox = document.createElement('div');

                imageBox.classList.add('image-box');

                imageBox.appendChild(imgElement);

                previewContainer.appendChild(imageBox);



                reader.onload = function (e) {

                    imgElement.src = e.target.result;

                    imgElement.style.maxWidth = "100%";

                    imgElement.style.maxHeight = "100%";

                };



                if (file) {

                    reader.readAsDataURL(file);

                }

            }

        }
    </script>
@endsection