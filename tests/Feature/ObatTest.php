<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Obat;

class ObatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_obat()
    {
        Obat::factory()->create([
            'nama_obat' => 'Paracetamol'
        ]);

        $response = $this->get('/obat');

        $response->assertStatus(200);
        $response->assertSee('Paracetamol');
    }

    /** @test */
    public function it_can_create_obat()
    {
        $response = $this->post('/obat', [
            'nama_obat' => 'Aspirin',
            'kategori' => 'Painkiller',
            'stok' => 10,
            'satuan' => 'Tablet',
            'harga' => 5000,
            'deskripsi' => 'Obat sakit kepala',
        ]);

        $response->assertRedirect('/obat');
        $this->assertDatabaseHas('obats', ['nama_obat' => 'Aspirin']);
    }

    /** @test */
    public function it_can_update_obat()
    {
        $obat = Obat::factory()->create();

        $response = $this->put("/obat/{$obat->id}", [
            'nama_obat' => 'Updated Name',
            'kategori' => $obat->kategori,
            'stok' => $obat->stok,
            'satuan' => $obat->satuan,
            'harga' => $obat->harga,
            'deskripsi' => $obat->deskripsi,
        ]);

        $response->assertRedirect('/obat');
        $this->assertDatabaseHas('obats', ['nama_obat' => 'Updated Name']);
    }

    /** @test */
    public function it_can_delete_obat()
    {
        $obat = Obat::factory()->create();

        $response = $this->delete("/obat/{$obat->id}");

        $response->assertRedirect('/obat');
        $this->assertDatabaseMissing('obats', ['id' => $obat->id]);
    }

    /** @test */
public function it_fails_validation_when_required_fields_are_missing()
{
    $response = $this->post('/obat', [
        'nama_obat' => '', // required
        'stok' => '',      // required
        'satuan' => '',    // required
        'harga' => '',     // required
    ]);

    $response->assertSessionHasErrors(['nama_obat', 'stok', 'satuan', 'harga']);
}

/** @test */
public function stok_must_be_non_negative_integer()
{
    $response = $this->post('/obat', [
        'nama_obat' => 'Test',
        'kategori' => 'Kategori',
        'stok' => -5, // invalid
        'satuan' => 'Tablet',
        'harga' => 1000,
        'deskripsi' => '',
    ]);

    $response->assertSessionHasErrors(['stok']);
}

/** @test */
public function harga_must_be_numeric()
{
    $response = $this->post('/obat', [
        'nama_obat' => 'Test',
        'kategori' => 'Kategori',
        'stok' => 10,
        'satuan' => 'Tablet',
        'harga' => 'not numeric',
        'deskripsi' => '',
    ]);

    $response->assertSessionHasErrors(['harga']);
}

/** @test */
public function it_can_load_create_page()
{
    $response = $this->get('/obat/create');
    $response->assertStatus(200);
    $response->assertSee('Tambah Obat');
}

/** @test */
public function it_can_load_edit_page()
{
    $obat = Obat::factory()->create();

    $response = $this->get("/obat/{$obat->id}/edit");

    $response->assertStatus(200);
    $response->assertSee($obat->nama_obat);
}

}
