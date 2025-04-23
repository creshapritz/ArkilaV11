@extends('layouts.admin')

@section('content')

    <style>
        body {
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f8f9fa;
        }

        .header-container {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .clients {
            width: 97%;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            padding-left: 20px;
            padding-top: 20px;
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .clienttbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #ffffff;
        }

        table th {
            background-color: #F07324;
            color: white;
            padding: 15px;
            text-align: center;
        }

        table td {
            color: #333;
            font-size: 16px;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table tr:nth-child(even) {
            background-color: #ffffff;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .client-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .action-icons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .action-icons a,
        .action-icons button {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 20px;
        }

        .action-icons button[type="submit"] i.bx-archive {
            color: red !important;


        }

        .action-icons button[type="submit"]:hover i.bx-archive {
            color: red;
            text-decoration: underline;
        }


        .action-icons a i.bx-show {
            color: #F07324;
        }

        .action-icons a:hover i.bx-show {
            color: #d65f1e;
            text-decoration: underline;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
        }

        .status-verified {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>

    <div class="header-container">
        <h1>Clients Overview</h1>
    </div>

    <div class="clients">
        <table class="clienttbl">
            <thead>
                <tr>
                    <th>Client ID</th>
                    <th>Client’s Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->id }}</td>
                        <td>
                            <div>
                                <span>{{ $client->first_name }} {{ $client->last_name }}</span>
                            </div>
                        </td>

                        <td>{{ $client->email }}</td>
                        <td>
                            @if($client->status === 'verified')
                                <span class="status-badge status-verified">Verified</span>
                            @else
                                <span class="status-badge status-pending">Pending</span>
                            @endif
                        </td>



                        <td>
                            <div class="action-icons">
                                <a href="{{ route('admin.clients.show', ['id' => $client->id]) }}">
                                    <i class='bx bx-show'></i>
                                </a>

                                <form action="{{ route('admin.clients.archive', $client->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to archive this client?')">
                                        <i class='bx bx-archive'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection