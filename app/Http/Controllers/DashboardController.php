<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendence;
use App\Models\Salary;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama.
     */
    public function index(): View
    {
        // 1. Ambil jumlah total
        $totalPegawai = Employee::count();
        $totalDepartemen = Department::count();

        // 2. Ambil statistik absensi HARI INI
        $totalHadirHariIni = Attendence::where('status_absensi', 'hadir')
            ->whereDate('tanggal', today())
            ->count();

        // 3. Ambil total gaji dibayar BULAN INI
        $totalGajiBulanIni = Salary::whereMonth('tanggal_gaji', today()->month)
            ->whereYear('tanggal_gaji', today()->year)
            ->sum('gaji_bersih');

        // === 4. DATA UNTUK GRAFIK ===
        // Ambil data departemen beserta jumlah pegawainya (employees_count)
        $departmentsData = Department::withCount('employees')->get();
        // Siapkan label (Nama Departemen)
        $chartLabels = $departmentsData->pluck('nama_departemen');
        // Siapkan data (Jumlah Pegawai)
        $chartData = $departmentsData->pluck('employees_count');


        // 5. Kirim semua data ke view
        return view('dashboard', [
            'totalPegawai' => $totalPegawai,
            'totalDepartemen' => $totalDepartemen,
            'totalHadirHariIni' => $totalHadirHariIni,
            'totalGajiBulanIni' => number_format($totalGajiBulanIni, 2, ',', '.'),
            'chartLabels' => $chartLabels, // <-- Kirim data grafik
            'chartData' => $chartData,     // <-- Kirim data grafik
        ]);
    }
}
