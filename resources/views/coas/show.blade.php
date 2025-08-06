@extends('layouts.app')

@section('title', 'Detail COA - Test Ticketux')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">COA: {{ $coa->kode }} - {{ $coa->nama }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('coas.edit', $coa) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('coas.destroy', $coa) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-delete">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
        <a href="{{ route('coas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi COA</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td>{{ $coa->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kode:</strong></td>
                        <td><code>{{ $coa->kode }}</code></td>
                    </tr>
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td>{{ $coa->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kategori:</strong></td>
                        <td>
                            <span class="badge bg-secondary">{{ $coa->kategori->nama }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Total Transaksi:</strong></td>
                        <td>
                            <span class="badge bg-info">{{ $coa->transaksis->count() }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $coa->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diperbarui:</strong></td>
                        <td>{{ $coa->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Transaksi</h5>
                <a href="{{ route('transaksis.create', ['coa_id' => $coa->id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah Transaksi
                </a>
            </div>
            <div class="card-body">
                @if($coa->transaksis->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coa->transaksis as $transaksi)
                            <tr>
                                <td>{{ $transaksi->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $transaksi->desc }}</td>
                                <td class="text-end">
                                    {{ $transaksi->debit > 0 ? 'Rp ' . number_format($transaksi->debit, 0, ',', '.') : '-' }}
                                </td>
                                <td class="text-end">
                                    {{ $transaksi->credit > 0 ? 'Rp ' . number_format($transaksi->credit, 0, ',', '.') : '-' }}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('transaksis.show', $transaksi) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('transaksis.edit', $transaksi) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary">
                            <tr>
                                <th colspan="2">TOTAL</th>
                                <th class="text-end">Rp {{ number_format($coa->transaksis->sum('debit'), 0, ',', '.') }}</th>
                                <th class="text-end">Rp {{ number_format($coa->transaksis->sum('credit'), 0, ',', '.') }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada transaksi untuk COA ini.</p>
                    <a href="{{ route('transaksis.create', ['coa_id' => $coa->id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Transaksi Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
