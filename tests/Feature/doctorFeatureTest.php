<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Doctor;
use App\Models\Doctor_schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Carbon\Carbon;

class DoctorFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_shows_doctor_schedule_for_today()
    {
        $doctor = Doctor::factory()->create(['nama' => 'Miya']);
        Doctor_schedule::factory()->create([
            'doctor_id' => $doctor->id,
            'hari' => Carbon::now()->dayOfWeek,
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00'
        ]);

        $this->actingAs(\App\Models\User::factory()->create());

        $response = $this->get(route('schedule'));

        $response->assertStatus(200);
        $response->assertViewIs('schedule');
        $response->assertViewHas('dokterList');
        $this->assertStringContainsString('Miya', $response->content());
    }

    /** @test */
    public function it_can_store_new_doctor_schedule()
    {
        $doctor = Doctor::factory()->create();

        $this->actingAs(\App\Models\User::factory()->create());

        $data = [
            'doctor_id' => $doctor->id,
            'hari' => 1,
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
        ];

        $response = $this->post(route('schedule.store'), $data);

        $response->assertRedirect(route('schedule'));
        $this->assertDatabaseHas('doctor_schedules', $data);
    }

    /** @test */
    public function it_fails_when_schedule_duplicate_in_same_day()
    {
        $doctor = Doctor::factory()->create();

        Doctor_schedule::factory()->create([
            'doctor_id' => $doctor->id,
            'hari' => 2,
        ]);

        $this->actingAs(\App\Models\User::factory()->create());

        $data = [
            'doctor_id' => $doctor->id,
            'hari' => 2,
            'jam_mulai' => '09:00',
            'jam_selesai' => '11:00',
        ];

        $response = $this->post(route('schedule.store'), $data);

        $response->assertSessionHasErrors(['hari']);
    }
}
