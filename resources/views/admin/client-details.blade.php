@extends('layouts.admin')

@section('content')
    <style>
        body {
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f3f4f6;

        }

        .header-container h1 {
            font-size: 2rem;
            color: #2e2e2e;
            margin-bottom: 20px;
            padding: 30px;
            font-weight: 600;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: grid;
            gap: 30px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 25px;
        }



        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            font-size: 1.5rem;
            color: #2e2e2e;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .text-muted {
            color: #2e2e2e !important;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }


        .card h3 {
            font-size: 1.3rem;
            color: #2e2e2e;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .document-item {
            text-align: center;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 15px;
            border-radius: 8px;
            transition: transform 0.2s ease-in-out;
        }

        .document-item:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .document-item img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 10px;
        }

        .document-item .title {
            font-size: 1rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #F07324;
            color: #ffffff;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease-in-out;
            margin-bottom: 25px;
            margin-left: 25px;
        }

        .back-btn:hover {
            background-color: #d65f1e;
            text-decoration: none;
            color: #ffffff;
        }


        @media (max-width: 992px) {
            .container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 20px;
            }

            .header-container h1 {
                font-size: 1.8rem;
            }

            section {
                padding: 20px;
            }
        }

        .status-badge {
            padding: 6px 30px;
            margin-right: 30px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }

        .status-badge.verified {
            background-color: #4CAF50;

        }

        .status-badge.pending {
            background-color: #FFC107;

        }

        .status-btn {
            padding: 10px 20px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .status-btn.verified {
            background-color: #4CAF50;
        }

        .status-btn.pending {
            background-color: #FFC107;
        }

        .status-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .status-btn {
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            margin-right: 10px;
        }

        .status-btn.verified {
            background-color: #28a745;
            color: white;
        }

        .status-btn.pending {
            background-color: #ffc107;
            color: black;
        }

        .status-btn.danger {
            background-color: #dc3545;
            color: white;
        }

        .status-btn.success {
            background-color: #17a2b8;
            color: white;
        }
    </style>

    <section>
        <div class="header-container" style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Client Details</h1>
            @if($client->status === 'verified')
                <span class="status-badge verified">Verified</span>
            @else
                <span class="status-badge pending">Pending</span>
            @endif
        </div>

        <div class="container">
            <div class="card">
                <div style="text-align: center;">
                    @if($client->profile_picture)
                        <img src="{{ asset($client->profile_picture) }}" alt="Profile Picture" class="profile-img">
                    @else
                        <img src="{{ asset('path/to/default/profile.png') }}" alt="No Profile Picture" class="profile-img">
                    @endif
                    <div class="grid">
                        <p><strong>Full Name:</strong> {{ $client->first_name }} {{ $client->middle_name }}
                            {{ $client->last_name }} {{ $client->extension_name }}
                        </p>
                        <p><strong>Age:</strong> {{ $client->age }}</p>
                        <p><strong>Date of Birth:</strong> {{ $client->dob }}</p>
                        <p><strong>Username:</strong> {{ $client->username }}</p>
                        <p><strong>Address:</strong> {{ $client->address }}</p>
                        <p><strong>Email:</strong> {{ $client->email }}</p>
                        <p><strong>Contact Number:</strong> {{ $client->contact_number }}</p>
                        <p><strong>Emergency Contact:</strong> {{ $client->emergency_contact }}</p>
                        <p><strong>Relationship:</strong> {{ $client->emergency_contact_relationship }}</p>
                        <p><strong>Driver License Type:</strong> {{ $client->driver_license_type }}</p>
                        <p><strong>Service Type:</strong> {{ $client->service_type }}</p>
                    </div>
                </div>
            </div>





            <div class="card">
                <form id="verifyClientForm" action="{{ route('admin.verify.client', $client->id) }}" method="POST"
                    style="display: none;">
                    @csrf
                </form>




                <h3>Client Documentations</h3>
                <div style="display: flex; justify-content: flex-end; margin: 20px 0;">
                    @if($client->status == 'verified')
                        <button class="status-btn verified" disabled> Verified</button>
                    @else
                        <button id="verifyClient" class="status-btn pending"> Verify Client</button>
                    @endif




                    @if($client->status === 'blocked')
                        <form id="unblockClientForm" action="{{ route('admin.unblock.client', $client->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            <button type="submit" class="status-btn success">Unblock Client</button>
                        </form>
                    @else
                        <form id="blockClientForm" action="{{ route('admin.block.client', $client->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            <button type="submit" class="status-btn danger">Block Client</button>
                        </form>
                    @endif

                </div>

                <div class="grid">
                    @if ($client->front_license)
                        <div class="document-item">
                            <h4 class="title">Driver License FRONT</h4>
                            <img src="{{ asset($client->front_license) }}" alt="Front License">


                        </div>
                    @endif
                    @if ($client->back_license)
                        <div class="document-item">
                            <h4 class="title">Driver License BACK</h4>
                            <img src="{{ asset($client->back_license) }}" alt="Back License">
                        </div>
                    @endif
                    @if ($client->front_first_id)
                        <div class="document-item">
                            <h4 class="title">{{ $client->first_id_type }} FRONT</h4>
                            <img src="{{ asset($client->front_first_id) }}" alt="First ID Front">
                        </div>
                    @endif
                    @if ($client->back_first_id)
                        <div class="document-item">
                            <h4 class="title">{{ $client->first_id_type }} BACK</h4>
                            <img src="{{ asset($client->back_first_id) }}" alt="First ID Back">
                        </div>
                    @endif
                    @if ($client->front_second_id)
                        <div class="document-item">
                            <h4 class="title">{{ $client->second_id_type }} FRONT</h4>
                            <img src="{{ asset($client->front_second_id) }}" alt="Second ID Front">
                        </div>
                    @endif
                    @if ($client->back_second_id)
                        <div class="document-item">
                            <h4 class="title">{{ $client->second_id_type }} BACK</h4>
                            <img src="{{ asset($client->back_second_id) }}" alt="Second ID Back">
                        </div>
                    @endif
                    @if ($client->driver_front_second_id)
                        <div class="document-item">
                            <h4 class="title">Driver Secondary ID FRONT</h4>
                            <img src="{{ asset($client->driver_front_second_id) }}" alt="Driver 2nd ID Front">
                        </div>
                    @endif
                    @if ($client->driver_back_second_id)
                        <div class="document-item">
                            <h4 class="title">Driver Secondary ID BACK</h4>
                            <img src="{{ asset($client->driver_back_second_id) }}" alt="Driver 2nd ID Back">
                        </div>
                    @endif
                    @if ($client->proof_of_billing)
                        <div class="document-item">
                            <h4 class="title">{{ $client->proof_of_billing_type }}</h4>
                            <img src="{{ asset($client->proof_of_billing) }}" alt="Proof of Billing">
                        </div>
                    @endif
                    @if ($client->driver_proof_of_billing)
                        <div class="document-item">
                            <h4 class="title">Driver Proof of Billing</h4>
                            <img src="{{ asset($client->driver_proof_of_billing) }}" alt="Driver Billing">
                        </div>
                    @endif
                </div>
            </div>




        </div>

        <a href="{{ route('admin.clients') }}" class="back-btn">Back</a>
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById('verifyClient')?.addEventListener('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Once verified, this client cannot be unverified!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F07324',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, verify it!',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        document.getElementById('verifyClientForm').submit();
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                });
            });

            document.getElementById('blockClientForm')?.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to block this client!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, block!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

            document.getElementById('unblockClientForm')?.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Unblock client?',
                    text: "They will be able to log in again.",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, unblock!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        </script>
    @endpush


@endsection