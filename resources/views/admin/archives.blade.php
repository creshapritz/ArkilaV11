@extends('layouts.admin-settings')

@section('content')
    <div style="flex-grow: 1; padding: 1rem;">
        <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">Archived Reviews</h2>

        @if (session('success'))
            <div
                style="background-color: #d1fae5; color: #065f46; padding: 0.5rem 1rem; border-radius: 0.375rem; margin-bottom: 1rem;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Archived Reviews Table -->
        <div style="overflow-x: auto; margin-bottom: 3rem;">
            <table
                style="width: 100%; background-color: white; border: 1px solid #d1d5db; border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <thead>
                    <tr style="background-color: #f3f4f6;">
                        <th style="padding: 0.5rem 1rem; text-align: left;">Rating</th>
                        <th style="padding: 0.5rem 1rem; text-align: left;">Review</th>
                        <th style="padding: 0.5rem 1rem; text-align: left;">Car ID</th>
                        <th style="padding: 0.5rem 1rem; text-align: left;">Client ID</th>
                        <th style="padding: 0.5rem 1rem; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($archivedReviews as $review)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.5rem 1rem;">{{ $review->rating }} ⭐</td>
                            <td style="padding: 0.5rem 1rem;">{{ $review->review }}</td>
                            <td style="padding: 0.5rem 1rem;">{{ $review->car_id }}</td>
                            <td style="padding: 0.5rem 1rem;">{{ $review->client_id }}</td>
                            <td style="padding: 0.5rem 1rem; text-align: center;">
                                <form action="{{ route('admin.restoreReview', $review->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    <button type="submit"
                                        style="background-color: #3b82f6; color: white; padding: 0.25rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; border: none;">Restore</button>
                                </form>
                                <form action="{{ route('admin.deleteReviewFromArchive', $review->id) }}" method="POST"
                                    style="display: inline-block;"
                                    onsubmit="return confirm('Are you sure you want to delete this review permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background-color: #ef4444; color: white; padding: 0.25rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; border: none;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #6b7280; padding: 0.5rem 1rem;">No archived
                                reviews found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Archived Clients Table -->
        <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">Archived Clients</h2>

        <div style="overflow-x: auto;">
            <table
                style="width: 100%; background-color: white; border: 1px solid #d1d5db; border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <thead>
                    <tr style="background-color: #f3f4f6;">
                        <th style="padding: 0.5rem 1rem; text-align: left;">Name</th>
                        <th style="padding: 0.5rem 1rem; text-align: left;">Email</th>
                        <th style="padding: 0.5rem 1rem; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($archivedClients as $client)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.5rem 1rem;">{{ $client->name }}</td>
                            <td style="padding: 0.5rem 1rem;">{{ $client->email }}</td>
                            <td style="padding: 0.5rem 1rem; text-align: center;">
                                <form action="{{ route('admin.restoreClient', $client->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    <button type="submit"
                                        style="background-color: #3b82f6; color: white; padding: 0.25rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; border: none;">Restore</button>
                                </form>
                                <form action="{{ route('admin.deleteClientFromArchive', $client->id) }}" method="POST"
                                    style="display: inline-block;"
                                    onsubmit="return confirm('Are you sure you want to delete this client permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background-color: #ef4444; color: white; padding: 0.25rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; border: none;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: #6b7280; padding: 0.5rem 1rem;">No archived
                                clients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection