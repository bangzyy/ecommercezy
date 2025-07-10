<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcommerceZy Login Page</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #F8F9FA;
        }
    </style>
</head>

<body class="font-sans bg-gray-100" data-aos="fade-up">
    <section class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
            <div class="text-center mb-6">
                <a href="#!">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="mx-auto mb-4" width="200">
                </a>
                <h2 class="text-2xl font-semibold text-gray-700">Sign in to your account</h2>
            </div>
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                @if (session('error'))
                    <div class="alert alert-danger text-red-600 mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">{{ __('Email Address') }}</label>
                    <input type="email" name="email" id="email"
                        class="w-full p-3 border border-gray-300 rounded-md @error('email')  @enderror"
                        placeholder="name@example.com" required>
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-2">{{ __('Password') }}</label>
                    <input type="password" name="password" id="password"
                        class="w-full p-3 border border-gray-300 rounded-md @error('password')  @enderror"
                        placeholder="Password" required>
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="rememberMe" id="rememberMe"
                            class="h-4 w-4 text-blue-500 border-gray-300 rounded">
                        <label for="rememberMe" class="text-sm text-gray-600 ml-2">{{ __('Keep me logged in') }}</label>
                    </div>
                    <a href="{{ route('password.reset.form') }}" class="text-sm text-blue-600 hover:underline">Forgot
                        password?</a>
                </div>
                <div class="mb-4">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700 transition duration-300">{{ __('Login') }}</button>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">{{ __("Don't have an account?") }} <a
                            href="{{ route('register') }}"
                            class="text-blue-600 hover:underline">{{ __('Sign up') }}</a></p>
                </div>
            </form>
        </div>
    </section>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
