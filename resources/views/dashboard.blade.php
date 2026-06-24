<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/70 backdrop-blur-md rounded-xl px-6 py-4 shadow">
                <h2 class="font-semibold text-xl text-green-800 leading-tight">
                    {{ __('Dashboard Admin') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="min-h-screen bg-gradient-to-b from-white to-green-200 bg-[url('/asset/bg.png')] bg-no-repeat bg-bottom bg-contain">
            <div class="py-1 px-6 rounded-xl">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 px-2 gap-6 mb-6">

                    <div class="bg-yellow-200 p-5 rounded-xl shadow flex items-center justify-between hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] transition-all duration-300 ease-in-out">
                        <div>
                            <p class="text-gray-800 text-lg font-semibold">Total Biaya Pembelian</p>
                            <h2 class="text-2xl font-bold">
                                Rp {{ number_format($totalExpenses, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>

                    <div class="bg-green-200 p-5 rounded-xl shadow flex items-center justify-between hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] transition-all duration-300 ease-in-out">
                        <div>
                            <p class="text-gray-800 text-lg font-semibold">Total Stock</p>
                            <h2 class="text-2xl font-bold">{{ $totalStock }}</h2>
                        </div>
                    </div>

                    <div class="bg-blue-200 p-5 rounded-xl shadow flex items-center justify-between hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] transition-all duration-300 ease-in-out">
                        <div>
                            <p class="text-gray-800 text-lg font-semibold">Total Barang</p>
                            <h2 class="text-2xl font-bold">{{ $totalProduct }}</h2>
                        </div>
                    </div>

                    <div class="bg-orange-200 p-5 rounded-xl shadow flex items-center justify-between hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02] transition-all duration-300 ease-in-out">
                        <div>
                            <p class="text-gray-800 text-lg font-semibold">Total Biaya Penjualan</p>
                            <h2 class="text-2xl font-bold">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-2 mb-6">

                    <div class="bg-purple-200 p-5 rounded-2xl shadow-lg hover:shadow-2xl hover:-translate-y-1 hover:scale-[1.01] transition-all duration-300 ease-in-out">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-xl text-gray-800">Transaksi Pembelian Terbaru</h3>
                            <span class="bg-white/70 px-3 py-1 rounded-full text-sm font-semibold text-purple-700">
                                {{ $recentPurchases->count() }} Data
                            </span>
                        </div>

                        <div class="space-y-4">
                            @forelse($recentPurchases as $purchase)
                            <div class="bg-white/50 backdrop-blur-md rounded-xl p-4 border border-white/40">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="text-sm text-gray-600">Nama Toko</p>
                                        <h4 class="font-bold text-lg text-gray-800">{{ $purchase->store_name }}</h4>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">Total</p>
                                        <p class="font-bold text-red-700">Rp {{ number_format($purchase->total, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="border-t pt-3 space-y-2">
                                    <p class="text-sm text-gray-600">Produk yang Dibeli</p>
                                    @foreach($purchase->details as $detail)
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold text-gray-700">
                                                {{ $detail->product->product_name ?? 'Produk ID: '.$detail->product_id }}
                                            </p>
                                            <p class="text-sm text-gray-600">Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-blue-700">
                                                {{ $detail->quantity ?? 0 }} {{ $detail->product->unit ?? 'pcs' }}
                                            </p>
                                        </div>
                                    </div>
                                    @if($purchase->shipping_cost > 0)
                                        <p class="text-xs text-gray-700 mt-1 font-medium">
                                        Ongkir: Rp {{ number_format($purchase->shipping_cost, 0, ',', '.') }}
                                        </p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @empty
                            <div class="bg-white/50 rounded-xl p-6 text-center text-gray-500">
                                Belum ada transaksi pembelian
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-red-200 p-5 rounded-2xl shadow-lg hover:shadow-2xl hover:-translate-y-1 hover:scale-[1.01] transition-all duration-300 ease-in-out">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-xl text-gray-800">Transaksi Penjualan Terbaru</h3>
                            <span class="bg-white/70 px-3 py-1 rounded-full text-sm font-semibold text-red-700">
                                {{ $recentSales->count() }} Data
                            </span>
                        </div>

                        <div class="space-y-4">
                            @forelse($recentSales as $sale)
                            <div class="bg-white/50 backdrop-blur-md rounded-xl p-4 border border-white/40">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="text-sm text-gray-600">Nama Customer</p>
                                        <h4 class="font-bold text-lg text-gray-800">{{ $sale->customer_name ?? 'Pelanggan' }}</h4>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">Total</p>
                                        <p class="font-bold text-green-700">Rp {{ number_format($sale->total, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="border-t pt-3 space-y-2">
                                    <p class="text-sm text-gray-600">Produk yang Dibeli</p>
                                    @foreach($sale->details as $detail)
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold text-gray-700">
                                                {{ $detail->product->product_name ?? 'Produk ID: '.$detail->product_id }}
                                            </p>
                                            <p class="text-sm text-gray-600">Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-blue-700">
                                                {{ $detail->quantity ?? 0 }} {{ $detail->product->unit ?? 'pcs' }}
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @empty
                            <div class="bg-white/50 rounded-xl p-6 text-center text-gray-500">
                                Belum ada transaksi penjualan
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>