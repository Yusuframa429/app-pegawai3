@extends('layouts.app')

@section('title', 'Tambah Jabatan Baru')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Tambah Jabatan Baru</h1>

        <form action="{{ route('positions.store') }}" method="POST">
            @csrf <div class="mb-4">
                <label for="nama_jabatan" class="block text-gray-700 font-bold mb-2">Nama Jabatan:</label>
                <input type="text" id="nama_jabatan" name="nama_jabatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>

            <div class="mb-4">
                <label for="gaji_pokok" class="block text-gray-700 font-bold mb-2">Gaji Pokok:</label>
                <input type="number" id="gaji_pokok" name="gaji_pokok" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="Contoh: 5000000" step="0.01" min="0" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>
                <a href="{{ route('positions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </form>

    </div>
@endsection
