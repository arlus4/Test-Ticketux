<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProfitLossExport;

class ReportController extends Controller
{
    public function profitLoss(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $months = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthData = $this->getMonthlyData($year, $month);
            if (!empty($monthData['categories'])) {
                $months[sprintf('%04d-%02d', $year, $month)] = $monthData;
            }
        }

        return view('reports.profit-loss', compact('months', 'year'));
    }

    private function getMonthlyData($year, $month)
    {
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));

        // Complex query with joins and subqueries for better performance
        $transaksis = Transaksi::select([
            'transaksis.debit',
            'transaksis.credit',
            'kategoris.nama as kategori_nama'
        ])
            ->join('coas', 'transaksis.coa_id', '=', 'coas.id')
            ->join('kategoris', 'coas.kategori_id', '=', 'kategoris.id')
            ->whereBetween('transaksis.tanggal', [$startDate, $endDate])
            ->get();

        // Use collection methods for more efficient processing
        $incomeCategories = ['Salary', 'Other Income'];

        $categories = $transaksis->groupBy('kategori_nama')->map(function ($group, $kategoriName) use ($incomeCategories) {
            if (in_array($kategoriName, $incomeCategories)) {
                // Income: credit increases, debit decreases
                return $group->sum('credit') - $group->sum('debit');
            } else {
                // Expense: debit increases, credit decreases
                return $group->sum('debit') - $group->sum('credit');
            }
        })->toArray();

        // Calculate totals using array functions
        $totalIncome = array_sum(array_intersect_key($categories, array_flip($incomeCategories)));
        $totalExpense = array_sum(array_diff_key($categories, array_flip($incomeCategories)));

        return [
            'categories' => $categories,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netIncome' => $totalIncome - $totalExpense
        ];
    }

    public function exportProfitLoss(Request $request)
    {
        $year = $request->get('year', date('Y'));

        return Excel::download(new ProfitLossExport($year), 'profit-loss-' . $year . '.xlsx');
    }
}
