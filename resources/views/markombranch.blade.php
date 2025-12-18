<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Formulir Permintaan POSM - Dashboard Indosat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/responsive-global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/markom.css') }}">
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
            .container {
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
                max-width: 100vw !important;
                overflow-x: hidden !important;
            }
            nav h1 {
                font-size: 1.25rem !important;
            }
            nav p {
                font-size: 0.75rem !important;
            }
            nav .flex.items-center.gap-4 {
                flex-direction: column !important;
                gap: 0.5rem !important;
                width: 100% !important;
                align-items: stretch !important;
            }
            nav .flex.items-center.gap-4 > * {
                width: 100% !important;
                max-width: 100% !important;
            }
            nav .text-right {
                display: none;
            }
            nav a, nav button, nav form {
                font-size: 0.75rem !important;
                padding: 0.5rem 0.75rem !important;
                width: 100% !important;
            }
            .text-3xl {
                font-size: 1.5rem !important;
            }
            .text-2xl {
                font-size: 1.25rem !important;
            }
            .grid-cols-2 {
                grid-template-columns: 1fr !important;
            }
            .p-8 {
                padding: 1.25rem !important;
            }
            input, textarea, select {
                font-size: 0.875rem !important;
            }
            button {
                font-size: 0.875rem !important;
            }
            h1, h2, h3, p {
                word-wrap: break-word !important;
                overflow-wrap: break-word !important;
            }
        }
        
        @media (max-width: 480px) {
            nav {
                padding: 0.5rem 0 !important;
            }
            nav h1 {
                font-size: 1rem !important;
            }
            nav .flex.justify-between {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 0.5rem;
            }
            .text-3xl {
                font-size: 1.25rem !important;
            }
            .p-8 {
                padding: 1rem !important;
            }
            input, textarea, select {
                font-size: 0.8125rem !important;
                padding: 0.5rem !important;
            }
            button {
                font-size: 0.8125rem !important;
                padding: 0.625rem 1rem !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 markom-container" style="overflow-x: hidden; width: 100%; margin: 0; padding: 0;">
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
                        <i class="fas fa-list mr-2"></i>Daftar Permintaan
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
    <div class="min-h-screen p-6">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md">
            <!-- Header -->
            <div class="border-b border-gray-200 p-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Formulir Permintaan POSM/Matpro Baru
                </h1>
            </div>

            <!-- Tabs Navigation -->
            <div class="flex border-b border-gray-200">
                <button onclick="showTab(1)" id="tab-btn-1" class="flex-1 py-4 px-6 text-sm font-medium transition-colors text-red-700 border-b-2 border-red-700 bg-red-50">
                    1. Detail Lokasi & Waktu
                </button>
                <button onclick="showTab(2)" id="tab-btn-2" class="flex-1 py-4 px-6 text-sm font-medium transition-colors text-gray-500 hover:text-gray-700">
                    2. Spesifikasi Item
                </button>
                <button onclick="showTab(3)" id="tab-btn-3" class="flex-1 py-4 px-6 text-sm font-medium transition-colors text-gray-500 hover:text-gray-700">
                    3. Finalisasi & Lampiran
                </button>
            </div>

            <!-- Form -->
            <form id="posmForm" class="p-6">
                @csrf

                <!-- Tab 1: Detail Lokasi & Waktu -->
                <div id="tab-1" class="tab-content space-y-6">
                    <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-6">
                        <p class="text-sm text-amber-900 font-medium">
                            <i class="fas fa-info-circle mr-2"></i>Pastikan semua informasi diisi dengan lengkap dan akurat
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Branch / Cabang <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="branch" id="branch" required
                                   placeholder="Contoh: SURABAYA"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Request (Otomatis)
                            </label>
                            <input type="text" value="{{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}" disabled
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Requester <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="requester_name" id="requester_name" required readonly
                                   value="{{ Auth::user()->name }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon Requester <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="requester_phone" id="requester_phone" required
                                   placeholder="Contoh: 081234567890"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal POSM Wajib Diterima (Deadline) <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="deadline" id="deadline" required
                                   min="{{ now()->addDay()->format('Y-m-d') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Pengiriman Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea name="shipping_address" id="shipping_address" required
                                  placeholder="Masukkan alamat cabang/outlet yang akan menerima POSM"
                                  rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" onclick="nextTab(2)"
                                class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors flex items-center gap-2">
                            Lanjut ke Spesifikasi Item
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Tab 2: Spesifikasi Item -->
                <div id="tab-2" class="tab-content space-y-6 hidden">
                    <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-6">
                        <p class="text-sm text-amber-900 font-medium">
                            <i class="fas fa-link mr-2"></i>Link Tambahan (Cth: link spreadsheet nama outlet/ppt pengajuan branding)
                        </p>
                    </div>

                    <div class="bg-orange-50 border-l-4 border-orange-400 p-4 mb-6">
                        <p class="text-sm text-orange-800 font-medium">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Opsi milih satu (kalau ada request materi yang berbeda, harus isi form berulang sejumlah materi yang mau direquest)
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tujuan / Peruntukan POSM <span class="text-red-500">*</span>
                            </label>
                            <select name="purpose" id="purpose" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <option value="">— Pilih Tujuan —</option>
                                <option value="outlet">Outlet / Toko</option>
                                <option value="event">Event / Aktivasi</option>
                                <option value="kantor">Kantor / Cabang</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis POSM (Katalog) <span class="text-red-500">*</span>
                            </label>
                            <select name="posm_type" id="posm_type" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <option value="">— Pilih Jenis POSM —</option>
                                <option value="signpole">Signpole</option>
                                <option value="shopblind">Shopblind</option>
                                <option value="vinyl_etalase">Vinyl Etalase</option>
                                <option value="shop_sign">Shop Sign</option>
                                <option value="aboard">Aboard</option>
                                <option value="sp_vinyl_nama_outlet">SP Vinyl Nama Outlet</option>
                                <option value="flagchain">Flagchain</option>
                                <option value="hanging_mobile">Hanging Mobile</option>
                                <option value="sticker_etalase">Sticker Etalase</option>
                                <option value="poster">Poster</option>
                                <option value="tentcard_a4">Tentcard A4</option>
                                <option value="tablemat">Tablemat</option>
                                <option value="sticker_a5">Sticker A5</option>
                                <option value="sticker_sp">Sticker SP</option>
                                <option value="price_tag">Price Tag</option>
                                <option value="others">Others</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah (QTY) Digunakan <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="quantity" id="quantity" required
                                   min="1" value="1"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Link Spreadsheet Ukuran
                            </label>
                            <input type="text" name="spreadsheet_link" id="spreadsheet_link"
                                   placeholder="https://docs.google.com/spreadsheets/..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>Opsional - Link Google Spreadsheet
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Link PPT Desain
                            </label>
                            <input type="text" name="design_link" id="design_link"
                                   placeholder="https://docs.google.com/presentation/ atau Canva"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>Opsional - Link Google Slides/PPT/Canva
                            </p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Detail Request (Materi Desain)
                        </label>
                        <textarea name="mandatory_elements" id="mandatory_elements"
                                  placeholder="Cth: Wajib ada Logo Sponsor A dan QR Code Promosi (Opsional)"
                                  rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent"></textarea>
                    </div>

                    <div class="flex justify-between">
                        <button type="button" onclick="prevTab(1)"
                                class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            <i class="fas fa-chevron-left mr-2"></i>Kembali
                        </button>
                        <button type="button" onclick="nextTab(3)"
                                class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors flex items-center gap-2">
                            Lanjut ke Finalisasi
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Tab 3: Finalisasi & Lampiran -->
                <div id="tab-3" class="tab-content space-y-6 hidden">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Tambahan untuk Tim Marcomm Region
                        </label>
                        <textarea name="notes" id="notes"
                                  placeholder="Contoh: Mohon dikirim via JNE YES, kami butuh cepat."
                                  rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent"></textarea>
                    </div>

                    <div class="flex justify-between pt-4">
                        <button type="button" onclick="prevTab(2)"
                                class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            <i class="fas fa-chevron-left mr-2"></i>Kembali
                        </button>
                        <button type="submit" id="submitBtn"
                                class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors flex items-center gap-2">
                            <i class="fas fa-check mr-2"></i>Ajukan Permintaan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Function to show notification
        function showNotification(type, message) {
            const notificationHtml = `
                <div class="alert alert-${type}" id="dynamicAlert" style="position: fixed; top: 1rem; right: 1rem; max-width: 400px; border-radius: 0.5rem; padding: 1rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 1000; animation: slideIn 0.3s ease-out; background-color: ${type === 'success' ? '#dcfce7' : '#fee2e2'}; border-left: 4px solid ${type === 'success' ? '#16a34a' : '#dc2626'}; color: ${type === 'success' ? '#166534' : '#991b1b'};">
                    <div style="display: flex; gap: 0.75rem;">
                        <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle" style="width: 1.5rem; height: 1.5rem; flex-shrink: 0; font-size: 1.5rem;"></i>
                        <div style="flex: 1;">
                            <strong style="display: block; font-weight: 600; margin-bottom: 0.25rem;">${type === 'success' ? 'Berhasil!' : 'Perhatian!'}</strong>
                            <p style="margin: 0.25rem 0 0 0; font-size: 0.875rem;">${message}</p>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing notification if any
            const existingAlert = document.getElementById('dynamicAlert');
            if (existingAlert) {
                existingAlert.remove();
            }
            
            // Add new notification
            document.body.insertAdjacentHTML('beforeend', notificationHtml);
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                const alert = document.getElementById('dynamicAlert');
                if (alert) alert.remove();
            }, 5000);
        }

        // Tab Management
        function showTab(tabNumber) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Remove active state from all buttons
            document.querySelectorAll('[id^="tab-btn-"]').forEach(btn => {
                btn.classList.remove('text-red-700', 'border-b-2', 'border-red-700', 'bg-red-50');
                btn.classList.add('text-gray-500');
            });

            // Show selected tab
            document.getElementById(`tab-${tabNumber}`).classList.remove('hidden');

            // Add active state to selected button
            const activeBtn = document.getElementById(`tab-btn-${tabNumber}`);
            activeBtn.classList.add('text-red-700', 'border-b-2', 'border-red-700', 'bg-red-50');
            activeBtn.classList.remove('text-gray-500');
        }

        function nextTab(tabNumber) {
            // Validate current tab before moving to next
            const currentTab = document.querySelector('.tab-content:not(.hidden)');
            const requiredFields = currentTab.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                showNotification('error', 'Mohon lengkapi semua field yang wajib diisi (bertanda *)');
                return;
            }

            showTab(tabNumber);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function prevTab(tabNumber) {
            showTab(tabNumber);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Form Submission
        document.getElementById('posmForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            // Final validation before submit
            const requiredFields = document.querySelectorAll('[required]');
            let isValid = true;
            let firstInvalidField = null;
            
            requiredFields.forEach(field => {
                if (!field.value || !field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                    if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                showNotification('error', 'Mohon lengkapi semua field yang wajib diisi (bertanda *)');
                if (firstInvalidField) {
                    firstInvalidField.focus();
                    firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            // Debug: log data yang akan dikirim
            console.log('Data yang akan dikirim:', data);

            try {
                const response = await fetch('{{ route("posm-requests.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                console.log('Response dari server:', result);

                if (result.success) {
                    showNotification('success', 'Permintaan POSM berhasil diajukan! Permintaan Anda akan segera diproses oleh tim Marcomm Region.');
                    setTimeout(() => {
                        window.location.href = '{{ route("posm-requests.index") }}';
                    }, 2000);
                } else {
                    // Show validation errors if any
                    let errorMessage = 'Gagal mengajukan permintaan. ';
                    if (result.errors) {
                        const firstError = Object.values(result.errors)[0];
                        errorMessage += firstError[0];
                    } else {
                        errorMessage += (result.message || 'Silakan coba lagi.');
                    }
                    showNotification('error', errorMessage);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Ajukan Permintaan';
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('error', 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Ajukan Permintaan';
            }
        });

        // Validation Helper
        document.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
            field.addEventListener('invalid', function() {
                this.classList.add('border-red-500');
            });

            field.addEventListener('input', function() {
                this.classList.remove('border-red-500');
            });
        });

        // Debug submit button
        console.log('Submit button:', document.getElementById('submitBtn'));
        console.log('Form:', document.getElementById('posmForm'));
        
        // Test if button is clickable
        const testBtn = document.getElementById('submitBtn');
        if (testBtn) {
            console.log('✓ Submit button found!');
            console.log('Button disabled?', testBtn.disabled);
            console.log('Button type:', testBtn.type);
        } else {
            console.error('✗ Submit button NOT found!');
        }

        // Test if form exists
        const testForm = document.getElementById('posmForm');
        if (testForm) {
            console.log('✓ Form found!');
        } else {
            console.error('✗ Form NOT found!');
        }

        // Auto hide alerts after 5 seconds
        setTimeout(() => {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            if (successAlert) successAlert.style.display = 'none';
            if (errorAlert) errorAlert.style.display = 'none';
        }, 5000);
    </script>
</body>
</html>
