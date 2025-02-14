<?php

namespace App\Http\Controllers;

use App\Models\IzinCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IzinCutiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Untuk admin, tampilkan semua pengajuan
            $izinCuti = IzinCuti::with('user')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Untuk karyawan, tampilkan pengajuan sendiri
            $izinCuti = IzinCuti::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('izin-cuti.index', compact('izinCuti'));
    }

    public function create()
    {
        return view('izin-cuti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:255',
        ]);

        // Cek apakah sudah ada izin yang overlap
        $existingIzin = IzinCuti::where('user_id', Auth::id())
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai]);
            })
            ->exists();

        if ($existingIzin) {
            return back()->with('error', 'Anda sudah memiliki pengajuan izin/cuti pada rentang tanggal tersebut');
        }

        IzinCuti::create([
            'user_id' => Auth::id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => 'pending'
        ]);

        return redirect()->route('izin-cuti.index')
            ->with('success', 'Pengajuan izin/cuti berhasil diajukan');
    }

    public function updateStatus(Request $request, IzinCuti $izinCuti)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:disetujui,ditolak'
        ]);

        $izinCuti->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status izin/cuti berhasil diperbarui');
    }
}
