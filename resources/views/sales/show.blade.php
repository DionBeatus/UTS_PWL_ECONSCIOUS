        <x-app-layout>
            <x-slot name="header">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white/70 backdrop-blur-md rounded-xl px-6 py-4 shadow flex justify-between items-center">
                        <h2 class="font-semibold text-xl text-green-800 leading-tight">
                            {{ __('Detail Transaksi Penjualan') }}
                        </h2>
                    </div>
                </div>
            </x-slot>

            <div class="py-6">
                <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-blue-100 shadow-sm sm:rounded-lg p-6 bg-gradient-to-b from-white to-[#CDFFC7]">

                        <div class="mb-6 bg-white/50 backdrop-blur-sm p-4 rounded-xl border border-green-100 shadow-sm">
                            <h3 class="text-sm font-bold text-green-800 uppercase tracking-wider mb-3">Informasi Transaksi Penjualan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="block text-gray-500 font-medium">Nama Customer:</span>
                                    <span class="text-base font-semibold text-gray-800">
                                        <td class="border px-4 py-2">
                                            {{ $sale->customer_name }}
                                        </td>
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-gray-500 font-medium">Email Pelanggan:</span>
                                    <span class="text-base font-semibold text-gray-800">{{ $sale->customer_email }}</span>
                                </div>
                                <div class="mt-1">
                                    <span class="block text-gray-500 font-medium">No. WhatsApp:</span>
                                    <span class="text-base font-semibold text-gray-800">{{ $sale->customer_phone }}</span>
                                </div>
                                <div class="mt-1">
                                    <span class="block text-gray-500 font-medium">Tanggal Penjualan:</span>
                                    <span class="text-base font-semibold text-gray-800">{{ $sale->sale_date }}</span>
                                </div>
                                <div class="mt-1">
                                    <span class="block text-gray-500 font-medium">Perubahan Oleh:</span>
                                    <span class="text-base font-semibold text-gray-800">{{ $sale->user->name ?? 'Admin' }}</span>
                                </div>
                                <div>
                                    <span class="block text-gray-500 font-medium">ID. Transaksi:</span>
                                    <span class="text-base font-semibold text-gray-800">{{ $sale->id }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2 text-center">Item Yang Dibeli</h3>
                            <div class="overflow-hidden border border-green-200 rounded-xl shadow-sm bg-white">
                                <table class="w-full text-sm border-collapse">
                                    <thead class="bg-green-50 text-green-800 border-b border-green-100 font-bold">
                                        <tr>
                                            <th class="px-4 py-3 text-left">Nama Produk</th>
                                            <th class="px-4 py-3 text-center">Harga Satuan</th>
                                            <th class="px-4 py-3 text-center">Quantity</th>
                                            <th class="px-4 py-3 text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 text-gray-700">
                                        @foreach($sale->details as $detail)
                                        <tr class="hover:bg-green-50/20 transition">
                                            <td class="px-4 py-3 font-semibold text-green-700">
                                                {{ $detail->product->product_name ?? 'Tidak Ada Produk Yang Dibeli' }}
                                            </td>
                                            <td class="px-4 py-3 text-center text-gray-600">
                                                Rp {{ number_format($detail->price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-3 text-center font-medium">
                                                {{ $detail->quantity }}
                                            </td>
                                            <td class="px-4 py-3 text-right font-bold text-gray-800">
                                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-green-50/40 border-t border-green-200 font-bold text-base">
                                        <tr>
                                            <td colspan="3" class="px-4 py-3 text-right text-gray-700">Total Keseluruhan:</td>
                                            <td class="px-4 py-3 text-right text-green-800 font-extrabold text-lg">
                                                Rp {{ number_format($sale->total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('sales.edit', $sale->id) }}"
                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition font-medium">
                                Edit Transaksi
                            </a>

                            <a href="{{ route('sales.index') }}"
                                class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition font-medium">
                                Kembali
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </x-app-layout>