<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/70 backdrop-blur-md rounded-xl px-6 py-4 shadow">
                <h2 class="font-semibold text-xl text-green-800 leading-tight">
                    {{ __('Edit Data Produk') }}
                </h2>
            </div>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-100 shadow-sm sm:rounded-lg p-6 bg-gradient-to-b from-white to-[#CDFFC7]">
                @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">Perubahan Oleh</label>
                        <input type="text" value="{{ Auth::user()->name ?? '-' }}" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">Nama Produk</label>
                        <input type="text" name="product_name" value="{{ old('product_name', $product->product_name ?? '') }}" class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">Kategori</label>
                        <select name="category" class="w-full border rounded px-3 py-2">
                            <option value="complement" {{ old('category', $product->category) == 'complement' ? 'selected' : '' }}>Complement</option>
                            <option value="finished product" {{ old('category', $product->category) == 'finished product' ? 'selected' : '' }}>Finished Product</option>
                            <option value="raw material" {{ old('category', $product->category) == 'raw material' ? 'selected' : '' }}>Raw Material</option>
                        </select>
                        @error('category')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">Sumber</label>
                        <select name="source_type" class="w-full border rounded px-3 py-2">
                            <option value="purchase" {{ old('source_type', $product->source_type) == 'purchase' ? 'selected' : '' }}>Purchase</option>
                            <option value="handmade" {{ old('source_type', $product->source_type) == 'handmade' ? 'selected' : '' }}>Handmade</option>
                            <option value="donation" {{ old('source_type', $product->source_type) == 'donation' ? 'selected' : '' }}>Donation</option>
                        </select>
                        @error('source_type')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">Satuan</label>
                        <select name="unit" class="w-full border rounded px-3 py-2">
                            <option value="pcs" {{ old('unit', $product->unit) == 'pcs' ? 'selected' : '' }}>Pcs</option>
                            <option value="kg" {{ old('unit', $product->unit) == 'kg' ? 'selected' : '' }}>Kg</option>
                            <option value="pack" {{ old('unit', $product->unit) == 'pack' ? 'selected' : '' }}>Pack</option>
                        </select>
                        @error('unit')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-gray-700 mb-1 text-left">Harga Jual</label>
                        <input type="text" id="selling_price_display" value="Rp {{ number_format(old('selling_price', $product->selling_price ?? 0), 0, ',', '.') }}" class="w-full border rounded px-3 py-2 bg-white text-left font-medium text-gray-600" required>
                        <input type="hidden" id="selling_price_value" name="selling_price" value="{{ old('selling_price', $product->selling_price ?? 0) }}">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-blue-700">
                            Update
                        </button>
                        <a href="{{ route('products.index') }}" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-gray-600">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function formatRupiah(angka) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
        }

        function dapatkanAngkaBersih(rupiahStr) {
            return Number(rupiahStr.replace(/[^0-9]/g, '')) || 0;
        }

        function calculatePrice() {
            let priceDisplay = document.getElementById('selling_price_display');
            let priceHidden = document.getElementById('selling_price_value');
            let rawPrice = priceDisplay.value;
            let cleanPriceValue = dapatkanAngkaBersih(rawPrice);
            priceHidden.value = cleanPriceValue;
            priceDisplay.value = formatRupiah(cleanPriceValue);
        }
        document.getElementById('selling_price_display').addEventListener('input', function() {
            calculatePrice();
        });
        document.getElementById('selling_price_display').addEventListener('blur', function(e) {
            if (e.target.value === '' || e.target.value === 'Rp ') {
                e.target.value = 'Rp 0';
                calculatePrice();
            }
        });
        calculatePrice();
    </script>
</x-app-layout>