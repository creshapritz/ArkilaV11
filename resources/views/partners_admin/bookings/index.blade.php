@extends('layouts.partners_admin')

@section('content')
    <section class="bookings-section">
        <div class="container">
            <div class="header-container">
                <h1 class="main-title">Bookings Management</h1>
                <form method="GET" action="{{ route('partners_admin.bookings') }}" class="filter-form">
                    <label for="company_name" class="filter-label">Company:</label>
                    <div class="select-wrapper">
                        <select name="company_name" id="company_name" class="filter-select"
                            onchange="this.form.submit()">
                            @php
                                $partnerCompanyName = Auth::guard('partner_admin')->user()->firstname ?? 'N/A';
                            @endphp
                            <option value="{{ $partnerCompanyName }}" selected>{{ $partnerCompanyName }}</option>
                        </select>
                      
                    </div>
                </form>
            </div>

            <div class="bookings-table-wrapper">
                @if ($bookings->isEmpty())
                    <p class="no-bookings">No bookings found for this company.</p>
                @else
                    <table class="bookings-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Car</th>
                                <th>Company</th>
                                <th>Pickup Date & Time</th>
                                <th>Dropoff Date & Time</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                            <tr onclick="window.open('{{ route('partners_admin.bookings.checklist.pdf', ['id' => $booking->id]) }}', '_blank')"
    style="cursor:pointer;">


                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->client->username ?? 'N/A' }}</td>
                                    <td>{{ $booking->car->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->car->company_name ?? 'N/A' }}</td>
                                  
                                    <td>
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $booking->pickup_date . ' ' . $booking->pickup_time)->format('F j, Y g:i A') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $booking->dropoff_date . ' ' . $booking->dropoff_time)->format('F j, Y g:i A') }}
                                    </td>
                                    <td>₱{{ number_format($booking->amount, 2) }}</td>
                                    <td>
                                        <form action="{{ route('partners_admin.bookings.updateStatus', ['id' => $booking->id]) }}"
                                            method="POST" onclick="event.stopPropagation();">
                                            @csrf
                                            @method('PUT')
                                            <div class="select-wrapper">
                                                <select name="status" class="status-select"
                                                    onchange="this.form.submit()">
                                                    <option value="Partially Paid"
                                                        {{ $booking->status == 'Partially Paid' ? 'selected' : '' }}>
                                                        Partially Paid</option>
                                                    <option value="Paid" {{ $booking->status == 'Paid' ? 'selected' : '' }}>
                                                        Paid</option>
                                                    <option value="Returned"
                                                        {{ $booking->status == 'Returned' ? 'selected' : '' }}>Returned
                                                    </option>
                                                </select>
                                              
                                            </div>
                                        </form>
                                    </td>

                                    <td>
                                <form action="{{ route('partners_admin.bookings.updateUsageStatus', ['id' => $booking->id]) }}"
                                    method="POST" onclick="event.stopPropagation();">
                                    @csrf
                                    @method('PUT')
                                    <div class="select-wrapper">
                                        <select name="usage_status" class="status-select" onchange="this.form.submit()">
                                            <option value="Not Yet Started" {{ $booking->usage_status == 'Not Yet Started' ? 'selected' : '' }}>Not Yet Started</option>
                                            <option value="In Use" {{ $booking->usage_status == 'In Use' ? 'selected' : '' }}>In Use</option>
                                            <option value="Completed" {{ $booking->usage_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    
                                    </div>
                                </form>
                            </td>


                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
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

        .bookings-section {
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

        .filter-form {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .filter-label {
            font-weight: 500;
            color: #4a5568; 
        }

        .select-wrapper {
            position: relative;
            display: inline-block;
        }

        .filter-select, .status-select {
            appearance: none;
            padding: 10px 35px 10px 15px;
            border: 1px solid #cbd5e0; 
            border-radius: 6px;
            color: #4a5568;
            background-color: #fff;
            font-size: 1rem;
            line-height: 1.5;
            cursor: pointer;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            width: 200px; 
        }

        .filter-select:focus, .status-select:focus {
            outline: none;
            border-color: #f97316; 
            box-shadow: 0 0 0 0.2rem rgba(249, 115, 22, 0.25); 
        }

        .dropdown-arrow {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            pointer-events: none;
            color: #718096; 
        }

        .bookings-table-wrapper {
            overflow-x: auto; 
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .bookings-table th {
            background-color: #f97316; 
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .bookings-table td {
            color: #4a5568;
            font-size: 0.95rem;
            padding: 12px 15px;
            border-bottom: 1px solid #edf2f7; 
        }

        .bookings-table tr:last-child td {
            border-bottom: none;
        }

        .bookings-table tbody tr:hover {
            background-color: #f7fafc;
        }

        .no-bookings {
            color: #718096;
            font-size: 1rem;
            padding: 20px;
            text-align: center;
        }

        .status-select {
            width: 150px; 
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .filter-form {
                width: 100%;
            }

            .filter-select {
                width: 100%;
            }

            .bookings-table th, .bookings-table td {
                padding: 8px 10px;
                font-size: 0.85rem;
            }
        }
    </style>
@endsection