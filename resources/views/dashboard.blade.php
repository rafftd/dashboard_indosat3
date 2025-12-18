<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - {{ Auth::user()->getRoleDisplayName() }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/responsive-global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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
                padding-left: 1rem !important;
                padding-right: 1rem !important;
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
            .grid {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
            }
            .text-2xl {
                font-size: 1.25rem !important;
            }
            .text-xl {
                font-size: 1.1rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }
            nav {
                padding: 0.75rem 0 !important;
            }
            nav h1 {
                font-size: 1rem !important;
            }
            nav .flex.justify-between {
                flex-direction: column;
                gap: 0.5rem;
                align-items: flex-start !important;
            }
            button {
                font-size: 0.75rem !important;
                padding: 0.5rem 1rem !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen" style="overflow-x: hidden; width: 100%; margin: 0; padding: 0;">
    <!-- Navbar -->
    <nav style="background: linear-gradient(90deg, #e91e8c 0%, #f48db8 30%, #ffd9e8 60%, #ffffff 100%); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); max-width: 100vw; overflow-x: hidden;">
        <div class="container mx-auto px-4 py-4" style="max-width: 100%; overflow-x: hidden;">
            <div class="flex justify-between items-center" style="max-width: 100%; flex-wrap: wrap;">
                <div>
                    <h1 class="text-2xl font-bold text-white">Dashboard Indosat</h1>
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
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center">
                <div class="text-6xl mb-4">
                    @if(Auth::user()->isAdministrasi())
                        👩‍💼
                    @elseif(Auth::user()->isDesigner())
                        🎨
                    @elseif(Auth::user()->isVendor())
                        👨‍💻
                    @else
                        📢
                    @endif
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h2>
                <p class="text-gray-600 mb-2">
                    Anda login sebagai: <span class="font-semibold text-red-600">{{ Auth::user()->getRoleDisplayName() }}</span>
                </p>
                <p class="text-gray-500 text-sm">
                    Email: {{ Auth::user()->email }}
                </p>

                <!-- Role-specific content will be added here -->
                <div class="mt-8 p-6 bg-blue-50 rounded-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Dashboard Anda</h3>
                    
                    @if(Auth::user()->isAdministrasi())
                        <p class="text-gray-700">Dashboard untuk Administrasi akan ditampilkan di sini.</p>
                    @elseif(Auth::user()->isDesigner())
                        <p class="text-gray-700">Dashboard untuk Designer akan ditampilkan di sini.</p>
                    @elseif(Auth::user()->isVendor())
                        <div class="space-y-8">
                            <!-- Form Pengiriman Button -->
                            <div class="text-center">
                                <a href="{{ route('vendor.shipping') }}" class="inline-flex items-center px-6 py-3 text-white font-semibold rounded-lg shadow-md transition-all" style="background-color: #32bcad; &:hover { background-color: #2aa89a; }" onmouseover="this.style.backgroundColor='#2aa89a'" onmouseout="this.style.backgroundColor='#32bcad'">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Form Pengiriman
                                </a>
                            </div>

                            <!-- Bukti Penerimaan MATPRO Section -->
                            <div class="bg-white rounded-lg shadow-md overflow-hidden mt-8">
                                <div class="bg-white px-6 py-4 border-b-2 border-orange-500">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-receipt text-orange-500 text-2xl"></i>
                                        <div>
                                            <h2 class="text-xl font-bold text-gray-800">Bukti Penerimaan MATPRO</h2>
                                            <p class="text-gray-600 text-sm">Data bukti penerimaan dari Markom Branch</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-gray-50 border-b">
                                            <tr>
                                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Penerima</th>
                                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Branch</th>
                                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Matpro</th>
                                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal Diterima</th>
                                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Diupload Oleh</th>
                                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Bukti</th>
                                            </tr>
                                        </thead>
                                        <tbody id="receiptsTableBody" class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td colspan="7" class="px-6 py-8 text-center">
                                                    <i class="fas fa-spinner fa-spin text-gray-400 text-3xl mb-2"></i>
                                                    <p class="text-gray-500">Memuat data...</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div id="receiptsPagination" class="bg-gray-50 px-6 py-4 border-t">
                                    <!-- Pagination will be loaded here -->
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-700">Dashboard untuk Marcomm Branch akan ditampilkan di sini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Receipt Preview Modal (for Vendor) -->
    @if(Auth::user()->isVendor())
    <div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-bold">Detail Bukti Penerimaan MATPRO</h3>
                <button onclick="closeReceiptModal()" class="text-white hover:text-gray-200 transition">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="receiptContent" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        // Load Matpro Receipts for Vendor
        let currentReceiptPage = 1;
        
        async function loadMatproReceipts(page = 1) {
            currentReceiptPage = page;
            try {
                const response = await fetch(`/matpro-receipts/list?page=${page}`);
                const result = await response.json();

                const receiptsData = result.data.data || result.data;
                const pagination = result.data.data ? result.data : null;
                
                if (result.success && receiptsData && receiptsData.length > 0) {
                    const tbody = document.getElementById('receiptsTableBody');
                    const startIndex = pagination ? (pagination.current_page - 1) * pagination.per_page : (page - 1) * 10;
                    
                    tbody.innerHTML = receiptsData.map((receipt, index) => `
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${startIndex + index + 1}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${receipt.nama_penerima || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${receipt.branch || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${receipt.matpro || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                ${receipt.tanggal_diterima ? new Date(receipt.tanggal_diterima).toLocaleDateString('id-ID') : '-'}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${receipt.user ? receipt.user.name : '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button onclick="viewReceipt(${receipt.id})" class="view-receipt-btn bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                    <i class="fas fa-eye mr-1"></i> Lihat Bukti
                                </button>
                            </td>
                        </tr>
                    `).join('');
                    
                    if (pagination) {
                        renderReceiptsPagination(pagination);
                    }
                } else {
                    document.getElementById('receiptsTableBody').innerHTML = `
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                                    <p class="text-gray-500 text-lg font-semibold">Belum ada bukti penerimaan</p>
                                    <p class="text-gray-400 text-sm mt-2">Bukti penerimaan dari Markom Branch akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    `;
                    document.getElementById('receiptsPagination').innerHTML = '';
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('receiptsTableBody').innerHTML = `
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-red-500">
                            <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
                            <p>Gagal memuat data bukti penerimaan</p>
                        </td>
                    </tr>
                `;
            }
        }
        
        function renderReceiptsPagination(pagination) {
            const container = document.getElementById('receiptsPagination');
            if (!pagination) return;
            
            const { current_page, last_page } = pagination;
            
            let html = '<nav class="flex items-center justify-center gap-2 py-4">';
            
            // Previous button
            if (current_page > 1) {
                html += `<button onclick="loadMatproReceipts(${current_page - 1})" 
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
                    html += `<button onclick="loadMatproReceipts(${i})" 
                        class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">${i}</button>`;
                }
            }
            
            // Next button
            if (current_page < last_page) {
                html += `<button onclick="loadMatproReceipts(${current_page + 1})" 
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

        async function viewReceipt(receiptId) {
            console.log('Viewing receipt ID:', receiptId);
            try {
                const response = await fetch(`/matpro-receipts/list?page=${currentReceiptPage}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const result = await response.json();
                console.log('Fetch result:', result);

                if (result.success) {
                    const receiptsData = result.data.data || result.data;
                    let receipt = receiptsData.find(r => r.id === receiptId);
                    
                    console.log('Found receipt in current page:', receipt);
                    
                    if (!receipt && result.data.last_page) {
                        console.log('Searching in other pages...');
                        for (let page = 1; page <= result.data.last_page; page++) {
                            if (page === currentReceiptPage) continue;
                            const pageResponse = await fetch(`/matpro-receipts/list?page=${page}`, {
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });
                            const pageResult = await pageResponse.json();
                            const pageData = pageResult.data.data || pageResult.data;
                            receipt = pageData.find(r => r.id === receiptId);
                            if (receipt) {
                                console.log('Found receipt in page:', page);
                                break;
                            }
                        }
                    }
                    
                    if (receipt) {
                        console.log('Displaying receipt:', receipt);
                        const fileExtension = receipt.bukti_file ? receipt.bukti_file.split('.').pop().toLowerCase() : '';
                        const fileUrl = `/storage/${receipt.bukti_file}`;
                        
                        let previewContent = '';
                        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                            previewContent = `<img src="${fileUrl}" alt="Bukti Penerimaan" class="w-full rounded-lg shadow-lg" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%23d1d5db%22%3E%3Cpath d=%22M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z%22/%3E%3C/svg%3E'">`;
                        } else if (fileExtension === 'pdf') {
                            previewContent = `<iframe src="${fileUrl}" class="w-full h-[500px] rounded-lg shadow-lg"></iframe>`;
                        } else {
                            previewContent = `<p class="text-center text-gray-500">Preview tidak tersedia untuk file ini</p>`;
                        }

                        let locationHtml = '';
                        if (receipt.latitude && receipt.longitude) {
                            const mapsUrl = `https://www.google.com/maps?q=${receipt.latitude},${receipt.longitude}`;
                            locationHtml = `
                                <div class="col-span-2 bg-blue-50 p-4 rounded-lg border border-blue-200">
                                    <p class="text-blue-700 text-sm mb-2 font-semibold flex items-center">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        Lokasi Pengambilan Foto
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-blue-900 font-mono text-sm">Latitude: ${parseFloat(receipt.latitude).toFixed(6)}</p>
                                            <p class="text-blue-900 font-mono text-sm">Longitude: ${parseFloat(receipt.longitude).toFixed(6)}</p>
                                        </div>
                                        <a href="${mapsUrl}" target="_blank" 
                                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium flex items-center gap-2">
                                            <i class="fas fa-external-link-alt"></i>
                                            Buka di Google Maps
                                        </a>
                                    </div>
                                </div>
                            `;
                        }

                        const content = `
                            <div class="space-y-6">
                                <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                                    <div>
                                        <p class="text-sm text-gray-600">Nama Penerima</p>
                                        <p class="font-semibold text-lg">${receipt.nama_penerima || '-'}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Branch</p>
                                        <p class="font-semibold text-lg">${receipt.branch || '-'}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Matpro</p>
                                        <p class="font-semibold">${receipt.matpro || '-'}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Tanggal Diterima</p>
                                        <p class="font-semibold">${receipt.tanggal_diterima ? new Date(receipt.tanggal_diterima).toLocaleDateString('id-ID') : '-'}</p>
                                    </div>
                                    ${locationHtml}
                                    <div class="col-span-2">
                                        <p class="text-sm text-gray-600">Diupload Oleh</p>
                                        <p class="font-semibold">${receipt.user ? receipt.user.name : '-'}</p>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between items-center mb-3">
                                        <h3 class="text-lg font-semibold">Bukti Penerimaan</h3>
                                        <a href="${fileUrl}" download class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium flex items-center gap-2">
                                            <i class="fas fa-download"></i>
                                            Unduh Foto
                                        </a>
                                    </div>
                                    ${previewContent}
                                </div>
                            </div>
                        `;

                        document.getElementById('receiptContent').innerHTML = content;
                        document.getElementById('receiptModal').classList.remove('hidden');
                        document.getElementById('receiptModal').classList.add('flex');
                    } else {
                        console.error('Receipt not found');
                        alert('Bukti penerimaan tidak ditemukan');
                    }
                } else {
                    console.error('API call failed:', result);
                    alert('Gagal memuat data bukti penerimaan');
                }
            } catch (error) {
                console.error('Error viewing receipt:', error);
                alert('Gagal memuat detail bukti penerimaan: ' + error.message);
            }
        }

        function closeReceiptModal() {
            document.getElementById('receiptModal').classList.add('hidden');
            document.getElementById('receiptModal').classList.remove('flex');
        }

        // Load receipts on page load for vendor
        document.addEventListener('DOMContentLoaded', function() {
            loadMatproReceipts();
        });
    </script>
    @endif
</body>
</html>
