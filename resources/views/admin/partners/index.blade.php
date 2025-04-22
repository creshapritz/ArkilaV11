@extends('layouts.admin')

@section('content')

    <section class="partners-ov">
       
        <div class="header-container">
            <h1>Partners Overview</h1>
            <a href="{{ route('admin.partners.create') }}" class="custom-btn">
                Add Partner
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

       
        <div class="partners">
            <table class="partnertbl">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company Owner</th>
                        <th>Company Email</th>
                        <th>Company Name</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($partners as $partner)
                        <tr>
                            <td>{{ $partner->id }}</td>
                            <td>{{ $partner->company_owner }}</td>
                            <td>{{ $partner->company_email }}</td>
                            <td>{{ $partner->company_name }}</td>
                          

                           
                            <td>
                                <span class="toggle-btn {{ $partner->status === 'Active' ? 'active' : 'inactive' }}"
                                    data-id="{{ $partner->id }}" style="cursor: pointer;">
                                    {{ $partner->status }}
                                </span>
                            </td>


                            <td>
                                <div class="action-icons">
                                    <a href="{{ route('admin.partners.show', $partner->id) }}" title="View">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <form action="{{ route('admin.partners.archive', $partner->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="archive" title="Archive"
                                            onclick="return confirm('Are you sure you want to archive this partner?')">
                                            <i class="bx bx-archive"></i>
                                        </button>
                                    </form>
                                    @if($partner->status === 'Archived')
                                        <form action="{{ route('admin.partners.unarchive', $partner->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="unarchive" title="Unarchive"
                                                onclick="return confirm('Are you sure you want to unarchive this partner?')">
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
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f4f6f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header-container {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .custom-btn {
            background-color: #F07324;
            margin-top: 15px;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .custom-btn:hover {
            background-color: #d65f1e !important;
            color: #fff !important;
            text-decoration: none;

        }


        .partners {
            width: 97%;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        h1 {
            font-size: 2rem;
            color: #2e2e2e;
            margin-left: 20px;
            padding-top: 20px;
            font-weight: 600;
        }


        .partnertbl {
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


        .client-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }


        .action-icons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
       
        .action-icons i:hover {
            color: #d65f1e;
            text-decoration: underline;
          
        }

        .action-icons a,
        .action-icons button {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 20px;
            color: #F07324;
            
            text-decoration: none;
        }

        .action-icons .archive i{
            color: #dc3545;
           
        }

        .action-icons .archive:hover {
            color: #dc3545;
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

        .btn-primary {
            display: inline-block;
            padding: 8px 12px;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.5;
            color: #fff;

            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #d65f1e !important;
            color: #fff !important;
            text-decoration: none;
        }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.toggle-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const partnerId = this.dataset.id;
                    const el = this;

                    fetch(`/admin/partners/${partnerId}/toggle-status`, {
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