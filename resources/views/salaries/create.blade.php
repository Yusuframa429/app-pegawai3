@extends('layouts.sidebar-layout')

@section('title', 'Buat Gaji Baru')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Buat Gaji Baru</h1>

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

        <form action="{{ route('salaries.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="employee_id" class="block text-gray-700 font-bold mb-2">Karyawan:</label>
                <select id="employee_id" name="employee_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->nama_lengkap }} (Jabatan: {{ $employee->position->nama_jabatan ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
                <small class="text-gray-500">Gaji pokok akan diambil otomatis dari jabatan karyawan.</small>
            </div>

            <div class="mb-4">
                <label for="tanggal_gaji" class="block text-gray-700 font-bold mb-2">Tanggal Gaji:</label>
                <input type="date" id="tanggal_gaji" name="tanggal_gaji" value="{{ old('tanggal_gaji') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>

            <div class="mb-4">
                <label for="tunjangan" class="block text-gray-700 font-bold mb-2">Tunjangan:</label>
                <input type="number" id="tunjangan" name="tunjangan" value="{{ old('tunjangan', 0) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" step="0.01" min="0" required>
            </div>

            <div class="mb-4">
                <label for="potongan" class="block text-gray-700 font-bold mb-2">Potongan:</label>
                <input type="number" id="potongan" name="potongan" value="{{ old('potongan', 0) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" step="0.01" min="0" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <i class="fa-solid fa-save"></i> Simpan & Hitung Gaji
                </button>
                <a href="{{ route('salaries.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
