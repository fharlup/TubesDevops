<?php

namespace Tests\Feature;

use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TagihanTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_view_invoice_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Tagihan::factory()->create(['no_tagihan' => 'INV-001']);

        $response = $this->get(route('tagihan.index'));

        $response->assertStatus(200);
        $response->assertSee('Data Tagihan Pasien');
        $response->assertSee('INV-001');
    }

    #[Test]
    public function user_can_create_new_invoice()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'no_tagihan' => '001',
            'name' => 'Budi Santoso',
            'total_tagihan' => '150000',
            'tanggal_tagihan' => now()->format('Y-m-d'),
        ];

        $response = $this->post(route('tagihan.store'), $data);

        $response->assertRedirect(route('tagihan.index'));
        $this->assertDatabaseHas('tagihan', [
            'no_tagihan' => 'INV-001',
            'name' => 'Budi Santoso',
            'total_tagihan' => 150000,
        ]);
    }

    #[Test]
    public function user_can_edit_invoice()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tagihan = Tagihan::factory()->create([
            'no_tagihan' => 'INV-002',
            'status' => 'belum_bayar',
            'total_tagihan' => 120000
        ]);

        $response = $this->put(route('tagihan.update', $tagihan->id), [
            'total_tagihan' => 200000,
            'status' => 'lunas',
            'tanggal_bayar' => now()->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('tagihan.index'));
        $this->assertDatabaseHas('tagihan', [
            'id' => $tagihan->id,
            'status' => 'lunas',
            'total_tagihan' => 200000
        ]);
    }

    #[Test]
    public function user_can_delete_invoice()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tagihan = Tagihan::factory()->create();

        $response = $this->delete(route('tagihan.destroy', $tagihan->id));

        $response->assertRedirect(route('tagihan.index'));
        $this->assertDatabaseMissing('tagihan', ['id' => $tagihan->id]);
    }

    #[Test]
    public function validation_fails_if_required_fields_are_empty()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('tagihan.store'), [
            'no_tagihan' => '',
            'name' => '',
            'total_tagihan' => '',
            'tanggal_tagihan' => '',
        ]);

        $response->assertSessionHasErrors([
            'no_tagihan',
            'name',
            'total_tagihan',
            'tanggal_tagihan'
        ]);
    }
}
