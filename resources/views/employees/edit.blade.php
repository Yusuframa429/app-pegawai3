@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Pegawai: {{ $employee->nama_lengkap }}</h1>

        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="mb-4">
                        <label for="nama_lengkap" class="block text-gray-700 font-bold mb-2">Nama Lengkap:</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ $employee->nama_lengkap }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                        <input type="email" id="email" name="email" value="{{ $employee->email }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>

                    <div class="mb-4">
                        <label for="nomor_telepon" class="block text-gray-700 font-bold mb-2">Nomor Telepon:</label>
                        <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ $employee->nomor_telepon }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="block text-gray-700 font-bold mb-2">Alamat:</label>
                        <textarea id="alamat" name="alamat" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">{{ $employee->alamat }}</textarea>
                    </div>
                </div>

                <div>
                    <div class="mb-4">
                        <label for="tanggal_lahir" class="block text-gray-700 font-bold mb-2">Tanggal Lahir:</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ $employee->tanggal_lahir }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>

                    <div class="mb-4">
                        <label for="tanggal_masuk" class="block text-gray-700 font-bold mb-2">Tanggal Masuk:</label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ $employee->tanggal_masuk }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 font-bold mb-2">Status:</label>
                        <select id="status" name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                            <option value="aktif" @if($employee->status == 'aktif') selected @endif>Aktif</option>
                            <option value="nonaktif" @if($employee->status == 'nonaktif') selected @endif>Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <i class="fa-solid fa-save"></i> Update
                </button>
                <a href="{{ route('employees.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </form>

    </div>
@endsection
