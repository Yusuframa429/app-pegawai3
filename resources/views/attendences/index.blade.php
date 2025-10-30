@extends('layouts.sidebar-layout')

@section('title', 'Daftar Absensi')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Manajemen Absensi</h1>
            <a href="{{ route('attendences.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fa-solid fa-plus"></i> Tambah Absensi
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
                        <th class="py-2 px-4 border-b">Nama Karyawan</th>
                        <th class="py-2 px-4 border-b">Tanggal</th>
                        <th class="py-2 px-4 border-b">Waktu Masuk</th>
                        <th class="py-2 px-4 border-b">Waktu Keluar</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendences as $key => $attendance)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b">{{ $attendance->employee->nama_lengkap ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b">{{ $attendance->tanggal }}</td>
                            <td class="py-2 px-4 border-b">{{ $attendance->waktu_masuk ?? '-' }}</td>
                            <td class="py-2 px-4 border-b">{{ $attendance->waktu_keluar ?? '-' }}</td>
                            <td class="py-2 px-4 border-b capitalize">{{ $attendance->status_absensi }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('attendences.edit', $attendance->id) }}"
                                    class="text-yellow-500 hover:text-yellow-700 mr-2">
                                    <i class="fa-solid fa-pencil"></i> Edit
                                </a>

                                <a href="#" class="text-red-500 hover:text-red-700"
                                    onclick="event.preventDefault(); confirmDelete('form-hapus-attendance-{{ $attendance->id }}');">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </a>
                                {{-- Form Hapus yang tersembunyi, di-submit oleh JS --}}
                                <form id="form-hapus-attendance-{{ $attendance->id }}"
                                    action="{{ route('attendences.destroy', $attendance->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 px-4 border-b text-center">
                                Tidak ada data absensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $attendences->links() }}
        </div>
    </div>
@endsection
