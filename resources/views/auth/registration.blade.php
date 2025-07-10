<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EcommerceZy Register Page</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans min-h-screen flex items-center justify-center">
    <div class="w-full max-w-4xl grid grid-cols-1 md:grid-cols-2 rounded-xl shadow-xl backdrop-blur-md bg-slate-300/20 overflow-hidden"
        data-aos="fade-up">
        <!-- Left side: Text only, transparent background -->
        <div class="hidden md:flex flex-col justify-center p-12 text-gray-600">
            <h1 class="text-4xl font-bold mb-4 drop-shadow-md">
                Welcome to <span class="text-amber-600">Ecommerce<span class="text-[#219ebc]">Zyy</span></span>
            </h1>
            <p class="text-base max-w-md leading-relaxed drop-shadow-md">
                Join EcommerceZy today and enjoy a seamless online shopping experience.
                Register now to unlock exclusive deals, track your orders, and more.
            </p>
        </div>
        <!-- Right side: Form, transparent background -->
        <div class="p-10 flex flex-col justify-center text-gray-800">
            <div class="text-center mb-6">
                <a href="#!">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="mx-auto mb-4" width="150" />
                </a>
                <h2 class="text-2xl font-semibold text-gray-600 drop-shadow-md">
                    Sign up to your account
                </h2>
            </div>
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                @if (session('error'))
                    <div class="alert alert-danger text-red-600 mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="mb-4">
                    <label for="name"
                        class="block text-gray-100 font-medium mb-2 drop-shadow-md">{{ __('Name') }}</label>
                    <input type="text" name="name" id="name"
                        class="w-full p-3 border border-gray-300 rounded-md bg-white/70 text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Adzy Gustry" required />
                    @error('name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email"
                        class="block text-gray-100 font-medium mb-2 drop-shadow-md">{{ __('Email Address') }}</label>
                    <input type="email" name="email" id="email"
                        class="w-full p-3 border border-gray-300 rounded-md bg-white/70 text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="name@example.com" required />
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4 relative">
                    <label for="password"
                        class="block text-gray-100 font-medium mb-2 drop-shadow-md">{{ __('Password') }}</label>
                    <input type="password" name="password" id="password"
                        class="w-full p-3 border border-gray-300 rounded-md bg-white/70 text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Password" required />
                    <button type="button" id="togglePassword"
                        class="absolute right-3 top-12 text-gray-700 hover:text-gray-900 focus:outline-none"
                        aria-label="Toggle password visibility">
                        Show
                    </button>
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4 relative">
                    <label for="password_confirmation"
                        class="block text-gray-100 font-medium mb-2 drop-shadow-md">{{ __('Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full p-3 border border-gray-300 rounded-md bg-white/70 text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Confirm Password" required />
                    <button type="button" id="toggleConfirmPassword"
                        class="absolute right-3 top-9 text-gray-700 hover:text-gray-900 focus:outline-none"
                        aria-label="Toggle confirm password visibility">
                        Show
                    </button>
                    @error('password_confirmation')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <button type="submit"
                        class="w-full bg-[#219ebc] text-white font-semibold p-3 rounded-md hover:bg-blue-600 transition duration-300">
                        {{ __('Register') }}
                    </button>
                </div>
                <div class="text-center">
                    <p class="text-sm text-amber-600 font-thin">
                        {{ __('Have an account?') }}
                        <a href="{{ route('login') }}"
                            class="text-yellow-900 hover:underline font-semibold">{{ __('Sign in') }}</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        togglePassword.addEventListener("click", () => {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            togglePassword.textContent = type === "password" ? "Show" : "Hide";
        });
        const toggleConfirmPassword = document.querySelector("#toggleConfirmPassword");
        const confirmPassword = document.querySelector("#password_confirmation");
        toggleConfirmPassword.addEventListener("click", () => {
            const type =
                confirmPassword.getAttribute("type") === "password" ? "text" : "password";
            confirmPassword.setAttribute("type", type);
            toggleConfirmPassword.textContent = type === "password" ? "Show" : "Hide";
        });
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
