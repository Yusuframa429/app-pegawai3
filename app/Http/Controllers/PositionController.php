<?php

namespace App\Http\Controllers;

// Import Model, Request, dan helper yang kita butuhkan
use App\Models\Position; // Ganti ke Position
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PositionController extends Controller
{
    /**
     * Tampilkan daftar semua jabatan.
     */
    public function index(): View
    {
        // Ambil semua data jabatan dari database
        $positions = Position::latest()->paginate(10); // Ambil data terbaru

        // Kirim data positions ke view 'positions.index'
        return view('positions.index', compact('positions'));
    }

    /**
     * Tampilkan formulir untuk membuat jabatan baru.
     */
    public function create(): View
    {
        // Langsung tampilkan view 'positions.create'
        return view('positions.create');
    }

    /**
     * Simpan jabatan baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'nama_jabatan' => 'required|string|max:100|unique:positions', // pastikan unik
            'gaji_pokok' => 'required|numeric|min:0', // validasi untuk angka
        ]);

        // 2. Buat jabatan baru di database
        Position::create($request->all());

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('positions.index')->with('success', 'Jabatan baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan data satu jabatan (kita lewati).
     */
    public function show(string $id)
    {
        return redirect()->route('positions.edit', $id);
    }

    /**
     * Tampilkan formulir untuk meng-edit jabatan.
     */
    public function edit(string $id): View
    {
        // 1. Cari jabatan berdasarkan ID
        $position = Position::findOrFail($id);

        // 2. Kirim data jabatan tadi ke view 'positions.edit'
        return view('positions.edit', compact('position'));
    }

    /**
     * Update data jabatan di database.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // 1. Cari jabatan yang mau di-update
        $position = Position::findOrFail($id);

        // 2. Validasi data
        $request->validate([
            'nama_jabatan' => 'required|string|max:100|unique:positions,nama_jabatan,' . $position->id,
            'gaji_pokok' => 'required|numeric|min:0', // validasi untuk angka
        ]);

        // 3. Update data di database
        $position->update($request->all());

        // 4. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('positions.index')->with('success', 'Data jabatan berhasil diperbarui.');
    }

    /**
     * Hapus jabatan dari database.
     */
    public function destroy(string $id): RedirectResponse
    {
        // 1. Cari jabatan
        $position = Position::findOrFail($id);

        // 2. Hapus jabatan
        $position->delete();

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('positions.index')->with('success', 'Jabatan berhasil dihapus.');
    }
}
