<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/70 backdrop-blur-md rounded-xl px-6 py-4 shadow">
                <h2 class="font-semibold text-xl text-green-800 leading-tight">
                    {{ __('Tambah Data Stok Produk') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-100 shadow-sm sm:rounded-lg p-6 bg-gradient-to-b from-white to-[#CDFFC7]">
                <form action="{{ route('stocks.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">PIC</label>
                        <input type="text"
                            value="{{ Auth::user()->name ?? '-' }}"
                            class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">Nama Produk</label>
                        <select name="product_id" class="w-full border rounded px-3 py-2 bg-white focus:ring-green-500 focus:border-green-500" required>
                            <option value=""></option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id')==$product->id)>
                                {{ $product->product_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('product_id')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">Jumlah Stok</label>
                        <input type="number" name="quantity" min="0" value="{{ old('quantity', '') }}"
                            class="w-full border rounded px-3 py-2 bg-white focus:ring-green-500 focus:border-green-500" required>
                        @error('quantity')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                            Simpan Data Stok
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