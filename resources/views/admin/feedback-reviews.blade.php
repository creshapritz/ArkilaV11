@extends('layouts.admin-settings')

@section('content')

    <style>
        .reviews-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            /* spacing between each review */
            max-width: 700px;
            /* optional: control width of stack */
            margin: 0 auto;
        }

        .review-container {
            background-color: #ffffff;
            border-radius: 0.75rem;
            padding: 1.25rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease-in-out;
            width: 100%;
        }

        .review-container:hover {
            transform: translateY(-2px);
        }

        .review-container p {
            margin-bottom: 0.5rem;
            color: #374151;
        }

        .review-container p strong {
            font-weight: 600;
            color: #1f2937;
        }

        .review-container .btn-theme {
            background-color: var(--theme-color, #3b82f6);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .review-container .btn-theme:hover {
            background-color:rgb(235, 143, 37);
        }
    </style>
    <div>
        <h2 class="text-2xl font-bold mb-4">Feedback & Reviews</h2>
    </div>
    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="reviews-wrapper">
        @foreach ($reviews as $review)
            <div class="review-container">
                <p><strong>Rating:</strong> {{ $review->rating }} ⭐</p>
                <p><strong>Review:</strong> {{ $review->review }}</p>
                <p><strong>Car ID:</strong> {{ $review->car_id }}</p>
                <p><strong>Client ID:</strong> {{ $review->client_id }}</p>

                <form action="{{ route('admin.archiveReview', $review->id) }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="btn-theme">Archive</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection