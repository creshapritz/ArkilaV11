@extends('layouts.admin')

@section('content')
    <h1>Edit Admin</h1>
    <form action="{{ route('admin.update', $admin->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>First Name:</label>
        <input type="text" name="firstname" value="{{ $admin->firstname }}" required>

        <label>Last Name:</label>
        <input type="text" name="lastname" value="{{ $admin->lastname }}" required>

        <label>Role:</label>
        <input type="text" name="role" value="{{ $admin->role }}" required>

        <label>Status:</label>
        <select name="status" required>
            <option value="1" {{ $admin->status ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !$admin->status ? 'selected' : '' }}>Inactive</option>
        </select>

        <button type="submit">Update Admin</button>
    </form>

    <a href="{{ route('admin.accounts') }}">Back</a>
@endsection
