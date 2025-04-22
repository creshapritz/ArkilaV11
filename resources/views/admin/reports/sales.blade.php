@extends('layouts.admin')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
        body {
            font-family: 'Sf Pro display';
        }

        .income-summary {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }

        .income-box {
            flex: 1;
            min-width: 180px;
            background-color: #F9F8F2;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;

            text-align: center;
            transition: transform 0.3s ease;
        }



        .income-box h4 {
            font-size: 16px;

            margin-bottom: 10px;
            color: #333;
        }

        .income-box p {
            font-size: 18px;
            font-weight: bold;
            color: #F07324;
            margin: 0;
        }

        #salesChart {
            margin-bottom: 40px;
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


        @media (max-width: 768px) {
            .income-summary {
                flex-direction: column;
            }

            .income-box {
                width: 100%;
            }
        }
    </style>
    <div class="container py-4">


        <div class="income-summary">
            <div class="income-box">
                <h4>Daily Income</h4>
                <p>₱{{ number_format($dailyIncome, 2) }}</p>
            </div>
            <div class="income-box">
                <h4>Weekly Income</h4>
                <p>₱{{ number_format($weeklyIncome, 2) }}</p>
            </div>
            <div class="income-box">
                <h4>Monthly Income</h4>
                <p>₱{{ number_format($monthlyIncome, 2) }}</p>
            </div>
            <div class="income-box">
                <h4>Quarterly Income</h4>
                <p>₱{{ number_format($quarterlyIncome, 2) }}</p>
            </div>
            <div class="income-box">
                <h4>Annual Income</h4>
                <p>₱{{ number_format($annualIncome, 2) }}</p>
            </div>
        </div>
        <canvas id="salesChart" height="100"></canvas>




        <form class="row g-3 mb-4" method="GET">
            <div class="col-md-4">
                <label for="from" class="form-label">From</label>
                <input type="date" class="form-control" id="from" name="from" value="{{ $from }}">
            </div>
            <div class="col-md-4">
                <label for="to" class="form-label">To</label>
                <input type="date" class="form-control" id="to" name="to" value="{{ $to }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>

        <div class="card">
            <div class="card-header">
                Sales Transactions
            </div>
            <div class="card-body p-0">
                <table class="table mb-0 table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Id</th>
                            <th>Client</th>
                            <th>Car</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>{{ $booking->client->first_name ?? 'N/A' }} {{ $booking->client->last_name ?? '' }}</td>
                                <td>{{ $booking->car->name ?? 'N/A' }}</td>
                                <td>{{ $booking->created_at->format('F d, Y') }}</td>
                                <td>₱{{ number_format($booking->amount, 2) }}</td>

                                <td><span class="badge bg-success">Paid</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No sales found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center p-3 flex-wrap">
                    <div>
                        Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }}
                        entries
                    </div>
                    <div class="mt-2">
                        {{ $bookings->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>


            </div>

        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary" style="margin-right: 15px;">Back</a>
            <form method="GET" action="{{ route('admin.reports.exportPDF') }}">
                <input type="hidden" name="from" value="{{ $from }}">
                <input type="hidden" name="to" value="{{ $to }}">
                <button type="submit" class="btn btn-danger">Download PDF</button>
            </form>

        </div>


    </div>


    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Daily', 'Weekly', 'Monthly', 'Quarterly', 'Annually'],
                datasets: [{
                    label: 'Income (₱)',
                    data: [
                                                                {{ $dailyIncome }},
                                                                {{ $weeklyIncome }},
                                                                {{ $monthlyIncome }},
                                                                {{ $quarterlyIncome }},
                        {{ $annualIncome }}
                    ],
                    backgroundColor: [
                        '#F28B82', '#4A90E2', '#F5C544', '#A78BC1', '#317873'
                    ],
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Sales Summary Overview',
                        color: '#333',
                        font: {
                            size: 16,
                            weight: 'bold',
                            family: 'SF Pro Display'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#555'
                        },
                        grid: {
                            color: '#eee'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#555',
                            callback: function (value) {
                                return '₱' + value.toLocaleString();
                            }
                        },
                        grid: {
                            color: '#eee'
                        }
                    }
                }
            }

        });
    </script>

@endsection