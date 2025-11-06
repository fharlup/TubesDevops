<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_guest_cannot_access_announcements(): void
    {
        $response = $this->get('/announcements');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_announcements(): void
    {
        $user = User::factory()->create(['role' => 'patient']);
        
        $response = $this->actingAs($user)->get('/announcements');
        
        $response->assertStatus(200);
        $response->assertViewIs('announcements.index');
    }

    public function test_admin_can_see_all_announcements(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        Announcement::create([
            'title' => 'Active Announcement',
            'content' => 'This is active',
            'type' => 'info',
            'status' => 'active',
            'start_date' => now(),
            'created_by' => $admin->id
        ]);
        
        Announcement::create([
            'title' => 'Inactive Announcement',
            'content' => 'This is inactive',
            'type' => 'info',
            'status' => 'inactive',
            'start_date' => now(),
            'created_by' => $admin->id
        ]);
        
        $response = $this->actingAs($admin)->get('/announcements');
        
        $response->assertSee('Active Announcement');
        $response->assertSee('Inactive Announcement');
    }

    public function test_admin_can_create_announcement(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->post('/announcements', [
            'title' => 'New Announcement',
            'content' => 'This is a new announcement',
            'type' => 'info',
            'status' => 'active',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(7)->format('Y-m-d')
        ]);
        
        $response->assertRedirect('/announcements');
        $this->assertDatabaseHas('announcements', [
            'title' => 'New Announcement',
            'content' => 'This is a new announcement'
        ]);
    }

    public function test_patient_cannot_create_announcement(): void
    {
        $patient = User::factory()->create(['role' => 'patient']);
        
        $response = $this->actingAs($patient)->post('/announcements', [
            'title' => 'New Announcement',
            'content' => 'This is a new announcement',
            'type' => 'info',
            'status' => 'active',
            'start_date' => now()->format('Y-m-d')
        ]);
        
        $response->assertRedirect('/announcements');
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('announcements', [
            'title' => 'New Announcement'
        ]);
    }

    public function test_admin_can_update_announcement(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $announcement = Announcement::create([
            'title' => 'Old Title',
            'content' => 'Old content',
            'type' => 'info',
            'status' => 'active',
            'start_date' => now(),
            'created_by' => $admin->id
        ]);
        
        $response = $this->actingAs($admin)->put("/announcements/{$announcement->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content',
            'type' => 'warning',
            'status' => 'active',
            'start_date' => now()->format('Y-m-d')
        ]);
        
        $response->assertRedirect('/announcements');
        $this->assertDatabaseHas('announcements', [
            'id' => $announcement->id,
            'title' => 'Updated Title',
            'content' => 'Updated content'
        ]);
    }

    public function test_admin_can_delete_announcement(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $announcement = Announcement::create([
            'title' => 'To Be Deleted',
            'content' => 'This will be deleted',
            'type' => 'info',
            'status' => 'active',
            'start_date' => now(),
            'created_by' => $admin->id
        ]);
        
        $response = $this->actingAs($admin)->delete("/announcements/{$announcement->id}");
        
        $response->assertRedirect('/announcements');
        $this->assertDatabaseMissing('announcements', [
            'id' => $announcement->id
        ]);
    }

    public function test_patient_cannot_delete_announcement(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $patient = User::factory()->create(['role' => 'patient']);
        
        $announcement = Announcement::create([
            'title' => 'Protected Announcement',
            'content' => 'Should not be deleted',
            'type' => 'info',
            'status' => 'active',
            'start_date' => now(),
            'created_by' => $admin->id
        ]);
        
        $response = $this->actingAs($patient)->delete("/announcements/{$announcement->id}");
        
        $response->assertRedirect('/announcements');
        $this->assertDatabaseHas('announcements', [
            'id' => $announcement->id
        ]);
    }
}