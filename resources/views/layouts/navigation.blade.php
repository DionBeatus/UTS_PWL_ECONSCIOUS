<nav class="sticky top-0 z-50 bg-gradient-to-r from-green-100 via-white to-green-100 backdrop-blur-md shadow-lg border-b border-green-100">
    <div class="max-w-screen-2xl mx-auto px-6">
        <div class="flex items-center justify-between h-20">

            <!-- LOGO -->
            <div class="flex items-center gap-3 shrink-0 hover:scale-105 duration-300 transition">
                <img src="{{ asset('asset/bumi_only.png') }}" class="h-10 w-auto object-contain" alt="Logo">
                <span class="font-bold text-3xl bg-gradient-to-r from-green-500 to-blue-500 bg-clip-text text-transparent pb-2">
                    econscious
                </span>
            </div>

            <!-- MENU -->
            <div class="hidden lg:flex flex-1 justify-center">
                <div class="flex items-center gap-5 text-[15px] font-semibold text-green-800">

                    <!-- DASHBOARD -->
                    <a href="{{ route('dashboard') }}"
                        class="relative px-1 py-2 rounded-lg transition duration-300
                   {{ request()->routeIs('dashboard') ? 'text-green-700' : 'hover:text-green-600' }}">
                        Dashboard
                        <span class="absolute left-0 -bottom-1 h-1 bg-green-600 rounded-full transition-all duration-300
                        {{ request()->routeIs('dashboard') ? 'w-full' : 'w-0 group-hover:w-full' }}">
                        </span>
                    </a>

                    <!-- USER -->
                    <a href="{{ route('users.index') }}"
                       class="relative px-1 py-2 rounded-lg transition duration-300
                   {{ request()->routeIs('users.*') ? 'text-green-700' : 'hover:text-green-600' }}">
                        Users
                        <span class="absolute left-0 -bottom-1 h-1 bg-green-600 rounded-full transition-all duration-300
                        {{ request()->routeIs('users.*') ? 'w-full' : 'w-0 group-hover:w-full' }}">
                        </span>
                    </a>
                    <!-- PRODUCTS -->
                    <a href="{{ route('products.index') }}"
                    class="relative px-1 py-2 rounded-lg transition duration-300
                   {{ request()->routeIs('products.*') ? 'text-green-700' : 'hover:text-green-600' }}">
                        Products
                        <span class="absolute left-0 -bottom-1 h-1 bg-green-600 rounded-full transition-all duration-300
                        {{ request()->routeIs('products.*') ? 'w-full' : 'w-0 group-hover:w-full' }}">
                        </span>
                    </a>

                    <!-- DONATIONS -->
                    <a href="{{ route('donations.index') }}"
                        class="relative px-1 py-2 rounded-lg transition duration-300
                   {{ request()->routeIs('donations.*') ? 'text-green-700' : 'hover:text-green-600' }}">
                        Donations
                        <span class="absolute left-0 -bottom-1 h-1 bg-green-600 rounded-full transition-all duration-300
                        {{ request()->routeIs('donations.*') ? 'w-full' : 'w-0 group-hover:w-full' }}">
                        </span>
                    </a>

                    <!-- PRODUCTIONS -->
                    <a href="{{ route('productions.index') }}"
                        class="relative px-1 py-2 rounded-lg transition duration-300
                   {{ request()->routeIs('productions.*') ? 'text-green-700' : 'hover:text-green-600' }}">
                        Productions
                        <span class="absolute left-0 -bottom-1 h-1 bg-green-600 rounded-full transition-all duration-300
                        {{ request()->routeIs('productions.*') ? 'w-full' : 'w-0 group-hover:w-full' }}">
                        </span>
                    </a>

                    <!-- RECIPE -->
                    <a href="{{ route('recipes.index') }}"
                        class="relative px-1 py-2 rounded-lg transition duration-300
                   {{ request()->routeIs('recipes.*') ? 'text-green-700' : 'hover:text-green-600' }}">
                        Recipes
                        <span class="absolute left-0 -bottom-1 h-1 bg-green-600 rounded-full transition-all duration-300
                        {{ request()->routeIs('recipes.*') ? 'w-full' : 'w-0 group-hover:w-full' }}">
                        </span>
                    </a>

                    <!-- SALES -->
                    <a href="{{ route('sales.index') }}"
                        class="relative px-1 py-2 rounded-lg transition duration-300
                   {{ request()->routeIs('sales.*') ? 'text-green-700' : 'hover:text-green-600' }}">
                        Sales
                        <span class="absolute left-0 -bottom-1 h-1 bg-green-600 rounded-full transition-all duration-300
                        {{ request()->routeIs('sales.*') ? 'w-full' : 'w-0 group-hover:w-full' }}">
                        </span>
                    </a>

                    <!-- PURCHASE -->
                    <a href="{{ route('purchases.index') }}"
                        class="relative px-1 py-2 rounded-lg transition duration-300
                   {{ request()->routeIs('purchases.*') ? 'text-green-700' : 'hover:text-green-600' }}">
                        Purchases
                        <span class="absolute left-0 -bottom-1 h-1 bg-green-600 rounded-full transition-all duration-300
                        {{ request()->routeIs('purchases.*') ? 'w-full' : 'w-0 group-hover:w-full' }}">
                        </span>
                    </a>

                    <!-- STOCK -->
                    <a href="{{ route('stocks.index') }}"
                        class="relative px-1 py-2 rounded-lg transition duration-300
                   {{ request()->routeIs('stocks.*') ? 'text-green-700' : 'hover:text-green-600' }}">
                        Stocks
                        <span class="absolute left-0 -bottom-1 h-1 bg-green-600 rounded-full transition-all duration-300
                        {{ request()->routeIs('stocks.*') ? 'w-full' : 'w-0 group-hover:w-full' }}">
                        </span>
                    </a>
                </div>
            </div>

            <!-- USER -->
            <div class="shrink-0 flex items-center gap-3">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="bg-gradient-to-r from-green-400 to-blue-400 text-white font-bold px-4 py-2 rounded-full shadow-md flex items-center gap-2 hover:scale-105 transition">
                            {{ Auth::user()->name }}
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.51a.75.75 0 01-1.08 0l-4.25-4.51a.75.75 0 01.02-1.06z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>