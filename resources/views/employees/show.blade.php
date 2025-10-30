@extends('layouts.sidebar-layout')

@section('title', 'Detail Pegawai: ' . $employee->nama_lengkap)

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">Detail Pegawai</h1>
            <a href="{{ route('employees.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>

        {{-- Data Utama Pegawai --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b pb-6">
            <div>
                <p class="text-sm text-gray-500">Nama Lengkap</p>
                <p class="text-lg font-semibold">{{ $employee->nama_lengkap }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="text-lg font-semibold">{{ $employee->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nomor Telepon</p>
                <p class="text-lg font-semibold">{{ $employee->nomor_telepon }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                @if ($employee->status == 'aktif')
                    <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Aktif</span>
                @else
                    <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-xs">Nonaktif</span>
                @endif
            </div>
            <div>
                <p class="text-sm text-gray-500">Departemen</p>
                <p class="text-lg font-semibold">{{ $employee->department->nama_departemen ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jabatan</p>
                <p class="text-lg font-semibold">{{ $employee->position->nama_jabatan ?? 'N/A' }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-sm text-gray-500">Alamat</p>
                <p class="text-lg font-semibold">{{ $employee->alamat }}</p>
            </div>
        </div>

        {{-- Histori Absensi --}}
        <div class="mt-6">
            <h2 class="text-xl font-bold mb-4">Histori Absensi (10 Terbaru)</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 border-b">Tanggal</th>
                            <th class="py-2 px-4 border-b">Masuk</th>
                            <th class="py-2 px-4 border-b">Keluar</th>
                            <th class="py-2 px-4 border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employee->attendences->sortByDesc('tanggal')->take(10) as $absen)
                            <tr class="hover:bg-gray-50 text-center">
                                <td class="py-2 px-4 border-b">{{ $absen->tanggal }}</td>
                                <td class="py-2 px-4 border-b">{{ $absen->waktu_masuk ?? '-' }}</td>
                                <td class="py-2 px-4 border-b">{{ $absen->waktu_keluar ?? '-' }}</td>
                                <td class="py-2 px-4 border-b capitalize">{{ $absen->status_absensi }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 px-4 border-b text-center">Belum ada data absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Histori Gaji --}}
        <div class="mt-6">
            <h2 class="text-xl font-bold mb-4">Histori Gaji (10 Terbaru)</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 border-b">Tanggal Gaji</th>
                            <th class="py-2 px-4 border-b">Gaji Pokok</th>
                            <th class="py-2 px-4 border-b">Tunjangan</th>
                            <th class="py-2 px-4 border-b">Potongan</th>
                            <th class="py-2 px-4 border-b">Gaji Bersih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employee->salaries->sortByDesc('tanggal_gaji')->take(10) as $gaji)
                            <tr class="hover:bg-gray-50 text-right">
                                <td class="py-2 px-4 border-b text-center">{{ $gaji->tanggal_gaji }}</td>
                                <td class="py-2 px-4 border-b">Rp {{ number_format($gaji->gaji_pokok, 2, ',', '.') }}</td>
                                <td class="py-2 px-4 border-b">Rp {{ number_format($gaji->tunjangan, 2, ',', '.') }}</td>
                                <td class="py-2 px-4 border-b">Rp {{ number_format($gaji->potongan, 2, ',', '.') }}</td>
                                <td class="py-2 px-4 border-b font-bold">Rp {{ number_format($gaji->gaji_bersih, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 px-4 border-b text-center">Belum ada data gaji.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
