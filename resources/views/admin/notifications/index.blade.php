@extends('layouts.admin')

@section('content')
    <div class="notifications-container">
        <h2>Notifications</h2>
        
        @if($unreadNotifications->isNotEmpty())
            <ul>
                @foreach($unreadNotifications as $notification)
                    <li>
                        <a href="{{ route('notification.details', $notification->id) }}">
                            {{ $notification->data['message'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No unread notifications.</p>
        @endif
    </div>
@endsection
