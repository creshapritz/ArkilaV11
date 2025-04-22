@extends('layouts.admin') 

@section('content')
    <div class="notification-detail">
        <h3>Notification Details</h3>
        <div class="notification-message">
            <strong>Message:</strong>
            <p>{{ $notification->data['message'] }}</p>
        </div>

        <div class="notification-time">
            <strong>Received At:</strong>
            <p>{{ $notification->created_at }}</p>
        </div>

        <form action="{{ route('notification.delete', $notification->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this notification?');">
            @csrf
            @method('DELETE')
            <button type="submit">Delete Notification</button>
        </form>
    </div>
@endsection
