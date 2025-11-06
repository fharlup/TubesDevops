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
        // 1. Validasi (DIUBAH)
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nik' => ['required', 'string', 'digits:16', 'unique:users'],
            'gender' => ['nullable', 'in:L,P'], // <-- DIUBAH ke L dan P
            'tanggal_lahir' => ['required', 'date'],
            'password' => $this->passwordRules(),
        ])->validate();

        // 2. Pembuatan User (Bagian ini sudah benar)
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'nik' => $input['nik'],
            'gender' => $input['gender'] ?? null,
            'tanggal_lahir' => $input['tanggal_lahir'],
        ]);
    }
}