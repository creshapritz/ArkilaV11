@extends('layouts.partners_admin')

@section('content')

    <style>
        body {
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            padding: 30px;
        }

        .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h2 {
            color: #333;
            font-size: 2.2rem;
            font-weight: 600;
            margin-bottom: 0;
        }

        .btn-success {
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            text-decoration: none;
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #d65f1e !important;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .vehicle-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .vehicle-card {
            background-color: white;
            height: 230px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
            display: flex;
            align-items: center;
        }

        .vehicle-card:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .vehicle-image {
            width: 300px;
            height: 180px;
            overflow: hidden;
            background-color: #eee;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
        }

        .car-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .vehicle-details {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
            min-height: 180px;
        }

        .vehicle-info {
            margin-bottom: 15px;
        }

        .name-brand {
            margin-bottom: 10px;
        }

        .vehicle-name {
            display: block;
            font-size: 1.4rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .vehicle-brand,
        .vehicle-id,
        .vehicle-platenum,
        .vehicle-availability,
        .vehicle-price {
            display: block;
            font-size: 0.95rem;
            color: #2e2e2e;
            margin-bottom: 3px;
        }

        .additional-info {
            margin-top: 10px;
        }

        .vehicle-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .view-icon,
        .archive-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.9rem;
            width: 120px;
            height: auto;
        }

        .view-icon {
            color: #F07324;
            background-color: #f8f9fa;
            border: 1px solid #F07324;
        }

        .view-icon:hover {
            background-color: #F07324;
            color: white;
            text-decoration: none;
        }

        .archive-icon {
            color: red;
            background-color: #f8f9fa;
            border: 1px solid red;
        }

        .archive-icon:hover {
            background-color: red;
            color: white;
            text-decoration: none;
        }

        .view-icon i,
        .archive-icon i {
            font-size: 1.5rem;
            line-height: 0;
        }

        p {
            font-size: 1rem;
            color: #555;
        }
    </style>

    <div class="container">
        <div class="flex justify-between items-center mb-4">
            <h2>List of Vehicles</h2>
            <div class="btn-group-vehicles">
                <a href="{{ route('partners_admin.cars.create') }}" class="btn btn-primary">
                    Request to Add a Car
                </a>

            </div>
        </div>


        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($cars->isEmpty())
            <p>No vehicles found.</p>
        @else
            <div class="vehicle-list">
                @foreach($cars as $car)
                    <div class="vehicle-card">
                        <div class="vehicle-image">
                            @if($car->primary_image)
                                <img src="{{ asset($car->primary_image) }}" alt="{{ $car->name }}" class="car-image">
                            @else
                                <img src="{{ asset('assets/img/default-car.png') }}" alt="Default Car Image" class="car-image">
                            @endif
                        </div>
                        <div class="vehicle-details">
                            <div class="vehicle-info">
                                <div class="name-brand">
                                    <span class="vehicle-name">{{ $car->name }}</span>
                                    <span class="vehicle-brand"><strong>Brand:</strong> {{ $car->brand }}</span>
                                    <span class="vehicle-id"><strong>Car ID:</strong> {{ $car->id }}</span>
                                </div>
                                <div class="additional-info">
                                    <span class="vehicle-platenum"><strong>Plate Number:</strong> {{ $car->platenum }}</span>
                                    <span class="vehicle-availability"><strong>Availability:</strong>
                                        {{ $car->availability ? 'Available' : 'Not Available' }}</span>
                                    <span class="vehicle-price"><strong>Price Per Day:</strong>
                                        ₱{{ number_format($car->price_per_day, 2) }}</span>
                                </div>
                            </div>
                            <div class="vehicle-actions">
                                <a href="{{ route('partners_admin.cars.show', ['id' => $car->id]) }}" class="view-icon">
                                    <span>View</span>
                                </a>



                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <!-- 
        <script>


            function deleteVehicle(vehicleId) {
                if (confirm("Are you sure you want to archive this vehicle?")) {
                    fetch(`/partners_admin/vehicles/${vehicleId}/archive`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.success);
                            location.reload();
                        })
                        .catch(error => console.error('Error:', error));
                }
            }
        </script> -->
@endsection