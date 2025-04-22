@extends('layouts.partners_admin')

@section('content')
    <div class="container">
        <h2 class="text-xl font-semibold mb-4">Request to Add a Car</h2>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('cars.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="sender_email">Recipient (Your Email)</label>
                    <input type="email" id="sender_email" name="sender_email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="name">Car Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" id="brand" name="brand" class="form-control" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="type">Car Type</label>
                    <input type="text" id="type" name="type" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="price_per_day">Price per Day (₱)</label>
                    <input type="number" id="price_per_day" name="price_per_day" class="form-control" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="seating_capacity">Seating Capacity</label>
                    <input type="number" id="seating_capacity" name="seating_capacity" class="form-control">
                </div>

                <div class="form-group">
                    <label for="num_bags">Number of Bags</label>
                    <input type="number" id="num_bags" name="num_bags" class="form-control">
                </div>

                <div class="form-group">
                    <label for="gas_type">Gas Type</label>
                    <input type="text" id="gas_type" name="gas_type" class="form-control">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="transmission">Transmission</label>
                    <select id="transmission" name="transmission" class="form-control">
                        <option value="Automatic">Automatic</option>
                        <option value="Manual">Manual</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="platenum">Plate Number</label>
                    <input type="text" id="platenum" name="platenum" class="form-control">
                </div>

                <div class="form-group">
                    <label for="mileage">Mileage (km)</label>
                    <input type="number" id="mileage" name="mileage" class="form-control">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" id="color" name="color" class="form-control">
                </div>

                <div class="form-group">
                    <label for="regexpiry">Registration Expiry</label>
                    <input type="date" id="regexpiry" name="regexpiry" class="form-control">
                </div>

                <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <input type="text" id="company_name" name="company_name" class="form-control">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="receiver_email">Send To (Admin Email)</label>
                    <input type="email" id="receiver_email" name="receiver_email" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit Request</button>
        </form>
    </div>

    <style>
        body {
            font-family: 'Sf pro display';
        }
        .container{
            margin-top: 40px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 1;
            min-width: 250px;

        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group select,
        .form-group input {
            font-size: 1rem;
        }

        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }


        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>

@endsection