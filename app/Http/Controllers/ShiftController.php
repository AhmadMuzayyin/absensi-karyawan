<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\User;
use App\Models\KaryawanShift;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::all();
        $karyawan = User::where('role', 'karyawan')->get();
        $karyawanShifts = KaryawanShift::with(['user', 'shift'])
            ->whereDate('tanggal_mulai', '<=', now())
            ->where(function ($query) {
                $query->whereDate('tanggal_selesai', '>=', now())
                    ->orWhereNull('tanggal_selesai');
            })
            ->get();

        return view('shifts.index', compact('shifts', 'karyawan', 'karyawanShifts'));
    }

    public function create()
    {
        return view('shifts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i|after:jam_masuk'
        ]);

        Shift::create($validated);

        return redirect()->route('shifts.index')
            ->with('success', 'Shift berhasil ditambahkan');
    }

    public function assignShift(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'shift_id' => 'required|exists:shifts,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai'
        ]);

        // Nonaktifkan shift lama jika ada
        KaryawanShift::where('user_id', $validated['user_id'])
            ->whereNull('tanggal_selesai')
            ->update(['tanggal_selesai' => Carbon::parse($validated['tanggal_mulai'])->subDay()]);

        // Buat assignment shift baru
        KaryawanShift::create($validated);

        return redirect()->route('shifts.index')
            ->with('success', 'Shift karyawan berhasil diatur');
    }

    public function edit(Shift $shift)
    {
        return view('shifts.edit', compact('shift'));
    }

    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i|after:jam_masuk'
        ]);

        $shift->update($validated);

        return redirect()->route('shifts.index')
            ->with('success', 'Shift berhasil diperbarui');
    }

    public function destroy(Shift $shift)
    {
        // Cek apakah shift sedang digunakan
        $shiftDipakai = KaryawanShift::where('shift_id', $shift->id)
            ->where(function ($query) {
                $query->where('tanggal_selesai', '>=', now())
                    ->orWhereNull('tanggal_selesai');
            })->exists();

        if ($shiftDipakai) {
            return back()->with('error', 'Shift tidak dapat dihapus karena sedang digunakan');
        }

        $shift->delete();
        return redirect()->route('shifts.index')
            ->with('success', 'Shift berhasil dihapus');
    }

    public function destroyKaryawanShift($id)
    {
        $karyawanShift = KaryawanShift::findOrFail($id);

        // Periksa apakah shift ini masih aktif
        if ($karyawanShift->tanggal_selesai === null || $karyawanShift->tanggal_selesai >= now()) {
            // Update tanggal selesai ke hari sebelumnya
            $karyawanShift->tanggal_selesai = now()->subDay();
            $karyawanShift->save();

            return redirect()->route('shifts.index')
                ->with('success', 'Shift karyawan berhasil diakhiri');
        }

        // Jika shift sudah tidak aktif, hapus langsung
        $karyawanShift->delete();

        return redirect()->route('shifts.index')
            ->with('success', 'Data shift karyawan berhasil dihapus');
    }
}
