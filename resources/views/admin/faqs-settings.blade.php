@extends('layouts.admin-settings')

@section('content')
    <div class="flex-grow-1 p-4">
        <h5 class="fw-bold">Company Management</h5>

        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.companyManagement') ? 'active' : '' }}"
                    href="{{ route('admin.companyManagement') }}">Company Logo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.admin-company-name') ? 'active' : '' }}"
                    href="{{ route('admin.admin-company-name') }}">Company Name</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.faqs.index') ? 'active' : '' }}"
                    href="{{ route('admin.faqs.index') }}">FAQS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.about-us-settings') ? 'active' : '' }}"
                    href="{{ route('admin.about-us-settings') }}">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.media-settings') ? 'active' : '' }}"
                    href="{{ route('admin.media-settings') }}">Media Settings</a>
            </li>
        </ul>
        <h5 class="fw-bold">Manage FAQs</h5>

        <form action="{{ route('admin.faqs.update') }}" method="POST">
            @csrf
            @method('PUT')

            @foreach ($faqs as $index => $faq)
                <div class="mb-4 border p-3 rounded">
                    <div class="form-group mb-2">
                        <label for="question_{{ $index }}">Question</label>
                        <input type="text" class="form-control" name="faqs[{{ $faq->id }}][question]"
                            value="{{ $faq->question }}">
                    </div>

                    <div class="form-group">
                        <label for="answer_{{ $index }}">Answer</label>
                        <textarea class="form-control" rows="3"
                            name="faqs[{{ $faq->id }}][answer]">{{ $faq->answer }}</textarea>
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-warning">Save Changes</button>
        </form>
    </div>
@endsection