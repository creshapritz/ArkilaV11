@extends('layouts.partners_admin')

@section('content')
    <div class="change-password-container">
        <div class="modern-card">
            <div class="card-header">
                <h2>Change Temporary Password</h2>
                <div class="important-note">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Important:</span> Change your password immediately after login to set a permanent password, then
                    log in again.
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('partner_admin.updatePassword') }}">
                    @csrf
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password" class="form-control" required
                            placeholder="Enter your new password">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                            required placeholder="Confirm your new password">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Update Password</button>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    .change-password-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;

        margin-top: 80px;
        padding: 20px;
    }

    .modern-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        overflow: hidden;
    }

    .card-header {
        background-color: #343a40;
        color: #fff;
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .card-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .important-note {
        background-color: #ffeeba;
        color: #85640a;
        padding: 10px;
        border-radius: 5px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .important-note i {
        font-size: 1.1rem;
    }

    .card-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #495057;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        font-size: 1rem;
        box-sizing: border-box;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: none;
    }

    .btn-primary {
        background-color: #F07324;
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
        width: 100%;
    }

    .btn-primary:hover {
        background-color:rgb(158, 76, 25);
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">