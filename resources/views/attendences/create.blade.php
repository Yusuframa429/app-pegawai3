@extends('layouts.sidebar-layout')

@section('title', 'Tambah Absensi Baru')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Tambah Absensi Baru</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops! Ada yang salah:</strong>
                <ul class="list-disc pl-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('attendences.store') }}" method="POST">
            @csrf <div class="mb-4">
                <label for="karyawan_id" class="block text-gray-700 font-bold mb-2">Karyawan:</label>
                <select id="karyawan_id" name="karyawan_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('karyawan_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-gray-700 font-bold mb-2">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>

            <div class="mb-4">
                <label for="waktu_masuk" class="block text-gray-700 font-bold mb-2">Waktu Masuk:</label>
                <input type="time" id="waktu_masuk" name="waktu_masuk" value="{{ old('waktu_masuk') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>

            <div class="mb-4">
                <label for="waktu_keluar" class="block text-gray-700 font-bold mb-2">Waktu Keluar:</label>
                <input type="time" id="waktu_keluar" name="waktu_keluar" value="{{ old('waktu_keluar') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>

            <div class="mb-4">
                <label for="status_absensi" class="block text-gray-700 font-bold mb-2">Status Absensi:</label>
                <select id="status_absensi" name="status_absensi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    <option value="hadir" {{ old('status_absensi') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin" {{ old('status_absensi') == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ old('status_absensi') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="alpha" {{ old('status_absensi') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>
                <a href="{{ route('attendences.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </form>

    </div>
@endsection
