<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'spesialisasi',
        'foto_url',
    ];

    /**
     * Relasi: Satu dokter bisa punya banyak jadwal
     */
    public function schedules()
    {
        // Nama model relasinya adalah DoctorSchedule
        return $this->hasMany(Doctor_schedule::class);
    }
}
