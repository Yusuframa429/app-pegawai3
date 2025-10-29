@extends('layouts.app')

@section('title', 'Tambah Departemen Baru')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Tambah Departemen Baru</h1>

        <form action="{{ route('departments.store') }}" method="POST">
            @csrf <div class="mb-4">
                <label for="nama_departemen" class="block text-gray-700 font-bold mb-2">Nama Departemen:</label>
                <input type="text" id="nama_departemen" name="nama_departemen" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>
                <a href="{{ route('departments.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </form>

    </div>
@endsection
