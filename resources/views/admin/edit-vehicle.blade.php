@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4">Edit Vehicle</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.vehicles.edit', $car->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Car Brand</label>
                        <input type="text" class="form-control" name="brand" value="{{ old('brand', $car->brand) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Car Model</label>
                        <input type="text" class="form-control" name="model" value="{{ old('model', $car->model) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Transmission</label>
                        <select class="form-select" name="transmission" required>
                            <option value="Automatic" {{ old('transmission', $car->transmission) == 'Automatic' ?
    'selected' : '' }}>Automatic</option>
                            <option value="Manual" {{ old('transmission', $car->transmission) == 'Manual' ?
    'selected' : '' }}>Manual</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Seating Capacity</label>
                        <input type="number" class="form-control" name="seating_capacity"
                            value="{{ old('seating_capacity', $car->seating_capacity) }}" required>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Gas Type</label>
                        <select class="form-select" name="gas_type" required>
                            <option value="Petrol" {{ old('gas_type', $car->gas_type) == 'Petrol' ? 'selected' : ''
                                }}>Petrol</option>
                            <option value="Diesel" {{ old('gas_type', $car->gas_type) == 'Diesel' ? 'selected' : ''
                                }}>Diesel</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Car Color</label>
                        <input type="text" class="form-control" name="color" value="{{ old('color', $car->color) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Car Plate Number</label>
                        <input type="text" class="form-control" name="plate_number"
                            value="{{ old('plate_number', $car->plate_number) }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Full-width fields -->
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Rental Price per Day</label>
                        <input type="number" class="form-control" name="rental_price"
                            value="{{ old('rental_price', $car->rental_price) }}" required>
                    </div>

                    <!-- Primary Image -->
                    <div class="mb-3">
                        <label class="form-label">Primary Image</label>
                        <input type="file" class="form-control" name="primary_image">
                        <small class="text-muted">Upload a new primary image if you want to change it.</small>
                        @if($car->primary_image)
                            <img src="{{ asset('storage/' . $car->primary_image) }}" alt="Current Primary Image"
                                class="img-fluid rounded mt-2" style="max-width: 150px;">
                        @endif
                    </div>

                    <!-- Company Logo -->
                    <div class="mb-3">
                        <label class="form-label">Company Logo</label>
                        <input type="file" class="form-control" name="company_logo">
                        <small class="text-muted">Upload a new company logo if you want to change it.</small>
                        @if($car->company_logo)
                            <img src="{{ asset('storage/' . $car->company_logo) }}" alt="Current Company Logo"
                                class="img-fluid rounded mt-2" style="max-width: 150px;">
                        @endif
                    </div>

                    <!-- Additional Images -->
                    <div class="mb-3">
                        <label class="form-label">Additional Images (Up to 3)</label>
                        <input type="file" class="form-control" name="additional_image[]" multiple accept="image/*">
                        <small class="text-muted">You can select multiple images.</small>

                        <!-- Display existing additional images -->
                        @if($car->additional_image)
                            <div class="mt-2">
                                @foreach(json_decode($car->additional_image) as $imagePath)
                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Additional Image"
                                        class="img-fluid rounded me-2" style="max-width: 80px;">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4">Update Vehicle</button>
                <a href="{{ route('admin.vehicles.show', $car->id) }}" class="btn btn-secondary px-4">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection