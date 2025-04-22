@extends('layouts.settings')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activity</title>
    <link rel="stylesheet" href="{{ asset('assets/css/welcome_settings.css') }}">
</head>

<body>
    <div>
        <div class="grid-container">
            <div class="account-activity">
                <h2>Account Activity</h2>
                <div class="activity-container">
                    <p><strong>Device and Activity</strong></p>

                    <table>
                        <thead>
                            <tr>
                                <th>Session ID</th>
                                <th>User ID</th>
                                <th>IP Address</th>
                                <th>User Agent</th>
                                <th>Last Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                            @forelse ($sessions ?? collect() as $session)
                                <tr>
                                    <td>{{ $session->id }}</td>
                                    <td>{{ $session->user_id ?? 'Guest' }}</td>
                                    <td>{{ $session->ip_address }}</td>
                                    <td>{{ Str::limit($session->user_agent, 50) }}</td>
                                    <td>{{ date('Y-m-d H:i:s', $session->last_activity) }}</td>
                                </tr>
                            @empty
                              
                                <tr>
                                    <td colspan="5">No session data available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>