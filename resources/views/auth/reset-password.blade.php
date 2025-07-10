@extends('layouts.auth')
@section('content')
    <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Reset Password</h2>
    @if(session('error'))
        <div x-data="{ showError: true }" x-show="showError"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
            <span @click="showError = false"
                class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer text-red-500 hover:text-red-700">&times;</span>
        </div>
    @endif
    <form method="POST" action="{{ route('password.update') }}" x-data="{ loading: false }" @submit="loading = true">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 mb-1 font-medium">Email</label>
            <input type="email" name="email" required
                class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                placeholder="Enter your email">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-1 font-medium">New Password</label>
            <input type="password" name="password" required
                class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                placeholder="New password">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 mb-1 font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                placeholder="Confirm password">
        </div>
        <button type="submit"
            class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-700 active:scale-95 transition-all duration-300 flex items-center justify-center"
            x-bind:disabled="loading">
            <span x-show="!loading">Update Password</span>
            <svg x-show="loading" class="animate-spin h-5 w-5 text-white ml-2" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </button>
    </form>
@endsection
