<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\User;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada admin user
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            $admin = User::first(); // Gunakan user pertama jika tidak ada admin
        }

        $announcements = [
            [
                'title' => 'Jadwal Vaksinasi COVID-19 Bulan November',
                'content' => 'Kami mengumumkan bahwa Rumah Sakit akan mengadakan program vaksinasi COVID-19 untuk umum pada bulan November 2025. Vaksinasi akan dilaksanakan setiap hari Senin dan Kamis, pukul 08.00 - 12.00 WIB di Ruang Poliklinik Lantai 2. Pendaftaran dapat dilakukan secara online melalui website rumah sakit atau langsung datang ke lokasi. Mohon membawa KTP dan kartu vaksinasi sebelumnya (jika ada).',
                'type' => 'info',
                'status' => 'active',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonth(),
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Perubahan Jam Operasional Apotek',
                'content' => 'Mulai tanggal 1 November 2025, jam operasional Apotek Rumah Sakit akan berubah menjadi:\n\nSenin - Jumat: 07.00 - 20.00 WIB\nSabtu: 08.00 - 16.00 WIB\nMinggu & Libur: 08.00 - 12.00 WIB\n\nUntuk kebutuhan darurat di luar jam operasional, silakan menghubungi IGD.',
                'type' => 'warning',
                'status' => 'active',
                'start_date' => Carbon::now()->subDays(3),
                'end_date' => null,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Maintenance Sistem Informasi Rumah Sakit',
                'content' => 'PENTING! Sistem Informasi Rumah Sakit akan menjalani maintenance rutin pada:\n\nTanggal: 30 Oktober 2025\nWaktu: 22.00 - 02.00 WIB (dini hari)\n\nSelama maintenance, layanan online seperti pendaftaran online, cek jadwal dokter, dan akses rekam medis elektronik tidak dapat diakses. Mohon maaf atas ketidaknyamanannya.',
                'type' => 'urgent',
                'status' => 'active',
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(2),
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Program Check-up Kesehatan Gratis',
                'content' => 'Dalam rangka memperingati Hari Kesehatan Nasional, Rumah Sakit mengadakan program check-up kesehatan gratis untuk masyarakat umum. Program ini meliputi:\n\n- Pemeriksaan tekanan darah\n- Cek gula darah\n- Cek kolesterol\n- Konsultasi dokter umum\n\nTerbatas untuk 100 orang pertama setiap harinya. Pendaftaran dibuka pukul 07.00 WIB.',
                'type' => 'info',
                'status' => 'active',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addWeeks(2),
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Protokol Kesehatan di Area Rumah Sakit',
                'content' => 'Untuk kenyamanan dan keselamatan bersama, kami mengingatkan kepada seluruh pengunjung untuk:\n\n1. Memakai masker dengan benar\n2. Mencuci tangan atau menggunakan hand sanitizer\n3. Menjaga jarak minimal 1 meter\n4. Mengikuti arahan petugas\n5. Maksimal 1 penunggu pasien\n\nTerima kasih atas kerjasama Anda.',
                'type' => 'general',
                'status' => 'active',
                'start_date' => Carbon::now()->subWeek(),
                'end_date' => null,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Libur Nasional - Layanan Terbatas',
                'content' => 'Menjelang libur akhir tahun, kami informasikan bahwa pada tanggal 25 Desember 2025 dan 1 Januari 2026, layanan rumah sakit akan beroperasi dengan kapasitas terbatas. Hanya IGD dan rawat inap yang beroperasi 24 jam. Untuk poliklinik akan tutup. Mohon rencanakan kunjungan Anda dengan baik.',
                'type' => 'warning',
                'status' => 'inactive',
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->subDays(5),
                'created_by' => $admin->id,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}