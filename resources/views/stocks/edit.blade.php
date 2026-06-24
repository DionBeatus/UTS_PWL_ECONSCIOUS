<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/70 backdrop-blur-md rounded-xl px-6 py-4 shadow">
                <h2 class="font-semibold text-xl text-green-800 leading-tight">
                    {{ __('Edit Data Stok Produk') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-100 shadow-sm sm:rounded-lg p-6 bg-gradient-to-b from-white to-[#CDFFC7]">
                <form action="{{ route('stocks.update', $stock->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">Perubahan Oleh</label>
                        <input type="text"
                            value="{{ Auth::user()->name ?? '-' }}"
                            class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">Nama Produk</label>
                        <input type="text" value="{{ $stock->product->product_name }}" class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-600 font-medium" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">Jumlah Stok</label>
                        <input type="number" name="quantity" min="0" value="{{ old('quantity', $stock->quantity) }}"
                            class="w-full border rounded px-3 py-2 bg-white focus:ring-green-500 focus:border-green-500" required>
                        @error('quantity')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                            Update Stok
                        </button>
                        <a href="{{ route('stocks.index') }}" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>