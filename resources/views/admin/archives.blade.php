@extends('layouts.admin-settings')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Archived Reviews</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div>
        @forelse ($archivedReviews as $review)
            <div class="border p-4 rounded mb-4 bg-white shadow">
                <p><strong>Rating:</strong> {{ $review->rating }} ⭐</p>
                <p><strong>Review:</strong> {{ $review->review }}</p>
                <p><strong>Car ID:</strong> {{ $review->car_id }}</p>
                <p><strong>Client ID:</strong> {{ $review->client_id }}</p>

                <form action="{{ route('admin.restoreReview', $review->id) }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="btn-theme py-1 px-3 rounded">♻ Restore</button>
                </form>
            </div>
        @empty
            <p class="text-gray-500">No archived reviews found.</p>
        @endforelse
    </div>
@endsection