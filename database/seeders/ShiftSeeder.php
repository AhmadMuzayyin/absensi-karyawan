<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shifts = [
            [
                'nama' => 'Pagi',
                'jam_masuk' => '08:00',
                'jam_keluar' => '16:00',
            ],
            [
                'nama' => 'Siang',
                'jam_masuk' => '16:00',
                'jam_keluar' => '00:00',
            ],
            [
                'nama' => 'Malam',
                'jam_masuk' => '00:00',
                'jam_keluar' => '08:00',
            ],
        ];

        foreach ($shifts as $shift) {
            Shift::create($shift);
        }
    }
}
