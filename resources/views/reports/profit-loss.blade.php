@extends('layouts.app')

@section('title', 'Laporan Profit/Loss - Test Ticketux')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan Laba/Rugi - {{ $year }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('reports.export-profit-loss', ['year' => $year]) }}" class="btn btn-success">
                <i class="fas fa-download"></i> Export Excel
            </a>
        </div>
        <form method="GET" class="d-flex">
            <select name="year" class="form-select me-2" onchange="this.form.submit()">
                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </form>
    </div>
</div>

@if(empty($months))
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    Tidak ada data transaksi untuk {{ $year }}. <a href="{{ route('transaksis.create') }}">Buat beberapa transaksi</a> untuk melihat laporan.
</div>
@else
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Bulan</th>
                        <th class="text-end">Pendapatan</th>
                        <th class="text-end">Pengeluaran</th>
                        <th class="text-end">Laba Bersih</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalIncome = 0;
                        $totalExpense = 0;
                        $totalNet = 0;
                    @endphp
                    @foreach($months as $month => $data)
                    @php
                        $totalIncome += $data['totalIncome'];
                        $totalExpense += $data['totalExpense'];
                        $totalNet += $data['netIncome'];
                        $statusClass = $data['netIncome'] >= 0 ? 'success' : 'danger';
                        $statusIcon = $data['netIncome'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                        $statusText = $data['netIncome'] >= 0 ? 'Laba' : 'Rugi';
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ date('F Y', strtotime($month . '-01')) }}</strong>
                        </td>
                        <td class="text-end text-success">
                            Rp {{ number_format($data['totalIncome'], 0, ',', '.') }}
                        </td>
                        <td class="text-end text-danger">
                            Rp {{ number_format($data['totalExpense'], 0, ',', '.') }}
                        </td>
                        <td class="text-end">
                            <span class="text-{{ $statusClass }} fw-bold">
                                Rp {{ number_format(abs($data['netIncome']), 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{{ $statusClass }}">
                                <i class="fas {{ $statusIcon }}"></i> {{ $statusText }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th>TOTAL {{ $year }}</th>
                        <th class="text-end text-success">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </th>
                        <th class="text-end text-danger">
                            Rp {{ number_format($totalExpense, 0, ',', '.') }}
                        </th>
                        <th class="text-end">
                            @php
                                $totalStatusClass = $totalNet >= 0 ? 'success' : 'danger';
                            @endphp
                            <span class="text-{{ $totalStatusClass }} fw-bold">
                                Rp {{ number_format(abs($totalNet), 0, ',', '.') }}
                            </span>
                        </th>
                        <th class="text-center">
                            @php
                                $totalStatusIcon = $totalNet >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                                $totalStatusText = $totalNet >= 0 ? 'Laba' : 'Rugi';
                            @endphp
                            <span class="badge bg-{{ $totalStatusClass }}">
                                <i class="fas {{ $totalStatusIcon }}"></i> {{ $totalStatusText }}
                            </span>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Detailed breakdown by category -->
<div class="row mt-4">
    @foreach($months as $month => $data)
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">{{ date('F Y', strtotime($month . '-01')) }} - Pembagian Laba/Rugi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th class="text-end">Jumlah</th>
                                <th class="text-center">Tipe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['categories'] as $category => $amount)
                            @php
                                $isIncome = in_array($category, ['Salary', 'Other Income']);
                                $typeClass = $isIncome ? 'success' : 'danger';
                                $typeText = $isIncome ? 'Pendapatan' : 'Pengeluaran';
                            @endphp
                            <tr>
                                <td>{{ $category }}</td>
                                <td class="text-end text-{{ $typeClass }}">
                                    Rp {{ number_format(abs($amount), 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $typeClass }}">{{ $typeText }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Add hover effects
    $('.table tbody tr').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );

    // Auto-submit year filter
    $('select[name="year"]').on('change', function() {
        $(this).closest('form').submit();
    });
});
</script>
@endsection
