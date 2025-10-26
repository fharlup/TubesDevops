<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'type',
        'status',
        'start_date',
        'end_date',
        'created_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Relationship dengan User (yang membuat pengumuman)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope untuk mendapatkan pengumuman yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('start_date', '<=', Carbon::today())
                    ->where(function($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', Carbon::today());
                    });
    }

    /**
     * Cek apakah pengumuman masih berlaku
     */
    public function isValid()
    {
        $today = Carbon::today();
        
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->start_date > $today) {
            return false;
        }

        if ($this->end_date && $this->end_date < $today) {
            return false;
        }

        return true;
    }

    /**
     * Get badge color based on type
     */
    public function getBadgeColorAttribute()
    {
        return [
            'info' => 'primary',
            'warning' => 'warning',
            'urgent' => 'danger',
            'general' => 'secondary'
        ][$this->type] ?? 'secondary';
    }

    /**
     * Get type label
     */
    public function getTypeLabelAttribute()
    {
        return [
            'info' => 'Informasi',
            'warning' => 'Peringatan',
            'urgent' => 'Mendesak',
            'general' => 'Umum'
        ][$this->type] ?? 'Umum';
    }
}