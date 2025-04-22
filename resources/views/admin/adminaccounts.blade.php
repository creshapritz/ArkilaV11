@extends('layouts.admin')

@section('content')

    <section class="admin-ov">

        <div class="header-container">
            <h1>Admin Accounts</h1>
            <a href="{{ route('admin.create') }}" class="btn btn-primary custom-btn">
                Add Admin
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        <div class="admin-table">
            <table class="admintbl">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>

                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->firstname }}</td>
                            <td>{{ $admin->lastname }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->role }}</td>

                            <td>
                                <form action="{{ route('admin.toggleStatus', $admin->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="toggle-btn {{ $admin->status == 'Active' ? 'active' : 'inactive' }}">
                                        {{ $admin->status }}
                                    </button>
                                </form>
                            </td>

                            <td>
                                <div class="action-icons">
                                    <a href="{{ route('admin.show', $admin->id) }}">
                                        <i class="bx bx-show"></i>
                                    </a>



                                    @if($admin->status !== 'Archived')
                                        <form action="{{ route('admin.archive', $admin->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to archive this admin?')">
                                                <i class="bx bx-archive"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.unarchive', $admin->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to unarchive this admin?')">
                                                <i class="bx bx-refresh"></i>
                                            </button>
                                        </form>
                                    @endif
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
        .custom-btn{
            padding: 10px 20px !important;
        }

        .header-container {
            margin-top: 20px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-right: 40px;
        }


        .admin-table {
            width: 97%;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }


        h1 {
            padding-left: 20px;
            font-size: 2rem;
            color: #2e2e2e;
            font-weight: 600;
            margin-bottom: 20px;
        }



        .admintbl {
            background-color: #ffffff;
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


        .status {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .status.active {
            background-color: #28a745;
            color: white;
        }

        .status.archived {
            background-color: #dc3545;
            color: white;
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
        }

        .action-icons button:hover {
            color: red;
        }


        .toggle-btn {
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .toggle-btn.active {
            background: #28a745;
            color: white;
        }

        .toggle-btn.inactive {
            background: #dc3545;
            color: white;
        }

        .action-icons form button i.bx-archive {
            color: red;
        }

        .action-icons form button i.bx-archive:hover {
            text-decoration: underline;
        }
    </style>

@endsection