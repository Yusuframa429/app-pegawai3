<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="bg-gray-100 flex h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-800 text-white flex flex-col p-4 shadow-lg">
        <div class="text-2xl font-bold text-center mb-8">
            Admin Panel
        </div>
        <nav class="flex-1">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200
                        {{ Request::routeIs('dashboard') ? 'bg-blue-600' : '' }}">
                        <i class="fa-solid fa-house mr-3"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('employees.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200
                        {{ Request::routeIs('employees.*') ? 'bg-blue-600' : '' }}">
                        <i class="fa-solid fa-users mr-3"></i>
                        Pegawai
                    </a>
                </li>
                <li>
                    <a href="{{ route('departments.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200
                        {{ Request::routeIs('departments.*') ? 'bg-blue-600' : '' }}">
                        <i class="fa-solid fa-building mr-3"></i>
                        Departemen
                    </a>
                </li>
                <li>
                    <a href="{{ route('positions.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200
                        {{ Request::routeIs('positions.*') ? 'bg-blue-600' : '' }}">
                        <i class="fa-solid fa-briefcase mr-3"></i>
                        Jabatan
                    </a>
                </li>
                <li>
                    <a href="{{ route('attendences.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200
                        {{ Request::routeIs('attendences.*') ? 'bg-blue-600' : '' }}">
                        <i class="fa-solid fa-clipboard-user mr-3"></i>
                        Absensi
                    </a>
                </li>
                <li>
                    <a href="{{ route('salaries.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200
                        {{ Request::routeIs('salaries.*') ? 'bg-blue-600' : '' }}">
                        <i class="fa-solid fa-sack-dollar mr-3"></i>
                        Penggajian
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}"
                        class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200
                        {{ Request::routeIs('users.*') ? 'bg-blue-600' : '' }}">
                        <i class="fa-solid fa-user-gear mr-3"></i>
                        Admin Users
                    </a>
                </li>
            </ul>
        </nav>
        {{-- Opsional: Bagian bawah sidebar --}}
        <div class="mt-8 pt-4 border-t border-gray-700 text-sm text-gray-400 text-center">
            &copy; {{ date('Y') }} Aplikasi Kepegawaian
        </div>
    </aside>

    {{-- Main Content Area --}}
    <main class="flex-1 p-8 overflow-y-auto">
        @yield('content')
    </main>
    <script>
        function confirmDelete(formId) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, submit form yang sesuai
                    document.getElementById(formId).submit();
                }
            })
        }
    </script>
    @stack('scripts')
</body>

</html>
