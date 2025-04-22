<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Driver Report - ARKILA</title>
    <style>
        @page {
            margin: 50px 40px;
            size: A4 landscape;
            margin: 20mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #2e2e2e;
        }

        header {
            position: fixed;
            top: -40px;
            left: 0;
            right: 0;
            text-align: center;
            line-height: 1.3;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #F07324;
        }
        .header .date {
            font-size: 11px;
            color: #333;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 11px;
            color: #555;
        }

        .content {
            margin-top: 80px;
        }

        .filters {
            margin-bottom: 15px;
        }

        .filters span {
            display: inline-block;
            margin-right: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #F07324;
            color: #fff;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f7f7f7;
        }

        td {
            font-size: 13px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #888;
        }
    </style>
</head>
<body>


<div class="header">
        <h2>Driver Earnings & Bookings Report</h2>
        <div class="date">Generated on: {{ \Carbon\Carbon::now()->format('F j, Y - h:i A') }}</div>
    </div>



<div class="content">
    <div class="filters">
        @if(request('company'))
            <span>Company: {{ \App\Models\Partner::find(request('company'))->company_name ?? 'N/A' }}</span>
        @endif
        @if(request('from'))
            <span>From: {{ \Carbon\Carbon::parse(request('from'))->format('F d, Y') }}</span>
        @endif
        @if(request('to'))
            <span>To: {{ \Carbon\Carbon::parse(request('to'))->format('F d, Y') }}</span>
        @endif
    </div>

    @if($drivers->isEmpty())
        <p>No driver data available for this report.</p>
    @else
        <table>
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
                @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $driver['name'] }}</td>
                        <td>{{ $driver['company_name'] ?? 'N/A' }}</td>
                        <td>{{ $driver['total_bookings'] }}</td>
                        <td>₱{{ number_format($driver['total_earnings'], 2) }}</td>
                        <td>{{ $driver['last_booking'] ? \Carbon\Carbon::parse($driver['last_booking'])->format('Y-m-d H:i') : 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="footer">
        ARKILA • {{ \Carbon\Carbon::now()->year }}
    </div>

</body>
</html>
