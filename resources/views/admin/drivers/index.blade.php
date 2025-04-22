@extends('layouts.admin')

@section('content')
    <section class="drivers-ov">
        <div class="header-container">
            <h1>Drivers Overview</h1>
            <a href="{{ route('admin.drivers.create') }}" class="add-driver-btn"> Add Driver</a>
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="drivers">
            <table class="drivertbl">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Driver’s Name</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                        <th>Company Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drivers as $driver)
                        <tr>
                            <td>{{ $driver->id }}</td>
                            <td>
                                <span>{{ $driver->name }}</span>
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
                            <td>
                                <div class="action-icons">
                                    <a href="{{ route('admin.drivers.show', $driver->id) }}">
                                        <i class='bx bx-show'></i>
                                    </a>

                                    <form action="{{ route('admin.drivers.archive', $driver->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
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
    </section>

    <style>
        body {
            font-family: 'SF Pro Display';
            background-color: #f8f9fa;
        }

        .header-container {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 25px;
            color: #2e2e2e;
            padding-top: 20px;
            padding-left: 20px;
        }


        .add-driver-btn {
            background-color: #F07324;
            color: white;
            padding: 10px 15px;
            text-decoration: none !important;
            border-radius: 5px;
            font-size: 16px;
            padding-right: 20px;
        }

        .add-driver-btn:hover {
            background-color: #d65f1e;
            color: white;
            text-decoration: none !important;
        }


        .drivers {
            width: 97%;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        .drivertbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }


        table th {
            background-color: #F07324;
            color: white;
            padding: 15px;
            text-align: center;
        }


        table td {
            color: #333;
            font-size: 16px;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }


        table tr:nth-child(even) {
            background-color: #ffffff;
        }


        table tr:hover {
            background-color: #f1f1f1;
        }


        .action-icons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .action-icons a,
        .action-icons button {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 20px;
            color: #F07324;
            transition: color 0.3s ease;
        }

        .action-icons button:hover {
            color: red;
            text-decoration: underline;
        }

        .action-icons button i.bx-archive {
            color: red;
        }

        .action-icons button:hover i.bx-archive {
            text-decoration: underline;
        }

        .toggle-btn {
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s ease;

            display: inline-block;
        }

        .toggle-btn.active {
            background: #28a745;
            color: white;
        }

        .toggle-btn.inactive {
            background: #dc3545;
            color: white;
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