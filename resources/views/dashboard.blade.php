<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="min-h-screen py-10 px-6 rounded-xl" style="background: linear-gradient(180deg, white, #CDFFC7)">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

    <div class="bg-purple-200 p-5 rounded-xl shadow flex items-center justify-between hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] 
                transition-all duration-300 ease-in-out cursor-pointer">
        <div>
            <p class="text-white-800 text-sm">Total Produk</p>
            <h2 class="text-2xl font-bold">{{ $totalProducts }}</h2>
        </div>
    </div>

    <div class="bg-green-100 p-5 rounded-xl shadow flex items-center justify-between hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] 
                transition-all duration-300 ease-in-out cursor-pointer">
        <div>
            <p class="text-white-800 text-sm">Total Stock</p>
            <h2 class="text-2xl font-bold">{{ $totalStock }}</h2>
        </div>
    </div>

    <!-- Penjualan -->
    <div class="bg-blue-200 p-5 rounded-xl shadow flex items-center justify-between hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] 
                transition-all duration-300 ease-in-out cursor-pointer">
        <div>
            <p class="text-white-800 text-sm">Total Penjualan</p>
            <h2 class="text-2xl font-bold">{{ $totalSales }}</h2>
        </div>
    </div>

    <!-- Revenue -->
    <div class="bg-orange-200 p-5 rounded-xl shadow flex items-center justify-between hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] 
                transition-all duration-300 ease-in-out cursor-pointer">
        <div>
            <p class="text-white-800 text-sm">Revenue</p>
            <h2 class="text-2xl font-bold">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </h2>
        </div>
    </div>
</div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-red-200 p-5 rounded-xl shadow hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] 
                transition-all duration-300 ease-in-out cursor-pointer">
                    <h3 class="font-semibold mb-3">Stock Rendah</h3>

                    @forelse($lowStock as $product)
                    <div class="flex justify-between border-b py-2">
                        <span>{{ $product->name }}</span>
                        <span class="text-red-600 font-semibold">
                            {{ $product->stock }}
                        </span>
                    </div>
                    @empty
                    <p class="text-gray-500">Stock barang aman</p>
                    @endforelse
                </div>

                <div class="bg-pink-200 p-5 rounded-xl shadow hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] 
                transition-all duration-300 ease-in-out cursor-pointer">
                    <h3 class="font-semibold mb-3">Transaksi Penjualan Terbaru</h3>

                    @forelse($recentSales as $sale)
                    <div class="flex justify-between border-b py-2">
                        <div>
                            <p>{{ $sale->customer_name }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $sale->product->name ?? '-' }}
                            </p>
                        </div>
                        <span>
                            Rp {{ number_format($sale->total, 0, ',', '.') }}
                        </span>
                    </div>
                    @empty
                    <p class="text-gray-500">Belum ada transaksi penjualan</p>
                    @endforelse
                </div>
            </div>
             <img src="{{ asset('asset/bg.png') }}" class="h-450 pb-50 w-auto object-contain">
        </div>
    </div>
</x-app-layout>