@extends ('layouts.admin-settings')

@section('content')
    <div class="flex-grow-1 p-4">
        <h5 class="fw-bold">Payment Settings</h5>

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.change-downpayment') ? 'active' : '' }}"
                    href="{{ route('admin.change-downpayment') }}">
                    Change Down Payment Percentage
                </a>
            </li>
        </ul>


        <div class="form-container">
    <h2 class="form-title">Edit Downpayment Percentage</h2>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.change-downpayment.update') }}" method="POST" class="form-content">
        @csrf
        <label for="percentage" class="form-label">Downpayment Percentage:</label>
        <input type="number" name="percentage" id="percentage" min="1" max="100" value="{{ $percentage }}"
               class="form-input" required>

        <button type="submit" class="btn-primary">Save</button>
    </form>
</div>
<style>
    .form-container {
    background-color: #fff;
    padding: 2rem;
    border-radius: 8px;
    max-width: 500px;
    margin: 2rem auto;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.form-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: #2c3e50;
}

.alert-success {
    background-color: #e8f9e9;
    color: #2e7d32;
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1.25rem;
    font-weight: 500;
}

.form-label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #34495e;
}

.form-input {
    width: 100%;
    padding: 0.75rem;
    border-radius: 0.5rem;
    border: 1px solid #ced4da;
    font-size: 1rem;
    transition: all 0.3s ease-in-out;
}

.form-input:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.btn-primary {
    margin-top: 1rem;
    background-color: #F07324;;
    color: #fff;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #F07324;;
}

</style>
@endsection