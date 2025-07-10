<x-layout>
    <x-slot name="title">Profile</x-slot>

    @section('content')
    <div class="container mx-auto px-4 py-8 pt-20 max-w-4xl" data-aos="fade-up">
        <!-- Profile Header -->
        <a href="/dashboard" class="text-[#219ebc] hover:text-blue-700">&laquo;Go Back</a>
        <h2 class="text-3xl font-semibold mb-8 text-center text-gray-800">My Profile</h2>

        <div class="bg-white rounded-lg shadow-lg p-8 flex flex-col md:flex-row gap-10">
            <!-- Sidebar Avatar + Name -->
            <div class="flex flex-col items-center md:w-1/3 space-y-4">
                <div class="relative w-40 h-40 rounded-full overflow-hidden border-4 border-[#219ebc]">
                    <img
                        id="avatarPreview"
                        src="/avatars/{{ auth()->user()->avatar }}"
                        alt="User Avatar"
                        class="w-full h-full object-cover"
                    />
                </div>
                <p class="text-xl font-medium text-gray-700">{{ auth()->user()->name }}</p>
            </div>

            <!-- Form Profile -->
            <form id="profileForm" method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data" class="md:w-2/3 space-y-6">
                @csrf

                <div>
                    <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Change Avatar</label>
                    <input
                        id="avatar"
                        name="avatar"
                        type="file"
                        accept="image/*"
                        class="block w-auto text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-[#219ebc] file:text-white
                            hover:file:bg-[#023047]"
                    />
                    @error('avatar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', auth()->user()->name) }}"
                            class="block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:border-[#219ebc] focus:ring focus:ring-[#219ebc]/50"
                        />
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            class="block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:border-[#219ebc] focus:ring focus:ring-[#219ebc]/50"
                        />
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            placeholder="Leave blank to keep current"
                            class="block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:border-[#219ebc] focus:ring focus:ring-[#219ebc]/50"
                        />
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input
                            id="confirm_password"
                            name="confirm_password"
                            type="password"
                            autocomplete="new-password"
                            placeholder="Confirm your password"
                            class="block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:border-[#219ebc] focus:ring focus:ring-[#219ebc]/50"
                        />
                        @error('confirm_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input
                            id="phone"
                            name="phone"
                            type="text"
                            value="{{ old('phone', auth()->user()->phone) }}"
                            class="block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:border-[#219ebc] focus:ring focus:ring-[#219ebc]/50"
                        />
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input
                            id="city"
                            name="city"
                            type="text"
                            value="{{ old('city', auth()->user()->city) }}"
                            class="block w-full rounded-md border border-gray-300 shadow-sm px-3 py-2 focus:border-[#219ebc] focus:ring focus:ring-[#219ebc]/50"
                        />
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="text-center pt-4">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-md bg-[#219ebc] px-8 py-3 text-white font-semibold hover:bg-[#023047] focus:outline-none focus:ring-2 focus:ring-[#219ebc]/80 transition"
                    >
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
 {{-- Review History --}}
<div class="mt-12 max-w-4xl mx-auto" data-aos="fade-up">
    <h3 class="text-2xl font-semibold mb-6 text-gray-800 text-center">My Reviews</h3>

    @if($reviews->isEmpty())
        <p class="text-gray-600 text-center">You haven't reviewed any products yet.</p>
    @else
        <div class="space-y-6">
            @foreach($reviews as $review)
                <div class="bg-white p-6 rounded-lg shadow border hover:shadow-lg transition-shadow duration-300">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                        <div>
                            <h4 class="text-xl font-semibold text-[#219ebc]">{{ $review->product->product_name }}</h4>
                            <div class="flex items-center space-x-1 mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg class="w-5 h-5 text-yellow-400 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09L5.64 12.5.76 8.41l6.165-.896L10 2.5l3.075 5.014 6.165.896-4.88 4.09 1.518 5.59z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09L5.64 12.5.76 8.41l6.165-.896L10 2.5l3.075 5.014 6.165.896-4.88 4.09 1.518 5.59z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <span class="text-sm text-gray-500 mt-4 md:mt-0">Reviewed on {{ $review->created_at->format('d M Y') }}</span>
                    </div>

                    <p class="text-gray-700 leading-relaxed">{{ $review->review }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>



    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Preview avatar saat pilih file baru
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatarPreview');

        avatarInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    avatarPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Konfirmasi sebelum submit form
        const form = document.getElementById('profileForm');
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to update your profile?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#219ebc',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

    </script>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated successfully',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    position: 'top-end',
                    toast: true,
                });
            });
        </script>
    @endif
    @endsection
</x-layout>
