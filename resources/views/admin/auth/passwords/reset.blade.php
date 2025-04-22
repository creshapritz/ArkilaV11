<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Admin Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Admin Reset Password</h2>

        <form action="{{ route('admin.password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email', $email) }}" required
                    class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4 relative">
                <label for="password" class="block text-gray-700 font-medium">New Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                <span class="absolute right-3 top-10 eye-icon cursor-pointer" id="togglePassword1">
                    <i class="fas fa-eye-slash"></i>
                </span>
            </div>

            <div class="mb-6 relative">
                <label for="password_confirmation" class="block text-gray-700 font-medium">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                <span class="absolute right-3 top-10 eye-icon cursor-pointer" id="togglePassword2">
                    <i class="fas fa-eye-slash"></i>
                </span>
            </div>

            <button type="submit"
                class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600 transition duration-200">
                Reset Password
            </button>
        </form>

        
    </div>
    <script>
        const togglePassword = (toggleId, passwordInputId) => {
            const toggle = document.getElementById(toggleId);
            const passwordInput = document.getElementById(passwordInputId);

            toggle.addEventListener('click', () => {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                toggle.querySelector('i').classList.toggle('fa-eye');
                toggle.querySelector('i').classList.toggle('fa-eye-slash');
            });
        };

        togglePassword('togglePassword1', 'password');
        togglePassword('togglePassword2', 'password_confirmation');
    </script>

</body>
</html>
