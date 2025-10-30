<?php

namespace App\Http\Controllers;

// Import Model yang kita butuhkan
use App\Models\Salary;
use App\Models\Employee; // Butuh ini untuk dropdown
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log; // Untuk debugging jika ada error

class SalaryController extends Controller
{
    /**
     * Tampilkan daftar semua gaji.
     */
    public function index(): View
    {
        // Ambil data gaji, DAN data relasi employee + position
        $salaries = Salary::with(['employee', 'position'])->latest()->paginate(10);

        return view('salaries.index', compact('salaries'));
    }

    /**
     * Tampilkan formulir untuk membuat gaji baru.
     */
    public function create(): View
    {
        // Ambil semua karyawan, tapi juga relasi 'position' mereka
        // agar kita bisa tampilkan di dropdown
        $employees = Employee::with('position')->orderBy('nama_lengkap')->get();

        return view('salaries.create', compact('employees'));
    }

    /**
     * Simpan gaji baru ke database (DENGAN PERHITUNGAN OTOMATIS).
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi data
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'tanggal_gaji' => 'required|date',
            'tunjangan' => 'required|numeric|min:0',
            'potongan' => 'required|numeric|min:0',
        ]);

        // 2. Ambil data Karyawan DAN jabatannya (position)
        $employee = Employee::with('position')->find($request->employee_id);

        // 3. Cek apakah karyawan punya jabatan & gaji pokok
        if (!$employee->position || is_null($employee->position->gaji_pokok)) {
            // Jika tidak, kembalikan dengan error
            return redirect()->back()
                ->withInput() // Bawa kembali data yg sudah diisi
                ->withErrors(['employee_id' => 'Karyawan ini tidak memiliki data jabatan atau gaji pokok.']);
        }

        // 4. Ambil data dari jabatan
        $gaji_pokok = $employee->position->gaji_pokok;
        $jabatan_id = $employee->position->id;

        // 5. Ambil data dari formulir
        $tunjangan = $request->tunjangan;
        $potongan = $request->potongan;

        // 6. HITUNG GAJI BERSIH
        $gaji_bersih = ($gaji_pokok + $tunjangan) - $potongan;

        // 7. Simpan ke database
        Salary::create([
            'employee_id' => $request->employee_id,
            'jabatan_id' => $jabatan_id,
            'tanggal_gaji' => $request->tanggal_gaji,
            'gaji_pokok' => $gaji_pokok,
            'tunjangan' => $tunjangan,
            'potongan' => $potongan,
            'gaji_bersih' => $gaji_bersih,
        ]);

        // 8. Arahkan kembali
        return redirect()->route('salaries.index')->with('success', 'Data gaji baru berhasil dibuat & dihitung.');
    }

    /**
     * Tampilkan data satu gaji (kita lewati).
     */
    public function show(string $id)
    {
        return redirect()->route('salaries.edit', $id);
    }

    /**
     * Tampilkan formulir untuk meng-edit gaji.
     */
    public function edit(string $id): View
    {
        // 1. Cari gaji berdasarkan ID, ambil juga relasinya
        $salary = Salary::with('employee')->findOrFail($id);

        // 2. Kita tidak perlu $employees di sini karena form edit tidak
        //    mengizinkan ganti karyawan.

        // 3. Kirim ke view
        return view('salaries.edit', compact('salary'));
    }

    /**
     * Update data gaji di database (DENGAN PERHITUNGAN ULANG).
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // 1. Cari gaji
        $salary = Salary::findOrFail($id);

        // 2. Validasi data (employee_id tidak divalidasi krn tidak di-submit)
        $request->validate([
            'tanggal_gaji' => 'required|date',
            'tunjangan' => 'required|numeric|min:0',
            'potongan' => 'required|numeric|min:0',
        ]);

        // 3. Ambil data
        $tunjangan = $request->tunjangan;
        $potongan = $request->potongan;
        $gaji_pokok = $salary->gaji_pokok; // Ambil gaji pokok yg sudah tersimpan

        // 4. HITUNG ULANG GAJI BERSIH
        $gaji_bersih = ($gaji_pokok + $tunjangan) - $potongan;

        // 5. Update data
        $salary->update([
            'tanggal_gaji' => $request->tanggal_gaji,
            'tunjangan' => $tunjangan,
            'potongan' => $potongan,
            'gaji_bersih' => $gaji_bersih,
        ]);

        // 6. Arahkan kembali
        return redirect()->route('salaries.index')->with('success', 'Data gaji berhasil diperbarui & dihitung ulang.');
    }

    /**
     * Hapus gaji dari database.
     */
    public function destroy(string $id): RedirectResponse
    {
        $salary = Salary::findOrFail($id);
        $salary->delete();
        return redirect()->route('salaries.index')->with('success', 'Data gaji berhasil dihapus.');
    }
}
