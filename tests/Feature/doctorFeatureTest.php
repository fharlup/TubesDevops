<?php

namespace Tests\Feature;

use App\Models\Doctor_schedule;
use App\Models\DoctorSchedule;
use Tests\TestCase;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class DoctorFeatureTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shows_doctor_schedule_for_today()
    {
        $doctor = Doctor::factory()->create(['nama' => 'Miya']);
        $schedule = Doctor_schedule::factory()->create([
            'doctor_id' => $doctor->id,
            'hari' => Carbon::now()->dayOfWeek,
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
        ]);

        $this->actingAs(User::factory()->create());

        $response = $this->get(route('schedule'));

        $response->assertStatus(200);
        $response->assertViewIs('schedule');
        $response->assertViewHas('dokterList');
        $this->assertStringContainsString('Miya', $response->getContent());
    }

    #[Test]
    public function it_fails_when_schedule_duplicate_in_same_day()
    {
        $doctor = Doctor::factory()->create();

        Doctor_schedule::factory()->create([
            'doctor_id' => $doctor->id,
            'hari' => 2,
        ]);

        $this->actingAs(User::factory()->create());

        $data = [
            'doctor_id' => $doctor->id,
            'hari' => 2,
            'jam_mulai' => '09:00',
            'jam_selesai' => '11:00',
        ];

        $response = $this->post(route('doctor.schedule.store'), $data);

        $response->assertSessionHasErrors(['hari']);
    }
}
