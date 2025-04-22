@extends('layouts.partners_admin')

@section('content')
    <section class="drivers-overview-section">
        <div class="container">
            <div class="header-container">
                <h1 class="main-title">Drivers Overview</h1>
                <a href="{{ route('partners_admin.drivers.create') }}" class="add-driver-btn">Request to Add New Driver</a>

            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="drivers-table-wrapper">
                <table class="drivers-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Driver’s Name</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Company Name</th>
                            <th>Status</th>
                            <th class="action-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($drivers as $driver)
                            <tr>
                                <td>{{ $driver->id }}</td>
                                <td>
                                    <div class="driver-info">
                                        <span>{{ $driver->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $driver->contact_number }}</td>
                                <td>{{ $driver->email }}</td>
                                <td>{{ $driver->company_name ?? 'N/A' }}</td>
                                <td>
                                    <span class="toggle-btn {{ $driver->status === 'Active' ? 'active' : 'inactive' }}"
                                        data-id="{{ $driver->id }}" style="cursor: pointer;">
                                        {{ $driver->status }}
                                    </span>
                                </td>
                                <td class="action-column">
                                    <div class="action-icons">
                                        <a href="{{ route('partners_admin.drivers.show', $driver->id) }}" class="view-icon">
                                            <i class='bx bx-show'></i>
                                        </a>
                                        <form action="{{ route('partners_admin.drivers.archive', $driver->id) }}" method="POST" class="archive-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="archive-button"
                                                onclick="return confirm('Are you sure you want to archive this driver?')">
                                                <i class='bx bx-archive'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <style>
        body {
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f4f6f8;
            color: #2e2e2e;
           
        }

        .drivers-overview-section {
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

        .add-driver-btn {
            background-color: #f97316;
            color: white;
            padding: 12px 20px;
            text-decoration: none !important;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .add-driver-btn:hover {
            background-color: #d65f1e;
            text-decoration: none !important;
            color: #fff;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #1a5e41;
            border: 1px solid #a7f3d0;
        }

        .drivers-table-wrapper {
            overflow-x: auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .drivers-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .drivers-table th {
            background-color: #f97316;
            color: white;
            padding: 12px 15px;
            text-align: center;
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .drivers-table td {
            color: #4a5568;
            font-size: 0.95rem;
            padding: 12px 15px;
            border-bottom: 1px solid #edf2f7;
            text-align: center;
        }

        .drivers-table tr:last-child td {
            border-bottom: none;
        }

        .drivers-table tbody tr:hover {
            background-color: #f7fafc;
        }

        .driver-info {
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: center;
        }

        .action-column {
            text-align: center;
        }

        .action-icons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }

        .view-icon,
        .archive-button {
            background: none;
            border: none;
            cursor: pointer;
            outline: none;
            display: flex;
            align-items: center;
            color: #f97316; 
            transition: color 0.3s ease;
        }

        .view-icon:hover {
            color: #d65f1e;
            text-decoration: underline;
        }

        .archive-button {
            color: #dc2626;
        }

        .archive-button:hover {
            color: #b91c1c;
            text-decoration: underline;
        }

        .view-icon i,
        .archive-button i {
            font-size: 20px;
        }

        .toggle-btn {
            padding: 8px 12px;
            font-size: 0.9rem;
            font-weight: bold;
            border: none;
            cursor: pointer;
            border-radius: 6px;
            transition: background 0.3s ease;
            display: inline-block;
            text-align: center;
            min-width: 80px;
        }

        .toggle-btn.active {
            background: #28a745;
            color: white;
        }

        .toggle-btn.inactive {
            background: #dc3545;
            color: white;
        }

        .no-clients { 
            color: #718096;
            font-size: 1rem;
            padding: 20px;
            text-align: center;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header-container {
                margin-bottom: 20px;
                padding-bottom: 15px;
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .main-title {
                font-size: 2rem;
            }

            .add-driver-btn {
                font-size: 0.85rem;
                padding: 10px 15px;
            }

            .drivers-table th,
            .drivers-table td {
                padding: 8px 10px;
                font-size: 0.85rem;
            }

            .action-icons {
                gap: 10px;
            }

            .view-icon i,
            .archive-button i {
                font-size: 18px;
            }
        }
    </style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const driverId = this.dataset.id;
                const el = this;

                fetch(`/admin/drivers/${driverId}/toggle-status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    el.textContent = data.status;
                    el.classList.remove('active', 'inactive');
                    el.classList.add(data.status === 'Active' ? 'active' : 'inactive');
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Failed to update status.');
                });
            });
        });
    });
</script>

@endsection