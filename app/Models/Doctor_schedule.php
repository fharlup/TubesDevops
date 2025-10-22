<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor_schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    /**
     * Relasi: Satu jadwal pasti dimiliki oleh satu dokter
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
