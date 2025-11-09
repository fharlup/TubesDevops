<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class MedicalRecordTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_medical_record()
    {
        $user = User::factory()->create();
        $doctor = Doctor::factory()->create();

        $record = MedicalRecord::create([
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
            'tanggal_kunjungan' => now()->format('Y-m-d'),
            'keluhan' => 'Demam tinggi',
            'diagnosis' => 'Tifus',
            'tindakan' => 'Rawat inap',
            'resep_obat' => 'Paracetamol',
        ]);

        $this->assertDatabaseHas('medical_records', [
            'user_id' => $user->id,
            'keluhan' => 'Demam tinggi',
        ]);
    }

    #[Test]
    public function it_belongs_to_a_user()
    {
        $record = MedicalRecord::factory()->create();
        $this->assertInstanceOf(User::class, $record->user);
    }

    #[Test]
    public function it_belongs_to_a_doctor()
    {
        $record = MedicalRecord::factory()->create();
        $this->assertInstanceOf(Doctor::class, $record->doctor);
    }

    #[Test]
    public function it_can_be_updated()
    {
        $record = MedicalRecord::factory()->create([
            'keluhan' => 'Sakit kepala',
        ]);

        $record->update(['keluhan' => 'Sakit perut']);

        $this->assertDatabaseHas('medical_records', [
            'id' => $record->id,
            'keluhan' => 'Sakit perut',
        ]);
    }

    #[Test]
    public function it_can_be_deleted()
    {
        $record = MedicalRecord::factory()->create();
        $recordId = $record->id;

        $record->delete();

        $this->assertDatabaseMissing('medical_records', [
            'id' => $recordId,
        ]);
    }
}
