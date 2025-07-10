@extends('admin.layouts.app')
@section('title', 'Pilih User')
@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">📋 Daftar User yang Melakukan Checkout</h1>
    <ul class="space-y-3">
        @forelse ($users as $user)
            <li>
                <a href="{{ route('admin.checkouts.user', $user->id) }}"
                   class="block p-4 bg-blue-50 hover:bg-blue-100 rounded border text-blue-800 font-semibold transition">
                    👤 {{ $user->name }} <span class="text-sm text-gray-500">({{ $user->email }})</span>
                </a>
            </li>
        @empty
            <li class="text-gray-600">Belum ada user yang melakukan checkout.</li>
        @endforelse
    </ul>
</div>
@endsection
