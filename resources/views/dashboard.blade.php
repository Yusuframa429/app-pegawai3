@extends('layouts.sidebar-layout')

@section('title', 'Dashboard Utama')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    {{-- Grid untuk Kartu Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Pegawai per Departemen</h2>
            {{-- Tempat grafik akan digambar --}}
            <div>
                <canvas id="departmentChart" style="max-height: 400px;"></canvas>
            </div>
        </div>

        {{-- Kartu 1: Total Pegawai --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Total Pegawai</div>
                <div class="text-3xl font-bold text-gray-900">{{ $totalPegawai }}</div>
            </div>
            <div class="text-blue-500">
                <i class="fa-solid fa-users fa-3x"></i>
            </div>
        </div>

        {{-- Kartu 2: Total Departemen --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Total Departemen</div>
                <div class="text-3xl font-bold text-gray-900">{{ $totalDepartemen }}</div>
            </div>
            <div class="text-green-500">
                <i class="fa-solid fa-building fa-3x"></i>
            </div>
        </div>

        {{-- Kartu 3: Hadir Hari Ini --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Hadir Hari Ini</div>
                <div class="text-3xl font-bold text-gray-900">{{ $totalHadirHariIni }}</div>
            </div>
            <div class="text-yellow-500">
                <i class="fa-solid fa-user-check fa-3x"></i>
            </div>
        </div>

        {{-- Kartu 4: Gaji Bulan Ini --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-500">Gaji Bulan Ini</div>
                <div class="text-2xl font-bold text-gray-900">Rp {{ $totalGajiBulanIni }}</div>
            </div>
            <div class="text-red-500">
                <i class="fa-solid fa-wallet fa-3x"></i>
            </div>
        </div>

    </div>



@endsection
@push('scripts')
{{-- 1. Load CDN Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- 2. Script untuk menggambar grafik --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('departmentChart');

        // Ambil data dari PHP (dikonversi ke JSON)
        const labels = @json($chartLabels);
        const data = @json($chartData);

        new Chart(ctx, {
            type: 'pie', // Tipe grafik: pie, bar, line, doughnut
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Pegawai',
                    data: data,
                    backgroundColor: [ // Sediakan beberapa warna
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                let total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                let percentage = ((value / total) * 100).toFixed(1) + '%';
                                return `${label}: ${value} (${percentage})`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
