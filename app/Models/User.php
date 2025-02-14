<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function karyawanShifts(): HasMany
    {
        return $this->hasMany(KaryawanShift::class);
    }

    public function currentShift()
    {
        return $this->karyawanShifts()
            ->where('tanggal_mulai', '<=', now())
            ->where(function ($query) {
                $query->where('tanggal_selesai', '>=', now())
                    ->orWhereNull('tanggal_selesai');
            })
            ->with('shift')
            ->first();
    }
    public function getShiftForDate($date)
    {
        return $this->karyawanShifts()
            ->where('tanggal_mulai', '<=', $date)
            ->where(function ($query) use ($date) {
                $query->where('tanggal_selesai', '>=', $date)
                    ->orWhereNull('tanggal_selesai');
            })
            ->with('shift')
            ->first();
    }

    public function isOnLeaveToday()
    {
        $today = now()->format('Y-m-d');

        return $this->izinCuti()
            ->where('status', 'disetujui')
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->exists();
    }

    public function izinCuti()
    {
        return $this->hasMany(IzinCuti::class);
    }
}
