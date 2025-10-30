@extends('layouts.sidebar-layout')

@section('title', 'Daftar Departemen')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Manajemen Departemen</h1>
            <a href="{{ route('departments.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fa-solid fa-plus"></i> Tambah Departemen
            </a>
        </div>

        <div class="mb-4">
            <form action="{{ route('departments.index') }}" method="GET">
                <div class="flex">
                    <input type="text" name="search"
                        class="shadow appearance-none border rounded-l w-full py-2 px-3 text-gray-700"
                        placeholder="Cari nama departemen..." value="{{ request('search') }}">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b">No</th>
                        <th class="py-2 px-4 border-b">Nama Departemen</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $key => $department)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b">{{ $department->nama_departemen }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('departments.edit', $department->id) }}"
                                    class="text-yellow-500 hover:text-yellow-700 mr-2">
                                    <i class="fa-solid fa-pencil"></i> Edit
                                </a>

                                {{-- Tombol Hapus baru, ini adalah link <a> yang memicu JS --}}
                                <a href="#" class="text-red-500 hover:text-red-700"
                                    onclick="event.preventDefault(); confirmDelete('form-hapus-department-{{ $department->id }}');">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </a>
                                {{-- Form Hapus yang tersembunyi, di-submit oleh JS --}}
                                <form id="form-hapus-department-{{ $department->id }}"
                                    action="{{ route('departments.destroy', $department->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 px-4 border-b text-center">
                                Tidak ada data departemen.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $departments->links() }}
        </div>
    </div>
@endsection
