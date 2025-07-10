<x-layout>
    @section('content')
        <div class="container mx-auto px-4 py-8 pt-20" data-aos="fade-up">

            {{-- Notifikasi --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4 relative"
                    role="alert">
                    <strong class="font-bold">Sukses! </strong>
                    <span>{{ session('success') }}</span>
                    <button type="button" @click="show = false"
                        class="absolute top-2 right-3 text-green-800 hover:text-green-900">&times;</button>
                </div>
            @elseif (session('error'))
                <div x-data="{ show: true }" x-show="show" class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4 relative"
                    role="alert">
                    <strong class="font-bold">Error! </strong>
                    <span>{{ session('error') }}</span>
                    <button type="button" @click="show = false"
                        class="absolute top-2 right-3 text-red-800 hover:text-red-900">&times;</button>
                </div>
            @endif

            <h2 class="text-2xl font-semibold mb-6 flex items-center gap-2"> <i
                    class="fas fa-shopping-cart text-blue-600"></i> Keranjang Belanja</h2>
            <div class="mt-6">
                <a href="{{ route('dashboard') }}" class="inline-block text-blue-600 hover:underline">&laquo; Lanjut
                    Belanja</a>
            </div>
            @if ($carts->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- Keranjang --}}
                    <div class="lg:col-span-2 space-y-4">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="select-all"
                                class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500" />
                            <label for="select-all" class="text-sm font-medium">Pilih Semua</label>
                        </div>
                        @php $grandTotal = 0; @endphp
                        @foreach ($carts as $cart)
                            <div class="bg-white rounded-lg shadow flex items-center p-4 gap-4">
                                <input type="checkbox" name="selected_carts[]" value="{{ $cart->id }}"
                                    class="cart-checkbox" form="checkout-form" />
                                <img src="{{ asset('storage/' . $cart->product->image) }}" alt="Product Image"
                                    class="w-20 h-20 object-cover rounded border" />
                                <div class="flex-1">
                                    <h3 class="font-semibold">{{ $cart->product->product_name }}</h3>
                                    <p class="text-sm text-gray-500">Kategori: {{ $cart->product->category->category_name }}
                                    </p>
                                    <p class="text-sm text-gray-500">Warna: {{ $cart->color ?? '-' }}</p>
                                    <div class="mt-2 flex items-center space-x-2">
                                        <span class="text-lg font-bold text-blue-600">Rp
                                            {{ number_format($cart->product->price, 0, ',', '.') }}</span>
                                    </div>
                                    <form action="{{ route('update.cart', $cart->id) }}" method="POST"
                                        class="flex items-center gap-2 mt-2 update-cart-form">
                                        @csrf
                                        @method('PUT')

                                        {{-- Quantity --}}
                                        <button type="button" onclick="this.nextElementSibling.stepDown()"
                                            class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center hover:bg-gray-300">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1"
                                            class=" w-16 h-8 border border-gray-300 rounded text-center focus:ring-blue-500 focus:border-blue-500" />
                                        <button type="button" onclick="this.previousElementSibling.stepUp()"
                                            class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center hover:bg-gray-300">
                                            <i class="fas fa-plus"></i>
                                        </button>

                                        {{-- Warna --}}
                                        @if ($cart->product->colors->count())
                                            <select name="color"
                                                class="border border-gray-300 rounded px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                                                @foreach ($cart->product->colors as $color)
                                                    <option value="{{ $color->color }}"
                                                        {{ $cart->color === $color->color ? 'selected' : '' }}>
                                                        {{ $color->color }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif

                                        <button type="submit"
                                            class="ml-2 px-3 py-1 bg-blue-600 text-white rounded-lg cursor-pointer hover:bg-blue-700 transition">
                                            <i class="fas fa-sync-alt mr-1"></i> Update
                                        </button>
                                    </form>

                                </div>
                                <div class="text-right">
                                    <p class="text-gray-500 text-sm">Subtotal</p>
                                    <p class="font-bold">Rp
                                        {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</p>
                                    <form action="{{ route('remove.from.cart', $cart->id) }}" method="POST"
                                        class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-700" title="Hapus">&#128465;</button>
                                    </form>
                                </div>
                            </div>
                            @php $grandTotal += $cart->product->price * $cart->quantity; @endphp
                        @endforeach
                    </div>

                    {{-- Ringkasan Belanja --}}
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">Ringkasan Belanja</h3>
                        <div class="flex justify-between mb-2">
                            <span>Total Harga ({{ $carts->count() }} Produk)</span>
                            <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Biaya Pengiriman</span>
                            <span>Rp 15.000</span>
                        </div>
                        <div class="border-t my-3"></div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-bold text-lg">Total Pembayaran</span>
                            <span class="text-blue-700 font-bold text-xl">Rp
                                {{ number_format($grandTotal + 15000, 0, ',', '.') }}</span>
                        </div>

                        <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block font-medium mb-1">Alamat Pengiriman</label>
                                <textarea name="address" rows="3" required
                                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>

                            <div>
                                <label class="block font-medium mb-1">Metode Pembayaran</label>
                                <select name="payment_method" id="payment-method" required
    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
    <option value="">-- PILIH METODE PEMBAYARAN --</option>
    <option value="Transfer Bank">Transfer Bank</option>
    <option value="COD">COD</option>
</select>

{{-- Info Rekening --}}
<div id="bank-transfer-info" class="mt-3 p-4 bg-gray-100 border border-blue-300 text-gray-800 rounded-lg hidden">
    <p class="font-semibold mb-1">Silakan transfer ke rekening berikut:</p>
    <ul class="text-sm space-y-1">
        <li><strong>BCA</strong> - 1234567890 a.n. <strong>Toko Adzy</strong></li>
        {{-- Bisa tambahkan bank lain jika perlu --}}
    </ul>
</div>

                            </div>

                            <button type="button" id="checkout-button"
                                class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 text-lg">
                                Checkout Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-blue-100 text-blue-800 px-4 py-3 rounded mt-4">Keranjang kamu kosong!</div>
            @endif


        </div>

        {{-- SweetAlert + JS Checkbox --}}
        <script>
            document.getElementById('select-all').addEventListener('change', function() {
                document.querySelectorAll('.cart-checkbox').forEach(cb => cb.checked = this.checked);
            });
            document.getElementById('payment-method').addEventListener('change', function () {
    const bankInfo = document.getElementById('bank-transfer-info');
    if (this.value === 'Transfer Bank') {
        bankInfo.classList.remove('hidden');
    } else {
        bankInfo.classList.add('hidden');
    }
});
            document.getElementById('checkout-button').addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('.cart-checkbox:checked');
                const address = document.querySelector('textarea[name="address"]').value.trim();
                const paymentMethod = document.querySelector('select[name="payment_method"]').value;

                if (checkedBoxes.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Pilih minimal satu produk!'
                    });
                    return;
                }

                if (!address) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Alamat pengiriman harus diisi!'
                    });
                    return;
                }

                if (!paymentMethod) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Metode pembayaran harus dipilih!'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Yakin ingin checkout?',
                    text: "Pastikan semua pesanan sudah sesuai!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Checkout!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Checkout!',
                            text: 'Barangmu Sukses di Checkout',
                            timer: 1500,
                            showConfirmButton: false,
                            willClose: () => {
                                document.getElementById('checkout-form').submit();
                            }
                        });
                    }
                });
            });

            document.querySelectorAll('.update-cart-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin ingin ubah ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Ubah',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#2563eb',
                        cancelButtonColor: '#d33',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>

    @endsection
</x-layout>
