<?php

namespace Tests\Unit;

use App\Models\Tagihan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TagihanTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_create_invoice_with_valid_data()
    {
        $tagihan = Tagihan::create([
            'no_tagihan' => 'INV-001',
            'name' => 'Budi Santoso',
            'total_tagihan' => 150000,
            'tanggal_tagihan' => now()->format('Y-m-d'),
            'status' => 'belum_bayar',
        ]);

        $this->assertDatabaseHas('tagihan', [
            'no_tagihan' => 'INV-001',
            'name' => 'Budi Santoso',
            'total_tagihan' => 150000,
        ]);
    }

    #[Test]
    public function default_invoice_status_is_unpaid()
    {
        $tagihan = Tagihan::create([
            'no_tagihan' => 'INV-002',
            'name' => 'Siti Aminah',
            'total_tagihan' => 100000,
            'tanggal_tagihan' => now()->format('Y-m-d'),
        ]);

        $this->assertEquals('belum_bayar', $tagihan->status);
    }

    #[Test]
    public function can_update_invoice_status_and_total()
    {
        $tagihan = Tagihan::create([
            'no_tagihan' => 'INV-003',
            'name' => 'Dewi Lestari',
            'total_tagihan' => 120000,
            'tanggal_tagihan' => now()->format('Y-m-d'),
            'status' => 'belum_bayar',
        ]);

        $tagihan->update([
            'status' => 'lunas',
            'total_tagihan' => 200000,
            'tanggal_bayar' => now()->format('Y-m-d'),
        ]);

        $this->assertDatabaseHas('tagihan', [
            'no_tagihan' => 'INV-003',
            'status' => 'lunas',
            'total_tagihan' => 200000,
        ]);
    }

    #[Test]
    public function can_delete_invoice_from_database()
    {
        $tagihan = Tagihan::create([
            'no_tagihan' => 'INV-004',
            'name' => 'Tono Wijaya',
            'total_tagihan' => 80000,
            'tanggal_tagihan' => now()->format('Y-m-d'),
            'status' => 'belum_bayar',
        ]);

        $tagihan->delete();

        $this->assertDatabaseMissing('tagihan', [
            'no_tagihan' => 'INV-004',
        ]);
    }

    #[Test]
    public function validation_requires_required_fields()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        // sengaja kosong, supaya gagal
        Tagihan::create([
            'no_tagihan' => null,
            'name' => null,
            'total_tagihan' => null,
            'tanggal_tagihan' => null,
        ]);
    }
}
