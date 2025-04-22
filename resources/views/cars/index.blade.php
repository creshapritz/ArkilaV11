@extends('layouts.app')

@section('content')
<div class="search-cars-page">
    


   
    @if(isset($cars))
    <div class="search-results">
        <h2>Available Cars</h2>
        @if($cars->isEmpty())
            <p class="no-cars-message">No cars available for the selected criteria.</p>
        @else
            <div class="car-list">
                @foreach($cars as $car)
                <div class="car-card">
                    <img src="{{ $car->primary_image }}" alt="{{ $car->name }}">
                    <h3>{{ $car->name }}</h3>
                    <p>Brand: {{ $car->brand }}</p>
                    <p>Type: {{ $car->type }}</p>
                    <p>Location: {{ $car->location }}</p>
                    <p>Price per Day: ₱{{ number_format($car->price_per_day, 2) }}</p>
                    <button class="btn-book">Book Now</button>
                </div>
                @endforeach
            </div>
        @endif
    </div>
    @endif
</div>
@endsection
