<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg text-green-700 font-bold">Daftar Produk</h3>

                    <a href="{{ route('products.create') }}"
                        class="px-4 py-2 font-semibold bg-green-600 text-white rounded hover:bg-green-700">
                        + Tambah Produk
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300">
                        <thead class="bg-green-50 text-green-700">
                            <tr>
                                <th class="border px-4 py-2 text-left">No</th>
                                <th class="border px-4 py-2 text-left">Perubahan Oleh</th>
                                <th class="border px-4 py-2 text-left">Nama Produk</th>
                                <th class="border px-4 py-2 text-left">Kategori</th>
                                <th class="border px-4 py-2 text-left">Sumber</th>
                                <th class="border px-4 py-2 text-left">Satuan</th>
                                <th class="border px-4 py-2 text-left">Harga Jual</th>
                                <th class="border px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($products as $key => $product)
                            <tr>
                                <td class="border px-4 py-2">
                                    {{ $products->firstItem() + $key }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $product->user->name }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $product->product_name }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $product->category }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $product->source_type }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $product->unit }}
                                </td>

                                <td class="border px-4 py-2">
                                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                </td>

                                <td class="border px-4 py-2 flex justify-center gap-2">

                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="px-3 font-semibold py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Edit
                                    </a>

                                    <form action="{{ route('products.destroy', $product->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="px-3 font-semibold py-1 bg-orange-600 text-white rounded hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    Belum ada data produk
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>

            <img src="{{ asset('asset/bg.png') }}" class="h-450 pb-50 w-auto object-contain">

        </div>
    </div>

</x-app-layout>