<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $isOnLeave = $user->isOnLeaveToday();
        $todayAbsensi = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();
        $activeShift = $user->currentShift();
        $riwayatAbsensi = Absensi::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('absensi.index', compact(
            'todayAbsensi',
            'activeShift',
            'riwayatAbsensi',
            'isOnLeave'
        ));
    }

    public function checkIn(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        if ($user->isOnLeaveToday()) {
            return back()->with('error', 'Anda sedang dalam masa izin/cuti');
        }
        $now = Carbon::now();

        // Cek shift aktif karyawan
        $karyawanShift = $user->currentShift();

        if (!$karyawanShift) {
            return back()->with('error', 'Anda belum memiliki shift yang ditentukan');
        }

        // Cek apakah sudah absen hari ini
        $existingAbsensi = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $now->toDateString())
            ->first();

        if ($existingAbsensi) {
            return back()->with('error', 'Anda sudah melakukan absensi hari ini');
        }

        // Cek apakah check-in dalam rentang waktu yang diizinkan
        $jamMasukShift = Carbon::parse($karyawanShift->shift->jam_masuk);
        $batasAwal = $jamMasukShift->copy()->subHours(2); // Izinkan check-in 2 jam sebelum jadwal
        $batasAkhir = $jamMasukShift->copy()->addHours(4); // Izinkan check-in sampai 4 jam setelah jadwal
        if ($now < $batasAwal) {
            return back()->with('error', 'Terlalu dini untuk melakukan check-in. Waktu check-in dibuka 2 jam sebelum jadwal.');
        }

        if ($now > $batasAkhir) {
            return back()->with('error', 'Sudah melewati batas waktu check-in.');
        }

        // Buat absensi baru
        Absensi::create([
            'user_id' => $user->id,
            'tanggal' => $now->toDateString(),
            'check_in' => $now->toTimeString(),
        ]);

        $status = $now->gt($jamMasukShift) ? 'terlambat' : 'tepat waktu';
        $message = $status === 'terlambat'
            ? 'Check-in berhasil, tetapi Anda terlambat ' . $now->diffInMinutes($jamMasukShift) . ' menit'
            : 'Check-in berhasil!';

        return back()->with('success', $message);
    }

    public function checkOut()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        if ($user->isOnLeaveToday()) {
            return back()->with('error', 'Anda sedang dalam masa izin/cuti');
        }
        $now = Carbon::now();
        $today = Carbon::today();

        // Cek shift aktif
        $karyawanShift = $user->currentShift();
        if (!$karyawanShift) {
            return back()->with('error', 'Anda tidak memiliki shift aktif');
        }

        // Cek apakah sudah check-in
        $absensi = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$absensi || !$absensi->check_in) {
            return back()->with('error', 'Anda belum check-in hari ini');
        }

        if ($absensi->check_out) {
            return back()->with('error', 'Anda sudah check-out hari ini');
        }

        // Cek apakah sudah waktunya check-out
        $jamKeluarShift = Carbon::parse($karyawanShift->shift->jam_keluar);
        $batasAwalCheckout = $jamKeluarShift->copy()->subHours(2); // Izinkan checkout 2 jam sebelum jadwal

        if ($now->lt($batasAwalCheckout)) {
            return back()->with('error', 'Belum waktunya check-out');
        }

        // Simpan data check-out
        $absensi->update(['check_out' => $now->toTimeString()]);

        return back()->with('success', 'Check-out berhasil!');
    }
}
