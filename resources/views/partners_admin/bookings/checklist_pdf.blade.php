<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $booking->car->company_name ?? 'Partner' }} - Vehicle Return Checklist</title>
    <style>
        @page {
            margin: 100px 40px 100px 40px;

        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 80px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }

       

        header h1 {
            font-size: 20px;
            margin: 0;
        }

        footer {
            position: fixed;
            bottom: -70px;
            left: 0;
            right: 0;
            height: 70px;
            font-size: 12px;
            text-align: center;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        h2 {
            text-align: center;
            margin: 20px 0 40px 0;
            font-size: 22px;
            text-transform: uppercase;
        }

        h3 {
            font-size: 16px;
            margin-top: 30px;
            margin-bottom: 10px;
            padding-bottom: 4px;
            border-bottom: 1px solid #ccc;
        }

        .info-group {
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 6px;
            font-size: 14px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin-top: 10px;
        }

        li {
            margin: 8px 0;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .checkbox {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 1px solid #555;
            margin-right: 10px;
            vertical-align: middle;
        }

        .signature-block {
            margin-top: 40px;
            font-size: 14px;
        }

        .line {
            border-top: 1px dashed #aaa;
            margin: 30px 0;
        }
    </style>
</head>
<body>

   
    <header>
      
        <h1>{{ $booking->car->company_name ?? 'Partner Company' }}</h1>
    </header>

   
    <footer>
        {{ $booking->car->company_name ?? 'Partner Company' }}
    </footer>

    <main>
        <h2>Vehicle Return Checklist</h2>

        <div class="info-group">
            <div class="info"><strong>Customer Name:</strong> {{ $booking->client->first_name ?? 'N/A' }} {{ $booking->client->middle_name ?? '' }} {{ $booking->client->last_name ?? 'N/A' }}</div>
            <div class="info"><strong>Reservation Number:</strong> {{ $booking->id }}</div>
            <div class="info"><strong>Vehicle Type:</strong> {{ $booking->car->brand ?? 'N/A' }}</div>
            <div class="info"><strong>Plate Number:</strong> {{ $booking->car->platenum ?? 'N/A' }}</div>
            <div class="info"><strong>Return Date:</strong> {{ \Carbon\Carbon::now()->format('Y-m-d') }}</div>
            <div class="info"><strong>Return Time:</strong> {{ \Carbon\Carbon::now()->format('h:i A') }}</div>
        </div>

        @php
            $sections = [
                'Vehicle Exterior Condition' => [
                    'No visible dents, scratches, or damages',
                    'Clean exterior',
                    'All side mirrors and lights intact',
                    'Windshield and windows in good condition',
                ],
                'Vehicle Interior Condition' => [
                    'Clean seats, carpets, and dashboard',
                    'No stains, tears, or damages',
                    'All controls and electronics are functioning',
                    'No personal belongings left behind',
                ],
                'Fuel and Mileage' => [
                    'Fuel level returned as per policy (Full/Half/Empty)',
                    'Mileage recorded: ___________________',
                    'No unusual mileage reported',
                ],
                'Tires and Spare' => [
                    'Tires in good condition (No punctures or wear)',
                    'Spare tire available and in good condition',
                    'Tools (Jack, wrench) provided and intact',
                ],
                'Accessories and Equipment' => [
                    'Car manual and registration papers present',
                    'Spare key returned',
                    'Dashboard items (e.g., GPS, infotainment) working',
                    'First aid kit and emergency tools available',
                ],
                'Additional Checks' => [
                    'No warning lights on dashboard',
                    'No unusual engine noises',
                    'Air conditioning and heating systems working',
                    'Car returned on time',
                ],
            ];
        @endphp

        @foreach ($sections as $title => $items)
            <h3>{{ $title }}</h3>
            <ul>
                @foreach ($items as $item)
                    <li>
                        <div class="checkbox"></div> {{ $item }}
                    </li>
                @endforeach
            </ul>
        @endforeach

        <div class="signature-block">
            <h3>Customer Acknowledgement</h3>
            <p>I confirm the vehicle was returned in the stated condition.</p>
            <p>Signature: _____________________________</p>
            <p>Date: ____________________________________</p>
        </div>

        <div class="line"></div>

        <div class="signature-block">
            <h3>Staff Verification</h3>
            <p>Signature: _____________________________</p>
            <p>Name: ____________________________________</p>
        </div>
    </main>
</body>
</html>
