<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Auth Page' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="min-h-screen bg-gradient-to-r from-blue-100 to-purple-100 flex items-center justify-center px-4">
    <div class="w-full max-w-md space-y-4">
        {{-- Back to login link --}}
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold text-lg block">
            &laquo; Back to Login
        </a>
        {{-- Card Content --}}
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg border border-gray-200">
            @yield('content')
        </div>
    </div>

</body>

</html>
