@extends('layouts.admin-settings')

@section('content')
    <div class="flex-grow-1 p-4">
        <h5 class="fw-bold">Back up & Restore</h5>

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.backup-restore') ? 'active' : '' }}"
                    href="{{ route('admin.backup-restore') }}">Back up & Restore</a>
            </li>
        </ul>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Backup Data</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($backups as $backup)
                    <tr>
                        <!-- Display the backup type, capitalized -->
                        <td>{{ ucfirst($backup->type) }}</td>

                        <!-- Display the backup data in a readable format (assuming it's an array or object) -->
                        <td>
                            @if(is_array($backup->data) || is_object($backup->data))
                                <!-- If it's an array or object, iterate over it and display each key-value pair -->
                                <ul>
                                    @foreach($backup->data as $key => $value)
                                        <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <!-- If it's a string or something else, just display it directly -->
                                <p>{{ $backup->data }}</p>
                            @endif
                        </td>

                        <td>
                            <!-- Restore Backup Form -->
                            <form action="{{ route('admin.restore.backup', $backup->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-theme py-1 px-3 rounded">Restore</button>
                            </form>

                            <!-- Delete Backup Form -->
                            <form action="{{ route('admin.delete.backup', $backup->id) }}" method="POST" style="display:inline;"
                                onsubmit="return confirm('Are you sure you want to delete this backup?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection