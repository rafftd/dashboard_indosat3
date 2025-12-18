<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Purchase Order - Dashboard Indosat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/responsive-global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="navbar-gradient">
        <div class="container mx-auto px-4 py-4 navbar-container">
            <div class="flex justify-between items-center navbar-content">
                <div>
                    <h1 class="text-2xl font-bold text-white">Dashboard Indosat</h1>
                    <p class="text-white text-opacity-90 text-sm">{{ Auth::user()->getRoleDisplayName() }}</p>
                </div>
                <div class="flex items-center gap-4">
                    @if(file_exists(public_path('images/logo_warna.png')))
                        <img src="{{ asset('images/logo_warna.png') }}" alt="Logo Indosat" class="h-16">
                    @endif
                    <a href="{{ route('password.change') }}" class="bg-white hover:bg-gray-100 text-gray-800 px-4 py-2 rounded-lg transition font-semibold border border-gray-300">
                        Change Password
                    </a>
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
    <div class="alert alert-success" id="successAlert">
        <div class="alert-content">
            <i class="fas fa-check-circle alert-icon"></i>
            <div style="flex: 1;">
                <strong class="alert-title">Berhasil!</strong>
                <p class="alert-message">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error" id="errorAlert">
        <div class="alert-content">
            <i class="fas fa-exclamation-circle alert-icon"></i>
            <div style="flex: 1;">
                <strong class="alert-title">Error!</strong>
                <p class="alert-message">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-t-2xl shadow-lg p-6 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <i class="fas fa-file-alt text-red-600 text-3xl"></i>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Data Purchase Order (PO)</h1>
                        <p class="text-gray-600 text-sm mt-1">Kelola data Purchase Order Indosat</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button onclick="openCreateUserModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center gap-2 shadow-lg hover:shadow-xl">
                        <i class="fas fa-user-plus"></i>
                        Create User
                    </button>
                    <button onclick="openCreateModal()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center gap-2 shadow-lg hover:shadow-xl">
                        <i class="fas fa-plus"></i>
                        Tambah Data Baru
                    </button>
                </div>
            </div>
        </div>

        <!-- PO List -->
        <div class="bg-white rounded-b-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nomor PO</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Judul PO</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal PO</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">RFS Date (Maksimal Produksi)</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenis Item</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenis Item</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="poTableBody" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                                <p>Memuat data...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Purchase Orders Pagination -->
            <div id="purchaseOrdersPagination" class="bg-gray-50 px-6 py-4 border-t">
                <!-- Pagination will be rendered here by JavaScript -->
            </div>
        </div>

        <!-- Matpro Receipts Section -->
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

    <!-- Create/Edit PO Modal -->
    <div id="poModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4">
            <div class="sticky top-0 text-white px-6 py-4 flex justify-between items-center" style="background: linear-gradient(90deg, #e91e8c 0%, #c6168d 100%);">
                <h2 id="modalTitle" class="text-xl font-bold">Tambah Purchase Order Baru</h2>
                <button onclick="closeModal()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <form id="poForm" class="p-6">
                @csrf
                <input type="hidden" id="poId" name="po_id">
                <input type="hidden" id="formMethod" value="POST">

                <!-- PO Information -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Purchase Order</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Judul PO <span class="text-red-500">*</span></label>
                            <input type="text" id="judul_po" name="judul_po" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                                placeholder="Masukkan judul purchase order">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nomor PO <span class="text-red-500">*</span></label>
                            <input type="text" id="nomor_po" name="nomor_po" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                                placeholder="Contoh: PO-2025-001">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Tanggal PO <span class="text-red-500">*</span></label>
                            <input type="date" id="tanggal_po" name="tanggal_po" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">RFS Date (Maksimal Produksi)</label>
                            <input type="date" id="rfs_date" name="rfs_date"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Kirim ke Markom Branch <span class="text-red-500">*</span></label>
                            <select id="markom_branch_id" name="markom_branch_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="">-- Pilih Markom Branch --</option>
                                @php
                                    $markomBranches = \App\Models\User::where('role', 'markom_branch')->orderBy('name')->get();
                                @endphp
                                @foreach($markomBranches as $markom)
                                    <option value="{{ $markom->id }}">{{ $markom->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">PO ini hanya akan terlihat oleh Markom Branch yang dipilih</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Jenis Item <span class="text-red-500">*</span> <span class="text-sm font-normal text-gray-500">(Pilih minimal 1)</span></label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="jenis_item[]" value="baliho" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                    <span class="text-gray-700">Baliho</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="jenis_item[]" value="poster" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                    <span class="text-gray-700">Poster</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="jenis_item[]" value="pamflet" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                    <span class="text-gray-700">Pamflet</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" id="checkbox_other" name="jenis_item[]" value="other" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500" onchange="toggleOtherInput()">
                                    <span class="text-gray-700">Other</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-span-2" id="jenisItemLainnyaContainer" style="display: none;">
                            <label class="block text-gray-700 font-semibold mb-2">Tuliskan Jenis Item Lainnya <span class="text-red-500">*</span></label>
                            <input type="text" id="jenis_item_lainnya" name="jenis_item_lainnya"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                                placeholder="Sebutkan jenis item lainnya">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" onclick="closeModal()" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" style="background: linear-gradient(90deg, #e91e8c 0%, #c6168d 100%);" class="px-6 py-2 hover:opacity-90 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- View PO Modal -->
    <div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4">
            <div class="sticky top-0 bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">Detail Purchase Order</h2>
                <button onclick="closeViewModal()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="viewContent" class="p-6">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div id="createUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto m-4">
            <div class="sticky top-0 bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">
                    <i class="fas fa-user-plus mr-2"></i>Create New User
                </h2>
                <button onclick="closeCreateUserModal()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <form id="createUserForm" class="p-6">
                @csrf
                
                <div class="space-y-4">
                    <!-- Role Selection -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Pilih Jenis Akun <span class="text-red-500">*</span>
                        </label>
                        <select id="role" name="role" required onchange="handleRoleChange()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Role --</option>
                            <option value="markom_branch">Markom Branch</option>
                            <option value="vendor">Vendor</option>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Pilih jenis akun yang akan dibuat</p>
                    </div>

                    <!-- Username (shown after role selected) -->
                    <div id="usernameField" class="hidden">
                        <label class="block text-gray-700 font-semibold mb-2">
                            Username <span id="roleLabel"></span> <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="username" name="username" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Contoh: markom_surabaya">
                        <p class="text-sm text-gray-500 mt-1">Username untuk login dan ditampilkan di sistem</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="new_password" name="password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Minimal 6 karakter">
                        <p class="text-sm text-gray-500 mt-1">Minimal 6 karakter</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Ulangi password">
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-6 mt-6 border-t">
                    <button type="button" onclick="closeCreateUserModal()" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-user-plus mr-2"></i>Create User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Receipt Modal -->
    <div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4">
            <div class="sticky top-0 bg-orange-600 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">Bukti Penerimaan MATPRO</h2>
                <button onclick="closeReceiptModal()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="receiptContent" class="p-6">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>

    <script>
        // Suppress external script errors (like VS Code Copilot)
        window.addEventListener('error', function(e) {
            if (e.filename && (e.filename.includes('copilot') || e.filename.includes('chrome-extension'))) {
                e.preventDefault();
                return true;
            }
        }, true);

        let itemCounter = 0;

        // CSRF Token Setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Purchase Order Baru';
            document.getElementById('poForm').reset();
            document.getElementById('poId').value = '';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('jenisItemLainnyaContainer').style.display = 'none';
            document.getElementById('jenis_item_lainnya').required = false;
            document.getElementById('poModal').classList.remove('hidden');
            document.getElementById('poModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('poModal').classList.add('hidden');
            document.getElementById('poModal').classList.remove('flex');
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
            document.getElementById('viewModal').classList.remove('flex');
        }

        // Create User Modal Functions
        function openCreateUserModal() {
            document.getElementById('createUserForm').reset();
            document.getElementById('usernameField').classList.add('hidden');
            document.getElementById('createUserModal').classList.remove('hidden');
            document.getElementById('createUserModal').classList.add('flex');
        }

        function closeCreateUserModal() {
            document.getElementById('createUserModal').classList.add('hidden');
            document.getElementById('createUserModal').classList.remove('flex');
        }

        function handleRoleChange() {
            const roleSelect = document.getElementById('role');
            const usernameField = document.getElementById('usernameField');
            const roleLabel = document.getElementById('roleLabel');
            const usernameInput = document.getElementById('username');
            
            if (roleSelect.value === 'markom_branch') {
                usernameField.classList.remove('hidden');
                roleLabel.textContent = 'Markom Branch';
                usernameInput.placeholder = 'Contoh: markom_surabaya';
            } else if (roleSelect.value === 'vendor') {
                usernameField.classList.remove('hidden');
                roleLabel.textContent = 'Vendor';
                usernameInput.placeholder = 'Contoh: vendor_jakarta';
            } else {
                usernameField.classList.add('hidden');
            }
        }

        // Create User Form Submission
        document.getElementById('createUserForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';

            const formData = {
                name: document.getElementById('username').value,
                role: document.getElementById('role').value,
                password: document.getElementById('new_password').value,
                password_confirmation: document.getElementById('password_confirmation').value
            };

            // Validate role is selected
            if (!formData.role) {
                alert('Silakan pilih jenis akun terlebih dahulu!');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                return;
            }

            try {
                const response = await fetch('{{ route("users.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    alert('✓ User berhasil dibuat!');
                    closeCreateUserModal();
                    // Optionally reload page or update user list
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    let errorMessage = '✗ Gagal membuat user.\n\n';
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
                alert('✗ Terjadi kesalahan saat membuat user. Silakan coba lagi.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });

        function toggleOtherInput() {
            const otherCheckbox = document.getElementById('checkbox_other');
            const otherContainer = document.getElementById('jenisItemLainnyaContainer');
            const otherInput = document.getElementById('jenis_item_lainnya');
            
            if (otherCheckbox && otherCheckbox.checked) {
                otherContainer.style.display = 'block';
                otherInput.required = true;
            } else {
                otherContainer.style.display = 'none';
                otherInput.required = false;
                otherInput.value = '';
            }
        }

        // Handle form submission
        document.getElementById('poForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Get jenis_item from checkboxes
            const jenisItemCheckboxes = document.querySelectorAll('input[name="jenis_item[]"]:checked');
            const jenisItemArray = Array.from(jenisItemCheckboxes).map(checkbox => checkbox.value);
            
            if (jenisItemArray.length === 0) {
                alert('Pilih minimal 1 jenis item!');
                return;
            }

            const data = {
                nomor_po: document.getElementById('nomor_po').value,
                judul_po: document.getElementById('judul_po').value,
                tanggal_po: document.getElementById('tanggal_po').value,
                rfs_date: document.getElementById('rfs_date').value || null,
                markom_branch_id: document.getElementById('markom_branch_id').value,
                jenis_item: jenisItemArray,
                jenis_item_lainnya: document.getElementById('jenis_item_lainnya').value || null
            };

            const poId = document.getElementById('poId').value;
            const method = poId ? 'PUT' : 'POST';
            const url = poId ? `/purchase-orders/${poId}` : '/purchase-orders';

            try {
                console.log('Sending data:', data);
                console.log('URL:', url);
                console.log('Method:', method);
                
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                console.log('Response status:', response.status);
                console.log('response.ok:', response.ok);
                
                const result = await response.json();
                console.log('Response data:', result);
                console.log('result.success:', result.success);
                console.log('Condition check:', response.ok && result.success);

                if (response.ok && result.success) {
                    console.log('SUCCESS BRANCH EXECUTED!');
                    try {
                        console.log('Closing modal...');
                        closeModal();
                        console.log('Modal closed successfully');
                        
                        console.log('Showing success message...');
                        // Gunakan confirm agar tidak di-block browser
                        if (confirm('✓ ' + result.message + '\n\nKlik OK untuk refresh halaman')) {
                            console.log('User clicked OK, reloading...');
                            window.location.reload();
                        } else {
                            console.log('User clicked Cancel, reloading anyway...');
                            window.location.reload();
                        }
                    } catch (err) {
                        console.error('Error in success handler:', err);
                        // Paksa reload meskipun ada error
                        window.location.reload();
                    }
                } else {
                    console.log('ERROR BRANCH EXECUTED!');
                    let errorMsg = result.message || 'Terjadi kesalahan';
                    
                    // Tampilkan detail error validasi jika ada
                    if (result.errors) {
                        errorMsg += '\n\nDetail Error:\n';
                        Object.keys(result.errors).forEach(key => {
                            errorMsg += `- ${result.errors[key][0]}\n`;
                        });
                    }
                    
                    alert(errorMsg);
                    console.error('Error response:', result);
                }
            } catch (error) {
                console.error('Fetch error:', error);
                alert('Terjadi kesalahan saat menyimpan data. Cek console untuk detail.');
            }
        });

        async function viewPO(id) {
            try {
                const response = await fetch(`/purchase-orders/${id}`);
                const result = await response.json();

                if (result.success) {
                    const po = result.data;
                    let itemsHtml = '';
                    
                    po.items.forEach((item, index) => {
                        const total = item.quantity * item.harga;
                        itemsHtml += `
                            <tr class="border-b">
                                <td class="px-4 py-3">${index + 1}</td>
                                <td class="px-4 py-3">${item.judul_po}</td>
                                <td class="px-4 py-3 text-right">${item.quantity}</td>
                                <td class="px-4 py-3 text-right">Rp ${item.harga.toLocaleString('id-ID')}</td>
                                <td class="px-4 py-3 text-right font-semibold">Rp ${total.toLocaleString('id-ID')}</td>
                                <td class="px-4 py-3">${item.keterangan || '-'}</td>
                            </tr>
                        `;
                    });
                    
                    // Format jenis item
                    const jenisItemArray = Array.isArray(po.jenis_item) ? po.jenis_item : [];
                    const jenisItemLabels = {
                        'baliho': 'Baliho',
                        'poster': 'Poster',
                        'pamflet': 'Pamflet',
                        'other': 'Lainnya'
                    };
                    let jenisItemDisplay = jenisItemArray.map(item => jenisItemLabels[item] || item).join(', ');
                    if (jenisItemArray.includes('other') && po.jenis_item_lainnya) {
                        jenisItemDisplay += ` (${po.jenis_item_lainnya})`;
                    }

                    const content = `
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                                <div class="col-span-2">
                                    <p class="text-sm text-gray-600">Judul PO</p>
                                    <p class="font-semibold text-lg">${po.judul_po || '-'}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Nomor PO</p>
                                    <p class="font-semibold text-lg">${po.nomor_po}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Jenis Item</p>
                                    <p class="font-semibold">${jenisItemDisplay}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Tanggal PO</p>
                                    <p class="font-semibold">${new Date(po.tanggal_po).toLocaleDateString('id-ID')}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">RFS Date (Maksimal Produksi)</p>
                                    <p class="font-semibold">${po.rfs_date ? new Date(po.rfs_date).toLocaleDateString('id-ID') : '-'}</p>
                                </div>
                            </div>
                        </div>
                    `;

                    document.getElementById('viewContent').innerHTML = content;
                    document.getElementById('viewModal').classList.remove('hidden');
                    document.getElementById('viewModal').classList.add('flex');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengambil data');
            }
        }

        async function editPO(id) {
            try {
                const response = await fetch(`/purchase-orders/${id}`);
                const result = await response.json();

                if (result.success) {
                    const po = result.data;
                    
                    document.getElementById('modalTitle').textContent = 'Edit Purchase Order';
                    document.getElementById('poId').value = po.id;
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('nomor_po').value = po.nomor_po;
                    document.getElementById('judul_po').value = po.judul_po || '';
                    document.getElementById('tanggal_po').value = po.tanggal_po;
                    document.getElementById('rfs_date').value = po.rfs_date || '';
                    
                    // Handle jenis_item checkboxes
                    const jenisItemArray = Array.isArray(po.jenis_item) ? po.jenis_item : [];
                    
                    // Uncheck all first
                    document.querySelectorAll('input[name="jenis_item[]"]').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    
                    // Check the ones in the array
                    jenisItemArray.forEach(value => {
                        const checkbox = document.getElementById(`checkbox_${value}`);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    });
                    
                    // Handle jenis_item_lainnya
                    if (jenisItemArray.includes('other') && po.jenis_item_lainnya) {
                        document.getElementById('jenisItemLainnyaContainer').style.display = 'block';
                        document.getElementById('jenis_item_lainnya').value = po.jenis_item_lainnya;
                        document.getElementById('jenis_item_lainnya').required = true;
                    } else {
                        document.getElementById('jenisItemLainnyaContainer').style.display = 'none';
                        document.getElementById('jenis_item_lainnya').value = '';
                        document.getElementById('jenis_item_lainnya').required = false;
                    }

                    document.getElementById('poModal').classList.remove('hidden');
                    document.getElementById('poModal').classList.add('flex');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengambil data');
            }
        }

        async function deletePO(id, nomorPo) {
            if (confirm(`Apakah Anda yakin ingin menghapus PO ${nomorPo}?`)) {
                try {
                    const response = await fetch(`/purchase-orders/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert(result.message);
                        location.reload();
                    } else {
                        alert(result.message || 'Terjadi kesalahan');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus data');
                }
            }
        }

        // Load Matpro Receipts
        let currentReceiptPage = 1;
        
        async function loadMatproReceipts(page = 1) {
            currentReceiptPage = page; // Save current page
            try {
                const response = await fetch(`/matpro-receipts/list?page=${page}`);
                const result = await response.json();

                // Handle pagination object
                const receiptsData = result.data.data || result.data;
                const pagination = result.data.data ? result.data : null;
                
                if (result.success && receiptsData && receiptsData.length > 0) {
                    const tbody = document.getElementById('receiptsTableBody');
                    const startIndex = pagination ? (pagination.current_page - 1) * pagination.per_page : (page - 1) * 10;
                    
                    tbody.innerHTML = receiptsData.map((receipt, index) => `
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${startIndex + index + 1}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${receipt.nama_penerima}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${receipt.branch}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${receipt.matpro}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                ${new Date(receipt.tanggal_diterima).toLocaleDateString('id-ID')}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${receipt.user ? receipt.user.name : '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button onclick="viewReceipt(${receipt.id})" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                    <i class="fas fa-eye mr-1"></i> Lihat Bukti
                                </button>
                            </td>
                        </tr>
                    `).join('');
                    
                    // Render pagination
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
            try {
                // Fetch with current page to get the receipt data
                const response = await fetch(`/matpro-receipts/list?page=${currentReceiptPage}`);
                const result = await response.json();

                if (result.success) {
                    // Handle pagination object
                    const receiptsData = result.data.data || result.data;
                    let receipt = receiptsData.find(r => r.id === receiptId);
                    
                    // If not found in current page, try to fetch all pages
                    if (!receipt && result.data.last_page) {
                        for (let page = 1; page <= result.data.last_page; page++) {
                            if (page === currentReceiptPage) continue;
                            const pageResponse = await fetch(`/matpro-receipts/list?page=${page}`);
                            const pageResult = await pageResponse.json();
                            const pageData = pageResult.data.data || pageResult.data;
                            receipt = pageData.find(r => r.id === receiptId);
                            if (receipt) break;
                        }
                    }
                    
                    if (receipt) {
                        const fileExtension = receipt.bukti_file.split('.').pop().toLowerCase();
                        const fileUrl = `/storage/${receipt.bukti_file}`;
                        
                        let previewContent = '';
                        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                            previewContent = `<img src="${fileUrl}" alt="Bukti Penerimaan" class="w-full rounded-lg shadow-lg">`;
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
                                        <p class="font-semibold text-lg">${receipt.nama_penerima}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Branch</p>
                                        <p class="font-semibold text-lg">${receipt.branch}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Matpro</p>
                                        <p class="font-semibold">${receipt.matpro}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Tanggal Diterima</p>
                                        <p class="font-semibold">${new Date(receipt.tanggal_diterima).toLocaleDateString('id-ID')}</p>
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
                                    <div class="mt-4 text-center">
                                    </div>
                                </div>
                            </div>
                        `;

                        document.getElementById('receiptContent').innerHTML = content;
                        document.getElementById('receiptModal').classList.remove('hidden');
                        document.getElementById('receiptModal').classList.add('flex');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal memuat detail bukti penerimaan');
            }
        }

        function closeReceiptModal() {
            document.getElementById('receiptModal').classList.add('hidden');
            document.getElementById('receiptModal').classList.remove('flex');
        }

        // Load data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadPurchaseOrders(1);
            loadMatproReceipts();
        });

        // Load Purchase Orders with pagination
        let currentPurchaseOrdersPage = 1;
        
        async function loadPurchaseOrders(page = 1) {
            try {
                const response = await fetch(`/purchase-orders?page=${page}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch Purchase Orders');
                }

                const result = await response.json();
                
                if (result.success && result.data) {
                    const paginatedData = result.data;
                    const purchaseOrders = paginatedData.data || paginatedData;
                    
                    displayPurchaseOrders(purchaseOrders, page, paginatedData.per_page || 10);
                    
                    if (paginatedData.last_page) {
                        renderPurchaseOrdersPagination(paginatedData);
                    }
                    
                    currentPurchaseOrdersPage = page;
                }
            } catch (error) {
                console.error('Error loading Purchase Orders:', error);
                document.getElementById('poTableBody').innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-red-500">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p>Gagal memuat data Purchase Order</p>
                        </td>
                    </tr>
                `;
            }
        }

        // Display Purchase Orders in table
        function displayPurchaseOrders(purchaseOrders, currentPage = 1, perPage = 10) {
            const tbody = document.getElementById('poTableBody');
            
            if (purchaseOrders.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                                <p class="text-gray-500 text-lg font-semibold">Belum ada data Purchase Order</p>
                                <p class="text-gray-400 text-sm mt-2">Klik tombol "Tambah Data Baru" untuk membuat PO pertama Anda</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = purchaseOrders.map((po, index) => {
                const rowNumber = ((currentPage - 1) * perPage) + index + 1;
                const tanggalPO = new Date(po.tanggal_po).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
                const rfsDate = po.rfs_date ? new Date(po.rfs_date).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                }) : '-';
                
                // Calculate days to RFS
                let countdownBadge = '<span class="text-gray-400 text-sm">-</span>';
                if (po.rfs_date) {
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    const rfs = new Date(po.rfs_date);
                    rfs.setHours(0, 0, 0, 0);
                    const daysToRfs = Math.floor((rfs - today) / (1000 * 60 * 60 * 24));
                    
                    let badgeClass, label;
                    if (daysToRfs < 0) {
                        badgeClass = 'bg-gray-500 text-white';
                        label = 'Expired ' + Math.abs(daysToRfs) + ' hari';
                    } else if (daysToRfs <= 5) {
                        badgeClass = 'bg-red-500 text-white';
                        label = 'H-' + daysToRfs;
                    } else if (daysToRfs <= 10) {
                        badgeClass = 'bg-yellow-500 text-white';
                        label = 'H-' + daysToRfs;
                    } else {
                        badgeClass = 'bg-green-500 text-white';
                        label = 'H-' + daysToRfs;
                    }
                    countdownBadge = `<span class="px-3 py-1 ${badgeClass} text-xs font-bold rounded-full">${label}</span>`;
                }
                
                // Format jenis_item
                let jenisItemHtml = '';
                if (po.jenis_item && Array.isArray(po.jenis_item)) {
                    const jenisLabels = {
                        'baliho': 'Baliho',
                        'poster': 'Poster',
                        'pamflet': 'Pamflet',
                        'other': 'Lainnya'
                    };
                    po.jenis_item.forEach(item => {
                        jenisItemHtml += `<span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full mr-1 mb-1">${jenisLabels[item] || item}</span>`;
                    });
                    if (po.jenis_item.includes('other') && po.jenis_item_lainnya) {
                        jenisItemHtml += `<span class="inline-block px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">(${po.jenis_item_lainnya})</span>`;
                    }
                }
                
                return `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${rowNumber}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-semibold text-gray-900">${po.nomor_po}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-gray-900">${po.judul_po || '-'}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${tanggalPO}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${rfsDate}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${countdownBadge}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${jenisItemHtml}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex gap-2">
                                <button onclick="viewPO(${po.id})" class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="editPO(${po.id})" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deletePO(${po.id}, '${po.nomor_po}')" class="text-red-600 hover:text-red-800" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Render Purchase Orders pagination
        function renderPurchaseOrdersPagination(paginationData) {
            const container = document.getElementById('purchaseOrdersPagination');
            if (!container) return;

            const { current_page, last_page } = paginationData;
            
            let html = '<nav class="flex items-center justify-center gap-2 py-4">';
            
            // Previous button
            if (current_page > 1) {
                html += `<button onclick="loadPurchaseOrders(${current_page - 1})" 
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
                    html += `<button onclick="loadPurchaseOrders(${i})" 
                        class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">${i}</button>`;
                }
            }
            
            // Next button
            if (current_page < last_page) {
                html += `<button onclick="loadPurchaseOrders(${current_page + 1})" 
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

        // Load receipts on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadMatproReceipts();
        });

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