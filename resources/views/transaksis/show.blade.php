@extends('layouts.app')

@section('title', 'Detail Transaksi - Test Ticketux')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Transaksi</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('transaksis.edit', $transaksi) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('transaksis.destroy', $transaksi) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-delete">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
        <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Transaksi</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
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
                        <td>
                            <code>{{ $transaksi->coa->kode }}</code> - {{ $transaksi->coa->nama }}<br>
                            <small class="text-muted">Kategori: {{ $transaksi->coa->kategori->nama }}</small>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Deskripsi:</strong></td>
                        <td>{{ $transaksi->desc }}</td>
                    </tr>
                    <tr>
                        <td><strong>Debit:</strong></td>
                        <td>
                            @if($transaksi->debit > 0)
                                <span class="text-danger fw-bold">Rp {{ number_format($transaksi->debit, 0, ',', '.') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Credit:</strong></td>
                        <td>
                            @if($transaksi->credit > 0)
                                <span class="text-success fw-bold">Rp {{ number_format($transaksi->credit, 0, ',', '.') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Saldo:</strong></td>
                        <td>
                            @php
                                $balance = $transaksi->debit - $transaksi->credit;
                                $textClass = $balance >= 0 ? 'text-success' : 'text-danger';
                            @endphp
                            <span class="{{ $textClass }} fw-bold">
                                Rp {{ number_format(abs($balance), 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $transaksi->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diperbarui:</strong></td>
                        <td>{{ $transaksi->updated_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Terkait</h5>
            </div>
            <div class="card-body">
                <h6>Detail Chart of Account:</h6>
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">{{ $transaksi->coa->kode }} - {{ $transaksi->coa->nama }}</h6>
                        <p class="card-text">
                            <strong>Kategori:</strong> {{ $transaksi->coa->kategori->nama }}<br>
                            <strong>Total Transaksi:</strong> {{ $transaksi->coa->transaksis->count() }}<br>
                            <strong>Total Debit:</strong> Rp {{ number_format($transaksi->coa->transaksis->sum('debit'), 0, ',', '.') }}<br>
                            <strong>Total Credit:</strong> Rp {{ number_format($transaksi->coa->transaksis->sum('credit'), 0, ',', '.') }}
                        </p>
                        <a href="{{ route('coas.show', $transaksi->coa) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> Lihat Detail COA
                        </a>
                    </div>
                </div>

                <h6 class="mt-4">Aksi Cepat:</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('transaksis.create', ['coa_id' => $transaksi->coa_id]) }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Transaksi ke COA ini
                    </a>
                    <a href="{{ route('reports.profit-loss') }}" class="btn btn-info">
                        <i class="fas fa-chart-line"></i> Lihat Laporan Profit/Loss
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Add some visual enhancements
    $('.card').hover(
        function() {
            $(this).addClass('shadow-sm');
        },
        function() {
            $(this).removeClass('shadow-sm');
        }
    );
});
</script>
@endsection
