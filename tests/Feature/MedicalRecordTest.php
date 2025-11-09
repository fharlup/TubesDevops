<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class MedicalRecordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_view_medical_record_index_page()
    {
        $user = User::factory()->create(['nik' => '1234567890']);
        $this->actingAs($user);

        $response = $this->get('/medical_records');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_create_a_medical_record()
    {
        $user = User::factory()->create(['nik' => '1234567890']);
        $doctor = Doctor::factory()->create();
        $this->actingAs($user);

        $data = [
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'keluhan' => 'Sakit kepala',
            'diagnosis' => 'Migrain',
            'tindakan' => 'Diberi obat',
            'resep_obat' => 'Paracetamol',
        ];

        $response = $this->post('/medical_records', $data);
        $response->assertRedirect('/medical_records');
        $this->assertDatabaseHas('medical_records', ['keluhan' => 'Sakit kepala']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_view_edit_medical_record_page()
    {
        $user = User::factory()->create(['nik' => '1234567890']);
        $doctor = Doctor::factory()->create();

        $medicalRecord = MedicalRecord::factory()->create([
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
        ]);

        $this->actingAs($user);

        $response = $this->get("/medical_records/{$medicalRecord->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('medical_records.edit');
        $response->assertSee($medicalRecord->keluhan);
    }
}
