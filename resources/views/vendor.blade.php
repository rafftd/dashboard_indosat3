@extends('layouts.app')

@section('title', 'Dashboard Pengiriman Vendor')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/responsive-global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor-shipping.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Prevent horizontal scroll */
        html, body {
            overflow-x: hidden !important;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        
        * {
            box-sizing: border-box;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 0.5rem !important;
                max-width: 100vw !important;
                overflow-x: hidden !important;
            }
            
            .dashboard-header {
                padding: 1rem !important;
            }
            
            .header-title {
                font-size: 1.25rem !important;
            }
            
            .header-subtitle {
                font-size: 0.875rem !important;
            }
            
            .card.form-card {
                max-width: 100% !important;
                padding: 1rem !important;
                margin: 0.5rem !important;
            }
            
            .card-title {
                font-size: 1.1rem !important;
                padding: 0.75rem !important;
            }
            
            .form-group {
                margin-bottom: 1rem !important;
            }
            
            .form-label {
                font-size: 0.875rem !important;
            }
            
            .form-input, .form-textarea {
                font-size: 0.875rem !important;
                padding: 0.625rem !important;
            }
            
            .btn-submit {
                width: 100% !important;
                padding: 0.875rem !important;
                font-size: 0.875rem !important;
            }
            
            #scanResiBtn {
                font-size: 0.875rem !important;
                padding: 0.75rem !important;
            }
            
            #resiCameraPreview {
                max-height: 200px !important;
            }
            
            .alert {
                font-size: 0.875rem !important;
                padding: 0.75rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .dashboard-header {
                padding: 0.75rem !important;
            }
            
            .header-icon {
                display: none !important;
            }
            
            .header-title {
                font-size: 1.1rem !important;
            }
            
            .header-subtitle {
                font-size: 0.75rem !important;
            }
            
            .card.form-card {
                padding: 0.75rem !important;
            }
            
            .card-title {
                font-size: 1rem !important;
                padding: 0.625rem !important;
            }
            
            .form-input, .form-textarea {
                font-size: 0.8125rem !important;
                padding: 0.5rem !important;
            }
            
            #resiCameraPreview {
                max-height: 180px !important;
            }
            
            #captureResiBtn, #cancelScanBtn {
                padding: 0.625rem !important;
                font-size: 0.8125rem !important;
            }
        }

        /* Style untuk input number dengan spinner yang jelas */
        input[type="number"].number-spinner {
            -moz-appearance: textfield;
            -webkit-appearance: none;
            appearance: none;
        }

        /* Tampilkan spinner untuk Chrome, Safari, Edge */
        input[type="number"].number-spinner::-webkit-inner-spin-button,
        input[type="number"].number-spinner::-webkit-outer-spin-button {
            -webkit-appearance: inner-spin-button !important;
            opacity: 1;
            height: 40px;
            cursor: pointer;
        }

        /* Tampilkan spinner untuk Firefox */
        input[type="number"].number-spinner {
            -moz-appearance: number-input;
        }
    </style>
@endsection

