<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Pengiriman Vendor - Designer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/responsive-global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/designer-vendor-shipments.css') }}">
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
        
        /* Responsive Styles for Mobile */
        @media (max-width: 768px) {
            .container {
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
                max-width: 100vw !important;
                overflow-x: hidden !important;
            }
            
            nav h1 {
                font-size: 1rem !important;
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
            
            .p-6 {
                padding: 1rem !important;
            }
            
            .p-8 {
                padding: 1.25rem !important;
            }
            
            table {
                font-size: 0.75rem !important;
            }
            
            table th, table td {
                padding: 0.5rem !important;
            }
            
            .overflow-x-auto {
                -webkit-overflow-scrolling: touch;
            }
        }
        
        @media (max-width: 480px) {
            nav {
                padding: 0.5rem 0 !important;
            }
            
            nav h1 {
                font-size: 0.875rem !important;
            }
            
            nav .flex.justify-between {
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            .text-3xl {
                font-size: 1.25rem !important;
            }
            
            .p-6 {
                padding: 0.75rem !important;
            }
            
            table {
                font-size: 0.625rem !important;
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            
            button {
                font-size: 0.625rem !important;
                padding: 0.375rem 0.5rem !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50" style="overflow-x: hidden; width: 100%; margin: 0; padding: 0;">
    <!-- Navbar -->
    <nav style="background: linear-gradient(90deg, #e91e8c 0%, #f48db8 30%, #ffd9e8 60%, #ffffff 100%); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); max-width: 100vw; overflow-x: hidden;">
        <div class="container mx-auto px-4 py-4" style="max-width: 100%; overflow-x: hidden;">
            <div class="flex justify-between items-center" style="max-width: 100%; flex-wrap: wrap;">
                <div>
                    <h1 class="text-2xl font-bold text-white">Dashboard Designer - Data Pengiriman Vendor</h1>
                    <p class="text-white text-opacity-90 text-sm">{{ Auth::user()->getRoleDisplayName() }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('designer.index') }}" class="bg-purple-700 hover:bg-purple-800 text-white px-4 py-2 rounded-lg transition font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
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

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6">
        <!-- Vendor Shipments Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-white px-6 py-4 border-b-2 border-gray-200">
                <h2 class="text-xl font-bold flex items-center" style="color: #32bcad;">
                    <i class="fas fa-truck mr-3"></i>
                    Data Pengiriman Vendor
                </h2>
                <p class="text-sm mt-1" style="color: #32bcad;">Semua resi pengiriman yang dibuat oleh vendor</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b-2 border-gray-300">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nomor Resi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Vendor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenis Item</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal Pengiriman</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="shipmentsTableBody" class="divide-y divide-gray-200">
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center">
                                <i class="fas fa-spinner fa-spin text-gray-400 text-3xl mb-2"></i>
                                <p class="text-gray-500">Memuat data...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="shipmentsPagination" class="bg-gray-50 px-6 py-4 border-t">
                <!-- Pagination will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto m-4">
            <div class="sticky top-0 text-white px-6 py-3 flex justify-between items-center" style="background-color: #32bcad;">
                <h2 class="text-lg font-bold">
                    <i class="fas fa-truck mr-2"></i>Detail Pengiriman
                </h2>
                <button onclick="closeDetailModal()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="detailContent" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        function viewShipmentDetail(shipmentId) {
            fetch(`/designer/vendor-shipments/${shipmentId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    const data = result.data;
                    const tanggalPengiriman = new Date(data.tanggal_pengiriman);
                    
                    const content = `
                        <div class="space-y-4">
                            <!-- Title -->
                            <h3 class="text-xl font-bold text-gray-800 pb-2" style="border-bottom: 2px solid #32bcad;">
                                Data Pengiriman Tersimpan
                            </h3>

                            <!-- Simple List -->
                            <div class="space-y-3 text-gray-800">
                                <div>
                                    <span class="font-semibold">Nomor Resi:</span> ${data.resi_pengiriman}
                                </div>
                                <div>
                                    <span class="font-semibold">Vendor:</span> ${data.nama_vendor}
                                </div>
                                <div>
                                    <span class="font-semibold">Kontak:</span> ${data.kontak_vendor}
                                </div>
                                <div>
                                    <span class="font-semibold">Alamat:</span> ${data.alamat_pengiriman}
                                </div>
                                <div>
                                    <span class="font-semibold">Tanggal Pengiriman:</span> ${tanggalPengiriman.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' })}
                                </div>
                                <div>
                                    <span class="font-semibold">Jenis Item:</span> ${data.jenis_item}
                                </div>
                                <div>
                                    <span class="font-semibold">Jumlah:</span> ${data.jumlah_item.toLocaleString('id-ID')} pcs
                                </div>
                                ${data.catatan ? `
                                <div>
                                    <span class="font-semibold">Catatan:</span> ${data.catatan}
                                </div>
                                ` : ''}
                                ${data.foto_resi ? `
                                <div>
                                    <span class="font-semibold">Foto Resi:</span>
                                    <div class="mt-2">
                                        <img src="/storage/vendor-resi/${data.foto_resi}" 
                                             alt="Foto Resi" 
                                             class="max-w-full h-auto rounded-lg border-2 border-gray-300 cursor-pointer hover:opacity-90 transition"
                                             onclick="window.open('/storage/vendor-resi/${data.foto_resi}', '_blank')"
                                             style="max-height: 400px;">
                                        <p class="text-xs text-gray-500 mt-1 italic">Klik foto untuk melihat ukuran penuh</p>
                                    </div>
                                </div>
                                ` : ''}
                            </div>

                            <!-- Close Button -->
                            <div class="flex justify-center pt-4 border-t-2 border-gray-200">
                                <button onclick="closeDetailModal()" 
                                        class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-2 rounded-lg font-semibold transition">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    `;
                    
                    document.getElementById('detailContent').innerHTML = content;
                    document.getElementById('detailModal').classList.remove('hidden');
                    document.getElementById('detailModal').classList.add('flex');
                } else {
                    alert('Gagal memuat detail pengiriman: ' + (result.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat detail pengiriman');
            });
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.getElementById('detailModal').classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('detailModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });

        // AJAX Loading for Shipments Table
        let currentPage = 1;

        async function loadShipments(page = 1) {
            try {
                const response = await fetch(`/designer/vendor-shipments?page=${page}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    const tbody = document.getElementById('shipmentsTableBody');
                    const data = result.data;
                    
                    if (data.data.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                                    <p class="text-gray-500 text-lg">Belum ada data pengiriman vendor</p>
                                </td>
                            </tr>
                        `;
                    } else {
                        tbody.innerHTML = data.data.map((shipment, index) => {
                            const rowNumber = (data.current_page - 1) * data.per_page + index + 1;
                            const tanggalPengiriman = new Date(shipment.tanggal_pengiriman);
                            const formattedDate = tanggalPengiriman.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                            
                            return `
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">${rowNumber}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-semibold" style="color: #32bcad;">${shipment.resi_pengiriman}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">${shipment.nama_vendor}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">${shipment.jenis_item}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">${shipment.jumlah_item.toLocaleString('id-ID')}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">${formattedDate}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="viewShipmentDetail(${shipment.id})" 
                                                class="text-white px-4 py-2 rounded text-sm font-semibold transition"
                                                style="background-color: #32bcad;"
                                                onmouseover="this.style.backgroundColor='#2aa89a'"
                                                onmouseout="this.style.backgroundColor='#32bcad'">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </button>
                                    </td>
                                </tr>
                            `;
                        }).join('');
                    }
                    
                    renderPagination(data);
                    currentPage = page;
                }
            } catch (error) {
                console.error('Error loading shipments:', error);
                document.getElementById('shipmentsTableBody').innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-red-600">
                            <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
                            <p>Gagal memuat data. Silakan refresh halaman.</p>
                        </td>
                    </tr>
                `;
            }
        }

        function renderPagination(pagination) {
            const container = document.getElementById('shipmentsPagination');
            
            if (pagination.last_page <= 1) {
                container.innerHTML = '';
                return;
            }
            
            let paginationHTML = '<div class="flex items-center justify-between"><div class="flex items-center gap-2">';
            
            // Previous button
            if (pagination.current_page > 1) {
                paginationHTML += `
                    <button onclick="loadShipments(${pagination.current_page - 1})" 
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
                        <button onclick="loadShipments(${i})" 
                                class="w-10 h-10 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            ${i}
                        </button>
                    `;
                }
            }
            
            // Next button
            if (pagination.current_page < pagination.last_page) {
                paginationHTML += `
                    <button onclick="loadShipments(${pagination.current_page + 1})" 
                            class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                `;
            }
            
            paginationHTML += `</div><p class="text-sm text-gray-600">Total: <span class="font-semibold">${pagination.total}</span> Shipment</p></div>`;
            
            container.innerHTML = paginationHTML;
        }

        // Load shipments on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadShipments(1);
        });
    </script>
</body>
</html>
