@extends('layouts.app')

@section('title', 'Create Kategori - Test Ticketux')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat Kategori Baru</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('kategoris.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Kategori Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kategoris.store') }}" method="POST" id="kategoriForm">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('nama') is-invalid @enderror"
                               id="nama"
                               name="nama"
                               value="{{ old('nama') }}"
                               placeholder="Masukkan nama kategori"
                               required>
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            Masukkan nama kategori (misalnya: "Pendapatan", "Biaya", dll.)
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('kategoris.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Bantuan</h5>
            </div>
            <div class="card-body">
                <h6>Apa itu Kategori?</h6>
                <p class="small text-muted">
                    Kategori digunakan untuk mengelompokkan Daftar Akun (Chart of Accounts/COA) yang saling berhubungan.
                    Contohnya, Anda mungkin memiliki kategori seperti:
                </p>
                <ul class="small text-muted">
                    <li>Pendapatan</li>
                    <li>Biaya</li>
                    <li>Asset</li>
                    <li>Liabilitas</li>
                </ul>
                <p class="small text-muted">
                    Setiap Daftar Akun (COA) harus memiliki kategori untuk memudahkan pengelompokan dan laporan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Form validation
    $('#kategoriForm').on('submit', function(e) {
        var nama = $('#nama').val().trim();
        
        if (nama === '') {
            e.preventDefault();
            $('#nama').addClass('is-invalid');
            if (!$('#nama').next('.invalid-feedback').length) {
                $('#nama').after('<div class="invalid-feedback">Nama kategori is required.</div>');
            }
            return false;
        }
        
        // Remove validation classes on successful validation
        $('#nama').removeClass('is-invalid');
    });

    // Real-time validation
    $('#nama').on('input', function() {
        if ($(this).val().trim() !== '') {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });

    // Focus on first input
    $('#nama').focus();
});
</script>
@endsection
