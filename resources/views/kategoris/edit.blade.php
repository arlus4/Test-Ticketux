@extends('layouts.app')

@section('title', 'Edit Kategori - Test Ticketux')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Kategori: {{ $kategori->nama }}</h1>
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
                <h5 class="card-title mb-0">Edit Informasi Kategori</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kategoris.update', $kategori) }}" method="POST" id="kategoriForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('nama') is-invalid @enderror"
                               id="nama"
                               name="nama"
                               value="{{ old('nama', $kategori->nama) }}"
                               placeholder="Masukkan nama kategori"
                               required>
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            Masukkan nama kategori yang deskriptif (misalnya, "Gaji", "Pengeluaran", dll.)
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
                <h5 class="card-title mb-0">Detail Kategori</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td>{{ $kategori->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $kategori->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diperbarui:</strong></td>
                        <td>{{ $kategori->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total COAs:</strong></td>
                        <td>
                            <span class="badge bg-info">{{ $kategori->coas->count() }}</span>
                        </td>
                    </tr>
                </table>

                @if($kategori->coas->count() > 0)
                <div class="mt-3">
                    <h6>COA yang terkait:</h6>
                    <ul class="list-group list-group-flush">
                        @foreach($kategori->coas->take(5) as $coa)
                        <li class="list-group-item px-0 py-1 small">
                            {{ $coa->kode }} - {{ $coa->nama }}
                        </li>
                        @endforeach
                        @if($kategori->coas->count() > 5)
                        <li class="list-group-item px-0 py-1 small text-muted">
                            ... and {{ $kategori->coas->count() - 5 }} more
                        </li>
                        @endif
                    </ul>
                </div>
                @endif
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
