<?php

namespace App\Http\Controllers;

// Import Model, Request, dan helper yang kita butuhkan
use App\Models\Employee; // Ganti dari User ke Employee
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
        // Ambil semua data pegawai dari database
        $employees = Employee::latest()->paginate(10); // Ambil data terbaru, 10 per halaman

        // Kirim data employees ke view 'employees.index'
        return view('employees.index', compact('employees'));
    }

    /**
     * Tampilkan formulir untuk membuat pegawai baru.
     */
    public function create(): View
    {
        // Langsung tampilkan view 'employees.create'
        return view('employees.create');
    }

    /**
     * Simpan pegawai baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:employees', // pastikan email unik di tabel employees
            'nomor_telepon' => 'required|string|max:15',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:aktif,nonaktif', // pastikan nilainya hanya 'aktif' atau 'nonaktif'
        ]);

        // 2. Buat pegawai baru di database
        // Ini bisa berjalan karena kita sudah mengatur $fillable di Model
        Employee::create($request->all());

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('employees.index')->with('success', 'Pegawai baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan data satu pegawai (kita lewati ini, tidak umum dipakai).
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
        // 1. Cari pegawai berdasarkan ID
        $employee = Employee::findOrFail($id);

        // 2. Kirim data pegawai tadi ke view 'employees.edit'
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update data pegawai di database.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // 1. Cari pegawai yang mau di-update
        $employee = Employee::findOrFail($id);

        // 2. Validasi data
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:employees,email,' . $employee->id, // Email boleh sama dengan email dia sendiri
            'nomor_telepon' => 'required|string|max:15',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // 3. Update data di database
        $employee->update($request->all());

        // 4. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('employees.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Hapus pegawai dari database.
     */
    public function destroy(string $id): RedirectResponse
    {
        // 1. Cari pegawai
        $employee = Employee::findOrFail($id);

        // 2. Hapus pegawai
        $employee->delete();

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
