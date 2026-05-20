<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/70 backdrop-blur-md rounded-xl px-6 py-4 shadow">
                <h2 class="font-semibold text-xl text-green-800 leading-tight">
                    {{ __('Tambah Transaksi Penjualan') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-100 shadow-sm sm:rounded-lg p-6 bg-gradient-to-b from-white to-[#CDFFC7]">
                <form action="{{ route('sales.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">PIC</label>
                        <input type="text"
                            value="{{ Auth::user()->name ?? '-' }}"
                            class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">
                            Tanggal Penjualan
                        </label>

                        <input type="date"
                            name="sale_date"
                            value="{{ old('sale_date', date('Y-m-d')) }}"
                            class="w-full border rounded px-3 py-2 bg-white focus:ring-green-500 focus:border-green-500">

                        @error('sale_date')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1 text-gray-700">Nama Customer</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                            class="w-full border rounded px-3 py-2 bg-white focus:ring-green-500 focus:border-green-500">
                        @error('customer_name')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-medium mb-1 text-gray-700">Email</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email') }}"
                                class="w-full border rounded px-3 py-2 bg-white focus:ring-green-500 focus:border-green-500">
                            @error('customer_email')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-medium mb-1 text-gray-700">No. HP</label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone') }}"
                                class="w-full border rounded px-3 py-2 bg-white focus:ring-green-500 focus:border-green-500">
                            @error('customer_phone')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium mb-2 text-gray-700">Produk yang Dibeli</label>
                        <div id="product-container" class="space-y-3">
                            <div class="flex flex-wrap md:flex-nowrap gap-2 items-center bg-white p-3 rounded-lg border border-green-100 product-row">
                                <div class="flex-1 min-w-[200px]">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Pilih Produk</label>
                                    <select name="products[]" class="w-full border rounded px-3 py-2 bg-white product-select" required>
                                        <option value=""></option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}">
                                            {{ $product->product_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-36">
                                    <label class="block text-xs font-medium text-gray-500 mb-1 text-center">Harga Jual</label>
                                    <input type="text" class="w-full border rounded px-3 py-2 bg-gray-50 text-center price-display font-medium text-gray-600" readonly value="Rp 0">
                                </div>
                                <div class="w-24">
                                    <label class="block text-xs font-medium text-gray-500 mb-1 text-center">Quantity</label>
                                    <input type="number" name="quantities[]" min="1" value="1"
                                        class="w-full border rounded px-3 py-2 bg-white text-center quantity-input font-medium" required>
                                </div>
                                <div class="w-36">
                                    <label class="block text-xs font-medium text-gray-500 mb-1 text-center">Subtotal</label>
                                    <input type="text" class="w-full border rounded px-3 py-2 bg-gray-50 text-center row-subtotal font-bold text-gray-800" readonly value="Rp 0">
                                </div>
                                <div class="pt-5">
                                    <button type="button" class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-sm remove-product-btn">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-product-btn" class="mt-3 px-3 py-1.5 bg-blue-600 text-white rounded text-sm font-medium hover:bg-blue-700 transition">
                            + Tambah Produk Berbeda
                        </button>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1 text-gray-600">Total</label>
                        <input type="text" id="grand_total_display" class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-800 font-bold text-lg" readonly value="Rp 0">
                        <input type="hidden" id="grand_total_value" name="total" value="0">
                    </div>

                    <div class="flex gap-2 border-t pt-4 border-green-200">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition font-medium">
                            Simpan Transaksi
                        </button>
                        <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600 transition font-medium">
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

        function calculateRowAndTotal() {
            let grandTotal = 0;
            document.querySelectorAll('.product-row').forEach(function(row) {
                let select = row.querySelector('.product-select');
                let qtyInput = row.querySelector('.quantity-input');
                let priceDisplay = row.querySelector('.price-display');
                let subtotalDisplay = row.querySelector('.row-subtotal');

                let selectedOption = select.options[select.selectedIndex];
                let price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                let qty = parseInt(qtyInput.value) || 0;
                let subtotal = price * qty;

                priceDisplay.value = formatRupiah(price);
                subtotalDisplay.value = formatRupiah(subtotal);

                grandTotal += subtotal;
            });

            document.getElementById('grand_total_display').value = formatRupiah(grandTotal);
            document.getElementById('grand_total_value').value = grandTotal;
        }

        document.getElementById('product-container').addEventListener('input', function(e) {
            if (e.target.classList.contains('product-select') || e.target.classList.contains('quantity-input')) {
                calculateRowAndTotal();
            }
        });

        document.getElementById('add-product-btn').addEventListener('click', function() {
            let container = document.getElementById('product-container');
            let rows = container.querySelectorAll('.product-row');
            let firstRow = rows[0];

            let newRow = firstRow.cloneNode(true);
            newRow.querySelector('.product-select').value = '';
            newRow.querySelector('.price-display').value = 'Rp 0';
            newRow.querySelector('.quantity-input').value = 1;
            newRow.querySelector('.row-subtotal').value = 'Rp 0';

            container.appendChild(newRow);
            calculateRowAndTotal();
        });

        document.getElementById('product-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-product-btn')) {
                let container = document.getElementById('product-container');
                if (container.querySelectorAll('.product-row').length > 1) {
                    e.target.closest('.product-row').remove();
                    calculateRowAndTotal();
                } else {
                    alert('Minimal harus ada 1 produk dalam transaksi!');
                }
            }
        });
    </script>
</x-app-layout>