<?php

namespace Database\Seeders;

use App\Models\Coa;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class CoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get kategori IDs
        $salaryKategori = Kategori::where('nama', 'Salary')->first();
        $otherIncomeKategori = Kategori::where('nama', 'Other Income')->first();
        $familyExpenseKategori = Kategori::where('nama', 'Family Expense')->first();
        $transportExpenseKategori = Kategori::where('nama', 'Transport Expense')->first();
        $mealExpenseKategori = Kategori::where('nama', 'Meal Expense')->first();

        $coas = [
            // Salary
            [
                'kode' => '401',
                'nama' => 'Gaji Karyawan',
                'kategori_id' => $salaryKategori->id,
            ],
            
            // Other Income
            [
                'kode' => '402',
                'nama' => 'Gaji Ketua MPR',
                'kategori_id' => $otherIncomeKategori->id,
            ],
            [
                'kode' => '403',
                'nama' => 'Profit Trading',
                'kategori_id' => $otherIncomeKategori->id,
            ],
            
            // Family Expense
            [
                'kode' => '601',
                'nama' => 'Biaya Sekolah',
                'kategori_id' => $familyExpenseKategori->id,
            ],
            [
                'kode' => '602',
                'nama' => 'Bensin',
                'kategori_id' => $familyExpenseKategori->id,
            ],
            [
                'kode' => '603',
                'nama' => 'Parkir',
                'kategori_id' => $familyExpenseKategori->id,
            ],
            
            // Transport Expense
            [
                'kode' => '604',
                'nama' => 'Makan Siang',
                'kategori_id' => $transportExpenseKategori->id,
            ],
            
            // Meal Expense
            [
                'kode' => '605',
                'nama' => 'Makana Pokok Bulanan',
                'kategori_id' => $mealExpenseKategori->id,
            ],
        ];

        foreach ($coas as $coa) {
            Coa::create($coa);
        }
    }
}
