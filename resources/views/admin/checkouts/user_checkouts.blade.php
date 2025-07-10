@extends('admin.layouts.app')
@section('title', 'Checkout ' . $user->name)
@section('content')
<div class="rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">🛒 Checkout dari {{ $user->name }}</h1>
    <div class="mb-6">
        <a href="{{ route('admin.checkouts.users') }}" class="text-blue-600 hover:underline font-semibold">&larr; Kembali ke daftar user</a>
    </div>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if($checkouts->isEmpty())
        <p class="text-gray-600">User ini belum melakukan checkout.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($checkouts as $checkout)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4 flex flex-col">
                    <img src="{{ asset('storage/' . $checkout->product->image) }}" alt="{{ $checkout->product->product_name }}" class="w-full h-48 object-cover rounded mb-4">
                    <h2 class="text-lg font-semibold mb-2">{{ $checkout->product->product_name }}</h2>
                    <div class="text-gray-700 mb-1"><strong>Jumlah:</strong> {{ $checkout->quantity }}</div>
                    <div class="text-gray-700 mb-1"><strong>Total Harga:</strong> Rp {{ number_format($checkout->total_price, 0, ',', '.') }}</div>
                    <div class="text-gray-700 mb-1"><strong>Alamat:</strong> {{ $checkout->address }}</div>
                    <div class="text-gray-700 mb-1"><strong>Metode:</strong> {{ $checkout->payment_method }}</div>
                    <div class="text-gray-700 mb-4"><strong>Status:</strong> <span class="capitalize">{{ $checkout->status }}</span></div>
                    <div class="mt-auto flex space-x-2">
                        @if($checkout->status == 'pending')
                            <button
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition sweet-action"
                                data-action="accept"
                                data-url="{{ route('admin.checkouts.accept', $checkout->id) }}">
                                Accept
                            </button>
                            <button
                                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition sweet-action"
                                data-action="reject"
                                data-url="{{ route('admin.checkouts.reject', $checkout->id) }}">
                                Reject
                            </button>
                        @else
                            <span class="text-gray-500 italic">No action available</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $checkouts->links() }}
        </div>
    @endif
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.sweet-action').forEach(button => {
            button.addEventListener('click', function () {
                let action = this.getAttribute('data-action');
                let url = this.getAttribute('data-url');
                let csrfToken = '{{ csrf_token() }}';
                let actionText = action === 'accept' ? 'menerima' : 'menolak';
                let actionBtn = action === 'accept' ? 'Yes, Accept' : 'Yes, Reject';
                let actionColor = action === 'accept' ? '#16a34a' : '#dc2626';
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Anda akan ${actionText} pesanan ini.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: actionColor,
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: actionBtn
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire('Berhasil!', data.message, 'success')
                                .then(() => {
                                    window.location.reload();
                                });
                        })
                        .catch(error => {
                            Swal.fire('Error', 'Terjadi kesalahan. Coba lagi.', 'error');
                        });
                    }
                });
            });
        });
    });
</script>
@endsection
