<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_gender_p(): void
    {
        $userData = [
            'name' => 'Fajar Mufid',
            'email' => 'fajar@contoh.com',
            'nik' => '1234567890123456',
            'tanggal_lahir' => '2000-01-01',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'gender' => 'P', 
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticated();
        $response->assertRedirect('/home');
        $this->assertDatabaseHas('users', [
            'email' => 'fajar@contoh.com',
            'gender' => 'P', 
        ]);
    }

    public function test_user_can_register_with_gender_l(): void
    {
        $userData = [
            'name' => 'Budi Santoso',
            'email' => 'budi@contoh.com',
            'nik' => '9876543210987654',
            'gender' => 'L',
            'tanggal_lahir' => '1999-05-10',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'budi@contoh.com',
            'gender' => 'L', 
        ]);
    }


    public function test_registration_fails_if_nik_is_missing(): void
    {
        $userData = [
            'name' => 'Fajar Mufid',
            'email' => 'fajar@contoh.com',
            'tanggal_lahir' => '2000-01-01',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertSessionHasErrors('nik');
        
                $this->assertGuest();
    }
}