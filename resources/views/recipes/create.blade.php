<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/70 backdrop-blur-md rounded-xl px-6 py-4 shadow">
                <h2 class="font-semibold text-xl text-green-800 leading-tight">
                    {{ __('Tambah Resep') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-blue-100 shadow-sm sm:rounded-lg p-6 bg-gradient-to-b from-white to-[#CDFFC7]">
                <form action="{{ route('recipes.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block font-medium mb-1 text-gray-700">
                                Produk Jadi
                            </label>
                            <select name="product_id" class="w-full border rounded px-3 py-2 bg-white">
                                <option value=""></option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium mb-1 text-gray-700">
                                Perubahan Oleh
                            </label>

                            <input type="text" value="{{ auth()->user()->name }}" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium mb-2 text-gray-700">
                            Bahan Penyusun
                        </label>

                        <div id="material-container" class="space-y-3">
                            <div class="flex gap-2 items-center bg-white p-3 rounded-lg border border-green-100 material-row">

                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Pilih Bahan</label>
                                    <select name="products[]" class="w-full border rounded px-3 py-2">
                                        <option value=""></option>
                                        @foreach($materials as $material)
                                        <option value="{{ $material->id }}">{{ $material->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="w-32">
                                    <input type="number" name="quantities[]" min="1" value="1" class="w-full border rounded px-3 py-2 text-center">
                                </div>

                                <button type="button" class="px-3 py-2 font-semibold bg-red-500 text-white rounded remove-material-btn">
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <button type="button" id="add-material-btn" class="mt-3 px-3 py-2 font-semibold bg-blue-600 text-white rounded hover:bg-blue-700">
                            + Tambah Bahan
                        </button>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 font-semibold bg-green-600 text-white rounded hover:bg-green-700">
                            Simpan Resep
                        </button>

                        <a href="{{ route('recipes.index') }}" class="px-4 py-2 font-semibold bg-orange-500 text-white rounded hover:bg-orange-600">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-material-btn')
            .addEventListener('click', function() {

                let container = document.getElementById('material-container');
                let firstRow = document.querySelector('.material-row');

                let newRow = firstRow.cloneNode(true);

                newRow.querySelector('select').value = '';
                newRow.querySelector('input').value = 1;

                container.appendChild(newRow);
            });

        document.getElementById('material-container')
            .addEventListener('click', function(e) {

                if (e.target.classList.contains('remove-material-btn')) {

                    let rows = document.querySelectorAll('.material-row');

                    if (rows.length > 1) {
                        e.target.closest('.material-row').remove();
                    } else {
                        alert('Minimal harus ada 1 bahan.');
                    }
                }
            });
    </script>
</x-app-layout>