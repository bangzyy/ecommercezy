<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel - @yield('title')</title>
    @vite('resources/css/app.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTTXrwf+2QeS+2s7j8b0P2uQ3z9xP8AzDg7ZQx1YyoGv6IxDGCGhC7AXAQazEemGKcOQ5Alw2w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTTXrwf+2QeS+2s7j8b0P2uQ3z9xP8AzDg7ZQx1YyoGv6IxDGCGhC7AXAQazEemGKcOQ5Alw2w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">
    {{-- Sidebar --}}
    <div class="w-64 bg-white shadow-lg flex flex-col hidden md:flex">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-blue-600">Admin Panel</h1>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 font-semibold' : '' }}">Dashboard</a>
            <a href="{{ route('categories.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50">Categories</a>
            <a href="{{ route('products.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50">Products</a>
            <a href="{{ route('admin.checkouts.users') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50">Checkouts</a>
        </nav>
        <form action="{{ route('logout') }}" method="POST" class="p-4">
            @csrf
            <button type="submit"
                class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold shadow">
                🔒 Logout
            </button>
        </form>
    </div>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-y-auto">
        <nav class="bg-white shadow p-4 flex items-center justify-between md:hidden">
            <h1 class="text-xl font-bold text-blue-600">Admin Panel</h1>
            {{-- Add mobile nav toggle here if needed --}}
        </nav>

        <main class="p-6">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
            @yield('scripts')
        </main>
    </div>

</body>
</html>
