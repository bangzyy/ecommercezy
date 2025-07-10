<header class="absolute inset-x-0 top-0 z-50" x-data="{ mobileMenuOpen: false }">
  <div
    x-show="mobileMenuOpen"
    @click.outside="mobileMenuOpen = false"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-4"
    class="lg:hidden absolute inset-x-0 top-full bg-slate-700 text-white p-6 z-40 space-y-4 shadow-lg rounded-b-lg"
  >
    <a href="#" class="block rounded-lg px-3 py-2 text-base font-semibold hover:bg-slate-600">Product</a>
    <a href="#" class="block rounded-lg px-3 py-2 text-base font-semibold hover:bg-slate-600">Marketplace</a>
    <a href="#" class="block rounded-lg px-3 py-2 text-base font-semibold hover:bg-slate-600">Docs</a>
    <a href="#" class="block rounded-lg px-3 py-2 text-base font-semibold hover:bg-slate-600">Help</a>
   @auth
  <div x-data="{ profileOpenMobile: false }">
    <button @click="profileOpenMobile = !profileOpenMobile"
      class="flex items-center gap-x-2 w-full rounded-lg px-3 py-2 text-base font-semibold hover:bg-slate-600">
      <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-900 text-white text-lg font-bold">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
      </span>
      {{ Auth::user()->name }}
    </button>
    <div x-show="profileOpenMobile" @click.outside="profileOpenMobile = false" x-transition
      class="mt-2 space-y-1">
      <a href="{{ route('profile') }}" class="block rounded-lg px-3 py-2 text-base font-semibold hover:bg-slate-600">View Profile</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="block w-full text-left rounded-lg px-3 py-2 text-base font-semibold hover:bg-slate-600">Log out</button>
      </form>
    </div>
  </div>
@else
  <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2 text-base font-semibold hover:bg-slate-600">Log in</a>
@endauth
  </div>
</header>
