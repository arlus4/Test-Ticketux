@extends('layouts.app')

@section('title', 'Dashboard - Test Ticketux')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Kategori</h5>
                        <h3 class="card-text">{{ \App\Models\Kategori::count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-tags fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('kategoris.index') }}" class="text-white text-decoration-none">
                    View Details <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total COA</h5>
                        <h3 class="card-text">{{ \App\Models\Coa::count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-list fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('coas.index') }}" class="text-white text-decoration-none">
                    View Details <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Transaksi</h5>
                        <h3 class="card-text">{{ \App\Models\Transaksi::count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exchange-alt fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('transaksis.index') }}" class="text-white text-decoration-none">
                    View Details <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Saldo</h5>
                        <h3 class="card-text">
                            Rp {{ number_format(\App\Models\Transaksi::sum('debit') - \App\Models\Transaksi::sum('credit'), 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-balance-scale fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('reports.profit-loss') }}" class="text-white text-decoration-none">
                    View Report <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Transaksi Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>COA</th>
                                <th>Debit</th>
                                <th>Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Transaksi::with('coa')->latest()->take(5)->get() as $transaksi)
                            <tr>
                                <td>{{ $transaksi->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $transaksi->coa->nama }}</td>
                                <td>{{ $transaksi->debit > 0 ? 'Rp ' . number_format($transaksi->debit, 0, ',', '.') : '-' }}</td>
                                <td>{{ $transaksi->credit > 0 ? 'Rp ' . number_format($transaksi->credit, 0, ',', '.') : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tindakan Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('kategoris.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Kategori Baru
                    </a>
                    <a href="{{ route('coas.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah COA Baru
                    </a>
                    <a href="{{ route('transaksis.create') }}" class="btn btn-info">
                        <i class="fas fa-plus"></i> Tambah Transaksi Baru
                    </a>
                    <a href="{{ route('reports.profit-loss') }}" class="btn btn-warning">
                        <i class="fas fa-chart-line"></i> Lihat Laporan Profit/Loss
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
