<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'jam_masuk',
        'jam_keluar'
    ];

    protected $casts = [
        'jam_masuk' => 'datetime',
        'jam_keluar' => 'datetime'
    ];

    public function karyawanShifts(): HasMany
    {
        return $this->hasMany(KaryawanShift::class);
    }
}
