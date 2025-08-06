@extends('layouts.app')

@section('title', 'Lihat Kategori - Test Ticketux')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kategori: {{ $kategori->nama }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('kategoris.edit', $kategori) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('kategoris.destroy', $kategori) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-delete">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
        <a href="{{ route('kategoris.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Kategori</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td>{{ $kategori->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td>{{ $kategori->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total COAs:</strong></td>
                        <td>
                            <span class="badge bg-info">{{ $kategori->coas->count() }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $kategori->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diperbarui:</strong></td>
                        <td>{{ $kategori->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">COA yang terkait</h5>
                <a href="{{ route('coas.create', ['kategori_id' => $kategori->id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah COA
                </a>
            </div>
            <div class="card-body">
                @if($kategori->coas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Transaksi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategori->coas as $coa)
                            <tr>
                                <td><code>{{ $coa->kode }}</code></td>
                                <td>{{ $coa->nama }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $coa->transaksis->count() }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('coas.show', $coa) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('coas.edit', $coa) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No COAs found for this kategori.</p>
                    <a href="{{ route('coas.create', ['kategori_id' => $kategori->id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create First COA
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
