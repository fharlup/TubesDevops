<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Doctor_schedule;

class DoctorScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_authenticated_user_can_create_a_doctor_schedule(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $doctor = Doctor::factory()->create();

        $scheduleData = [
            'doctor_id' => $doctor->id,
            'hari' => 1,
            'jam_mulai' => '09:00',
            'jam_selesai' => '17:00',
        ];

        $response = $this->actingAs($user)
            ->post(route('doctor.schedule.store'), $scheduleData);

        $response->assertRedirect(route('schedule'));
        $response->assertSessionHas('success', 'Jadwal ketersediaan dokter berhasil disimpan!');
        $this->assertDatabaseHas('doctor_schedules', [
            'doctor_id' => $doctor->id,
            'hari' => 1,
            'jam_mulai' => '09:00',
            'jam_selesai' => '17:00',
        ]);
    }

    public function test_store_schedule_fails_if_end_time_is_before_start_time(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $doctor = Doctor::factory()->create();

        $invalidData = [
            'doctor_id' => $doctor->id,
            'hari' => 2,
            'jam_mulai' => '17:00',
            'jam_selesai' => '09:00',
        ];

        $response = $this->actingAs($user)
            ->post(route('doctor.schedule.store'), $invalidData);

        $response->assertRedirect(route('schedule'));
        $response->assertSessionHasErrors('jam_selesai');
        $this->assertDatabaseCount('doctor_schedules', 0);
    }

    public function test_store_schedule_fails_if_schedule_already_exists_for_that_day(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $doctor = Doctor::factory()->create();

        Doctor_schedule::create([
            'doctor_id' => $doctor->id,
            'hari' => 3,
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
        ]);

        $duplicateData = [
            'doctor_id' => $doctor->id,
            'hari' => 3,
            'jam_mulai' => '13:00',
            'jam_selesai' => '17:00',
        ];

        $response = $this->actingAs($user)
            ->post(route('doctor.schedule.store'), $duplicateData);

        $response->assertRedirect(route('schedule'));
        $response->assertSessionHasErrors(['hari' => 'Dokter ini sudah memiliki jadwal di hari tersebut!']);
        $this->assertDatabaseCount('doctor_schedules', 1);
    }

    public function test_a_guest_cannot_create_a_doctor_schedule(): void
    {
        $doctor = Doctor::factory()->create();
        $scheduleData = [
            'doctor_id' => $doctor->id,
            'hari' => 1,
            'jam_mulai' => '09:00',
            'jam_selesai' => '17:00',
        ];

        $response = $this->post(route('doctor.schedule.store'), $scheduleData);

        $response->assertRedirect('/login');
        $this->assertDatabaseCount('doctor_schedules', 0);
    }

}
