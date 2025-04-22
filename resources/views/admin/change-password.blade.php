@extends('layouts.admin-settings')

@section('content')
    <div class="container mt-4">
        <h3>Change Password</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ implode('', $errors->all(':message')) }}
            </div>
        @endif

        <form action="{{ route('admin.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Password</button>
            <a href="{{ route('admin.admin-settings') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection