@extends('layouts.admin')

@section('content')
    <style>
        body {
            font-family: 'Sf Pro display';
        }

        .report-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h2.report-title {
            text-align: left;
            font-size: 28px;
            color: #2e2e2e;
            margin-bottom: 30px;
        }

        .filters {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }


        .filters select,
        .filters input {
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        table.report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.report-table th,
        table.report-table td {
            padding: 12px 16px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 15px;
        }

        table.report-table th {
            background-color: #F07324;
            color: white;
            font-weight: bold;
        }

        table.report-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .no-data {
            text-align: center;
            font-size: 16px;
            color: #777;
            padding: 40px;
            border: 1px dashed #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
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
    </style>

    <div class="report-container">
        <!-- Filters for Date and Company -->
        <div class="filters">
            <form method="GET" action="{{ route('admin.reports.drivers') }}"
                style="display: flex; align-items: flex-end; gap: 10px;">
                <div>
                    <label for="company_name">Filter by Company</label>
                    <select name="company_name" id="company_name">
                        <option value="all">All Companies</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company }}" {{ request('company_name') == $company ? 'selected' : '' }}>
                                {{ $company }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>&nbsp;</label>
                    <button type="submit"
                        style="background-color: #F07324; color: white; padding: 5px 30px; border: none; border-radius: 5px;">
                        Filter
                    </button>
                </div>
            </form>
        </div>


        @if ($drivers->isEmpty())
            <div class="no-data">No driver booking records found.</div>
        @else
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Driver Name</th>
                        <th>Company</th>
                        <th>Total Bookings</th>
                        <th>Total Earnings</th>
                        <th>Last Booking</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($drivers as $driver)
                        <tr>
                            <td>{{ $driver['name'] }}</td>
                            <td>{{ $driver['company_name'] ?? 'N/A' }}</td>
                            <td>{{ $driver['total_bookings'] }}</td>
                            <td>₱{{ number_format($driver['total_earnings'], 2) }}</td>
                            <td>{{ $driver['last_booking'] ? $driver['last_booking']->format('Y-m-d H:i') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row align-items-center mt-4">
                <div class="col-md-12 d-flex justify-content-end">
                    {{ $drivers->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>


            <div class="d-flex justify-content-end mt-3 gap-2">
                <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary equal-btn">Back</a>
                <a href="{{ route('admin.reports.drivers.exportPdf', request()->query()) }}" class="btn btn-danger equal-btn">
                    Export to PDF
                </a>
            </div>

        @endif
    </div>
@endsection