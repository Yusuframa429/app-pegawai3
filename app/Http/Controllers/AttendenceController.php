<?php

namespace App\Http\Controllers;

// Import Model yang kita butuhkan
use App\Models\Attendence;
use App\Models\Employee; // <-- Kita butuh ini untuk dropdown
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AttendenceController extends Controller
{
    /**
     * Tampilkan daftar semua absensi.
     */
    public function index(): View
    {
        // Ambil data absensi, TAPI JUGA ambil data relasi karyawannya
        $attendences = Attendence::with('employee')->latest()->paginate(10);

        // Kirim data ke view
        return view('attendences.index', compact('attendences'));
    }

    /**
     * Tampilkan formulir untuk membuat absensi baru.
     */
    public function create(): View
    {
        // Ambil semua karyawan untuk ditampilkan di dropdown
        $employees = Employee::orderBy('nama_lengkap')->get();

        return view('attendences.create', compact('employees'));
    }

    /**
     * Simpan absensi baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi data
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i|after_or_equal:waktu_masuk',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        // 2. Buat absensi baru
        Attendence::create($request->all());

        // 3. Arahkan kembali
        return redirect()->route('attendences.index')->with('success', 'Data absensi baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan data satu absensi (kita lewati).
     */
    public function show(string $id)
    {
        return redirect()->route('attendences.edit', $id);
    }

    /**
     * Tampilkan formulir untuk meng-edit absensi.
     */
    public function edit(string $id): View
    {
        // 1. Cari absensi berdasarkan ID
        $attendance = Attendence::findOrFail($id);

        // 2. Ambil semua karyawan untuk dropdown
        $employees = Employee::orderBy('nama_lengkap')->get();

        // 3. Kirim ke view
        return view('attendences.edit', compact('attendance', 'employees'));
    }

    /**
     * Update data absensi di database.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // 1. Cari absensi
        $attendance = Attendence::findOrFail($id);

        // 2. Validasi data
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i|after_or_equal:waktu_masuk',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        // 3. Update data
        $attendance->update($request->all());

        // 4. Arahkan kembali
        return redirect()->route('attendences.index')->with('success', 'Data absensi berhasil diperbarui.');
    }

    /**
     * Hapus absensi dari database.
     */
    public function destroy(string $id): RedirectResponse
    {
        // 1. Cari absensi
        $attendance = Attendence::findOrFail($id);

        // 2. Hapus
        $attendance->delete();

        // 3. Arahkan kembali
        return redirect()->route('attendences.index')->with('success', 'Data absensi berhasil dihapus.');
    }
}
