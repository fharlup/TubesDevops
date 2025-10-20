<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Menambahkan aturan validasi untuk field baru
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nik' => ['required', 'string', 'digits:16', 'unique:users'],
            'gender' => ['required', 'string', 'in:Laki-laki,Perempuan'],
            'tanggal_lahir' => ['required', 'date'],
            'password' => $this->passwordRules(),
        ])->validate();

        // Menambahkan field baru saat membuat user
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'nik' => $input['nik'],
            'gender' => $input['gender'],
            'tanggal_lahir' => $input['tanggal_lahir'],
        ]);
    }
}