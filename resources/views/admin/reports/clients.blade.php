@extends('layouts.admin')

@section('content')
    <div class="client-container">
        <!-- <h2 class="title">Client Booking Report</h2> -->

        <form method="GET" action="{{ route('admin.reports.clients') }}" class="search-form mb-4">
            <input type="text" name="search" placeholder="Search by client name or email" value="{{ request('search') }}">
            <button type="submit">Search</button>
        </form>



        @if ($clients->isEmpty())
            <div class="alert-info-custom">No clients with bookings found.</div>
        @else
            <div class="table-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Email</th>

                            <th>Last Booking</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr class="{{ $client['total_bookings'] > 5 ? 'highlight' : '' }}">
                                <td>{{ $client['name'] }}</td>
                                <td>{{ $client['email'] }}</td>

                                <td>{{ $client['last_booking'] ? $client['last_booking']->format('Y-m-d H:i') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.reports.clients.exportSpecificPDF', ['email' => $client['email']]) }}"
                                        class="export-link">Export {{ $client['name'] }}'s Bookings</a>

                                </td>
                            </tr>


                        @endforeach
                    </tbody>
                </table>
            </div>


            <!-- Pagination -->
            <div class="col-md-12 d-flex justify-content-end">
                {{ $clients->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>


    <div class="d-flex justify-content-end mt-3 gap-2">
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary equal-btn">Back</a>
        <a href="{{ route('admin.reports.clients.exportPDF', ['search' => request('search')]) }}" class="btn btn-danger equal-btn">Export All to PDF</a>
    </div>


    <style>
        body {
            font-family: 'Sf Pro display';
        }

        .client-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .title {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .input-group-custom {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .input-group-custom input[type="text"] {
            flex: 1;
            padding: 8px;
            font-size: 16px;
        }

        .input-group-custom button {
            padding: 8px 16px;
            font-size: 16px;
            background-color: royalblue;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .input-group-custom button:hover {
            background-color: #274caa;
        }

        .alert-info-custom {
            background-color: #e8f4fd;
            padding: 15px;
            border-left: 5px solid #007bff;
            color: #333;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .custom-table th,
        .custom-table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .custom-table thead {
            background-color: #F07324;
            color: white;
        }

        .highlight {
            background-color: #F9F8F2;
        }

        .view-btn {
            padding: 6px 12px;

            background-color: #90C6AA;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }


        .equal-btn {
            width: 150px;
            text-align: center;
            margin-right: 20px;
            margin-bottom: 20px;
        }

        .equal-btn {
            min-width: 140px;
            text-align: center;
        }

        .pagination-center {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }



        .search-form {
            display: flex;
            gap: 10px;
            align-items: center;
            max-width: 500px;
        }

        .search-form input[type="text"] {
            flex: 1;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        .search-form input[type="text"]:focus {
            border-color: #f07b20;
        }

        .search-form button {
            background-color: #f07b20;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .search-form button:hover {
            background-color: #d96812;
        }

        .export-link {
            color: #2e2e2e;
            font-weight: 500;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .export-link:hover {
            color: #f07b20;
            text-decoration: underline;
        }
    

       
    </style>



@endsection