<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Kepegawaian')</title>

    {{-- CDN Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- CDN Font Awesome untuk ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Ini untuk menambahkan CSS/JS tambahan jika dibutuhkan oleh halaman tertentu --}}
    @stack('styles')
    @stack('scripts')

</head>
<body class="bg-gray-100">
    {{-- Ini adalah tempat di mana konten utama atau layout lain akan di-inject --}}
    @yield('content')
</body>
</html>
