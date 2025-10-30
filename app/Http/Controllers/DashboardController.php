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


    public function index(): View
    {

        $totalPegawai = Employee::count();
        $totalDepartemen = Department::count();


        $totalHadirHariIni = Attendence::where('status_absensi', 'hadir')
            ->whereDate('tanggal', today())
            ->count();


        $totalGajiBulanIni = Salary::whereMonth('tanggal_gaji', today()->month)
            ->whereYear('tanggal_gaji', today()->year)
            ->sum('gaji_bersih');

        $departmentsData = Department::withCount('employees')->get();
        $chartLabels = $departmentsData->pluck('nama_departemen');
        $chartData = $departmentsData->pluck('employees_count');


        return view('dashboard', [
            'totalPegawai' => $totalPegawai,
            'totalDepartemen' => $totalDepartemen,
            'totalHadirHariIni' => $totalHadirHariIni,
            'totalGajiBulanIni' => number_format($totalGajiBulanIni, 2, ',', '.'),
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);
    }
}
