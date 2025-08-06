<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Salary'],
            ['nama' => 'Other Income'],
            ['nama' => 'Family Expense'],
            ['nama' => 'Transport Expense'],
            ['nama' => 'Meal Expense'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
