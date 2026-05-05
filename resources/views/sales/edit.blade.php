<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/70 backdrop-blur-md rounded-xl px-6 py-4 shadow">
                <h2 class="font-semibold text-xl text-green-800 leading-tight">
                    {{ __('Edit Data Penjualan') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="bg-blue max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-100 shadow-sm sm:rounded-lg p-6 bg-gradient-to-b from-white to-[#CDFFC7]">
                <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Nama Customer</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', $sale->customer_name) }}"
                            class="w-full border rounded px-3 py-2">
                        @error('customer_name')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Email</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email', $sale->customer_email) }}"
                            class="w-full border rounded px-3 py-2">
                        @error('customer_email')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Nama Produk</label>
                        <select name="product_id" class="w-full border rounded px-3 py-2">
                            <option value="">Pilih Produk</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id', $sale->product_id) == $product->id)>
                                {{ $product->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('product_id')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Quantity</label>
                        <input type="number" name="quantity"
                            value="{{ old('quantity', $sale->quantity ?? '') }}"
                            class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Harga</label>
                        <input type="number" name="price"
                            value="{{ old('price', $sale->price) }}"
                            class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Total</label>
                        <input type="number" id="total"
                            value="{{ $sale->total }}"
                            class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-blue-700">
                            Update
                        </button>
                        <a href="{{ route('sales.index') }}"
                            class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-gray-600">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const qty = document.querySelector('input[name="quantity"]');
        const price = document.querySelector('input[name="price"]');
        const total = document.getElementById('total');

        function hitungTotal() {
            let q = Number(qty.value);
            let p = Number(price.value);

            if (isNaN(q)) q = 0;
            if (isNaN(p)) p = 0;

            total.value = q * p;
        }

        qty.addEventListener('input', hitungTotal);
        price.addEventListener('input', hitungTotal);
    </script>
</x-app-layout>