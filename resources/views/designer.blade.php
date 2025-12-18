<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Designer - POSM Approval</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/responsive-global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/designer.css') }}">
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
        
        /* Custom colors matching the theme - Using RED like admin and markom */
        .bg-designer-primary { background-color: #dc2626; }
        .bg-designer-secondary { background-color: #b91c1c; }
        .text-designer-primary { color: #dc2626; }
        .border-designer-primary { border-color: #dc2626; }
        
        /* Responsive Styles for Mobile */
        @media (max-width: 768px) {
            .container {
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }
            
            nav h1 {
                font-size: 1rem !important;
            }
            
            nav p {
                font-size: 0.75rem !important;
            }
            
            nav img {
                max-height: 2.5rem !important;
                width: auto !important;
                object-fit: contain !important;
                margin: 0 auto !important;
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
            
            nav a, nav button, nav form {
                font-size: 0.75rem !important;
                padding: 0.5rem 0.75rem !important;
                width: 100% !important;
            }
            
            nav .text-right {
                display: none;
            }
            
            .text-3xl {
                font-size: 1.5rem !important;
            }
            
            .text-2xl {
                font-size: 1.25rem !important;
            }
            
            .text-xl {
                font-size: 1rem !important;
            }
            
            .grid-cols-4 {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 0.75rem !important;
            }
            
            .grid-cols-2 {
                grid-template-columns: 1fr !important;
            }
            
            .rounded-xl {
                border-radius: 0.5rem !important;
            }
            
            .p-6 {
                padding: 1rem !important;
            }
            
            .p-8 {
                padding: 1.25rem !important;
            }
            
            .mb-8 {
                margin-bottom: 1.5rem !important;
            }
            
            table {
                font-size: 0.75rem !important;
            }
            
            table th, table td {
                padding: 0.5rem !important;
            }
            
            button {
                font-size: 0.75rem !important;
                padding: 0.375rem 0.75rem !important;
            }
        }
        
        @media (max-width: 480px) {
            nav h1 {
                font-size: 0.875rem !important;
            }
            
            nav {
                padding: 0.5rem 0 !important;
            }
            
            nav img {
                max-height: 2rem !important;
                width: auto !important;
                object-fit: contain !important;
            }
            
            .grid-cols-4 {
                grid-template-columns: 1fr !important;
            }
            
            .text-3xl {
                font-size: 1.25rem !important;
            }
            
            .text-2xl {
                font-size: 1.1rem !important;
            }
            
            .p-6 {
                padding: 0.75rem !important;
            }
            
            table {
                font-size: 0.625rem !important;
            }
            
            .overflow-x-auto {
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>
<body class="bg-gray-100" style="overflow-x: hidden; width: 100%; margin: 0; padding: 0;">
    <!-- Navbar -->
    <nav style="background: linear-gradient(90deg, #e91e8c 0%, #f48db8 30%, #ffd9e8 60%, #ffffff 100%); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); max-width: 100vw; overflow-x: hidden;">
        <div class="container mx-auto px-4 py-4" style="max-width: 100%; overflow-x: hidden;">
            <div class="flex justify-between items-center" style="max-width: 100%; flex-wrap: wrap;">
                <div>
                    <h1 class="text-2xl font-bold text-white">Dashboard Designer - POSM Approval</h1>
                    <p class="text-white text-opacity-90 text-sm">{{ Auth::user()->getRoleDisplayName() }}</p>
                </div>
                <div class="flex items-center gap-4">
                    @if(Auth::user()->isMarkomBranch())
                    <a href="{{ route('posm-requests.index') }}" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition font-semibold text-white">
                        <i class="fas fa-file-alt mr-2"></i>POSM Request
                    </a>
                    @endif
                    <a href="{{ route('designer.vendor-shipments') }}" class="bg-purple-700 hover:bg-purple-800 px-4 py-2 rounded-lg transition font-semibold text-white">
                        <i class="fas fa-truck mr-2"></i>Data Pengiriman Vendor
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
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
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
    <div class="container mx-auto px-4 py-6">
        <!-- Statistics Cards -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-clipboard-list text-red-600 mr-2"></i>
                Tabel Info
            </h2>
            
            <div class="grid grid-cols-4 gap-4">
                <!-- Card 1 -->
                <div class="bg-white border-2 border-gray-300 rounded-lg p-6 text-center shadow-lg">
                    <div class="text-5xl font-bold mb-2 text-amber-500">{{ $stats['pending_approval'] }}</div>
                    <div class="text-sm font-semibold text-amber-600">Menunggu Persetujuan (Approval Inbox)</div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white border-2 border-gray-300 rounded-lg p-6 text-center shadow-lg">
                    <div class="text-5xl font-bold mb-2 text-red-600">{{ $stats['urgent_requests'] }}</div>
                    <div class="text-sm font-semibold text-red-600">Permintaan URGENT (Deadline < 3 Hari)</div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white border-2 border-gray-300 rounded-lg p-6 text-center shadow-lg">
                    <div class="text-5xl font-bold mb-2 text-green-600">{{ $stats['approved_sla'] }}</div>
                    <div class="text-sm font-semibold text-green-600">Selesai (Finish)</div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white border-2 border-gray-300 rounded-lg p-6 text-center shadow-lg">
                    <div class="text-5xl font-bold mb-2 text-blue-600">{{ $stats['on_process'] }}</div>
                    <div class="text-sm font-semibold text-blue-600">to Vendor</div>
                </div>
            </div>
        </div>

        <!-- Approval Inbox Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="bg-white px-6 py-4 border-b-2 border-gray-200">
                <h2 class="text-xl font-bold" style="color: #ec008c;">
                    <i class="fas fa-inbox mr-2"></i>
                    Approval Inbox
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-red-200">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase" style="width: 60px;">NO</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">BRANCH</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">TUJUAN POSM</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">DEADLINE</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">COUNTDOWN (FITUR 3)</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">ITEM & QTY</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">DETAIL PERMINTAAN</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">AKSI APPROVAL (FITUR 2)</th>
                        </tr>
                    </thead>
                    <tbody id="pendingTableBody" class="divide-y divide-gray-200">
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center">
                                <i class="fas fa-spinner fa-spin text-gray-400 text-3xl mb-2"></i>
                                <p class="text-gray-500">Memuat data...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="pendingPagination" class="bg-gray-50 px-6 py-4 border-t">
                <!-- Pagination will be loaded here -->
            </div>
        </div>

        <!-- INBOX SELESAI (Completed Requests) -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="bg-white px-6 py-4 border-b-2 border-gray-200">
                <h2 class="text-xl font-bold flex items-center" style="color: #ec008c;">
                    <i class="fas fa-check-double mr-2"></i>
                    Approved & Rejected
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b-2 border-gray-300">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase" style="width: 60px;">No</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Branch</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Keperluan</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Deadline</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">ITEM & QTY</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase" style="display: none;">Approved By</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Approved At</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Detail</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Step</th>
                        </tr>
                    </thead>
                    <tbody id="completedTableBody" class="divide-y divide-gray-200">
                        <tr>
                            <td colspan="10" class="px-6 py-8 text-center">
                                <i class="fas fa-spinner fa-spin text-gray-400 text-3xl mb-2"></i>
                                <p class="text-gray-500">Memuat data...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="completedPagination" class="bg-gray-50 px-6 py-4 border-t">
                <!-- Pagination will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4">
            <div class="sticky top-0 text-white px-6 py-4 flex justify-between items-center" style="background-color: #ec008c;">
                <h2 class="text-xl font-bold">
                    <i class="fas fa-file-alt mr-2"></i>Detail Permintaan POSM
                </h2>
                <button onclick="closeDetailModal()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="detailContent" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Function to show notification
        function showNotification(type, message) {
            const notificationHtml = `
                <div class="alert alert-${type}" id="dynamicAlert" style="position: fixed; top: 1rem; right: 1rem; max-width: 400px; border-radius: 0.5rem; padding: 1rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 1000; animation: slideIn 0.3s ease-out; background-color: ${type === 'success' ? '#dcfce7' : '#fee2e2'}; border-left: 4px solid ${type === 'success' ? '#16a34a' : '#dc2626'}; color: ${type === 'success' ? '#166534' : '#991b1b'};">
                    <div style="display: flex; gap: 0.75rem;">
                        <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle" style="width: 1.5rem; height: 1.5rem; flex-shrink: 0; font-size: 1.5rem;"></i>
                        <div style="flex: 1;">
                            <strong style="display: block; font-weight: 600; margin-bottom: 0.25rem;">${type === 'success' ? 'Berhasil!' : 'Error!'}</strong>
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

        function viewDetail(requestId) {
            fetch(`/designer/requests/${requestId}`, {
                headers: {
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    const data = result.data;
                    const deadline = new Date(data.deadline);
                    
                    // Helper function to truncate long text
                    const truncateTextDetail = (text, maxLength = 100) => {
                        if (!text || text === '-') return text || '-';
                        if (text.length <= maxLength) return text;
                        return text.substring(0, maxLength) + '...';
                    };
                    
                    const content = `
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="col-span-2 bg-white border-2 border-pink-500 rounded-lg p-6 shadow-lg">
                                    <h3 class="text-2xl font-bold mb-2" style="color: #ec008c;">Request Number</h3>
                                    <p class="text-3xl font-bold" style="color: #ec008c;">${data.request_number}</p>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 mb-1">Branch / Cabang</p>
                                    <p class="font-bold text-lg text-gray-900">${truncateTextDetail(data.branch, 50)}</p>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 mb-1">Nama Requester</p>
                                    <p class="font-bold text-lg text-gray-900">${truncateTextDetail(data.requester_name, 50)}</p>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 mb-1">Nomor Telepon</p>
                                    <p class="font-bold text-lg text-gray-900">${data.requester_phone || '-'}</p>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 mb-1">Deadline POSM Diterima</p>
                                    <p class="font-bold text-lg text-gray-900">${deadline.toLocaleDateString('id-ID')}</p>
                                </div>

                                <div class="col-span-2 bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 mb-1">Alamat Pengiriman</p>
                                    <div class="font-bold text-gray-900 cursor-pointer hover:text-pink-600 transition" 
                                         onclick="showFullTextPopup('Alamat Pengiriman', \`${(data.shipping_address || '-').replace(/`/g, '\\`').replace(/\n/g, '\\n')}\`)">
                                        <p class="break-words">${truncateTextDetail(data.shipping_address, 120)}</p>
                                        ${(data.shipping_address || '-').length > 120 ? '<span class="text-xs text-pink-600 font-normal"><i class="fas fa-expand-alt mr-1"></i>Klik untuk lihat lengkap</span>' : ''}
                                    </div>
                                </div>

                                <div class="bg-yellow-50 rounded-lg p-4 border-2 border-yellow-400">
                                    <p class="text-sm text-gray-600 mb-1">Tujuan/Peruntukan POSM</p>
                                    <div class="font-bold text-lg text-gray-900 cursor-pointer hover:text-pink-600 transition" 
                                         onclick="showFullTextPopup('Tujuan/Peruntukan POSM', \`${(data.purpose || '-').replace(/`/g, '\\`').replace(/\n/g, '\\n')}\`)">
                                        <p class="break-words">${truncateTextDetail(data.purpose, 80)}</p>
                                        ${(data.purpose || '-').length > 80 ? '<span class="text-xs text-pink-600 font-normal"><i class="fas fa-expand-alt mr-1"></i>Klik untuk lihat lengkap</span>' : ''}
                                    </div>
                                </div>

                                <div class="bg-yellow-50 rounded-lg p-4 border-2 border-yellow-400">
                                    <p class="text-sm text-gray-600 mb-1">Jenis POSM (Katalog)</p>
                                    <div class="font-bold text-lg text-gray-900 cursor-pointer hover:text-pink-600 transition" 
                                         onclick="showFullTextPopup('Jenis POSM (Katalog)', \`${(data.posm_type || '-').replace(/`/g, '\\`').replace(/\n/g, '\\n')}\`)">
                                        <p class="break-words">${truncateTextDetail(data.posm_type, 50)}</p>
                                        ${(data.posm_type || '-').length > 50 ? '<span class="text-xs text-pink-600 font-normal"><i class="fas fa-expand-alt mr-1"></i>Klik untuk lihat lengkap</span>' : ''}
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 mb-1">Jumlah (QTY) Digunakan</p>
                                    <p class="font-bold text-lg text-gray-900">${data.quantity} Pcs</p>
                                </div>

                                ${data.spreadsheet_link || data.design_link ? `
                                <div class="col-span-2 bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                                    <p class="text-sm font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-link mr-2"></i>Link Spesifikasi Item
                                    </p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        ${data.spreadsheet_link ? `
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <p class="text-xs text-gray-500 mb-2">Link Spreadsheet Ukuran</p>
                                            <a href="${data.spreadsheet_link}" target="_blank" 
                                               class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded transition w-full justify-center">
                                                <i class="fas fa-external-link-alt mr-2"></i>Buka Link
                                            </a>
                                        </div>
                                        ` : ''}
                                        ${data.design_link ? `
                                        <div class="bg-white rounded-lg p-3 shadow-sm">
                                            <p class="text-xs text-gray-500 mb-2">Link PPT Desain</p>
                                            <a href="${data.design_link}" target="_blank" 
                                               class="inline-flex items-center px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm rounded transition w-full justify-center">
                                                <i class="fas fa-external-link-alt mr-2"></i>Buka Link
                                            </a>
                                        </div>
                                        ` : ''}
                                    </div>
                                </div>
                                ` : ''}

                                ${data.mandatory_elements ? `
                                <div class="col-span-2 bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 mb-1">Detail Request (Materi Desain)</p>
                                    <div class="font-semibold text-gray-900 cursor-pointer hover:text-pink-600 transition" 
                                         onclick="showFullTextPopup('Detail Request (Materi Desain)', \`${data.mandatory_elements.replace(/`/g, '\\`').replace(/\n/g, '\\n')}\`)">
                                        <p class="break-words">${truncateTextDetail(data.mandatory_elements, 150)}</p>
                                        ${data.mandatory_elements.length > 150 ? '<span class="text-xs text-pink-600 font-normal"><i class="fas fa-expand-alt mr-1"></i>Klik untuk lihat lengkap</span>' : ''}
                                    </div>
                                </div>
                                ` : ''}

                                ${data.notes ? `
                                <div class="col-span-2 bg-orange-50 rounded-lg p-4 border-l-4 border-orange-500">
                                    <p class="text-sm text-gray-600 mb-1">Catatan Tambahan</p>
                                    <div class="font-semibold text-gray-900 cursor-pointer hover:text-pink-600 transition" 
                                         onclick="showFullTextPopup('Catatan Tambahan', \`${data.notes.replace(/`/g, '\\`').replace(/\n/g, '\\n')}\`)">
                                        <p class="break-words">${truncateTextDetail(data.notes, 150)}</p>
                                        ${data.notes.length > 150 ? '<span class="text-xs text-pink-600 font-normal"><i class="fas fa-expand-alt mr-1"></i>Klik untuk lihat lengkap</span>' : ''}
                                    </div>
                                </div>
                                ` : ''}

                                <div class="col-span-2 bg-gray-100 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 mb-1">Waktu Request</p>
                                    <p class="font-bold text-gray-900">${new Date(data.created_at).toLocaleString('id-ID')}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    document.getElementById('detailContent').innerHTML = content;
                    document.getElementById('detailModal').classList.remove('hidden');
                    document.getElementById('detailModal').classList.add('flex');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.location.reload();
            });
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.getElementById('detailModal').classList.remove('flex');
        }

        // Function to show full text in a popup modal
        function showFullTextPopup(title, text) {
            const modalHtml = `
                <div id="fullTextModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-[60]" onclick="closeFullTextPopup()">
                    <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[80vh] overflow-hidden m-4" onclick="event.stopPropagation()">
                        <div class="sticky top-0 text-white px-6 py-4 flex justify-between items-center" style="background-color: #ec008c;">
                            <h3 class="text-lg font-bold">
                                <i class="fas fa-info-circle mr-2"></i>${title}
                            </h3>
                            <button onclick="closeFullTextPopup()" class="text-white hover:text-gray-200 transition">
                                <i class="fas fa-times text-2xl"></i>
                            </button>
                        </div>
                        <div class="p-6 overflow-y-auto max-h-[calc(80vh-80px)]">
                            <div class="bg-gray-50 rounded-lg p-4 border-2 border-gray-200">
                                <p class="text-gray-900 whitespace-pre-wrap break-words leading-relaxed">${text}</p>
                            </div>
                        </div>
                        <div class="sticky bottom-0 bg-gray-100 px-6 py-3 flex justify-end border-t">
                            <button onclick="closeFullTextPopup()" 
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                                <i class="fas fa-times mr-2"></i>Tutup
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }

        function closeFullTextPopup() {
            const modal = document.getElementById('fullTextModal');
            if (modal) {
                modal.remove();
            }
        }

        function toggleTruncate(element) {
            element.classList.toggle('expanded');
            const icon = element.querySelector('.truncate-icon');
            if (element.classList.contains('expanded')) {
                icon.classList.remove('fa-angle-down');
                icon.classList.add('fa-angle-up');
            } else {
                icon.classList.remove('fa-angle-up');
                icon.classList.add('fa-angle-down');
            }
        }

        // Direct approve function - approve with completed status
        function approveRequestDirectly(requestId) {
            if (confirm('Apakah Anda yakin ingin menyetujui permintaan ini?')) {
                const button = event.target;
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Proses...';
                
                fetch(`/designer/requests/${requestId}/approval`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'approve',
                        production_status: 'completed'
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showNotification('success', 'Permintaan berhasil disetujui!');
                        setTimeout(() => {
                            loadPendingRequests();
                            loadCompletedRequests();
                        }, 1000);
                    } else {
                        showNotification('error', result.message || 'Gagal menyetujui permintaan');
                        button.disabled = false;
                        button.innerHTML = '✓ Selesai';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('error', 'Terjadi kesalahan saat menyetujui permintaan');
                    button.disabled = false;
                    button.innerHTML = '✓ Selesai';
                });
            }
        }

        // Direct reject function - show rejection form
        function rejectRequestDirectly(requestId) {
            const modalHtml = `
                <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: flex;">
                    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-xl">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-red-600 mb-3">
                                <i class="fas fa-times-circle mr-2"></i>Tolak Permintaan
                            </h3>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Penolakan:</label>
                            <textarea id="reject-reason-direct-${requestId}" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                      placeholder="Tuliskan alasan penolakan..."></textarea>
                        </div>
                        <div class="flex gap-3 justify-end">
                            <button onclick="closeRejectModalDirect()" 
                                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold transition">
                                Batal
                            </button>
                            <button onclick="confirmRejectionDirect(${requestId})" 
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">
                                <i class="fas fa-paper-plane mr-1"></i>Kirim Penolakan
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }

        function closeRejectModalDirect() {
            const modal = document.getElementById('rejectModal');
            if (modal) {
                modal.remove();
            }
        }

        function confirmRejectionDirect(requestId) {
            const reason = document.getElementById(`reject-reason-direct-${requestId}`).value.trim();
            
            if (!reason) {
                alert('Alasan penolakan wajib diisi!');
                return;
            }

            const button = event.target;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Proses...';

            fetch(`/designer/requests/${requestId}/approval`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    action: 'reject',
                    rejection_reason: reason
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showNotification('success', 'Permintaan berhasil ditolak');
                    closeRejectModalDirect();
                    setTimeout(() => {
                        loadPendingRequests();
                        loadCompletedRequests();
                    }, 1000);
                } else {
                    showNotification('error', result.message || 'Gagal menolak permintaan');
                    button.disabled = false;
                    button.innerHTML = '<i class="fas fa-paper-plane mr-1"></i>Kirim Penolakan';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Terjadi kesalahan saat menolak permintaan');
                button.disabled = false;
                button.innerHTML = '<i class="fas fa-paper-plane mr-1"></i>Kirim Penolakan';
            });
        }

        // View Step function - show timeline/progress of the request
        function viewStep(requestId) {
            // Show modal with production action buttons
            const modalHtml = `
                <div id="stepModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: flex;">
                    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg m-4">
                        <div class="sticky top-0 text-white px-6 py-4 flex justify-between items-center" style="background-color: #ec008c;">
                            <h2 class="text-xl font-bold">
                                <i class="fas fa-tasks mr-2"></i>Production Step
                            </h2>
                            <button onclick="closeStepModal()" class="text-white hover:text-gray-200">
                                <i class="fas fa-times text-2xl"></i>
                            </button>
                        </div>
                        <div class="p-6">
                            <div class="bg-green-50 border-2 border-green-500 rounded-lg p-6">
                                <h4 class="font-bold text-green-800 mb-4 flex items-center text-lg">
                                    <i class="fas fa-check-circle mr-2"></i>AKSI LANJUTAN
                                </h4>
                                <div class="flex gap-3">
                                    <button onclick="setProductionStatusFromStep(${requestId}, 'start_produce')" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg text-base font-semibold transition flex-1 flex items-center justify-center">
                                        <i class="fas fa-play mr-2"></i>to Vendor
                                    </button>
                                    <button onclick="setProductionStatusFromStep(${requestId}, 'completed')" 
                                            class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-lg text-base font-semibold transition flex-1 flex items-center justify-center">
                                        <i class="fas fa-check mr-2"></i>Selesai
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }

        function closeStepModal() {
            const modal = document.getElementById('stepModal');
            if (modal) {
                modal.remove();
            }
        }

        // Set production status from Step modal
        function setProductionStatusFromStep(requestId, status) {
            const statusText = status === 'start_produce' ? 'to Vendor' : 'Selesai';
            
            if (confirm(`Ubah status menjadi: ${statusText}?`)) {
                fetch(`/designer/requests/${requestId}/production`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        production_status: status
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showNotification('success', `Status berhasil diubah menjadi ${statusText}`);
                        closeStepModal();
                        setTimeout(() => {
                            loadCompletedRequests();
                        }, 1000);
                    } else {
                        showNotification('error', result.message || 'Gagal mengubah status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('error', 'Terjadi kesalahan saat mengubah status');
                });
            }
        }

        function approveRequest(requestId) {
            // Hide approval buttons
            document.getElementById(`approval-buttons-${requestId}`).style.display = 'none';
            
            // Hide reject action box if shown
            const rejectBox = document.getElementById(`action-reject-${requestId}`);
            rejectBox.classList.remove('show-action');
            rejectBox.classList.add('hidden-action');
            
            // Show ACC action box
            const accBox = document.getElementById(`action-acc-${requestId}`);
            accBox.classList.remove('hidden-action');
            accBox.classList.add('show-action');
        }

        function rejectRequest(requestId) {
            // Hide approval buttons
            document.getElementById(`approval-buttons-${requestId}`).style.display = 'none';
            
            // Hide ACC action box if shown
            const accBox = document.getElementById(`action-acc-${requestId}`);
            accBox.classList.remove('show-action');
            accBox.classList.add('hidden-action');
            
            // Show reject action box
            const rejectBox = document.getElementById(`action-reject-${requestId}`);
            rejectBox.classList.remove('hidden-action');
            rejectBox.classList.add('show-action');
        }

        function setProductionStatus(requestId, status) {
            const statusText = status === 'start_produce' ? 'Start Produce' : 'Selesai';
            
            // Create modal confirmation
            const modalHtml = `
                <div id="confirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50" style="display: flex;">
                    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-xl">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-green-600 mb-2">
                                <i class="fas fa-check-circle mr-2"></i>ACCED - Proses Cetak
                            </h3>
                            <p class="text-gray-700">Status akan diubah menjadi: <strong>${statusText}</strong></p>
                        </div>
                        <div class="flex gap-3 justify-end">
                            <button onclick="closeConfirmModal()" 
                                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold transition">
                                Batal
                            </button>
                            <button onclick="confirmStatusChange(${requestId}, '${status}')" 
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
                                Ya
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }

        function closeConfirmModal() {
            const modal = document.getElementById('confirmModal');
            if (modal) {
                modal.remove();
            }
        }

        function confirmStatusChange(requestId, status) {
            closeConfirmModal();
            
            fetch(`/designer/requests/${requestId}/approval`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    action: 'approve',
                    production_status: status
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showNotification('success', result.message);
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showNotification('error', result.message || 'Gagal menyetujui permintaan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Terjadi kesalahan saat menyetujui permintaan');
            });
        }

        function submitRejection(requestId) {
            const reason = document.getElementById(`reject-reason-${requestId}`).value.trim();
            
            if (!reason) {
                // Show inline error message instead of alert
                const reasonField = document.getElementById(`reject-reason-${requestId}`);
                reasonField.style.borderColor = '#dc2626';
                reasonField.placeholder = '⚠️ Alasan wajib diisi!';
                return;
            }

            // Create modal confirmation
            const modalHtml = `
                <div id="confirmRejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50" style="display: flex;" onclick="closeRejectModal()">
                    <div class="max-w-md w-full mx-4" onclick="event.stopPropagation()">
                        <div class="bg-white rounded-lg p-6 shadow-xl">
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-red-600 mb-2">
                                    <i class="fas fa-times-circle mr-2"></i>AKSI LANJUTAN
                                </h3>
                                <p class="text-sm text-gray-700 mb-3">If 'ditolak', so muncul kolom alasan</p>
                                <div class="bg-red-50 border-2 border-red-500 rounded-lg p-4">
                                    <p class="text-sm font-semibold text-gray-800 mb-1">Alasan Penolakan:</p>
                                    <p class="text-sm text-gray-700">${reason}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-center">
                            <button onclick="confirmRejection(${requestId}, \`${reason}\`)" 
                                    class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition shadow-lg">
                                <i class="fas fa-paper-plane mr-2"></i>Kirim Penolakan
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }

        function closeRejectModal() {
            const modal = document.getElementById('confirmRejectModal');
            if (modal) {
                modal.remove();
            }
        }

        function confirmRejection(requestId, reason) {
            closeRejectModal();

            fetch(`/designer/requests/${requestId}/approval`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    action: 'reject',
                    rejection_reason: reason
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showNotification('success', result.message);
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showNotification('error', result.message || 'Gagal menolak permintaan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Terjadi kesalahan saat menolak permintaan');
            });
        }

        // Auto hide alerts after 5 seconds
        setTimeout(() => {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            if (successAlert) successAlert.style.display = 'none';
            if (errorAlert) errorAlert.style.display = 'none';
        }, 5000);

        // AJAX Loading Functions
        let currentPendingPage = 1;
        let currentCompletedPage = 1;

        async function loadPendingRequests(page = 1) {
            try {
                const response = await fetch(`/designer?type=pending&page=${page}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    const tbody = document.getElementById('pendingTableBody');
                    const data = result.data;
                    
                    if (data.data.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                                    <p class="text-gray-500 text-lg">Tidak ada permintaan menunggu approval</p>
                                </td>
                            </tr>
                        `;
                    } else {
                        tbody.innerHTML = data.data.map((request, index) => {
                            const rowNumber = (data.current_page - 1) * data.per_page + index + 1;
                            const deadline = new Date(request.deadline);
                            const today = new Date();
                            const diffTime = deadline - today;
                            const daysLeft = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                            
                            let countdownClass, countdownText;
                            if (daysLeft < 0) {
                                countdownClass = 'countdown-expired';
                                countdownText = Math.abs(daysLeft) + ' Hari (Lewat)';
                            } else if (daysLeft <= 2) {
                                countdownClass = 'countdown-urgent';
                                countdownText = daysLeft + ' HARI!';
                            } else if (daysLeft <= 5) {
                                countdownClass = 'countdown-warning';
                                countdownText = daysLeft + ' Hari';
                            } else {
                                countdownClass = 'countdown-normal';
                                countdownText = daysLeft + ' Hari';
                            }
                            
                            const formattedDeadline = deadline.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                            
                            const truncateText = (text, maxLength = 30) => {
                                if (!text) return '-';
                                return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
                            };
                            
                            return `
                                <tr class="hover:bg-red-50" id="row-${request.id}">
                                    <td class="px-4 py-3 text-center whitespace-nowrap">
                                        <span class="font-bold text-gray-700">${rowNumber}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="font-semibold text-gray-900">${truncateText(request.branch, 20)}</span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700" title="${request.purpose || '-'}">
                                        ${truncateText(request.purpose, 40)}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-700">
                                        ${formattedDeadline}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-3 py-1 ${countdownClass} text-xs font-bold rounded-full">
                                            ${countdownText}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700" title="${request.posm_type}">
                                        ${truncateText(request.posm_type, 25)} (${request.quantity} Pcs)
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <button onclick="viewDetail(${request.id})" 
                                                class="text-white px-4 py-2 rounded-lg text-sm font-semibold transition" style="background-color: #ec008c;" onmouseover="this.style.backgroundColor='#d3007d'" onmouseout="this.style.backgroundColor='#ec008c'">
                                            <i class="fas fa-file-alt mr-1"></i>Lihat Format
                                        </button>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex gap-2" id="approval-buttons-${request.id}">
                                            <button onclick="approveRequestDirectly(${request.id})" 
                                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                                ✓ ACC
                                            </button>
                                            <button onclick="rejectRequestDirectly(${request.id})" 
                                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                                ✗ Tidak
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        }).join('');
                    }
                    
                    renderPendingPagination(data);
                    currentPendingPage = page;
                }
            } catch (error) {
                console.error('Error loading pending requests:', error);
                document.getElementById('pendingTableBody').innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-red-600">
                            <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
                            <p>Gagal memuat data. Silakan refresh halaman.</p>
                        </td>
                    </tr>
                `;
            }
        }

        async function loadCompletedRequests(page = 1) {
            try {
                const response = await fetch(`/designer?type=completed&page=${page}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    const tbody = document.getElementById('completedTableBody');
                    const data = result.data;
                    
                    if (data.data.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="10" class="px-6 py-12 text-center">
                                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                                    <p class="text-gray-500 text-lg">Belum ada permintaan selesai</p>
                                </td>
                            </tr>
                        `;
                    } else {
                        tbody.innerHTML = data.data.map((request, index) => {
                            const rowNumber = (data.current_page - 1) * data.per_page + index + 1;
                            const statusBadge = request.status === 'approved' 
                                ? '<span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">✓ ACC</span>'
                                : request.status === 'rejected'
                                ? '<span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">✗ DITOLAK</span>'
                                : '<span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-bold rounded-full">-</span>';
                            
                            const productionBadge = request.production_status === 'start_produce'
                                ? '<span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-full"><i class="fas fa-play mr-1"></i>Produksi Dimulai</span>'
                                : request.production_status === 'completed'
                                ? '<span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full"><i class="fas fa-check-double mr-1"></i>Selesai</span>'
                                : '<span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-bold rounded-full">Belum Produksi</span>';
                            
                            const approvedAt = request.approved_at ? new Date(request.approved_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
                            const approverName = request.approver ? request.approver.name : '-';
                            
                            const truncateText = (text, maxLength = 30) => {
                                if (!text) return '-';
                                return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
                            };
                            
                            const deadlineDate = request.deadline ? new Date(request.deadline).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
                            
                            return `
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-center whitespace-nowrap">
                                        <span class="font-bold text-gray-700">${rowNumber}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="font-semibold text-gray-900">${truncateText(request.branch, 20)}</span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700" title="${request.purpose || '-'}">
                                        ${truncateText(request.purpose, 40)}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-700">
                                        ${deadlineDate}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700" title="${request.posm_type}">
                                        ${truncateText(request.posm_type, 25)} (${request.quantity} Pcs)
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        ${statusBadge}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap" style="display: none;">
                                        ${productionBadge}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-700 text-sm">
                                        ${approvedAt}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <button onclick="viewDetail(${request.id})" 
                                                class="text-white px-4 py-2 rounded-lg text-sm font-semibold transition"
                                                style="background-color: #ec008c;"
                                                onmouseover="this.style.backgroundColor='#d3007d'"
                                                onmouseout="this.style.backgroundColor='#ec008c'">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </button>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <button onclick="viewStep(${request.id})" 
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                            <i class="fas fa-tasks mr-1"></i>Step
                                        </button>
                                    </td>
                                </tr>
                            `;
                        }).join('');
                    }
                    
                    renderCompletedPagination(data);
                    currentCompletedPage = page;
                }
            } catch (error) {
                console.error('Error loading completed requests:', error);
                document.getElementById('completedTableBody').innerHTML = `
                    <tr>
                        <td colspan="10" class="px-6 py-8 text-center text-red-600">
                            <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
                            <p>Gagal memuat data. Silakan refresh halaman.</p>
                        </td>
                    </tr>
                `;
            }
        }

        function renderPendingPagination(pagination) {
            const container = document.getElementById('pendingPagination');
            
            if (pagination.last_page <= 1) {
                container.innerHTML = '';
                return;
            }
            
            let paginationHTML = '<div class="flex items-center justify-between"><div class="flex items-center gap-2">';
            
            // Previous button
            if (pagination.current_page > 1) {
                paginationHTML += `
                    <button onclick="loadPendingRequests(${pagination.current_page - 1})" 
                            class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                `;
            }
            
            // Page numbers
            for (let i = 1; i <= pagination.last_page; i++) {
                if (i === pagination.current_page) {
                    paginationHTML += `
                        <button class="w-10 h-10 bg-gray-800 text-white rounded-lg font-semibold">
                            ${i}
                        </button>
                    `;
                } else {
                    paginationHTML += `
                        <button onclick="loadPendingRequests(${i})" 
                                class="w-10 h-10 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            ${i}
                        </button>
                    `;
                }
            }
            
            // Next button
            if (pagination.current_page < pagination.last_page) {
                paginationHTML += `
                    <button onclick="loadPendingRequests(${pagination.current_page + 1})" 
                            class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                `;
            }
            
            paginationHTML += `</div><p class="text-sm text-gray-600">Total: <span class="font-semibold">${pagination.total}</span> Pending Request</p></div>`;
            
            container.innerHTML = paginationHTML;
        }

        function renderCompletedPagination(pagination) {
            const container = document.getElementById('completedPagination');
            
            if (pagination.last_page <= 1) {
                container.innerHTML = '';
                return;
            }
            
            let paginationHTML = '<div class="flex items-center justify-between"><div class="flex items-center gap-2">';
            
            // Previous button
            if (pagination.current_page > 1) {
                paginationHTML += `
                    <button onclick="loadCompletedRequests(${pagination.current_page - 1})" 
                            class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                `;
            }
            
            // Page numbers
            for (let i = 1; i <= pagination.last_page; i++) {
                if (i === pagination.current_page) {
                    paginationHTML += `
                        <button class="w-10 h-10 bg-gray-800 text-white rounded-lg font-semibold">
                            ${i}
                        </button>
                    `;
                } else {
                    paginationHTML += `
                        <button onclick="loadCompletedRequests(${i})" 
                                class="w-10 h-10 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            ${i}
                        </button>
                    `;
                }
            }
            
            // Next button
            if (pagination.current_page < pagination.last_page) {
                paginationHTML += `
                    <button onclick="loadCompletedRequests(${pagination.current_page + 1})" 
                            class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                `;
            }
            
            paginationHTML += `</div><p class="text-sm text-gray-600">Total: <span class="font-semibold">${pagination.total}</span> Completed Request</p></div>`;
            
            container.innerHTML = paginationHTML;
        }

        // Load both tables on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadPendingRequests(1);
            loadCompletedRequests(1);
        });
    </script>
</body>
</html>

