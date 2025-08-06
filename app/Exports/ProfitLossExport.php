<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfitLossExport implements FromArray, WithHeadings
{
    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function array(): array
    {
        $data = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthData = $this->getMonthlyData($this->year, $month);
            if (!empty($monthData['categories'])) {
                $monthName = sprintf('%04d-%02d', $this->year, $month);

                // Income categories
                foreach (['Salary', 'Other Income'] as $category) {
                    if (isset($monthData['categories'][$category])) {
                        $data[] = [
                            $monthName,
                            $category,
                            $monthData['categories'][$category],
                            'Income'
                        ];
                    }
                }

                // Expense categories
                foreach (['Family Expense', 'Transport Expense', 'Meal Expense'] as $category) {
                    if (isset($monthData['categories'][$category])) {
                        $data[] = [
                            $monthName,
                            $category,
                            $monthData['categories'][$category],
                            'Expense'
                        ];
                    }
                }

                // Add totals
                $totalIncome = ($monthData['categories']['Salary'] ?? 0) + ($monthData['categories']['Other Income'] ?? 0);
                $totalExpense = ($monthData['categories']['Family Expense'] ?? 0) + ($monthData['categories']['Transport Expense'] ?? 0) + ($monthData['categories']['Meal Expense'] ?? 0);

                $data[] = [$monthName, 'Total Income', $totalIncome, 'Total'];
                $data[] = [$monthName, 'Total Expense', $totalExpense, 'Total'];
                $data[] = [$monthName, 'Net Income', $totalIncome - $totalExpense, 'Total'];
                $data[] = ['', '', '', '']; // Empty row for separation
            }
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Month',
            'Category',
            'Amount',
            'Type'
        ];
    }



    private function getMonthlyData($year, $month)
    {
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));

        $transaksis = Transaksi::with('coa.kategori')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        $categories = [];

        foreach ($transaksis as $transaksi) {
            $kategoriName = $transaksi->coa->kategori->nama;

            if (!isset($categories[$kategoriName])) {
                $categories[$kategoriName] = 0;
            }

            if (in_array($kategoriName, ['Salary', 'Other Income'])) {
                $categories[$kategoriName] += $transaksi->credit - $transaksi->debit;
            } else {
                $categories[$kategoriName] += $transaksi->debit - $transaksi->credit;
            }
        }

        return ['categories' => $categories];
    }
}
