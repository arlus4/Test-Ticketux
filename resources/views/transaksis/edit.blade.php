@extends('layouts.app')

@section('title', 'Edit Transaksi - Test Ticketux')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Transaksi</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Transaksi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('transaksis.update', $transaksi) }}" method="POST" id="transaksiForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                        <input type="date"
                               class="form-control @error('tanggal') is-invalid @enderror"
                               id="tanggal"
                               name="tanggal"
                               value="{{ old('tanggal', $transaksi->tanggal->format('Y-m-d')) }}"
                               required>
                        @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="coa_id" class="form-label">Chart of Account (COA) <span class="text-danger">*</span></label>
                        <select class="form-select @error('coa_id') is-invalid @enderror"
                                id="coa_id"
                                name="coa_id"
                                required>
                            <option value="">Pilih akun</option>
                            @foreach($coas as $coa)
                                <option value="{{ $coa->id }}" {{ old('coa_id', $transaksi->coa_id) == $coa->id ? 'selected' : '' }}>
                                    {{ $coa->kode }} - {{ $coa->nama }} ({{ $coa->kategori->nama }})
                                </option>
                            @endforeach
                        </select>
                        @error('coa_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="desc" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('desc') is-invalid @enderror"
                                  id="desc"
                                  name="desc"
                                  rows="3"
                                  placeholder="Masukkan deskripsi transaksi"
                                  required>{{ old('desc', $transaksi->desc) }}</textarea>
                        @error('desc')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="debit" class="form-label">Jumlah Debit</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                           class="form-control @error('debit') is-invalid @enderror"
                                           id="debit"
                                           name="debit"
                                           value="{{ old('debit', $transaksi->debit) }}"
                                           min="0"
                                           step="0.01">
                                    @error('debit')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    Masukkan jumlah debit (menambahkan biaya/aset)
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="credit" class="form-label">Jumlah Credit</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                           class="form-control @error('credit') is-invalid @enderror"
                                           id="credit"
                                           name="credit"
                                           value="{{ old('credit', $transaksi->credit) }}"
                                           min="0"
                                           step="0.01">
                                    @error('credit')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    Masukkan jumlah credit (menambahkan pendapatan/kewajiban)
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Catatan:</strong> Salah satu dari jumlah debit atau credit harus lebih besar dari 0, tetapi tidak keduanya.
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('transaksis.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Transaksi</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td>{{ $transaksi->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal:</strong></td>
                        <td>{{ $transaksi->tanggal->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>COA:</strong></td>
                        <td>{{ $transaksi->coa->kode }} - {{ $transaksi->coa->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Debit:</strong></td>
                        <td>Rp {{ number_format($transaksi->debit, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Credit:</strong></td>
                        <td>Rp {{ number_format($transaksi->credit, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diperbarui:</strong></td>
                        <td>{{ $transaksi->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Bantuan</h5>
            </div>
            <div class="card-body">
                <h6>Debit vs Credit:</h6>
                <ul class="small text-muted">
                    <li><strong>Debit:</strong> Menambahkan biaya, aset</li>
                    <li><strong>Credit:</strong> Menambahkan pendapatan, kewajiban</li>
                </ul>
                
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Peringatan:</strong> Edit Transaksi ini mungkin memengaruhi laporan dan perhitungan yang ada.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Form validation
    $('#transaksiForm').on('submit', function(e) {
        var debit = parseFloat($('#debit').val()) || 0;
        var credit = parseFloat($('#credit').val()) || 0;
        
        // Check if both debit and credit are 0
        if (debit === 0 && credit === 0) {
            e.preventDefault();
            alert('Either debit or credit amount must be greater than 0.');
            return false;
        }
        
        // Check if both debit and credit have values
        if (debit > 0 && credit > 0) {
            e.preventDefault();
            alert('Only one of debit or credit should have a value, not both.');
            return false;
        }
    });

    // Auto-clear opposite field when entering amount
    $('#debit').on('input', function() {
        if (parseFloat($(this).val()) > 0) {
            $('#credit').val(0);
        }
    });
    
    $('#credit').on('input', function() {
        if (parseFloat($(this).val()) > 0) {
            $('#debit').val(0);
        }
    });

    // Focus on first input
    $('#tanggal').focus();
});
</script>
@endsection
