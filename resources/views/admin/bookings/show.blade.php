@extends('layouts.admin')

@section('content')
    <style>
        .container {
            padding: 30px;
            max-width: 960px;
            margin: 20px auto;
            font-family: 'Sf Pro display'
        }

        
        .mb-4 {
            margin-bottom: 2.5rem;
         
        }

      
        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        
            border: 1px solid #e0e0e0;
       
            padding: 25px;
            
        }

      
        .d-flex {
            display: flex;
            align-items: center;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .justify-content-end {
            justify-content: flex-end;
        }

        
        .mb-3 {
            margin-bottom: 1.25rem;
        }

        .mt-4 {
            margin-top: 2rem;
        }

        .mb-0 {
            margin-bottom: 0;
        }

      
        h2 {
            color: #333;
            font-size: 2rem;
            font-weight: 600;
        }

        h4 {
            color: #555;
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 10px;
        }

      
        .badge {
            display: inline-block;
            padding: 0.6rem 1rem;
            border-radius: 0.5rem;
         
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
       
            letter-spacing: 0.5px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .bg-success {
            background-color: #4CAF50;
        
            color: #fff;
        }

        .bg-info {
            background-color: #2196F3;
       
            color: #fff;
        }

        .bg-warning {
            background-color: #FF9800;
    
            color: #fff;
        }

        .bg-danger {
            background-color: #F44336;
          
            color: #fff;
        }

     
        hr {
            margin: 1.5rem 0;
            border-top: 1px solid #ddd;
       }

    
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .col-md-6 {
            flex: 1 0 calc(50% - 10px);
       
            padding-right: 10px;
            margin-bottom: 10px;
           
            box-sizing: border-box;
        }

        p {
            line-height: 1.6;
            color: #666;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        strong {
            color: #333;
            font-weight: 600;
        }

     
        .btn-outline-primary {
            background-color: transparent;
            border: 2px solid #F07324;
            color: #F07324;
            border-radius: 0.5rem;
            padding: 0.8rem 1.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
            display: inline-block;
            margin-top: 1.5rem;
        }

        .btn-outline-primary:hover {
            background-color: #F07324;
            color: #fff;
            border-color: #F07324;
            box-shadow: 0 2px 6px rgba(240, 115, 36, 0.2);
            
        }

 
        .btn-secondary {
            background-color: #f2f2f2;
            color: #555;
            border: 1px solid #ddd;
            padding: 0.7rem 1.4rem;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #e0e0e0;
            color: #333;
            border-color: #ccc;
        }

        .gpsbtn {
            background-color: #f2f2f2;
            color: #555;
            border: 1px solid #ddd;
            width: 200px;
            padding: 0.7rem 2rem;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            text-decoration: none;
            justify-content: center;

        }
        .gpsbtn:hover{
            background-color: #e0e0e0;
            color: #333;
            border-color: #ccc;
            text-decoration: none;
           
        }

       
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            h2 {
                font-size: 1.75rem;
            }

            h4 {
                font-size: 1.3rem;
            }

            .row {
                flex-direction: column;
              
            }

            .col-md-6 {
                flex: 0 0 100%;
                padding-right: 0;
                margin-bottom: 15px;
            }

            .badge {
                font-size: 0.8rem;
                padding: 0.5rem 0.8rem;
            }

            .btn-outline-primary,
            .btn-secondary {
                font-size: 0.9rem;
                padding: 0.6rem 1.2rem;
            }
        }
    </style>
    <div class="container">
        <h2 class="mb-4">Booking Details</h2>

        <div class="card">
            <div class="d-flex justify-content-between mb-3">
                <h4 class="mb-0">Booking #{{ $booking->id }}</h4>
                <span class="badge
                    {{
        $booking->status == 'Paid' ? 'bg-success' :
        ($booking->status == 'Returned' ? 'bg-info' :
            ($booking->status == 'Cancelled' ? 'bg-danger' : 'bg-warning'))
                    }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Client:</strong> {{ $booking->client->username ?? 'N/A' }}</p>
                    <p><strong>Car:</strong> {{ $booking->car->brand ?? 'N/A' }} -
                        {{ $booking->car->company_name ?? 'N/A' }}
                    </p>
                    <p><strong>Amount:</strong> ₱{{ number_format($booking->amount, 2) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Pickup Location:</strong> {{ $booking->pickup_location }}</p>
                    <p><strong>Dropoff Location:</strong> {{ $booking->dropoff_location }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Pickup Date & Time:</strong><br>
                        {{ \Carbon\Carbon::parse($booking->pickup_date . ' ' . $booking->pickup_time)->format('F j, Y g:i A') }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Dropoff Date & Time:</strong><br>
                        {{ \Carbon\Carbon::parse($booking->dropoff_date . ' ' . $booking->dropoff_time)->format('F j, Y g:i A') }}
                    </p>
                </div>
            </div>

            <!-- <a href="{{ route('admin.bookings.gps-tracking', $booking->id) }}" class="gpsbtn">
                View GPS Tracking
            </a> -->

            <div class="mt-4 d-flex justify-content-end">
                <button onclick="window.history.back()" class="btn-secondary">Back</button>
            </div>
        </div>
    </div>
@endsection