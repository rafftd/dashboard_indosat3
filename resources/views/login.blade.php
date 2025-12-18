<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard Indosat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/responsive-global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="gradient-bg">
    <div class="login-container">
        <div class="login-card card-shadow">
            <!-- Left Side - Branding -->
            <div class="branding-section">
                @if(file_exists(public_path('images/indosat-logo.png')))
                    <img src="{{ asset('images/indosat-logo.png') }}" alt="Indosat Logo" class="branding-logo">
                @else
                    <div class="branding-logo-placeholder">
                        <span class="logo-text">indosat</span>
                        <span class="logo-subtext">OOREDOO HUTCHISON</span>
                    </div>
                @endif
                
                <div class="features-list">
                    <div class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span>Purchase Order Management</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span>POSM Request System</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span>Vendor Shipment Tracking</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle feature-icon"></i>
                        <span>Marcomm Branch</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="form-section">
                <h2 class="form-title">Selamat Datang!</h2>
                <p class="form-subtitle">Silakan login untuk melanjutkan</p>

            @if(session('error'))
                <div class="error-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="success-alert">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <!-- Username Input -->
                <div class="form-group">
                    <label for="username" class="form-label">
                        <i class="fas fa-user"></i>Username
                    </label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        value="{{ old('username') }}"
                        class="form-input"
                        placeholder="Masukkan username"
                        required
                    >
                    @error('username')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i>Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input"
                        placeholder="Masukkan password"
                        required
                    >
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="remember-row">
                    <div class="remember-checkbox">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">
                    <i class="fas fa-sign-in-alt"></i>Login
                </button>
            </form>

            <!-- Info Box -->
            <div class="info-box">
                <p class="info-title">
                    <i class="fas fa-info-circle"></i>Akun Default untuk Testing:
                </p>
                <div class="info-accounts">
                    <div>• <strong>Administrasi:</strong> Administrasi</div>
                    <div>• <strong>Designer:</strong> Designer</div>
                    <div>• <strong>Vendor:</strong> Vendor</div>
                    <div>• <strong>Marcomm:</strong> Marcomm Branch</div>
                </div>
                <p class="info-password">
                    <i class="fas fa-key"></i>Password Default: <span>password</span>
                </p>
                <p class="info-footer-text">
                    <i class="fas fa-lock"></i> Anda akan diminta mengubah password saat login pertama kali
                </p>
            </div>
        </div>
    </div>
</body>
</html>
