@extends('layouts.admin')

@section('content')
    <style>
        body {
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f8f9fa;
            color: #333;

        }

        h1.page-title {
            font-size: 2rem;
            font-weight: 600;
            color: #2e2e2e;
            margin-bottom: 30px;
            text-align: left;
            margin-top: 25px;

        }



        .form-control {
            border-radius: 8px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            padding: 0.5rem 1rem;
            font-size: 1rem;
            line-height: 1.5;
            border: 1px solid #ced4da;

        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05), 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        .form-control-file {
            padding-top: 8px;
        }

        .logo-upload-container {
            max-width: 400px;
            margin: 0 auto 30px auto;
            border: 2px dashed #ced4da;
            border-radius: 12px;
            padding: 25px 20px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .logo-container {
            width: 120px;
            height: 120px;
            border-radius: 8px;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            margin: 0 auto 15px auto;
            border: 1px solid #ddd;
        }

        .logo-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .custom-file-input-wrapper {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            font-size: 0.95rem;
            font-weight: 500;
            background-color: #F07324;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            overflow: hidden;
            transition: background-color 0.3s ease;
        }

        .custom-file-input-wrapper:hover {
            background-color: #d65f1e;
        }

        .custom-file-input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            height: 100%;
            width: 100%;
            cursor: pointer;
        }


        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            justify-content: center;
            width: 100%;
            text-align: center;

        }

        .submit-btn,
        .btn-secondary {
            background-color: #F07324;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            text-align: center;
            margin-bottom: 30px;
        }



        .submit-btn:hover {
            background-color: #d65f1e;
        }

        .btn-secondary {
            background-color: #6c757d;

        }


        .alert-danger {
            margin-top: 20px;
            border-radius: 6px;
            padding: 10px 15px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>

    <div class="container">
        <h1 class="page-title">Add Partner</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="company_owner">Company Owner</label>
                        <input type="text" name="company_owner" id="company_owner" class="form-control"
                            placeholder="Enter company owner's name" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="company_email">Company Email</label>
                        <input type="email" name="company_email" id="company_email" class="form-control"
                            placeholder="Enter company email" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-control"
                            placeholder="Enter company name" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="company_phone">Company Phone</label>
                        <input type="text" name="company_phone" id="company_phone" class="form-control"
                            placeholder="Enter company phone number" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="company_logo">Company Logo</label>
                <div class="logo-upload-container">
                    <div class="logo-container">
                        <img id="logoPreview" src="#" alt="Logo Preview" style="display: none;" />
                    </div>
                    <div class="custom-file-input-wrapper">
                        Choose Logo
                        <input type="file" name="company_logo" id="company_logo" class="custom-file-input" accept="image/*"
                            required onchange="previewLogo(event)">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="company_document">Company Document (PDF)</label>
                
                <div id="pdfPreview" style="margin-top: 10px; font-size: 0.9rem; color: #555;"></div>

                <div class="custom-file-input-wrapper">
                    Choose File
                    <input type="file" name="company_document" id="company_document" class="custom-file-input" accept=".pdf"
                        required onchange="previewPDF(event)">
                </div>
            </div>


            <div class="button-container">
                <button type="submit" class="submit-btn">Save Partner</button>
                <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        function previewLogo(event) {
            var output = document.getElementById('logoPreview');
            output.style.display = 'block';
            output.src = URL.createObjectURL(event.target.files[0]);
        }

        function previewPDF(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('pdfPreview');

            if (file && file.type === "application/pdf") {
                preview.innerHTML = `<i class="fas fa-file-pdf" style="color:#F07324; margin-right: 5px;"></i> ${file.name}`;
            } else {
                preview.textContent = "No valid PDF selected.";
            }
        }
    </script>

@endsection