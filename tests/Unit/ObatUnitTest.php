<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Obat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class ObatUnitTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_an_obat()
    {
        $obat = Obat::factory()->create([
            'nama_obat' => 'Paracetamol',
            'kategori' => 'Umum',
            'stok'      => 20,
            'satuan'    => 'Tablet',
            'harga'     => 5000,
            'deskripsi' => 'Obat demam',
        ]);

        $this->assertDatabaseHas('obats', [
            'id' => $obat->id,
            'nama_obat' => 'Paracetamol',
        ]);
    }

    #[Test]
    public function it_can_be_updated()
    {
        $obat = Obat::factory()->create([
            'nama_obat' => 'Aspirin'
        ]);

        $obat->update(['nama_obat' => 'Aspirin Plus']);

        $this->assertDatabaseHas('obats', [
            'id' => $obat->id,
            'nama_obat' => 'Aspirin Plus',
        ]);
    }

    #[Test]
    public function it_can_be_deleted()
    {
        $obat = Obat::factory()->create();
        $id = $obat->id;

        $obat->delete();

        $this->assertDatabaseMissing('obats', [
            'id' => $id,
        ]);
    }

    #[Test]
    public function it_has_correct_fillable_properties()
    {
        $obat = new Obat;

        $expected = [
            'nama_obat',
            'kategori',
            'stok',
            'satuan',
            'harga',
            'deskripsi',
        ];

        $this->assertEquals($expected, $obat->getFillable());
    }
}
