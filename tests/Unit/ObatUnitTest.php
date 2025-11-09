<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Obat;

class ObatUnitTest extends TestCase
{
    public function test_obat_model_can_be_created_in_memory()
    {
        $obat = new Obat([
            'nama_obat' => 'Paracetamol',
            'kategori' => 'Analgesik',
            'stok' => 100,
            'satuan' => 'tablet',
            'harga' => 5000,
            'deskripsi' => 'Pain relief medicine',
        ]);

        $this->assertEquals('Paracetamol', $obat->nama_obat);
        $this->assertEquals('Analgesik', $obat->kategori);
        $this->assertEquals(100, $obat->stok);
        $this->assertEquals('tablet', $obat->satuan);
        $this->assertEquals(5000, $obat->harga);
        $this->assertEquals('Pain relief medicine', $obat->deskripsi);
    }
}
