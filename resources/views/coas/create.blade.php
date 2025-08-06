@extends('layouts.app')

@section('title', 'Buat COA - Test Ticketux')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat COA Baru</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('coas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi COA</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('coas.store') }}" method="POST" id="coaForm">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Akun <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('kode') is-invalid @enderror"
                               id="kode"
                               name="kode"
                               value="{{ old('kode') }}"
                               placeholder="misalnya: 401, 602"
                               required>
                        @error('kode')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            Masukkan kode akun yang unik (biasanya 3 digit)
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Akun <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('nama') is-invalid @enderror"
                               id="nama"
                               name="nama"
                               value="{{ old('nama') }}"
                               placeholder="Masukkan nama akun"
                               required>
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            Masukkan nama akun
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('kategori_id') is-invalid @enderror"
                                id="kategori_id"
                                name="kategori_id"
                                required>
                            <option value="">Pilih kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            Pilih kategori akun
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('coas.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan COA
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
                <h6>Petunjuk Code:</h6>
                <ul class="small text-muted">
                    <li><strong>400-499:</strong> Income accounts</li>
                    <li><strong>500-599:</strong> Cost of goods sold</li>
                    <li><strong>600-699:</strong> Operating expenses</li>
                    <li><strong>700-799:</strong> Other expenses</li>
                </ul>
                
                <h6 class="mt-3">Contoh:</h6>
                <ul class="small text-muted">
                    <li>401 - Gaji Pegawai</li>
                    <li>501 - Biaya Barang</li>
                    <li>602 - Biaya Operasional</li>
                    <li>603 - Biaya Parkir</li>
                    <li>604 - Biaya Makan</li>
                </ul>
            </div>
        </div>

        @if($kategoris->count() == 0)
        <div class="card mt-3">
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Tidak ada kategori. Silakan <a href="{{ route('kategoris.create') }}">buat kategori</a> terlebih dahulu.
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Form validation
    $('#coaForm').on('submit', function(e) {
        var kode = $('#kode').val().trim();
        var nama = $('#nama').val().trim();
        var kategoriId = $('#kategori_id').val();
        
        var hasError = false;
        
        if (kode === '') {
            $('#kode').addClass('is-invalid');
            hasError = true;
        }
        
        if (nama === '') {
            $('#nama').addClass('is-invalid');
            hasError = true;
        }
        
        if (kategoriId === '') {
            $('#kategori_id').addClass('is-invalid');
            hasError = true;
        }
        
        if (hasError) {
            e.preventDefault();
            return false;
        }
    });

    // Real-time validation
    $('#kode, #nama').on('input', function() {
        if ($(this).val().trim() !== '') {
            $(this).removeClass('is-invalid');
        }
    });
    
    $('#kategori_id').on('change', function() {
        if ($(this).val() !== '') {
            $(this).removeClass('is-invalid');
        }
    });

    // Focus on first input
    $('#kode').focus();
});
</script>
@endsection
