@extends('layouts.sidebar-layout')

@section('title', 'Daftar Pegawai')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Manajemen Pegawai</h1>
            <a href="{{ route('employees.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fa-solid fa-plus"></i> Tambah Pegawai
            </a>
        </div>
        <div class="mb-4">
            <form action="{{ route('employees.index') }}" method="GET">
                <div class="flex">
                    <input type="text" n ame="search"
                        class="shadow appearance-none border rounded-l w-full py-2 px-3 text-gray-700"
                        placeholder="Cari nama atau email..." value="{{ request('search') }}">
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
                        <th class="py-2 px-4 border-b">Nama Lengkap</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Departemen</th>
                        <th class="py-2 px-4 border-b">Jabatan</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $key => $employee)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b">{{ $employee->nama_lengkap }}</td>
                            <td class="py-2 px-4 border-b">{{ $employee->email }}</td>

                            <td class="py-2 px-4 border-b">{{ $employee->department->nama_departemen ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b">{{ $employee->position->nama_jabatan ?? 'N/A' }}</td>

                            <td class="py-2 px-4 border-b">
                                @if ($employee->status == 'aktif')
                                    <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Aktif</span>
                                @else
                                    <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-xs">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('employees.show', $employee->id) }}"
                                    class="text-blue-500 hover:text-blue-700 mr-2">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('employees.edit', $employee->id) }}"
                                    class="text-yellow-500 hover:text-yellow-700 mr-2">
                                    <i class="fa-solid fa-pencil"></i> Edit
                                </a>
                                {{-- Tombol Hapus baru, ini adalah link <a> yang memicu JS --}}
                                <a href="#" class="text-red-500 hover:text-red-700"
                                    onclick="event.preventDefault(); confirmDelete('form-hapus-department-{{ $employee->id }}');">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </a>
                                {{-- Form Hapus yang tersembunyi, di-submit oleh JS --}}
                                <form id="form-hapus-department-{{ $employee->id }}"
                                    action="{{ route('departments.destroy', $employee->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 px-4 border-b text-center">
                                Tidak ada data pegawai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $employees->links() }}
        </div>
    </div>
@endsection