@section('content')
<div class="dashboard-container">
    <div class="dashboard-wrapper">
        <!-- Header -->
        <div class="dashboard-header">
            <div class="header-content">
                <div class="header-icon">
                    <svg class="icon-package" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Dashboard Pengiriman Vendor</h1>
                    <p class="header-subtitle">Form Pengiriman Vendor - IM3</p>
                </div>
            </div>
        </div>

        <!-- Form Pengiriman -->
        <div class="card form-card" style="max-width: 800px; margin: 0 auto;">
                <h2 class="card-title">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Form Pengiriman Vendor
                </h2>

                <form action="{{ route('vendor.store') }}" method="POST" id="vendorForm">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">
                            <svg class="icon-small" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Nama Vendor *
                        </label>
                        <input type="text" name="nama_vendor" class="form-input" placeholder="Nama vendor" required readonly value="{{ Auth::user()->name }}" style="background-color: #f3f4f6; cursor: not-allowed;">
                        @error('nama_vendor')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <svg class="icon-small" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Jenis Item *
                        </label>
                        <input type="text" name="jenis_item" class="form-input" placeholder="Contoh: Poster, Sticker" required value="{{ old('jenis_item') }}">
                        @error('jenis_item')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jumlah Item *</label>
                        <input type="number" name="jumlah_item" class="form-input number-spinner" placeholder="Masukkan jumlah" required value="{{ old('jumlah_item') }}" min="1" step="1" pattern="[0-9]*" inputmode="numeric">
                        @error('jumlah_item')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Catatan Tambahan</label>
                        <textarea name="catatan" class="form-textarea" rows="3" placeholder="Tuliskan catatan tambahan jika ada">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <svg class="icon-small" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Alamat Pengiriman *
                        </label>
                        <textarea name="alamat_pengiriman" class="form-textarea" rows="3" placeholder="Alamat lengkap pengiriman" required>{{ old('alamat_pengiriman') }}</textarea>
                        @error('alamat_pengiriman')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <svg class="icon-small" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Tanggal Pengiriman *
                        </label>
                        <input type="date" name="tanggal_pengiriman" id="tanggal_pengiriman" class="form-input" required readonly style="background-color: #f3f4f6; cursor: not-allowed;" value="{{ old('tanggal_pengiriman') }}">
                        @error('tanggal_pengiriman')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <svg class="icon-small" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Nomor Resi *
                        </label>
                        
                        <!-- Resi Input -->
                        <input type="text" name="resi_pengiriman" id="resi_pengiriman" class="form-input" placeholder="Masukkan nomor resi" required value="{{ old('resi_pengiriman') }}">
                        <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">
                            <i class="fas fa-info-circle"></i> Masukkan nomor resi pengiriman
                        </p>
                        @error('resi_pengiriman')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Foto Resi Section -->
                    <div class="form-group">
                        <label class="form-label">
                            <svg class="icon-small" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Foto Bukti Resi *
                        </label>
                        
                        <!-- Camera Preview -->
                        <div id="fotoCameraContainer" class="mb-4">
                            <video id="fotoCameraPreview" autoplay playsinline style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 8px; background: #000; display: none;"></video>
                            <canvas id="fotoCanvas" style="width: 100%; max-height: 300px; border-radius: 8px; border: 2px solid #10b981; display: none;"></canvas>
                        </div>

                        <!-- Camera Controls -->
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                            <button type="button" id="startFotoBtn" style="flex: 1; padding: 0.75rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Buka Kamera
                            </button>
                            <button type="button" id="captureFotoBtn" style="flex: 1; padding: 0.75rem; background: #10b981; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: none; align-items: center; justify-content: center; gap: 0.5rem;">
                                <i class="fas fa-camera-retro"></i>
                                Ambil Foto
                            </button>
                            <button type="button" id="retakeFotoBtn" style="flex: 1; padding: 0.75rem; background: #f59e0b; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: none; align-items: center; justify-content: center; gap: 0.5rem;">
                                <i class="fas fa-redo"></i>
                                Foto Ulang
                            </button>
                        </div>

                        <!-- Hidden inputs -->
                        <input type="hidden" name="foto_resi" id="foto_resi" required />
                        
                        <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">
                            <i class="fas fa-info-circle"></i> Foto akan diambil langsung dari kamera
                        </p>
                        @error('foto_resi')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        Simpan Data Pengiriman
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success" id="successAlert">
        <div class="alert-content">
            <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="alert-text">
                <strong>Berhasil!</strong>
                <p>{{ session('success') }}</p>
                @if(session('resi'))
                    <p>Nomor Resi: <strong>{{ session('resi') }}</strong></p>
                @endif
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error" id="errorAlert">
        <div class="alert-content">
            <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="alert-text">
                <strong>Error!</strong>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif
@endsection

