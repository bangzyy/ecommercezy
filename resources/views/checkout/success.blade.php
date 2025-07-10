<x-layout>
    @section('content')
        <div class="min-h-screen bg-gray-50 py-10 px-8">
            @if (session('success'))
                <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700">
                    {{ session('error') }}
                </div>
            @endif
            <div class="max-w-full mx-auto  rounded-xl shadow-md p-10 text-center animate-fadeIn">
                <h2 class="text-5xl font-extrabold text-green-600 mb-6 animate-bounce">
                    🎉 Terima Kasih!
                </h2>
                <p class="text-xl text-gray-700 mb-10">
                    Sudah Checkout di
                    <span class="font-semibold">
                        <span class="text-[#219ebc]">Ecommerce</span>
                        <span class="text-[#ffb703]">Zyy</span>!
                    </span>
                    Pesanan kamu sedang diproses. 😍
                </p>
                <h3 class="text-3xl font-semibold text-left mb-8 border-b pb-3">Detail Pesanan:</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-full">
                    @foreach ($checkouts as $checkout)
                        @php
                            $status = strtolower($checkout->status);
                            $statusColor = match (true) {
                                $status === 'done' && $checkout->review => 'border-blue-400 bg-blue-100',
                                $status === 'accepted' => 'border-green-400 bg-green-50',
                                $status === 'rejected' => 'border-red-400 bg-red-50',
                                default => 'border-yellow-400 bg-yellow-50',
                            };
                        @endphp
                        <div class="rounded-lg border {{ $statusColor }} shadow-md p-6 flex flex-col animate-slideUp"
                            id="checkout-card-{{ $checkout->id }}">
                            <div class="w-full h-48 rounded-lg overflow-hidden border border-gray-300 mb-5">
                                <img src="{{ asset('storage/' . $checkout->product->image) }}"
                                    alt="{{ $checkout->product->name }}" class="w-full h-full object-cover" loading="lazy">
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 mb-3">{{ $checkout->product->name }}</h4>
                            <div class="text-gray-700 mb-5 text-sm space-y-1 text-left">
                                <p><span class="font-medium">Jumlah:</span> {{ $checkout->quantity }}</p>
                                <p><span class="font-medium">Total Harga:</span> Rp
                                    {{ number_format($checkout->total_price, 0, ',', '.') }}</p>
                                <p><span class="font-medium">Alamat:</span> {{ $checkout->address }}</p>
                                <p><span class="font-medium">Metode Pembayaran:</span> {{ $checkout->payment_method }}</p>
                            </div>
                            <p class="font-semibold text-lg">
                                Status:
                                @if ($status === 'accepted')
                                    <span class="text-green-600">Accepted ✔️</span>
                                @elseif($status === 'done')
                                    <span class="text-green-800">Done ✅</span>
                                @elseif ($status === 'rejected')
                                    <span class="text-red-600">Rejected ❌</span>
                                @else
                                    <span class="text-yellow-600">Pending ⏳</span>
                                    <p class="text-gray-500 text-sm mb-2">Tunggu konfirmasi dari admin</p>
                                @endif
                            </p>
                            {{-- Tombol Aksi --}}
                            <div class="mt-auto space-y-2" id="button-group-{{ $checkout->id }}">
                                @if ($status === 'accepted')
                                    <button onclick="showConfirmModal({{ $checkout->id }})"
                                        class="w-full px-4 py-2 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition"
                                        id="btn-terima-{{ $checkout->id }}">
                                        Pesanan Diterima
                                    </button>
                                @elseif ($status === 'pending')
                                    <form action="{{ route('checkout.batalkan', $checkout->id) }}" method="POST"
                                        class="form-batalkan">
                                        @csrf
                                        <button type="submit"
                                            class="w-full px-4 py-2 rounded-lg bg-yellow-500 text-white font-medium hover:bg-yellow-600 transition">
                                            Batalkan Checkout
                                        </button>
                                    </form>
                                @endif
                                {{-- Review hanya muncul jika status sudah "done" --}}
                                @if ($status === 'done')
                                    @if (!$checkout->review)
                                        <form action="{{ route('reviews.store') }}" method="POST" class="mt-4 text-left">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $checkout->product->id }}">
                                            <input type="hidden" name="checkout_id" value="{{ $checkout->id }}">
                                            <!-- Hidden rating input -->
                                            <input type="hidden" name="rating" id="ratingInput" required>
                                            <!-- Bintang rating -->
                                            <div id="starRating" class="flex space-x-1 mb-4">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-gray-300 text-xl cursor-pointer"
                                                        data-value="{{ $i }}"></i>
                                                @endfor
                                            </div>
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Ulasan</label>
                                            <textarea name="review" rows="3" class="w-full p-2 border rounded mb-4" placeholder="Tulis ulasan kamu..."
                                                required></textarea>
                                            <button type="submit"
                                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                                Kirim Ulasan
                                            </button>
                                        </form>
                                    @else
                                        <div class="mt-4 text-left">
                                            <p class="font-medium">Rating: {{ $checkout->review->rating }} ⭐</p>
                                            <p class="text-gray-700">Ulasan: {{ $checkout->review->review }}</p>
                                        </div>
                                    @endif
                                @endif
                                <form action="{{ route('checkout.destroy', $checkout->id) }}" method="POST"
                                    class="form-hapus">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full px-4 py-2 rounded-lg bg-red-500 text-white font-medium hover:bg-red-600 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="confirmModal"
            class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-40 backdrop-blur-sm">
            <div class="bg-white p-6 rounded-xl shadow-xl max-w-sm w-full text-center">
                <h2 class="text-lg font-bold mb-4">Konfirmasi Penerimaan</h2>
                <p class="text-sm text-gray-600 mb-6">Anda yakin ingin mengkonfirmasi penerimaan barang?</p>
                <div class="flex justify-end space-x-3">
                    <button onclick="hideConfirmModal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button id="modalConfirmBtn"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">OK</button>
                </div>
            </div>
        </div>
        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
            .animate-fadeIn {
                animation: fadeIn 0.8s ease forwards;
            }
            @keyframes slideUp {
                0% {
                    opacity: 0;
                    transform: translateY(20px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .animate-slideUp {
                animation: slideUp 0.5s ease forwards;
            }
        </style>
        {{-- SweetAlert2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            let selectedCheckoutId = null;
            function showConfirmModal(id) {
                selectedCheckoutId = id;
                document.getElementById('confirmModal').classList.remove('hidden');
            }
            function hideConfirmModal() {
                document.getElementById('confirmModal').classList.add('hidden');
                selectedCheckoutId = null;
            }
            document.getElementById('modalConfirmBtn').addEventListener('click', async function() {
                if (selectedCheckoutId) {
                    try {
                        const response = await fetch(`/checkout/terima/${selectedCheckoutId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                        });
                        if (response.ok) {
                            hideConfirmModal();
                            const card = document.getElementById(`checkout-card-${selectedCheckoutId}`);
                            if (card) {
                                const statusText = card.querySelector('p.font-semibold.text-lg');
                                if (statusText) {
                                    statusText.innerHTML = `
                                        Status:
                                        <span class="text-green-600">Accepted ✔️</span>
                                    `;
                                }
                                const waitingMsg = card.querySelector('p.text-gray-500');
                                if (waitingMsg) waitingMsg.remove();
                                const btn = document.getElementById(`btn-terima-${selectedCheckoutId}`);
                                if (btn) btn.remove();
                            }
                            Swal.fire('Berhasil!', 'Pesanan telah diterima.', 'success');
                        } else {
                            Swal.fire('Gagal!', 'Gagal mengkonfirmasi pesanan.', 'error');
                        }
                    } catch (err) {
                        Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                    }
                }
            });
            document.addEventListener('DOMContentLoaded', () => {
                const stars = document.querySelectorAll('#starRating i');
                const ratingInput = document.getElementById('ratingInput');
                stars.forEach(star => {
                    star.addEventListener('click', () => {
                        const value = star.getAttribute('data-value');
                        ratingInput.value = value;
                        stars.forEach(s => {
                            if (s.getAttribute('data-value') <= value) {
                                s.classList.remove('text-gray-300');
                                s.classList.add('text-yellow-400');
                            } else {
                                s.classList.remove('text-yellow-400');
                                s.classList.add('text-gray-300');
                            }
                        });
                    });
                });
            });
            // Konfirmasi SweetAlert2 saat hapus pesanan
            document.querySelectorAll('.form-hapus').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin ingin menghapus pesanan ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e3342f',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });

            // Konfirmasi SweetAlert2 saat batalkan checkout
            document.querySelectorAll('.form-batalkan').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin ingin membatalkan pesanan ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#f59e0b',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, batalkan!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif
        </script>
    @endsection
</x-layout>
