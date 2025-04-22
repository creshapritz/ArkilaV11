@extends('layouts.partners_admin')

@section('content')
    <style>
        body {
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            padding: 30px;
            margin: 20px auto;
            max-width: 1200px;

        }

        .left-section,
        .right-section {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .left-section h3,
        .right-section h3,
        .right-section h4 {
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 1.8rem;
        }


        .car-image-container {
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .car-image {
            display: block;
            width: 100%;
            height: auto;
            aspect-ratio: 16/9;

            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        .car-image:hover {
            transform: scale(1.03);
        }

        .car-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));

            gap: 15px;
            margin-bottom: 25px;
        }

        .car-details {
            font-size: 1rem;
            color: #555;
        }

        .car-details strong {
            font-weight: 600;
            color: #333;
        }

        .edit-button-container {
            text-align: right;
        }




        .car-features ul {
            list-style: none;
            padding: 0;
        }

        .car-features li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            color: #555;
        }

        .car-features li:last-child {
            border-bottom: none;
        }

        .car-features li strong {
            font-weight: 600;
            color: #333;
            display: inline-block;
            width: 150px;

        }

        .carousel {
            position: relative;
            margin-top: 25px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .carousel-inner {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;

        }

        .carousel-item {
            flex: 0 0 100%;
            scroll-snap-align: start;
        }

        .carousel-image {
            display: block;
            width: 100%;
            height: auto;
            aspect-ratio: 16/9;
            object-fit: cover;
        }

        .carousel-control-prev,
        .carousel-control-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 10;
            font-size: 1.2rem;
            border-radius: 5px;
        }

        .carousel-control-prev {
            left: 10px;
        }

        .carousel-control-next {
            right: 10px;
        }

        .no-images-message {
            margin-top: 20px;
            text-align: center;
            font-size: 1rem;
            color: #777;
        }


        .company-logo {
            margin-top: 30px;
            text-align: center;
        }

        .company-logo h4 {
            font-size: 1.4rem;
            margin-bottom: 10px;
            color: #333;
        }

        .company-logo-img {
            max-width: 150px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .back-button-container {
            margin-bottom: 20px;
        }

        .back-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #F07324;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease-in-out;
        }

        .back-button:hover {
            background-color: #d65f1e !important;
            text-decoration: none !important;
            color: white !important;
        }

        @media (max-width: 992px) {
            .container {
                grid-template-columns: 1fr;
            }

            .right-section {
                margin-top: 30px;
            }
        }

        @media (max-width: 768px) {
            .car-details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container">
        <div class="left-section">

            <h3>Car Details</h3>
            <div class="car-image-container">
                @if($car->primary_image)
                    <img src="{{ asset($car->primary_image) }}" alt="Car Image" class="car-image">
                @else
                    <p>No primary image available.</p>
                @endif
            </div>

            <div class="car-details-grid">
                <p class="car-details"><strong>Car ID:</strong> {{ $car->id }}</p>
                <p class="car-details"><strong>Car Brand:</strong> {{ $car->brand }}</p>
                <p class="car-details"><strong>Car Model:</strong> {{ $car->name }}</p>
                <p class="car-details"><strong>Plate Number:</strong> {{ $car->platenum ?? 'N/A' }}</p>
                <p class="car-details"><strong>Mileage:</strong> {{ $car->mileage ?? 'N/A' }}</p>
                <p class="car-details"><strong>Car Color:</strong> {{ $car->color ?? 'N/A' }}</p>
                <p class="car-details"><strong>Registration Expiry Date:</strong> {{ $car->regexpiry ?? 'N/A' }}</p>
                <p class="car-details"><strong>Price Per Day:</strong> ₱{{ number_format($car->price_per_day, 2) }}</p>
            </div>

            <div class="back-button-container">
                <a href="javascript:history.back()" class="back-button">Back</a>
            </div>

        </div>

        <div class="right-section">
            <div class="car-features">
                <h3>Features</h3>
                <ul>
                    <li><strong>Transmission:</strong> {{ $car->transmission }}</li>
                    <li><strong>Seating Capacity:</strong> {{ $car->seating_capacity }} persons</li>
                    <li><strong>Gas Type:</strong> {{ $car->gas_type }}</li>
                    <li><strong>Number of Bags:</strong> {{ $car->num_bags }}</li>
                </ul>
            </div>


            @if($car->additional_image)

                <h4>Additional Images</h4>

                <div class="carousel">

                    <div class="carousel-inner">

                        @foreach(json_decode($car->additional_image) as $key => $imagePath)

                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

                                <img src="{{ asset($imagePath) }}" class="carousel-image" alt="Additional Image">

                            </div>

                        @endforeach

                    </div>
                    <button class="carousel-control-prev" onclick="moveSlide(-1)">&#10094;</button>
                    <button class="carousel-control-next" onclick="moveSlide(1)">&#10095;</button>
                </div>
            @else
                <div class="no-images-message">
                    <p>No Additional Images Available</p>
                </div>
            @endif



            @if ($car->company_logo)
                <div class="company-logo">
                    <h4>Company Logo</h4>
                    <img src="{{ asset($car->company_logo) }}" alt="Company Logo" class="company-logo-img">
                </div>
            @else
                <p>No company logo available.</p>
            @endif
        </div>
    </div>

    <script>
        let currentSlide = 0;
        function moveSlide(step) {

            const slides = document.querySelectorAll('.carousel-item');

            const totalSlides = slides.length;



            currentSlide = (currentSlide + step + totalSlides) % totalSlides;

            slides.forEach((slide, index) => {

                slide.classList.remove('active');

                if (index === currentSlide) {

                    slide.classList.add('active');

                }

            });

        }
    </script>

@endsection