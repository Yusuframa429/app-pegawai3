<?php

namespace App\Http\Controllers;

// Import Model yang kita butuhkan
use App\Models\Employee;
use App\Models\Department; // <-- Tambahkan ini
use App\Models\Position;   // <-- Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EmployeeController extends Controller
{
    /**
     * Tampilkan daftar semua pegawai.
     */
    public function index(): View
    {
        // Ambil data pegawai, TAPI JUGA ambil data relasinya
        // 'with' (Eager Loading) mencegah N+1 query problem
        $employees = Employee::with(['department', 'position'])->latest()->paginate(10);

        return view('employees.index', compact('employees'));
    }

    /**
     * Tampilkan formulir untuk membuat pegawai baru.
     */
    public function create(): View
    {
        // Ambil semua departemen & jabatan
        $departments = Department::all();
        $positions = Position::all();

        // Kirim ke view
        return view('employees.create', compact('departments', 'positions'));
    }

    /**
     * Simpan pegawai baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi data
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:employees',
            'nomor_telepon' => 'required|string|max:15',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
            // Validasi jembatan (kita buat nullable karena di migrasi juga nullable)
            'department_id' => 'nullable|exists:departments,id',
            'jabatan_id' => 'nullable|exists:positions,id',
        ]);

        // 2. Buat pegawai baru
        Employee::create($request->all());

        // 3. Arahkan kembali
        return redirect()->route('employees.index')->with('success', 'Pegawai baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan data satu pegawai (kita lewati).
     */
    public function show(string $id)
    {
        return redirect()->route('employees.edit', $id);
    }

    /**
     * Tampilkan formulir untuk meng-edit pegawai.
     */
    public function edit(string $id): View
    {
        // 1. Cari pegawai
        $employee = Employee::findOrFail($id);

        // 2. Ambil semua departemen & jabatan (untuk dropdown)
        $departments = Department::all();
        $positions = Position::all();

        // 3. Kirim ke view
        return view('employees.edit', compact('employee', 'departments', 'positions'));
    }

    /**
     * Update data pegawai di database.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // 1. Cari pegawai
        $employee = Employee::findOrFail($id);

        // 2. Validasi data
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:employees,email,' . $employee->id,
            'nomor_telepon' => 'required|string|max:15',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
            // Validasi jembatan
            'department_id' => 'nullable|exists:departments,id',
            'jabatan_id' => 'nullable|exists:positions,id',
        ]);

        // 3. Update data
        $employee->update($request->all());

        // 4. Arahkan kembali
        return redirect()->route('employees.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Hapus pegawai dari database.
     */
    public function destroy(string $id): RedirectResponse
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
