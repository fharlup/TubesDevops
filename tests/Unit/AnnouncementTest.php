<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_it_has_correct_fillable_attributes(): void
    {
        $fillable = [
            'title',
            'content',
            'type',
            'status',
            'start_date',
            'end_date',
            'created_by'
        ];
        
        $announcement = new Announcement();
        
        $this->assertEquals($fillable, $announcement->getFillable());
    }

    public function test_it_belongs_to_a_creator(): void
    {
        $user = User::factory()->create();
        $announcement = Announcement::create([
            'title' => 'Test',
            'content' => 'Test content',
            'type' => 'info',
            'status' => 'active',
            'start_date' => now(),
            'created_by' => $user->id
        ]);
        
        $this->assertInstanceOf(User::class, $announcement->creator);
        $this->assertEquals($user->id, $announcement->creator->id);
    }

    public function test_it_returns_correct_badge_color_for_type(): void
    {
        $announcement = new Announcement(['type' => 'info']);
        $this->assertEquals('primary', $announcement->badge_color);
        
        $announcement->type = 'warning';
        $this->assertEquals('warning', $announcement->badge_color);
        
        $announcement->type = 'urgent';
        $this->assertEquals('danger', $announcement->badge_color);
        
        $announcement->type = 'general';
        $this->assertEquals('secondary', $announcement->badge_color);
    }

    public function test_it_returns_correct_type_label(): void
    {
        $announcement = new Announcement(['type' => 'info']);
        $this->assertEquals('Informasi', $announcement->type_label);
        
        $announcement->type = 'warning';
        $this->assertEquals('Peringatan', $announcement->type_label);
        
        $announcement->type = 'urgent';
        $this->assertEquals('Mendesak', $announcement->type_label);
        
        $announcement->type = 'general';
        $this->assertEquals('Umum', $announcement->type_label);
    }

    public function test_active_scope_returns_only_active_announcements(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $activeAnnouncement = Announcement::create([
            'title' => 'Active',
            'content' => 'Content',
            'type' => 'info',
            'status' => 'active',
            'start_date' => now()->subDay(),
            'end_date' => now()->addDay(),
            'created_by' => $admin->id
        ]);
        
        $inactiveAnnouncement = Announcement::create([
            'title' => 'Inactive',
            'content' => 'Content',
            'type' => 'info',
            'status' => 'inactive',
            'start_date' => now(),
            'created_by' => $admin->id
        ]);
        
        $futureAnnouncement = Announcement::create([
            'title' => 'Future',
            'content' => 'Content',
            'type' => 'info',
            'status' => 'active',
            'start_date' => now()->addDay(),
            'created_by' => $admin->id
        ]);
        
        $expiredAnnouncement = Announcement::create([
            'title' => 'Expired',
            'content' => 'Content',
            'type' => 'info',
            'status' => 'active',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDay(),
            'created_by' => $admin->id
        ]);
        
        $active = Announcement::active()->get();
        
        $this->assertCount(1, $active);
        $this->assertEquals('Active', $active->first()->title);
    }

    public function test_is_valid_returns_correct_boolean(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Valid announcement
        $valid = Announcement::create([
            'title' => 'Valid',
            'content' => 'Content',
            'type' => 'info',
            'status' => 'active',
            'start_date' => now()->subDay(),
            'end_date' => now()->addDay(),
            'created_by' => $admin->id
        ]);
        $this->assertTrue($valid->isValid());
        
        // Inactive
        $inactive = Announcement::create([
            'title' => 'Inactive',
            'content' => 'Content',
            'type' => 'info',
            'status' => 'inactive',
            'start_date' => now(),
            'created_by' => $admin->id
        ]);
        $this->assertFalse($inactive->isValid());
        
        // Future
        $future = Announcement::create([
            'title' => 'Future',
            'content' => 'Content',
            'type' => 'info',
            'status' => 'active',
            'start_date' => now()->addDay(),
            'created_by' => $admin->id
        ]);
        $this->assertFalse($future->isValid());
        
        // Expired
        $expired = Announcement::create([
            'title' => 'Expired',
            'content' => 'Content',
            'type' => 'info',
            'status' => 'active',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDay(),
            'created_by' => $admin->id
        ]);
        $this->assertFalse($expired->isValid());
    }

    public function test_dates_are_cast_correctly(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $announcement = Announcement::create([
            'title' => 'Test',
            'content' => 'Content',
            'type' => 'info',
            'status' => 'active',
            'start_date' => '2025-10-27',
            'end_date' => '2025-11-27',
            'created_by' => $admin->id
        ]);
        
        $this->assertInstanceOf(Carbon::class, $announcement->start_date);
        $this->assertInstanceOf(Carbon::class, $announcement->end_date);
    }
}