<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
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

        @page {
            size: A4 landscape;
            margin: 20mm;
        }

        h1, h2, h3 {
            text-align: center;
            color: #333;
        }

        .report-header {
            margin-bottom: 30px;
            text-align: center;
            padding: 20px;
        }

        .report-header h1 {
            font-size: 24px;
            margin: 0;
            color: #F07424; /* Accent color */
        }

        .report-header p {
            font-size: 12px;
            margin: 5px 0;
        }

        .report-header h3 {
            font-size: 18px;
            margin-top: 10px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            font-size: 12px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #F07424; 
            color: white;
            font-weight: bold;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        .total {
            font-weight: bold;
            text-align: right;
            font-size: 14px;
            margin-top: 20px;
        }

        

        .footer p {
            margin: 5px 0;
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

    <div class="report-header">
        
        <h1>ARKILA SALES REPORT</h1>
        <p>Sumulong St., Brgy. San Pedro, Angono, Rizal</p>
        <p>Email: arkilacarrental123@gmail.com | Phone: (02) 123-4567</p>
       
        @if($from && $to)
            <p>Period: {{ \Carbon\Carbon::parse($from)->format('F j, Y') }} to {{ \Carbon\Carbon::parse($to)->format('F j, Y') }}</p>
        @endif
    </div>
    <div class="header">
      
        <div class="date">Generated on: {{ \Carbon\Carbon::now()->format('F j, Y - h:i A') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Car</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->client->first_name ?? 'N/A' }} {{ $booking->client->last_name ?? '' }}</td>
                    <td>{{ $booking->car->name ?? 'N/A' }}</td>
                    <td>{{ $booking->created_at->format('M d, Y') }}</td>
                    <td>PHP {{ number_format($booking->amount, 2) }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Total Revenue: PHP {{ number_format($totalRevenue, 2) }}</p>

    <div class="footer">
        ARKILA • {{ \Carbon\Carbon::now()->year }}
    </div>
  
</body>
</html>
