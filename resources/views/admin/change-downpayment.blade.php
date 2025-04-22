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


        <h2 class="text-2xl font-bold mb-4">Edit Downpayment Percentage</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.change-downpayment.update') }}" method="POST" class="space-y-4">
            @csrf
            <label for="percentage" class="block font-semibold">Downpayment Percentage:</label>
            <input type="number" name="percentage" id="percentage" min="1" max="100" value="{{ $percentage }}"
                class="border p-2 rounded w-64">

            <button type="submit" class="btn-theme mt-2">Save</button>
        </form>
    </div>
@endsection