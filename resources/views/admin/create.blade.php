@extends('layouts.admin')

@section('content')
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1 class="form-title mb-4 text-center">Create Admin Account</h1>


        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">

            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
            </div>


            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" class="form-control" placeholder="Enter first name" required>
            </div>

            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" class="form-control" placeholder="Enter last name" required>
            </div>

            <div class="form-group" id="company-name-group" style="display:none;">
                <label for="partner_id">Company</label>
                <select name="partner_id" class="form-control">
                    <option value="" disabled selected>Select company</option>
                    @foreach($partners as $partner)
                        <option value="{{ $partner->id }}">{{ $partner->company_name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group" id="company-phone-group" style="display:none;">
                <label for="company_phone">Phone Number</label>
                <input type="text" name="company_phone" class="form-control" placeholder="Enter phone number">
            </div>
            <div class="form-group" id="company-logo-group" style="display:none;">
                <label for="company_logo">Company Logo</label>
                <div class="custom-file-upload">
                    <label for="company_logo" class="upload-btn">Choose File</label>
                    <span id="company-logo-name" class="file-name">No file chosen</span>
                    <input type="file" id="company_logo" name="company_logo" accept="image/*" hidden>
                </div>
            </div>


            <div class="form-group" id="company-document-group" style="display:none;">
                <label for="company_document">Company Document</label>
                <div class="custom-file-upload">
                    <label for="company_document" class="upload-btn">Choose File</label>
                    <span id="company-document-name" class="file-name">No file chosen</span>
                    <input type="file" id="company_document" name="company_document"
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" hidden>
                </div>
            </div>









            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control" required>

                    <option value="" disabled selected>Select role</option>
                    <option value="admin">Super Admin</option>
                    <option value="staff">Staff</option>
                    <option value="partner">Partners</option>
                    <option value="driver">Drivers</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
        </form>

        <a href="{{ route('admin.index') }}" class="btn btn-secondary btn-block mt-3">Back to Admin List</a>
    </div>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'SF Pro Display';

        }

        .form-title {
            margin-top: 40px;

        }

        .container {
            max-width: 600px;

        }


        .form-group {
            margin-bottom: 20px;
        }

        .btn {

            height: 40px;
            font-size: 1rem;
        }

        .custom-file-upload {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .upload-btn {
            background-color: #F07324;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .upload-btn:hover {
            background-color: rgb(150, 72, 23);
        }

        .file-name {
            font-size: 0.9rem;
            color: #555;
            font-style: italic;
        }
    </style>
@endsection




@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.querySelector('select[name="role"]');
            const companyNameGroup = document.getElementById('company-name-group');
            const companyPhoneGroup = document.getElementById('company-phone-group');
            const companyLogoGroup = document.getElementById('company-logo-group');
            const companyDocumentGroup = document.getElementById('company-document-group');

            function toggleCompanyFields() {
                const selectedRole = roleSelect.value;

                if (selectedRole === 'partner') {
                    companyNameGroup.style.display = 'block';
                    companyPhoneGroup.style.display = 'block';
                    companyLogoGroup.style.display = 'block';
                    companyDocumentGroup.style.display = 'block';
                } else if (selectedRole === 'staff' || selectedRole === 'driver') {
                    companyNameGroup.style.display = 'block';
                    companyPhoneGroup.style.display = 'block';
                    companyLogoGroup.style.display = 'none';
                    companyDocumentGroup.style.display = 'none';
                } else {
                    companyNameGroup.style.display = 'none';
                    companyPhoneGroup.style.display = 'none';
                    companyLogoGroup.style.display = 'none';
                    companyDocumentGroup.style.display = 'none';
                }
            }

            roleSelect.addEventListener('change', toggleCompanyFields);
            toggleCompanyFields();
        });
        document.getElementById('company_logo').addEventListener('change', function () {
            const fileName = this.files[0]?.name || 'No file chosen';
            document.getElementById('company-logo-name').textContent = fileName;
        });

        document.getElementById('company_document').addEventListener('change', function () {
            const fileName = this.files[0]?.name || 'No file chosen';
            document.getElementById('company-document-name').textContent = fileName;
        });

    </script>
@endpush