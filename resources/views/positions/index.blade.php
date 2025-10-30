@extends('layouts.sidebar-layout')

@section('title', 'Daftar Jabatan')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Manajemen Jabatan</h1>
            <a href="{{ route('positions.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fa-solid fa-plus"></i> Tambah Jabatan
            </a>
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
                        <th class="py-2 px-4 border-b">Nama Jabatan</th>
                        <th class="py-2 px-4 border-b">Gaji Pokok</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($positions as $key => $position)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b">{{ $position->nama_jabatan }}</td>
                            <td class="py-2 px-4 border-b text-right">Rp
                                {{ number_format($position->gaji_pokok, 2, ',', '.') }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('positions.edit', $position->id) }}"
                                    class="text-yellow-500 hover:text-yellow-700 mr-2">
                                    <i class="fa-solid fa-pencil"></i> Edit
                                </a>

                                <a href="#" class="text-red-500 hover:text-red-700"
                                    onclick="event.preventDefault(); confirmDelete('form-hapus-attendance-{{ $position->id }}');">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </a>
                                {{-- Form Hapus yang tersembunyi, di-submit oleh JS --}}
                                <form id="form-hapus-attendance-{{ $position->id }}"
                                    action="{{ route('attendences.destroy', $position->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 px-4 border-b text-center">
                                Tidak ada data jabatan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $positions->links() }}
        </div>
    </div>
@endsection
