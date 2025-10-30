<?php

namespace App\Http\Controllers;

// Import Model yang kita butuhkan
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;

// IMPORT YANG BENAR (Ini akan memperbaiki error di screenshot)
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EmployeeController extends Controller
{
    /**
     * Tampilkan daftar semua pegawai (SUDAH DENGAN FITUR SEARCH).
     */
    public function index(Request $request): View // <-- Ini sekarang ada di tempat yang TEPAT
    {
        // 1. Ambil kata kunci dari URL, jika ada
        $keyword = $request->query('search');

        // 2. Mulai query
        $query = Employee::query();

        // 3. Jika ada kata kunci, tambahkan kondisi 'where'
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('nama_lengkap', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 4. Lanjutkan query
        $employees = $query->with(['department', 'position'])
                            ->latest()
                            ->paginate(10)
                            ->withQueryString();

        // 5. Kirim data ke view
        return view('employees.index', compact('employees'));
    }


    /**
     * Tampilkan formulir untuk membuat pegawai baru.
     */
    public function create(): View
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.create', compact('departments', 'positions'));
    }

    /**
     * Simpan pegawai baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:employees',
            'nomor_telepon' => 'required|string|max:15',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
            'department_id' => 'nullable|exists:departments,id',
            'jabatan_id' => 'nullable|exists:positions,id',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')->with('success', 'Pegawai baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan data satu pegawai (kita lewati).
     */
    public function show(string $id)
    {
        // 1. Ambil data pegawai
        // 2. Ambil juga SEMUA data relasinya (department, position, attendences, salaries)
        $employee = Employee::with(['department', 'position', 'attendences', 'salaries'])
                            ->findOrFail($id);

        // 3. Kirim data ke view baru
        return view('employees.show', compact('employee'));
    }

    /**
     * Tampilkan formulir untuk meng-edit pegawai.
     */
    public function edit(string $id): View
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.edit', compact('employee', 'departments', 'positions'));
    }

    /**
     * Update data pegawai di database.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:employees,email,' . $employee->id,
            'nomor_telepon' => 'required|string|max:15',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
            'department_id' => 'nullable|exists:departments,id',
            'jabatan_id' => 'nullable|exists:positions,id',
        ]);

        $employee->update($request->all());

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
