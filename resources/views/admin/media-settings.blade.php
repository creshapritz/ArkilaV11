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

        <h2 class="text-2xl font-bold mb-4">Change Media</h2>

        <form action="{{ route('admin.settings.updateMedia') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Welcome Background Video Section -->
            <div style="margin-bottom: 30px;">
                <label for="welcome_video" class="fw-bold">Welcome Background Video:</label><br>
                <div style="text-align: center; margin-top: 10px;">
                    @if($videoPath)
                        <video id="video-preview" width="640" height="360" controls style="display:block; margin: 0 auto;">
                            <source src="{{ asset($videoPath) }}" type="video/mp4">
                        </video>
                    @else
                        <video id="video-preview" width="640" height="360" controls
                            style="display:none; margin: 0 auto;"></video>
                    @endif
                </div>
                <input type="file" name="welcome_video" accept="video/mp4" class="form-control mt-2">
            </div>

            <!-- Ads Banner Image Section -->
            <div style="margin-bottom: 30px;">
                <label for="ads_banner" class="fw-bold">Ads Banner Image:</label><br>
                <div style="text-align: center; margin-top: 10px;">
                    @if($bannerPath)
                        <img id="banner-preview" src="{{ asset($bannerPath) }}" alt="Current Banner" width="640"
                            style="display:block; margin: 0 auto;">
                    @else
                        <img id="banner-preview" alt="Banner Preview" width="640" style="display:none; margin: 0 auto;">
                    @endif
                </div>
                <input type="file" name="ads_banner" accept="image/*" class="form-control mt-2">
            </div>

            <!-- Footer Video Section -->
            <div style="margin-bottom: 30px;">
                <label for="footer_video" class="fw-bold">Footer Video:</label><br>
                <div style="text-align: center; margin-top: 10px;">
                    @if($footervideoPath)
                        <video id="footer-video-preview" width="640" height="360" controls
                            style="display:block; margin: 0 auto;">
                            <source src="{{ asset($footervideoPath) }}" type="video/mp4">
                        </video>
                    @else
                        <video id="footer-video-preview" width="640" height="360" controls
                            style="display:none; margin: 0 auto;"></video>
                    @endif
                </div>
                <input type="file" name="footer_video" accept="video/mp4" class="form-control mt-2">
            </div>

            <button type="submit" class="btn-theme py-1 px-3 rounded">
                Save Media
            </button>
        </form>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const videoInput = document.querySelector('input[name="welcome_video"]');
            const videoPreview = document.getElementById('video-preview');

            const bannerInput = document.querySelector('input[name="ads_banner"]');
            const bannerPreview = document.getElementById('banner-preview');

            const footerVideoInput = document.querySelector('input[name="footer_video"]');
            const footerVideoPreview = document.getElementById('footer-video-preview');

            if (videoInput) {
                videoInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file && file.type === "video/mp4") {
                        const videoURL = URL.createObjectURL(file);
                        videoPreview.src = videoURL;
                        videoPreview.load();
                        videoPreview.style.display = 'block';
                    }
                });
            }

            if (bannerInput) {
                bannerInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const imageURL = URL.createObjectURL(file);
                        bannerPreview.src = imageURL;
                        bannerPreview.style.display = 'block';
                    }
                });
            }

            if (footerVideoInput) {
                footerVideoInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file && file.type === "video/mp4") {
                        const videoURL = URL.createObjectURL(file);
                        footerVideoPreview.src = videoURL;
                        footerVideoPreview.load();
                        footerVideoPreview.style.display = 'block';
                    }
                });
            }
        });
    </script>

@endsection