<?php

namespace App\Http\Controllers;

use App\Exports\LaporanAbsensiExport;
use App\Models\User;
use App\Models\Absensi;
use App\Models\IzinCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKaryawan = User::where('role', 'karyawan')->count();
        $hadirHariIni = Absensi::whereDate('tanggal', Carbon::today())
            ->whereNotNull('check_in')
            ->count();
        $karyawanHadirHariIni = Absensi::whereDate('tanggal', Carbon::today())
            ->whereNotNull('check_in')
            ->pluck('user_id');
        $tidakHadir = User::where('role', 'karyawan')
            ->whereNotIn('id', $karyawanHadirHariIni)
            ->count();
        $absensiHariIni = Absensi::with('user')
            ->whereDate('tanggal', Carbon::today())
            ->get();
        $statistikMingguan = Absensi::select(
            DB::raw('DATE(tanggal) as tanggal'),
            DB::raw('COUNT(*) as total_hadir')
        )
            ->whereDate('tanggal', '>=', Carbon::now()->subDays(7))
            ->whereDate('tanggal', '<=', Carbon::now())
            ->whereNotNull('check_in')
            ->groupBy('tanggal')
            ->get();

        return view('dashboard', compact(
            'totalKaryawan',
            'hadirHariIni',
            'tidakHadir',
            'absensiHariIni',
            'statistikMingguan'
        ));
    }

    public function laporan(Request $request)
    {
        $karyawan = User::where('role', 'karyawan')->get();
        $tanggalMulai = $request->tanggal_mulai ?? Carbon::now()->startOfMonth();
        $tanggalSelesai = $request->tanggal_selesai ?? Carbon::now()->endOfMonth();
        $karyawanId = $request->karyawan_id;

        $query = Absensi::with(['user'])
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);

        if ($karyawanId) {
            $query->where('user_id', $karyawanId);
        }

        $absensi = $query->get();

        // Query untuk izin/cuti
        $izinQuery = IzinCuti::with(['user'])
            ->whereBetween('tanggal_mulai', [$tanggalMulai, $tanggalSelesai]);

        if ($karyawanId) {
            $izinQuery->where('user_id', $karyawanId);
        }

        $izinCuti = $izinQuery->get();

        // Menghitung statistik
        $statistik = [
            'total_hadir' => $absensi->count(),
            'total_tepat_waktu' => $absensi->where('check_in', '<=', '08:00:00')->count(),
            'total_terlambat' => $absensi->where('check_in', '>', '08:00:00')->count(),
            'total_izin' => $izinCuti->where('status', 'disetujui')->count(),
        ];

        if ($request->has('export')) {
            return Excel::download(
                new LaporanAbsensiExport($absensi, $izinCuti, $statistik),
                'laporan-absensi.xlsx'
            );
        }

        return view('laporan', compact(
            'karyawan',
            'absensi',
            'izinCuti',
            'statistik',
            'tanggalMulai',
            'tanggalSelesai',
            'karyawanId'
        ));
    }
}
