<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;
    
    protected $table = 'tagihan';

    protected $fillable = [
        'pasien_id',
        'no_tagihan',
        'name',
        'total_tagihan',
        'status',
        'tanggal_tagihan',
        'tanggal_bayar',
    ];

    protected $casts = [
        'tanggal_tagihan' => 'date',
        'tanggal_bayar' => 'date',
        'total_tagihan' => 'decimal:2',
    ];

    // default attributes
    protected $attributes = [
        'status' => 'belum_bayar',
    ];
}
