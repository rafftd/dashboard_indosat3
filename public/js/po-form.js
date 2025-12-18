document.addEventListener('DOMContentLoaded', function() {
    let columnCounter = 0;

    // Handle Jenis Item dropdown change
    const jenisItemSelect = document.getElementById('jenis_item');
    const othersRow = document.getElementById('othersRow');
    const othersInput = document.getElementById('jenis_item_lainnya');

    jenisItemSelect.addEventListener('change', function() {
        if (this.value === 'Others') {
            othersRow.classList.add('show');
            othersRow.style.display = 'block';
            othersInput.required = true;
        } else {
            othersRow.classList.remove('show');
            othersRow.style.display = 'none';
            othersInput.required = false;
            othersInput.value = '';
        }
    });

    // Handle Add Column button
    const btnAddColumn = document.getElementById('btnAddColumn');
    const dynamicColumns = document.getElementById('dynamicColumns');

    btnAddColumn.addEventListener('click', function() {
        columnCounter++;
        const newColumn = createDynamicColumn(columnCounter);
        dynamicColumns.insertAdjacentHTML('beforeend', newColumn);
        
        // Add event listener to the new remove button
        const removeBtn = dynamicColumns.querySelector(`#removeColumn${columnCounter}`);
        removeBtn.addEventListener('click', function() {
            this.closest('.dynamic-field-group').remove();
        });
    });

    // Create dynamic column HTML
    function createDynamicColumn(id) {
        return `
            <div class="dynamic-field-group" id="columnGroup${id}">
                <button type="button" class="remove-column-btn" id="removeColumn${id}" title="Hapus kolom">
                    <i class="fas fa-times"></i>
                </button>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="judul_po_${id}">Judul PO #${id}</label>
                            <input type="text" class="form-control" id="judul_po_${id}" 
                                   name="judul_po[]" 
                                   placeholder="Masukkan judul PO">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="quantity_${id}">Quantity</label>
                            <input type="number" class="form-control" id="quantity_${id}" 
                                   name="quantity[]" 
                                   placeholder="0" min="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="harga_${id}">Harga Satuan</label>
                            <input type="text" class="form-control currency-input" id="harga_${id}" 
                                   name="harga[]" 
                                   placeholder="Rp 0">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="keterangan_${id}">Keterangan</label>
                            <textarea class="form-control" id="keterangan_${id}" 
                                      name="keterangan[]" 
                                      rows="3" 
                                      placeholder="Tambahkan keterangan (opsional)"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Currency formatting for price inputs
    dynamicColumns.addEventListener('input', function(e) {
        if (e.target.classList.contains('currency-input')) {
            formatCurrency(e.target);
        }
    });

    function formatCurrency(input) {
        let value = input.value.replace(/[^\d]/g, '');
        if (value) {
            value = parseInt(value).toLocaleString('id-ID');
            input.value = 'Rp ' + value;
        }
    }

    // Handle Lihat Semua POV button
    const btnLihatPOV = document.getElementById('btnLihatPOV');
    btnLihatPOV.addEventListener('click', function() {
        // Redirect ke halaman list PO atau buka modal
        window.location.href = '/po/list'; // Sesuaikan dengan route Anda
    });

    // Form validation before submit
    const poForm = document.getElementById('poForm');
    poForm.addEventListener('submit', function(e) {
        const jenisItem = jenisItemSelect.value;
        
        if (jenisItem === 'Others' && !othersInput.value.trim()) {
            e.preventDefault();
            alert('Mohon isi jenis item lainnya');
            othersInput.focus();
            return false;
        }

        // Validate at least one dynamic column if needed
        const dynamicFields = dynamicColumns.querySelectorAll('.dynamic-field-group');
        if (dynamicFields.length === 0) {
            const confirm = window.confirm('Anda belum menambahkan kolom judul PO. Lanjutkan?');
            if (!confirm) {
                e.preventDefault();
                return false;
            }
        }
    });

    // Auto-set today's date for Tanggal PO
    const tanggalPO = document.getElementById('tanggal_po');
    if (!tanggalPO.value) {
        const today = new Date().toISOString().split('T')[0];
        tanggalPO.value = today;
    }

    // Get Answer button functionality (if you add it)
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-get-answer')) {
            // Show modal or tooltip with help information
            const modal = new bootstrap.Modal(document.getElementById('getAnswerModal'));
            modal.show();
        }
    });
});