@section('scripts')
<script>
    let fotoCameraStream = null;
    let capturedFotoBlob = null;

    // Camera Controls
    const startFotoBtn = document.getElementById('startFotoBtn');
    const captureFotoBtn = document.getElementById('captureFotoBtn');
    const retakeFotoBtn = document.getElementById('retakeFotoBtn');
    const fotoCameraPreview = document.getElementById('fotoCameraPreview');
    const fotoCanvas = document.getElementById('fotoCanvas');

    // Start Camera untuk Foto Resi
    startFotoBtn.addEventListener('click', async function() {
        try {
            // Request camera access
            fotoCameraStream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    facingMode: 'environment', // Use back camera on mobile
                    width: { ideal: 1920 },
                    height: { ideal: 1080 }
                } 
            });
            
            fotoCameraPreview.srcObject = fotoCameraStream;
            fotoCameraPreview.style.display = 'block';
            fotoCanvas.style.display = 'none';
            
            startFotoBtn.style.display = 'none';
            captureFotoBtn.style.display = 'flex';
            retakeFotoBtn.style.display = 'none';
        } catch (error) {
            console.error('Error accessing camera:', error);
            alert('❌ Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
        }
    });

    // Capture Photo
    captureFotoBtn.addEventListener('click', function() {
        const context = fotoCanvas.getContext('2d');
        
        // Set canvas size to match video
        fotoCanvas.width = fotoCameraPreview.videoWidth;
        fotoCanvas.height = fotoCameraPreview.videoHeight;
        
        // Draw video frame to canvas
        context.drawImage(fotoCameraPreview, 0, 0);
        
        // Convert canvas to blob with high quality
        fotoCanvas.toBlob(function(blob) {
            capturedFotoBlob = blob;
            
            // Show captured photo
            fotoCanvas.style.display = 'block';
            fotoCameraPreview.style.display = 'none';
            
            // Stop camera stream
            if (fotoCameraStream) {
                fotoCameraStream.getTracks().forEach(track => track.stop());
            }
            
            captureFotoBtn.style.display = 'none';
            retakeFotoBtn.style.display = 'flex';
            
        }, 'image/jpeg', 0.95); // High quality JPEG (95%)
    });

    // Retake Photo
    retakeFotoBtn.addEventListener('click', function() {
        fotoCanvas.style.display = 'none';
        capturedFotoBlob = null;
        startFotoBtn.click(); // Restart camera
    });

    // Form Submission
    document.getElementById('vendorForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validate photo
        if (!capturedFotoBlob) {
            alert('❌ Silakan ambil foto resi terlebih dahulu!');
            return;
        }

        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';

        const formData = new FormData(this);
        
        // Add photo blob to form data
        formData.set('foto_resi', capturedFotoBlob, 'resi-' + Date.now() + '.jpg');

        try {
            const response = await fetch('{{ route("vendor.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            // Reset button terlebih dahulu
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan Data Pengiriman';

            const result = await response.json();
            console.log('Response dari server:', result);

            if (response.ok && result.success) {
                alert('✓ Data pengiriman berhasil disimpan!');
                
                // Reset form dan camera
                document.getElementById('vendorForm').reset();
                fotoCanvas.style.display = 'none';
                capturedFotoBlob = null;
                startFotoBtn.style.display = 'flex';
                captureFotoBtn.style.display = 'none';
                retakeFotoBtn.style.display = 'none';
                
                // Stop camera stream if active
                if (fotoCameraStream) {
                    fotoCameraStream.getTracks().forEach(track => track.stop());
                    fotoCameraStream = null;
                }
                
                // Reload halaman setelah delay singkat
                setTimeout(() => {
                    window.location.reload();
                }, 800);
            } else {
                let errorMessage = '✗ Gagal menyimpan data pengiriman.\n\n';
                if (result.errors) {
                    Object.keys(result.errors).forEach(key => {
                        errorMessage += `${result.errors[key][0]}\n`;
                    });
                } else {
                    errorMessage += (result.message || 'Silakan coba lagi.');
                }
                alert(errorMessage);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('✗ Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
            
            // Reset button state pada error
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan Data Pengiriman';
        }
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        if (fotoCameraStream) {
            fotoCameraStream.getTracks().forEach(track => track.stop());
        }
    });

    // Auto hide alerts after 5 seconds
    setTimeout(() => {
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 5000);

    // Auto-fill tanggal pengiriman dengan tanggal hari ini
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const todayFormatted = `${year}-${month}-${day}`;
        
        const tanggalInput = document.getElementById('tanggal_pengiriman');
        if (tanggalInput) {
            tanggalInput.value = todayFormatted;
        }
    });

    // Pastikan input jumlah item hanya menerima angka
    const jumlahItemInput = document.querySelector('input[name="jumlah_item"]');
    if (jumlahItemInput) {
        // Mencegah input karakter non-angka
        jumlahItemInput.addEventListener('keypress', function(e) {
            // Hanya izinkan angka (0-9)
            if (e.key && !/[0-9]/.test(e.key)) {
                e.preventDefault();
            }
        });

        // Mencegah paste non-angka
        jumlahItemInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const numbersOnly = pastedText.replace(/[^0-9]/g, '');
            if (numbersOnly) {
                this.value = numbersOnly;
            }
        });

        // Pastikan nilai tidak kurang dari 1
        jumlahItemInput.addEventListener('change', function() {
            if (this.value < 1 || this.value === '') {
                this.value = 1;
            }
        });

        // Hapus karakter non-angka saat input
        jumlahItemInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value === '' || parseInt(this.value) < 1) {
                this.value = '';
            }
        });
    }
</script>
@endsection