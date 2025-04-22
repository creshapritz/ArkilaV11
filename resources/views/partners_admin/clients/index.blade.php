@extends('layouts.partners_admin')

@section('content')
    <section class="clients-overview-section">
        <div class="container">
            <div class="header-container">
                <h1 class="main-title">Clients Overview</h1>
            </div>

            <div class="clients-table-wrapper">
                <table class="clients-table">
                    <thead>
                        <tr>
                            <th>Client ID</th>
                            <th>Client’s Name</th>
                            <th>Contact #</th>
                            <th>Email</th>
                            <th class="action-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>
                                    <div class="client-info">
                                        <span>{{ $client->first_name }} {{ $client->last_name }}</span>
                                    </div>
                                </td>
                                <td>{{ $client->contact_number }}</td>
                                <td>{{ $client->email }}</td>
                                <td class="action-column">
                                    <div class="action-icons">
                                        <a href="{{ route('partners_admin.clients.show', ['id' => $client->id]) }}"
                                            class="view-icon">
                                            <i class='bx bx-show'></i>
                                        </a>
                                        <form action="{{ route('partners_admin.clients.archive', $client->id) }}"
                                            method="POST" class="archive-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="archive-button"
                                                onclick="return confirm('Are you sure you want to archive this client?')">
                                                <i class='bx bx-archive'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="no-clients">No clients found for this partner.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <style>
        body {
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f4f6f8;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .clients-overview-section {
            padding: 30px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e6ed;
        }

        .main-title {
            font-size: 2.2rem;
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 0;
        }

        .clients-table-wrapper {
            overflow-x: auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .clients-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .clients-table th {
            background-color: #f97316;
            color: white;
            padding: 12px 15px;
            text-align: center;
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .clients-table td {
            color: #4a5568;
            font-size: 0.95rem;
            padding: 12px 15px;
            border-bottom: 1px solid #edf2f7;
            text-align: center;
        }

        .clients-table tr:last-child td {
            border-bottom: none;
        }

        .clients-table tbody tr:hover {
            background-color: #f7fafc;
        }

        .client-info {
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: center;
        }

        .client-img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }

        .action-column {
            text-align: center;
        }

        .action-icons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px; 
        }

        .view-icon,
        .archive-button {
            background: none;
            border: none;
            cursor: pointer;
            outline: none;
            display: flex;
            align-items: center;
        }

        .view-icon i,
        .archive-button i {
            font-size: 20px; 
        }

        .view-icon i {
            color: #f97316; 
            transition: color 0.2s ease-in-out;
        }

        .view-icon:hover i {
            color: #d65f1e;
            text-decoration: underline;
        }

        .archive-button i {
            color: #dc2626; 
            transition: color 0.2s ease-in-out;
        }

        .archive-button:hover i {
            color: #b91c1c;
            text-decoration: underline; 
        }
       

        .no-clients {
            color: #718096;
            font-size: 1rem;
            padding: 20px;
            text-align: center;
        }

        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header-container {
                margin-bottom: 20px;
                padding-bottom: 15px;
            }

            .main-title {
                font-size: 2rem;
            }

            .clients-table th,
            .clients-table td {
                padding: 8px 10px;
                font-size: 0.85rem;
            }

            .action-icons {
                gap: 10px;
            }

            .view-icon i,
            .archive-button i {
                font-size: 18px;
            }
        }
    </style>
@endsection