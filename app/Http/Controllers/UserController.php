<?php

namespace App\Http\Controllers;

// Import Model, Request, dan helper yang kita butuhkan
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Tampilkan daftar semua user.
     * (Fungsi untuk READ - bagian dari R)
     */
    public function index(): View
    {
        // Ambil semua data user dari database
        $users = User::all();

        // Kirim data users ke view 'users.index'
        return view('users.index', compact('users'));
    }

    /**
     * Tampilkan formulir untuk membuat user baru.
     * (Fungsi untuk CREATE - bagian dari C)
     */
    public function create(): View
    {
        // Langsung tampilkan view 'users.create'
        return view('users.create');
    }

    /**
     * Simpan user baru ke database.
     * (Fungsi untuk CREATE - bagian dari C)
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // 'unique:users' pastikan email belum terdaftar
            'password' => 'required|string|min:8', // Minimal 8 karakter
        ]);

        // 2. Buat user baru di database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password WAJIB di-hash!
        ]);

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan data satu user (kita lewati ini, tidak umum dipakai di CRUD tabel).
     */
    public function show(string $id)
    {
        // Biasanya tidak dipakai untuk CRUD admin, kita fokus di edit
        return redirect()->route('users.edit', $id);
    }

    /**
     * Tampilkan formulir untuk meng-edit user.
     * (Fungsi untuk UPDATE - bagian dari U)
     */
    public function edit(string $id): View
    {
        // 1. Cari user berdasarkan ID
        $user = User::findOrFail($id); // findOrFail akan error jika ID tidak ditemukan

        // 2. Kirim data user tadi ke view 'users.edit'
        return view('users.edit', compact('user'));
    }

    /**
     * Update data user di database.
     * (Fungsi untuk UPDATE - bagian dari U)
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // 1. Cari user yang mau di-update
        $user = User::findOrFail($id);

        // 2. Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // Email boleh sama dengan email dia sendiri
        ]);

        // 3. Siapkan data yang mau di-update
        $dataToUpdate = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // 4. Cek apakah user mengisi password baru
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']); // Validasi password jika diisi
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        // 5. Update data di database
        $user->update($dataToUpdate);

        // 6. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Hapus user dari database.
     * (Fungsi untuk DELETE - bagian dari D)
     */
    public function destroy(string $id): RedirectResponse
    {
        // 1. Cari user
        $user = User::findOrFail($id);

        // 2. Hapus user
        $user->delete();

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
