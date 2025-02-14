<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class LaporanAbsensiExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected $absensi;
    protected $izinCuti;
    protected $statistik;

    public function __construct($absensi, $izinCuti, $statistik)
    {
        $this->absensi = $absensi;
        $this->izinCuti = $izinCuti;
        $this->statistik = $statistik;
    }

    public function collection()
    {
        return $this->absensi;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Karyawan',
            'Jam Masuk',
            'Jam Keluar',
            'Status',
            'Keterangan'
        ];
    }

    public function map($absensi): array
    {
        return [
            Carbon::parse($absensi->tanggal)->format('d/m/Y'),
            $absensi->user->name,
            $absensi->check_in,
            $absensi->check_out ?? '-',
            $this->getStatus($absensi),
            $this->getKeterangan($absensi)
        ];
    }

    private function getStatus($absensi)
    {
        if (!$absensi->check_in) return 'Tidak Hadir';
        if (Carbon::parse($absensi->check_in)->format('H:i:s') > '08:00:00') return 'Terlambat';
        return 'Tepat Waktu';
    }

    private function getKeterangan($absensi)
    {
        if ($absensi->check_in && Carbon::parse($absensi->check_in)->format('H:i:s') > '08:00:00') {
            $terlambat = Carbon::parse($absensi->check_in)->diffInMinutes(Carbon::parse('08:00:00'));
            return "Terlambat {$terlambat} menit";
        }
        return '-';
    }

    public function title(): string
    {
        return 'Laporan Absensi';
    }
}
