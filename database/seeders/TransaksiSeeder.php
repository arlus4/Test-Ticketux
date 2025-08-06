<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use App\Models\Coa;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get COA IDs
        $gajiKaryawan = Coa::where('kode', '401')->first();
        $gajiKetuaMPR = Coa::where('kode', '402')->first();
        $bensin = Coa::where('kode', '602')->first();

        $transaksis = [
            // Transaksi dari gambar
            [
                'tanggal' => '2022-01-01',
                'coa_id' => $gajiKaryawan->id,
                'desc' => 'Gaji Karyawan Pensiunan Di Perusahaan A',
                'debit' => 0,
                'credit' => 5000000,
            ],
            [
                'tanggal' => '2022-01-02',
                'coa_id' => $gajiKetuaMPR->id,
                'desc' => 'Gaji Ketua',
                'debit' => 0,
                'credit' => 7000000,
            ],
            [
                'tanggal' => '2022-01-10',
                'coa_id' => $bensin->id,
                'desc' => 'Bensin Anak',
                'debit' => 25000,
                'credit' => 0,
            ],
        ];

        foreach ($transaksis as $transaksi) {
            Transaksi::create($transaksi);
        }
    }
}
