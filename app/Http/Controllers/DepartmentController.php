<?php

namespace App\Http\Controllers;

// Import Model, Request, dan helper yang kita butuhkan
use App\Models\Department; // Ganti ke Department
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DepartmentController extends Controller
{
    /**
     * Tampilkan daftar semua departemen.
     */
    public function index(): View
    {
        // Ambil semua data departemen dari database
        $departments = Department::latest()->paginate(10); // Ambil data terbaru

        // Kirim data departments ke view 'departments.index'
        return view('departments.index', compact('departments'));
    }

    /**
     * Tampilkan formulir untuk membuat departemen baru.
     */
    public function create(): View
    {
        // Langsung tampilkan view 'departments.create'
        return view('departments.create');
    }

    /**
     * Simpan departemen baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi data yang masuk (hanya satu kolom)
        $request->validate([
            'nama_departemen' => 'required|string|max:100|unique:departments', // pastikan unik
        ]);

        // 2. Buat departemen baru di database
        Department::create($request->all());

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('departments.index')->with('success', 'Departemen baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan data satu departemen (kita lewati).
     */
    public function show(string $id)
    {
        return redirect()->route('departments.edit', $id);
    }

    /**
     * Tampilkan formulir untuk meng-edit departemen.
     */
    public function edit(string $id): View
    {
        // 1. Cari departemen berdasarkan ID
        $department = Department::findOrFail($id);

        // 2. Kirim data departemen tadi ke view 'departments.edit'
        return view('departments.edit', compact('department'));
    }

    /**
     * Update data departemen di database.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // 1. Cari departemen yang mau di-update
        $department = Department::findOrFail($id);

        // 2. Validasi data
        $request->validate([
            'nama_departemen' => 'required|string|max:100|unique:departments,nama_departemen,' . $department->id,
        ]);

        // 3. Update data di database
        $department->update($request->all());

        // 4. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('departments.index')->with('success', 'Data departemen berhasil diperbarui.');
    }

    /**
     * Hapus departemen dari database.
     */
    public function destroy(string $id): RedirectResponse
    {
        // 1. Cari departemen
        $department = Department::findOrFail($id);

        // 2. Hapus departemen
        $department->delete();

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('departments.index')->with('success', 'Departemen berhasil dihapus.');
    }
}
