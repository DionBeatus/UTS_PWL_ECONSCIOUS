<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            {{ __('Edit Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-100 shadow-sm sm:rounded-lg p-6" style="background: linear-gradient(180deg, white, #CDFFC7)">

                <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Tanggal Pembelian</label>
                        <input type="date" name="purchase_date"
                            value="{{ old('purchase_date', $purchase->purchase_date) }}"
                            class="w-full border rounded px-3 py-2">
                        @error('purchase_date')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Nama Store</label>
                        <input type="text" name="store_name"
                            value="{{ old('store_name', $purchase->store_name) }}"
                            class="w-full border rounded px-3 py-2">
                        @error('store_name')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">User</label>
                        <input type="text"
                            value="{{ $purchase->user->name ?? '-' }}"
                            class="w-full border rounded px-3 py-2 bg-gray-100"
                            readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Produk</label>
                        <select name="product_id" class="w-full border rounded px-3 py-2">
                            @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                @selected(old('product_id', $purchase->product_id) == $product->id)>
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
                            value="{{ old('quantity', $purchase->quantity) }}"
                            class="w-full border rounded px-3 py-2">
                        @error('quantity')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Harga</label>
                        <input type="number" name="price"
                            value="{{ old('price', $purchase->price) }}"
                            class="w-full border rounded px-3 py-2">
                        @error('price')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Total</label>
                        <input type="number" id="total"
                            value="{{ $purchase->total }}"
                            class="w-full border rounded px-3 py-2 bg-gray-100"
                            readonly>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-blue-700">
                            Update
                        </button>

                        <a href="{{ route('purchases.index') }}"
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