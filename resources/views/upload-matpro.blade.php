<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Bukti Penerimaan MATPRO - Dashboard Indosat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/responsive-global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/upload-matpro.css') }}">
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
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            nav h1 {
                font-size: 1.25rem !important;
            }
            nav p, nav a {
                font-size: 0.875rem !important;
            }
            .container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
                max-width: 100vw !important;
                overflow-x: hidden !important;
            }
            h2 {
                font-size: 1.25rem !important;
            }
            .grid-cols-2 {
                grid-template-columns: 1fr !important;
            }
            video, canvas {
                max-height: 250px !important;
            }
        }
        
        @media (max-width: 480px) {
            nav h1 {
                font-size: 1rem !important;
            }
            nav {
                padding: 0.75rem 0 !important;
            }
            nav .flex {
                flex-direction: column !important;
                gap: 0.5rem !important;
                align-items: flex-start !important;
                width: 100% !important;
            }
            nav .flex > * {
                width: 100% !important;
                max-width: 100% !important;
            }
            .container {
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }
            h2 {
                font-size: 1.1rem !important;
            }
            input, textarea, select {
                font-size: 0.875rem !important;
            }
            button {
                font-size: 0.875rem !important;
                padding: 0.625rem 1rem !important;
            }
            video, canvas {
                max-height: 200px !important;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200" style="overflow-x: hidden; width: 100%; margin: 0; padding: 0;">
    <!-- Navbar -->
    <nav style="background: linear-gradient(90deg, #e91e8c 0%, #f48db8 30%, #ffd9e8 60%, #ffffff 100%); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); max-width: 100vw; overflow-x: hidden;">
        <div class="container mx-auto px-4 py-4" style="max-width: 100%; overflow-x: hidden;">
            <div class="flex justify-between items-center" style="max-width: 100%; flex-wrap: wrap;">
                <div>
                    <h1 class="text-2xl font-bold text-white">Dashboard Indosat - Markom Branch</h1>
                    <p class="text-white text-opacity-90 text-sm">{{ Auth::user()->getRoleDisplayName() }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('posm-requests.index') }}" class="bg-purple-700 hover:bg-purple-800 text-white px-4 py-2 rounded-lg transition font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                    </a>
                    @if(file_exists(public_path('images/logo_warna.png')))
                        <img src="{{ asset('images/logo_warna.png') }}" alt="Logo Indosat" class="h-16">
                    @endif
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-gray-600 text-sm">{{ Auth::user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg transition font-semibold">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Success/Error Notifications -->
    @if(session('success'))
    <div class="alert alert-success" id="successAlert" style="position: fixed; top: 1rem; right: 1rem; max-width: 400px; border-radius: 0.5rem; padding: 1rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 1000; animation: slideIn 0.3s ease-out; background-color: #dcfce7; border-left: 4px solid #16a34a; color: #166534;">
        <div style="display: flex; gap: 0.75rem;">
            <i class="fas fa-check-circle" style="width: 1.5rem; height: 1.5rem; flex-shrink: 0; font-size: 1.5rem;"></i>
            <div style="flex: 1;">
                <strong style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Berhasil!</strong>
                <p style="margin: 0.25rem 0 0 0; font-size: 0.875rem;">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error" id="errorAlert" style="position: fixed; top: 1rem; right: 1rem; max-width: 400px; border-radius: 0.5rem; padding: 1rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 1000; animation: slideIn 0.3s ease-out; background-color: #fee2e2; border-left: 4px solid #dc2626; color: #991b1b;">
        <div style="display: flex; gap: 0.75rem;">
            <i class="fas fa-exclamation-circle" style="width: 1.5rem; height: 1.5rem; flex-shrink: 0; font-size: 1.5rem;"></i>
            <div style="flex: 1;">
                <strong style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Error!</strong>
                <p style="margin: 0.25rem 0 0 0; font-size: 0.875rem;">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    <style>
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>

    <!-- Main Content -->
    <div class="min-h-screen p-8">
        <div class="max-w-6xl mx-auto">


            <!-- Main Card -->
            <div class="bg-white rounded-lg shadow-sm p-8">
                <!-- Title Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                        Monitoring & Penerimaan Barang
                    </h2>
                    <p class="text-gray-600">
                        Pantau dan konfirmasi penerimaan barang dari vendor setelah pengiriman.
                    </p>
                </div>

                <!-- Form Section -->
                <form id="matproForm" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-700 mb-4">
                            Detail Penerimaan Barang
                        </h3>

                        <!-- Row 1: Nama Penerima & Branch -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Penerima <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="nama_penerima"
                                    id="nama_penerima"
                                    required
                                    placeholder="Nama lengkap penerima"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Branch / Cabang <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="branch"
                                    id="branch"
                                    required
                                    placeholder="Contoh: Surabaya Branch"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition"
                                />
                            </div>
                        </div>

                        <!-- Row 2: Matpro & Tanggal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Matpro (Jenis Matpro + Judul PO) <span class="text-red-500">*</span>
                                </label>
                                <!-- Debug info -->
                                @if(isset($currentUserId))
                                    <div class="text-xs text-blue-600 mb-1">Debug: User ID Anda = {{ $currentUserId }}, PO Count = {{ count($purchaseOrders) }}</div>
                                @endif
                                <select
                                    name="matpro"
                                    id="matpro"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition">
                                    <option value="">-- Pilih PO yang Diterima --</option>
                                    @if(isset($purchaseOrders) && count($purchaseOrders) > 0)
                                        @foreach($purchaseOrders as $po)
                                            <option value="{{ implode(', ', $po->jenis_item) }} - {{ $po->judul_po }}">
                                                {{ $po->nomor_po }}: {{ implode(', ', $po->jenis_item) }} - {{ $po->judul_po }} [ID:{{ $po->markom_branch_id }}]
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>Tidak ada PO yang ditugaskan untuk Anda</option>
                                    @endif
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Hanya PO yang ditugaskan ke Anda yang muncul di sini</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Diterima <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    name="tanggal_diterima"
                                    id="tanggal_diterima"
                                    required
                                    readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed outline-none"
                                />
                            </div>
                        </div>

                        <!-- Camera Capture with Geolocation -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Upload Bukti Penerimaan Barang <span class="text-red-500">*</span>
                            </label>
                            
                            <!-- Camera Preview -->
                            <div id="cameraContainer" class="mb-4">
                                <video id="cameraPreview" autoplay playsinline class="w-full max-w-md rounded-lg border-2 border-gray-300 bg-black hidden"></video>
                                <canvas id="photoCanvas" class="w-full max-w-md rounded-lg border-2 border-green-500 hidden"></canvas>
                            </div>

                            <!-- Camera Selection -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-video mr-1"></i>Pilih Kamera
                                </label>
                                <select id="cameraSelect" class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="environment">📷 Kamera Belakang</option>
                                    <option value="user">🤳 Kamera Depan</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>Foto akan diambil langsung dari kamera dengan informasi lokasi
                                </p>
                            </div>

                            <!-- Camera Controls -->
                            <div class="flex gap-3 mb-4">
                                <button type="button" id="startCameraBtn" 
                                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                                    <i class="fas fa-camera"></i>
                                    Buka Kamera
                                </button>
                                <button type="button" id="captureBtn" 
                                    class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center gap-2 hidden">
                                    <i class="fas fa-camera-retro"></i>
                                    Ambil Foto
                                </button>
                                <button type="button" id="retakeBtn" 
                                    class="px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition flex items-center gap-2 hidden">
                                    <i class="fas fa-redo"></i>
                                    Foto Ulang
                                </button>
                            </div>

                            <!-- Location Info -->
                            <div id="locationInfo" class="bg-blue-50 border border-blue-200 rounded-lg p-4 hidden">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-map-marker-alt text-blue-600 text-xl mt-1"></i>
                                    <div class="flex-1">
                                        <p class="font-semibold text-blue-900 mb-2">Informasi Lokasi</p>
                                        <p class="text-sm text-blue-700" id="locationText">Mendapatkan lokasi...</p>
                                        <p class="text-xs text-blue-600 mt-1" id="coordinatesText"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden inputs -->
                            <input type="hidden" name="bukti_file" id="bukti_file" required />
                            <input type="hidden" name="latitude" id="latitude" />
                            <input type="hidden" name="longitude" id="longitude" />
                            
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>Foto akan diambil langsung dari kamera dengan informasi lokasi
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button
                                type="submit"
                                id="submitBtn"
                                class="px-8 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm"
                            >
                                <i class="fas fa-save mr-2"></i>Simpan Bukti Penerimaan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        let cameraStream = null;
        let capturedPhotoBlob = null;

        // Camera Controls
        const startCameraBtn = document.getElementById('startCameraBtn');
        const captureBtn = document.getElementById('captureBtn');
        const retakeBtn = document.getElementById('retakeBtn');
        const cameraPreview = document.getElementById('cameraPreview');
        const photoCanvas = document.getElementById('photoCanvas');
        const locationInfo = document.getElementById('locationInfo');
        const locationText = document.getElementById('locationText');
        const coordinatesText = document.getElementById('coordinatesText');

        // Get camera select element
        const cameraSelect = document.getElementById('cameraSelect');

        // Detect if device is mobile
        function isMobileDevice() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }

        // Start Camera
        startCameraBtn.addEventListener('click', async function() {
            try {
                // Get selected camera mode
                const selectedCamera = cameraSelect.value;
                
                // Set resolution based on device type
                const isMobile = isMobileDevice();
                const videoConstraints = {
                    facingMode: selectedCamera,
                    width: { ideal: isMobile ? 3840 : 1920 },  // 4K for mobile, Full HD for desktop
                    height: { ideal: isMobile ? 2160 : 1080 }
                };
                
                // Request camera access with fallback
                try {
                    cameraStream = await navigator.mediaDevices.getUserMedia({ 
                        video: videoConstraints
                    });
                } catch (err) {
                    // Fallback: Try without specific facingMode if selected camera not available
                    console.warn('Kamera yang dipilih tidak tersedia, menggunakan kamera default:', err);
                    cameraStream = await navigator.mediaDevices.getUserMedia({ 
                        video: {
                            width: { ideal: isMobile ? 3840 : 1920 },
                            height: { ideal: isMobile ? 2160 : 1080 }
                        }
                    });
                    alert('ℹ️ Kamera yang dipilih tidak tersedia, menggunakan kamera default.');
                }
                
                cameraPreview.srcObject = cameraStream;
                cameraPreview.classList.remove('hidden');
                photoCanvas.classList.add('hidden');
                
                startCameraBtn.classList.add('hidden');
                captureBtn.classList.remove('hidden');
                retakeBtn.classList.add('hidden');
                cameraSelect.disabled = true; // Disable selection while camera is active

                // Get location
                getLocation();
            } catch (error) {
                console.error('Error accessing camera:', error);
                alert('❌ Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
            }
        });

        // Capture Photo
        captureBtn.addEventListener('click', function() {
            const context = photoCanvas.getContext('2d');
            
            // Set canvas size to match video (Full HD)
            photoCanvas.width = cameraPreview.videoWidth;
            photoCanvas.height = cameraPreview.videoHeight;
            
            // Draw video frame to canvas
            context.drawImage(cameraPreview, 0, 0);
            
            // Convert canvas to blob with high quality (0.95 = 95% quality, similar to WhatsApp)
            photoCanvas.toBlob(function(blob) {
                capturedPhotoBlob = blob;
                
                // Create File object from blob
                const file = new File([blob], 'photo-' + Date.now() + '.jpg', { type: 'image/jpeg' });
                
                // Store in hidden input (we'll use this in form submission)
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                
                // Show captured photo
                photoCanvas.classList.remove('hidden');
                cameraPreview.classList.add('hidden');
                
                // Stop camera stream
                if (cameraStream) {
                    cameraStream.getTracks().forEach(track => track.stop());
                }
                
                captureBtn.classList.add('hidden');
                retakeBtn.classList.remove('hidden');
                
            }, 'image/jpeg', 0.95); // High quality JPEG (95%) like WhatsApp
        });

        // Retake Photo
        retakeBtn.addEventListener('click', function() {
            photoCanvas.classList.add('hidden');
            capturedPhotoBlob = null;
            cameraSelect.disabled = false; // Enable camera selection for retake
            
            // Show start button again, don't auto-start camera
            startCameraBtn.classList.remove('hidden');
            retakeBtn.classList.add('hidden');
            captureBtn.classList.add('hidden');
        });

        // Get Geolocation
        function getLocation() {
            locationInfo.classList.remove('hidden');
            locationText.textContent = 'Mendapatkan lokasi GPS (pastikan GPS aktif)...';
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const accuracy = position.coords.accuracy;
                        
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;
                        
                        let accuracyInfo = '';
                        if (accuracy) {
                            if (accuracy < 50) {
                                accuracyInfo = ` (Akurasi: Sangat Baik ±${Math.round(accuracy)}m)`;
                            } else if (accuracy < 200) {
                                accuracyInfo = ` (Akurasi: Baik ±${Math.round(accuracy)}m)`;
                            } else {
                                accuracyInfo = ` (Akurasi: Rendah ±${Math.round(accuracy)}m - Aktifkan GPS untuk akurasi lebih baik)`;
                            }
                        }
                        
                        locationText.textContent = '✓ Lokasi berhasil didapatkan' + accuracyInfo;
                        coordinatesText.textContent = `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    },
                    function(error) {
                        console.error('Error getting location:', error);
                        let errorMsg = '⚠️ ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMsg += 'Izin lokasi ditolak. Klik ikon kunci/info di address bar untuk mengizinkan lokasi.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMsg += 'Lokasi tidak tersedia. Aktifkan GPS/Location di perangkat Anda.';
                                break;
                            case error.TIMEOUT:
                                errorMsg += 'Timeout mendapatkan lokasi. Coba lagi.';
                                break;
                            default:
                                errorMsg += 'Tidak dapat mendapatkan lokasi.';
                        }
                        locationText.textContent = errorMsg;
                        coordinatesText.textContent = 'Foto tetap bisa diupload tanpa lokasi';
                    },
                    {
                        enableHighAccuracy: true, // Gunakan GPS, bukan WiFi/IP
                        timeout: 10000, // 10 detik timeout
                        maximumAge: 0 // Jangan gunakan cache lokasi
                    }
                );
            } else {
                locationText.textContent = '❌ Browser tidak mendukung geolocation';
                coordinatesText.textContent = 'Gunakan browser modern (Chrome/Firefox/Safari)';
            }
        }

        // Form Submission
        document.getElementById('matproForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            // Validate photo
            if (!capturedPhotoBlob) {
                alert('❌ Silakan ambil foto terlebih dahulu!');
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';

            const formData = new FormData(this);
            
            // Add photo blob to form data
            formData.set('bukti_file', capturedPhotoBlob, 'photo-' + Date.now() + '.jpg');

            try {
                const response = await fetch('{{ route("posm-receipts.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    alert('✓ Bukti penerimaan berhasil disimpan!');
                    window.location.href = '{{ route("posm-requests.index") }}';
                } else {
                    let errorMessage = '✗ Gagal menyimpan bukti penerimaan.\n\n';
                    if (result.errors) {
                        Object.keys(result.errors).forEach(key => {
                            errorMessage += `${result.errors[key][0]}\n`;
                        });
                    } else {
                        errorMessage += (result.message || 'Silakan coba lagi.');
                    }
                    alert(errorMessage);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Simpan Bukti Penerimaan';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('✗ Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Simpan Bukti Penerimaan';
            }
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
            }
        });

        // Auto hide alerts after 5 seconds
        setTimeout(() => {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            if (successAlert) successAlert.style.display = 'none';
            if (errorAlert) errorAlert.style.display = 'none';
        }, 5000);

        // Auto-fill tanggal diterima dengan tanggal hari ini
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const todayFormatted = `${year}-${month}-${day}`;
            
            document.getElementById('tanggal_diterima').value = todayFormatted;
        });
    </script>
</body>
</html>
