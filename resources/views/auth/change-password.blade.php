<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - Dashboard Indosat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-red-50 to-orange-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="bg-red-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-key text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Ubah Password</h1>
            <p class="text-gray-600">
                @if(isset($isAdmin) && $isAdmin)
                    Admin: Kelola Password User
                @else
                    Silakan ubah password default Anda
                @endif
            </p>
        </div>

        <!-- Change Password Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('warning'))
            <div class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3"></i>
                    <p class="font-semibold">{{ session('warning') }}</p>
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

            <form method="POST" action="{{ route('password.update') }}" id="changePasswordForm">
                @csrf

                @if(isset($isAdmin) && $isAdmin)
                <!-- Dropdown Pilih User (Khusus Admin) -->
                <div class="mb-6">
                    <label for="user_id" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user-cog mr-2 text-red-600"></i>Pilih User yang Akan Diubah Passwordnya
                    </label>
                    <select id="user_id" 
                            name="user_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                            onchange="toggleCurrentPasswordField()"
                            required>
                        <option value="">-- Pilih User --</option>
                        <option value="{{ auth()->id() }}">{{ auth()->user()->name }} (Saya Sendiri)</option>
                        @php
                            $roleLabels = [
                                'administrasi' => 'Administrasi',
                                'designer' => 'Designer',
                                'markom_regional' => 'Markom Regional',
                                'markom_branch' => 'Markom Branch',
                                'vendor' => 'Vendor'
                            ];
                        @endphp
                        @foreach($users ?? [] as $user)
                            @if($user->id !== auth()->id())
                            <option value="{{ $user->id }}">
                                {{ $user->name }} - {{ $roleLabels[$user->role] ?? $user->role }}
                            </option>
                            @endif
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Pilih username yang ingin Anda ubah passwordnya</p>
                </div>

                <!-- Current Password (muncul jika admin ubah password sendiri) -->
                <div class="mb-6 hidden" id="current_password_field">
                    <label for="current_password" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2 text-red-600"></i>Password Saat Ini
                    </label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                           placeholder="Masukkan password saat ini">
                    <p class="text-sm text-gray-500 mt-1">Diperlukan saat mengubah password sendiri</p>
                </div>
                @else
                <!-- Current Password (untuk non-admin) -->
                <div class="mb-6">
                    <label for="current_password" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2 text-red-600"></i>Password Saat Ini
                    </label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                           placeholder="Masukkan password saat ini"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Gunakan "password" jika baru pertama login</p>
                </div>
                @endif

                <!-- New Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-key mr-2 text-red-600"></i>Password Baru
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                           placeholder="Masukkan password baru"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Minimal 6 karakter</p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-check-circle mr-2 text-red-600"></i>Konfirmasi Password Baru
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                           placeholder="Ulangi password baru"
                           required>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-lg hover:shadow-xl mb-3">
                    <i class="fas fa-save mr-2"></i>Ubah Password
                </button>

                @if(isset($isAdmin) && $isAdmin)
                <!-- Back to Dashboard Button (khusus admin) -->
                <a href="{{ route('dashboard') }}" 
                   class="w-full block text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                </a>
                @endif
            </form>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-6">
            <p class="text-gray-600 text-sm">
                <i class="fas fa-shield-alt text-red-600 mr-2"></i>
                Password Anda akan dienkripsi dengan aman
            </p>
        </div>
    </div>

    @if(isset($isAdmin) && $isAdmin)
    <script>
        function toggleCurrentPasswordField() {
            const userSelect = document.getElementById('user_id');
            const currentPasswordField = document.getElementById('current_password_field');
            const currentPasswordInput = document.getElementById('current_password');
            const currentUserId = '{{ auth()->id() }}';
            
            if (userSelect.value === currentUserId) {
                // Jika pilih diri sendiri, tampilkan field current password
                currentPasswordField.classList.remove('hidden');
                currentPasswordInput.required = true;
            } else {
                // Jika pilih user lain, sembunyikan field current password
                currentPasswordField.classList.add('hidden');
                currentPasswordInput.required = false;
                currentPasswordInput.value = '';
            }
        }
    </script>
    @endif
</body>
</html>
