<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>

  {{-- Vite Assets (hanya jika manifest.json ada) --}}
  @if (file_exists(public_path('build/manifest.json')))
      @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif

  <script src="//unpkg.com/alpinejs" defer></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
  </style>
</head>
<body class="min-h-screen bg-gray-50">

    {{-- @include('components.header') --}}
    @include('components.navbar')

    <main class="flex-grow pt-6">
        {{-- {{ $slot }} --}}
        @yield('content')
    </main>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>

</body>
</html>
