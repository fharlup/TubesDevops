<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TagihanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tagihan')->insert([
            [
                'no_tagihan' => 'INV-001',
                'pasien_id' => null,
                'name' => 'Rizky Kusuma Nugraha',
                'total_tagihan' => 150000.00,
                'status' => 'belum_bayar',
                'tanggal_tagihan' => Carbon::now()->subDays(3)->format('Y-m-d'),
                'tanggal_bayar' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'no_tagihan' => 'INV-002',
                'pasien_id' => null,
                'name' => 'Dewi Ayu Pratiwi',
                'total_tagihan' => 275000.00,
                'status' => 'lunas',
                'tanggal_tagihan' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'tanggal_bayar' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'no_tagihan' => 'INV-003',
                'pasien_id' => null, 
                'name' => 'Andi Saputra',
                'total_tagihan' => 98000.00,
                'status' => 'belum_bayar',
                'tanggal_tagihan' => Carbon::now()->subDay()->format('Y-m-d'),
                'tanggal_bayar' => null,
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
        ]);
    }
}