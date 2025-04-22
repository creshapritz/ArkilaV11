@extends('layouts.admin')

@section('content')
    <div class="container mt-4">


        <div class="summary-box">
            <strong>Total ARKILA Revenue (20% of all paid bookings):</strong>
            <span class="amount">₱{{ number_format($arkilaShare, 2) }}</span>
        </div>

        <form method="GET" action="{{ route('admin.reports.arkila') }}" class="d-flex align-items-center gap-3 mb-4"
            style="flex-wrap: wrap;">
            <div>
                <label for="year" class="form-label fw-semibold me-2">Filter by Year:</label>
                <select name="year" id="year" class="form-select shadow-sm rounded" onchange="this.form.submit()"
                    style="min-width: 150px;">
                    @foreach ($availableYears as $yearOption)
                        <option value="{{ $yearOption }}" {{ $yearOption == $year ? 'selected' : '' }}>
                            {{ $yearOption }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>


        <div class="chart-container">
            <canvas id="arkilaEarningsChart" height="100"></canvas>
        </div>

        @if ($bookings->isEmpty())
            <div class="alert alert-info">No paid booking records available.</div>
        @else
            <div class="table-container mb-4">
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Company Name</th>
                            <th>Car</th>
                            <th>Total Amount</th>
                            <th>ARKILA Share (20%)</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>{{ $booking->car->partner->company_name ?? 'N/A' }}</td>
                                <td>{{ $booking->car->brand }} {{ $booking->car->model }}</td>
                                <td>₱{{ number_format($booking->amount, 2) }}</td>
                                <td>₱{{ number_format($booking->amount * 0.20, 2) }}</td>
                                <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="row align-items-center mt-4">
                <div class="col-md-12 d-flex justify-content-end">
                    {{ $bookings->appends(['year' => $year])->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <!-- NEW: Export & Back Buttons -->
            <div class="d-flex justify-content-end mt-3 gap-2">
                <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary equal-btn">
                    Back
                </a>
                <a href="{{ route('admin.reports.arkila.export', ['year' => $year, 'type' => 'pdf']) }}"
                    class="btn btn-danger equal-btn">
                    Export to PDF
                </a>


            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('arkilaEarningsChart').getContext('2d');
        const arkilaEarningsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($monthlyEarnings)) !!},
                datasets: [{
                    label: 'ARKILA Earnings (₱)',
                    data: {!! json_encode(array_values($monthlyEarnings)) !!},
                    backgroundColor: '#F07324',
                    borderRadius: 10,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                      
                        color: '#333',
                        font: {
                            size: 18,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => '₱' + value.toLocaleString()
                        }
                    }
                }
            }
        });
    </script>

    <!-- Styles -->
    <style>
        body {
            font-family: 'Sf Pro display';
        }

        .chart-container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #F07324;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .summary-box {
            padding: 15px;
            background-color: #f1f1f1;
            border-left: 5px solid #F07324;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .summary-box .amount {
            font-weight: bold;
            color: #2d2d2d;
            margin-left: 10px;
        }

        .equal-btn {
            width: 150px;
            text-align: center;
            margin-right: 10px;
            margin-bottom: 20px;
        }

        .equal-btn {
            min-width: 140px;
            text-align: center;
        }


        .alert {
            background-color: #d9edf7;
            padding: 12px;
            border: 1px solid #bce8f1;
            color: #31708f;
            border-radius: 4px;
        }

        .btn {
            padding: 8px 16px;
            font-size: 14px;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .filter-export-form {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-export-form select {
            padding: 5px;
        }

        .pagination .page-link {
            color: #F07324;
            border: 1px solid #ddd;
            padding: 8px 16px;
            margin: 0 4px;
            border-radius: 4px;
        }

        .pagination .active .page-link {
            background-color: #F07324;
            color: white;
        }

        .filter-export-form {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-export-form label {
            font-weight: 600;
            margin-right: 5px;
        }

        .filter-export-form select {
            padding: 15px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;

        }

        .filter-export-form select:focus {
            border-color: #f07324;
            outline: none;
        }
    </style>
@endsection