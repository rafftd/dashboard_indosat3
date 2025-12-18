@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="po-form-wrapper">
        <form id="poForm" action="{{ route('po.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nomor_po">Nomor PO</label>
                        <input type="text" class="form-control" id="nomor_po" name="nomor_po" 
                               placeholder="Masukkan nomor PO (mis. PO-001)" required>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_po">Tanggal Pembuatan PO</label>
                        <input type="date" class="form-control" id="tanggal_po" name="tanggal_po" 
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <!-- RFS Date -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="rfs_date">RFS Date (Maksimal Produksi)</label>
                        <input type="date" class="form-control" id="rfs_date" name="rfs_date">
                    </div>
                </div>

                <!-- Jenis Item -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jenis_item">Jenis Item</label>
                        <select class="form-control" id="jenis_item" name="jenis_item" required>
                            <option value="">-- Pilih jenis item --</option>
                            <option value="Backdrop event">Backdrop event</option>
                            <option value="Bunting">Bunting</option>
                            <option value="Banner">Banner</option>
                            <option value="Spanduk">Spanduk</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Kolom Others (Hidden by default) -->
            <div class="row mt-3" id="othersRow" style="display: none;">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="jenis_item_lainnya">Tuliskan jenis item lainnya</label>
                        <input type="text" class="form-control" id="jenis_item_lainnya" 
                               name="jenis_item_lainnya" 
                               placeholder="Contoh: Backdrop event, Bunting, dsb.">
                    </div>
                </div>
            </div>

            <!-- Tombol Tambah Kolom -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <button type="button" class="btn btn-add-column" id="btnAddColumn">
                        <i class="fas fa-plus"></i> Tambahin Kolom Judul PO
                    </button>
                </div>
            </div>

            <!-- Container untuk kolom dinamis -->
            <div id="dynamicColumns"></div>

            <!-- Tombol Action -->
            <div class="row mt-5">
                <div class="col-md-12 d-flex justify-content-end gap-3">
                    <button type="button" class="btn btn-outline-primary btn-lg" id="btnLihatPOV">
                        Lihat Semua POV
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg">
                        Simpan Data PO
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Get Answer -->
<div class="modal fade" id="getAnswerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Fitur bantuan untuk pengisian form ini.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/po-form.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/po-form.js') }}"></script>
@endpush