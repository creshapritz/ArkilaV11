<!-- @extends('layouts.app')

@section('content')
<h2>Account Activity</h2>
<table>
    <thead>
        <tr>
            <th>Activity</th>
            <th>IP Address</th>
            <th>User Agent</th>
            <th>Timestamp</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
        <tr>
            <td>{{ $log->activity }}</td>
            <td>{{ $log->ip_address }}</td>
            <td>{{ $log->user_agent }}</td>
            <td>{{ $log->timestamp }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection -->
