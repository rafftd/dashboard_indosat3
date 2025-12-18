<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Dashboard Indosat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-red-50 to-orange-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="bg-red-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-unlock-alt text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Lupa Password?</h1>
            <p class="text-gray-600">Reset password ke default</p>
        </div>

        <!-- Forgot Password Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                <div class="flex items-start">
                    <i class="fas fa-check-circle mr-3 mt-1"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                <div class="flex items-start">
                    <i class="fas fa-times-circle mr-3 mt-1"></i>
                    <div>
                        @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Info Box -->
            <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded">
                <div class="flex items-start">
                    <i class="fas fa-info-circle mr-3 mt-1"></i>
                    <div class="text-sm">
                        <p class="font-semibold mb-1">Cara Reset Password:</p>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Masukkan email Anda</li>
                            <li>Password akan direset ke: <strong>"password"</strong></li>
                            <li>Login dengan password default</li>
                            <li>Ubah password setelah login</li>
                        </ol>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('password.reset') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-envelope mr-2 text-red-600"></i>Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                           placeholder="nama@example.com"
                           value="{{ old('email') }}"
                           required>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-lg hover:shadow-xl mb-4">
                    <i class="fas fa-redo mr-2"></i>Reset Password
                </button>

                <!-- Back to Login -->
                <a href="{{ route('login') }}" 
                   class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Login
                </a>
            </form>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-6">
            <p class="text-gray-600 text-sm">
                <i class="fas fa-shield-alt text-red-600 mr-2"></i>
                Password default: <strong>"password"</strong>
            </p>
        </div>
    </div>
</body>
</html>
