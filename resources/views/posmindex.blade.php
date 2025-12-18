<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Permintaan POSM - Dashboard Indosat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/responsive-global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/posmindex.css') }}">
</head>
<body class="posm-container">
    <!-- Navbar -->
    <nav class="navbar-gradient-posm">
        <div class="container mx-auto px-4 py-4 navbar-container-posm">
            <div class="flex justify-between items-center navbar-content-posm">
                <div>
                    <h1 class="text-2xl font-bold text-white">Dashboard Indosat - Markom Branch</h1>
                    <p class="text-white text-opacity-90 text-sm">{{ Auth::user()->getRoleDisplayName() }}</p>
                </div>
                <div class="flex items-center gap-4" style="flex-shrink: 1;">
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

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-t-2xl shadow-lg p-6 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <i class="fas fa-clipboard-list text-purple-700 text-3xl"></i>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Daftar Permintaan POSM</h1>
                        <p class="text-gray-600 text-sm mt-1">Kelola permintaan POSM/Matpro Anda</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('posm-requests.upload') }}" 
                       class="bg-purple-700 hover:bg-purple-800 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center gap-2 shadow-lg hover:shadow-xl">
                        <i class="fas fa-upload"></i>
                        Upload Bukti Penerimaan
                    </a>
                    <a href="{{ route('posm-requests.create') }}" 
                       class="bg-purple-700 hover:bg-purple-800 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center gap-2 shadow-lg hover:shadow-xl">
                        <i class="fas fa-plus"></i>
                        Buat Permintaan Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="bg-white rounded-b-2xl shadow-lg p-6 mb-6">
            <div class="grid grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Permintaan</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $requests->count() }}</p>
                    </div>
                    <i class="fas fa-file-alt text-gray-400 text-3xl"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Menunggu Persetujuan</p>
                        <p class="text-2xl font-bold text-amber-600">{{ $requests->where('status', 'pending')->count() }}</p>
                    </div>
                    <i class="fas fa-clock text-amber-400 text-3xl"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Disetujui</p>
                        <p class="text-2xl font-bold text-green-600">{{ $requests->where('status', 'approved')->count() }}</p>
                    </div>
                    <i class="fas fa-check-circle text-green-400 text-3xl"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Selesai</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $requests->where('status', 'completed')->count() }}</p>
                    </div>
                    <i class="fas fa-check-double text-blue-400 text-3xl"></i>
                </div>
            </div>
            </div>
        </div>

        <!-- POSM Requests Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <i class="fas fa-clipboard-list text-purple-700 text-2xl"></i>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Riwayat Permintaan POSM</h2>
                        <p class="text-gray-600 text-sm mt-1">Daftar semua permintaan POSM yang telah dibuat</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full" id="posmRequestsTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                NO
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Waktu Request
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Branch / Keperluan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jenis POSM
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                QTY
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deadline
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody id="posmRequestsBody" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                                <p>Memuat data...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- POSM Requests Pagination -->
            <div id="posmRequestsPagination" class="bg-gray-50 px-6 py-4 border-t">
                <!-- Pagination will be rendered here by JavaScript -->
            </div>
        </div>

        <!-- Purchase Order Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Red Header like in the image -->
            <div class="bg-white p-4 border-b-2 border-red-600">
                <div class="flex items-center gap-3">
                    <i class="fas fa-file-invoice text-2xl text-red-600"></i>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Data Purchase Order</h2>
                        <p class="text-sm text-gray-600">Data purchase order dari Admin</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full" id="poTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NOMOR PO</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JUDUL PO</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TANGGAL PO</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RFS DATE</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JENIS ITEM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="poTableBody" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                                <p>Memuat data...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- PO Pagination -->
            <div id="poPagination" class="mt-6">
                <!-- Pagination will be rendered here by JavaScript -->
            </div>
        </div>
    </div>

    <!-- PO Detail Modal -->
    <div id="poDetailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Detail Purchase Order</h3>
                <button onclick="closePOModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="poModalContent" class="space-y-4">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Detail Permintaan POSM</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="modalContent" class="space-y-4">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        // Current page tracking
        let currentPOPage = 1;
        let currentPOSMRequestsPage = 1;

        // Load data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadPOSMRequestsData(1);
            loadPOData(1);
        });

        // Load POSM Requests data with pagination
        async function loadPOSMRequestsData(page = 1) {
            try {
                const response = await fetch(`/posm-requests?page=${page}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch POSM Requests data');
                }

                const result = await response.json();
                
                if (result.success && result.data) {
                    const paginatedData = result.data;
                    const requests = paginatedData.data || paginatedData;
                    
                    displayPOSMRequestsData(requests, page, paginatedData.per_page || 10);
                    
                    if (paginatedData.last_page) {
                        renderPOSMRequestsPagination(paginatedData);
                    }
                    
                    currentPOSMRequestsPage = page;
                }
            } catch (error) {
                console.error('Error loading POSM Requests data:', error);
                document.getElementById('posmRequestsBody').innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-red-500">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p>Gagal memuat data permintaan POSM</p>
                        </td>
                    </tr>
                `;
            }
        }

        // Display POSM Requests data in table
        function displayPOSMRequestsData(requests, currentPage = 1, perPage = 10) {
            const tbody = document.getElementById('posmRequestsBody');
            
            if (requests.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                            <p class="text-gray-500 text-lg mb-4">Belum ada permintaan POSM</p>
                            <a href="{{ route('posm-requests.create') }}" 
                               class="inline-block bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition">
                                <i class="fas fa-plus mr-2"></i>Buat Permintaan Pertama
                            </a>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = requests.map((request, index) => {
                const rowNumber = (currentPage - 1) * perPage + index + 1;
                const statusBadgeClass = getStatusBadgeClass(request.status);
                const statusLabel = getStatusLabel(request.status);
                const createdAt = new Date(request.created_at).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const deadline = new Date(request.deadline).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
                
                // Truncate text helper
                const truncate = (text, maxLength = 30) => {
                    if (!text) return 'N/A';
                    return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
                };
                
                return `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${rowNumber}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${createdAt}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="font-medium" title="${request.branch}">${truncate(request.branch, 25)}</div>
                            <div class="text-gray-500" title="${request.purpose || 'N/A'}">${truncate(request.purpose, 30)}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900" title="${request.posm_type}">
                            ${truncate(request.posm_type, 20)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${request.quantity}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${deadline}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statusBadgeClass}">
                                ${statusLabel}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="viewDetail(${request.id})" 
                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye"></i>
                            </button>
                            ${request.status === 'pending' ? `
                                <button onclick="deleteRequest(${request.id})" 
                                        class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            ` : ''}
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Render POSM Requests pagination
        function renderPOSMRequestsPagination(paginationData) {
            const container = document.getElementById('posmRequestsPagination');
            if (!container) return;

            const { current_page, last_page } = paginationData;
            
            let html = '<nav class="flex items-center justify-center gap-2 py-4">';
            
            // Previous button
            if (current_page > 1) {
                html += `<button onclick="loadPOSMRequestsData(${current_page - 1})" 
                    class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>`;
            } else {
                html += `<button disabled 
                    class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>`;
            }
            
            // Page numbers
            for (let i = 1; i <= last_page; i++) {
                if (i === current_page) {
                    html += `<button class="inline-flex items-center justify-center w-10 h-10 text-sm font-semibold text-white bg-gray-800 border border-gray-800 rounded">${i}</button>`;
                } else {
                    html += `<button onclick="loadPOSMRequestsData(${i})" 
                        class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">${i}</button>`;
                }
            }
            
            // Next button
            if (current_page < last_page) {
                html += `<button onclick="loadPOSMRequestsData(${current_page + 1})" 
                    class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>`;
            } else {
                html += `<button disabled 
                    class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>`;
            }
            
            html += '</nav>';
            container.innerHTML = html;
        }

        // Helper functions for status badge
        function getStatusBadgeClass(status) {
            const classes = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'approved': 'bg-green-100 text-green-800',
                'rejected': 'bg-red-100 text-red-800',
                'in_production': 'bg-blue-100 text-blue-800',
                'completed': 'bg-purple-100 text-purple-800'
            };
            return classes[status] || 'bg-gray-100 text-gray-800';
        }

        function getStatusLabel(status) {
            const labels = {
                'pending': 'Menunggu',
                'approved': 'Disetujui',
                'rejected': 'Ditolak',
                'in_production': 'Produksi',
                'completed': 'Selesai'
            };
            return labels[status] || status;
        }

        // Load Purchase Order data with pagination
        async function loadPOData(page = 1) {
            try {
                const response = await fetch(`/purchase-orders?page=${page}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch PO data');
                }

                const result = await response.json();
                
                if (result.success && result.data) {
                    // Handle paginated response
                    const paginatedData = result.data;
                    const purchaseOrders = paginatedData.data || paginatedData;
                    
                    displayPOData(purchaseOrders, page, paginatedData.per_page || 10);
                    
                    // Render pagination if data is paginated
                    if (paginatedData.last_page) {
                        renderPOPagination(paginatedData);
                    }
                    
                    currentPOPage = page;
                }
            } catch (error) {
                console.error('Error loading PO data:', error);
                document.getElementById('poTableBody').innerHTML = `
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-red-500">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p>Gagal memuat data Purchase Order</p>
                        </td>
                    </tr>
                `;
            }
        }

        // Render PO pagination
        function renderPOPagination(paginationData) {
            const container = document.getElementById('poPagination');
            if (!container) return;

            const { current_page, last_page, per_page, total, from } = paginationData;
            
            let html = '<nav class="flex items-center justify-center gap-2 py-4">';
            
            // Previous button
            if (current_page > 1) {
                html += `<button onclick="loadPOData(${current_page - 1})" 
                    class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>`;
            } else {
                html += `<button disabled 
                    class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>`;
            }
            
            // Page numbers
            for (let i = 1; i <= last_page; i++) {
                if (i === current_page) {
                    html += `<button class="inline-flex items-center justify-center w-10 h-10 text-sm font-semibold text-white bg-gray-800 border border-gray-800 rounded">${i}</button>`;
                } else {
                    html += `<button onclick="loadPOData(${i})" 
                        class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">${i}</button>`;
                }
            }
            
            // Next button
            if (current_page < last_page) {
                html += `<button onclick="loadPOData(${current_page + 1})" 
                    class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>`;
            } else {
                html += `<button disabled 
                    class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>`;
            }
            
            html += '</nav>';
            container.innerHTML = html;
        }

        // Display PO data in table
        function displayPOData(purchaseOrders, currentPage = 1, perPage = 10) {
            const tbody = document.getElementById('poTableBody');
            
            if (purchaseOrders.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                            <p class="text-gray-500 text-lg">Belum ada data Purchase Order</p>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = purchaseOrders.map((po, index) => {
                // Calculate actual row number based on pagination
                const rowNumber = ((currentPage - 1) * perPage) + index + 1;
                
                const tanggalPO = po.tanggal_po ? new Date(po.tanggal_po).toLocaleDateString('id-ID') : '-';
                const rfsDate = po.rfs_date ? new Date(po.rfs_date).toLocaleDateString('id-ID') : '-';
                
                // Format jenis_item (array to string)
                let jenisItemText = '-';
                if (po.jenis_item && Array.isArray(po.jenis_item)) {
                    const itemLabels = {
                        'baliho': 'Baliho',
                        'poster': 'Poster',
                        'pamflet': 'Pamflet',
                        'other': po.jenis_item_lainnya || 'Lainnya'
                    };
                    jenisItemText = po.jenis_item.map(item => itemLabels[item] || item).join(', ');
                }
                
                return `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${rowNumber}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-semibold text-gray-900">${po.nomor_po}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-900">${po.judul_po || '-'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${tanggalPO}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${rfsDate}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">${jenisItemText}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="viewPODetail(${po.id})" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg inline-flex items-center gap-2 transition">
                                <i class="fas fa-eye"></i>
                                Lihat Bukti
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // View PO Detail
        async function viewPODetail(poId) {
            try {
                const response = await fetch(`/purchase-orders/${poId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const result = await response.json();
                
                if (result.success && result.data) {
                    const po = result.data;
                    const items = result.items || [];
                    
                    // Format jenis_item
                    let jenisItemText = '-';
                    if (po.jenis_item && Array.isArray(po.jenis_item)) {
                        const itemLabels = {
                            'baliho': 'Baliho',
                            'poster': 'Poster',
                            'pamflet': 'Pamflet',
                            'other': po.jenis_item_lainnya || 'Lainnya'
                        };
                        jenisItemText = po.jenis_item.map(item => itemLabels[item] || item).join(', ');
                    }
                    
                    document.getElementById('poModalContent').innerHTML = `
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nomor PO</label>
                                    <p class="mt-1 text-sm text-gray-900 font-semibold">${po.nomor_po}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Judul PO</label>
                                    <p class="mt-1 text-sm text-gray-900">${po.judul_po || '-'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal PO</label>
                                    <p class="mt-1 text-sm text-gray-900">${po.tanggal_po ? new Date(po.tanggal_po).toLocaleDateString('id-ID') : '-'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">RFS Date</label>
                                    <p class="mt-1 text-sm text-gray-900">${po.rfs_date ? new Date(po.rfs_date).toLocaleDateString('id-ID') : '-'}</p>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Jenis Item</label>
                                    <p class="mt-1 text-sm text-gray-900">${jenisItemText}</p>
                                </div>
                            </div>
                            
                            ${items.length > 0 ? `
                            <div class="mt-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-3">Item PO</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            ${items.map(item => `
                                                <tr>
                                                    <td class="px-4 py-2 text-sm text-gray-900">${item.nama_item}</td>
                                                    <td class="px-4 py-2 text-sm text-gray-600">${item.deskripsi || '-'}</td>
                                                    <td class="px-4 py-2 text-sm text-gray-900">${item.quantity}</td>
                                                    <td class="px-4 py-2 text-sm text-gray-900">${item.satuan}</td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            ` : ''}
                        </div>
                    `;
                    document.getElementById('poDetailModal').classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal memuat detail PO');
            }
        }

        function closePOModal() {
            document.getElementById('poDetailModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('poDetailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePOModal();
            }
        });

        async function viewDetail(id) {
            try {
                const response = await fetch(`/posm-requests/${id}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const result = await response.json();
                
                if (result.success) {
                    const data = result.data;
                    document.getElementById('modalContent').innerHTML = `
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Branch</label>
                                <p class="mt-1 text-sm text-gray-900">${data.branch}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Requester</label>
                                <p class="mt-1 text-sm text-gray-900">${data.requester_name}</p>
                                <p class="mt-1 text-sm text-gray-500">${data.requester_phone}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lokasi Pemasangan</label>
                                <p class="mt-1 text-sm text-gray-900">${data.site_name}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deadline</label>
                                <p class="mt-1 text-sm text-gray-900">${new Date(data.deadline).toLocaleDateString('id-ID')}</p>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                                <p class="mt-1 text-sm text-gray-900">${data.shipping_address}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tujuan</label>
                                <p class="mt-1 text-sm text-gray-900">${data.purpose}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis POSM</label>
                                <p class="mt-1 text-sm text-gray-900">${data.posm_type}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                <p class="mt-1 text-sm text-gray-900">${data.quantity}</p>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Elemen Wajib</label>
                                <p class="mt-1 text-sm text-gray-900">${data.mandatory_elements}</p>
                            </div>
                            
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Link Spreadsheet Ukuran</label>
                                ${data.spreadsheet_link ? `
                                    <a href="${data.spreadsheet_link}" target="_blank" class="inline-flex items-center px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded transition">
                                        <i class="fas fa-external-link-alt mr-2"></i>
                                        Buka Link
                                    </a>
                                ` : '<p class="text-sm text-gray-400 italic">Opsional - Link Google Spreadsheet</p>'}
                            </div>
                            
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Link PPT Desain</label>
                                ${data.design_link ? `
                                    <a href="${data.design_link}" target="_blank" class="inline-flex items-center px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded transition">
                                        <i class="fas fa-external-link-alt mr-2"></i>
                                        Buka Link
                                    </a>
                                ` : '<p class="text-sm text-gray-400 italic">Opsional - Link Google Slides/PPT/Canva</p>'}
                            </div>
                            ${data.notes ? `
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                                <p class="mt-1 text-sm text-gray-900">${data.notes}</p>
                            </div>
                            ` : ''}
                            ${data.rejection_reason ? `
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-red-700">Alasan Penolakan</label>
                                <p class="mt-1 text-sm text-red-600">${data.rejection_reason}</p>
                            </div>
                            ` : ''}
                        </div>
                    `;
                    document.getElementById('detailModal').classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal memuat detail permintaan');
            }
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        async function deleteRequest(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus permintaan ini?')) {
                return;
            }

            try {
                const response = await fetch(`/posm-requests/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    alert('Permintaan berhasil dihapus');
                    location.reload();
                } else {
                    alert(result.message || 'Gagal menghapus permintaan');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus permintaan');
            }
        }

        // Close modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
