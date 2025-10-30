<?php

namespace App\Http\Controllers;

use App\Models\Attendence;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AttendenceController extends Controller
{
    public function index(): View
    {
        $attendences = Attendence::with('employee')->latest()->paginate(10);
        return view('attendences.index', compact('attendences'));
    }
    public function create(): View
    {
        $employees = Employee::orderBy('nama_lengkap')->get();

        return view('attendences.create', compact('employees'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i|after_or_equal:waktu_masuk',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        Attendence::create($request->all());

        return redirect()->route('attendences.index')->with('success', 'Data absensi baru berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        return redirect()->route('attendences.edit', $id);
    }


    public function edit(string $id): View
    {
        $attendance = Attendence::findOrFail($id);

        $employees = Employee::orderBy('nama_lengkap')->get();

        return view('attendences.edit', compact('attendance', 'employees'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {

        $attendance = Attendence::findOrFail($id);


        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i|after_or_equal:waktu_masuk',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
        ]);


        $attendance->update($request->all());


        return redirect()->route('attendences.index')->with('success', 'Data absensi berhasil diperbarui.');
    }


    public function destroy(string $id): RedirectResponse
    {

        $attendance = Attendence::findOrFail($id);

        $attendance->delete();

        return redirect()->route('attendences.index')->with('success', 'Data absensi berhasil dihapus.');
    }
}
