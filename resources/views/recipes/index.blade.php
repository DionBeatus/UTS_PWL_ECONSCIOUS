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
                    <h3 class="text-lg text-green-700 font-bold">
                        Daftar Resep Produk
                    </h3>

                    <a href="{{ route('recipes.create') }}"
                        class="px-4 py-2 font-semibold bg-green-600 text-white rounded hover:bg-green-700">
                        + Tambah Resep
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300">

                        <thead class="bg-green-50 text-green-700">
                            <tr>
                                <th class="border px-4 py-2 text-left">No</th>
                                <th class="border px-4 py-2 text-left">Produk Jadi</th>
                                <th class="border px-4 py-2 text-left">Perubahan Oleh</th>
                                <th class="border px-4 py-2 text-center">Jumlah Bahan</th>
                                <th class="border px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($recipes as $key => $recipe)

                            <tr>
                                <td class="border px-4 py-2">
                                    {{ $recipes->firstItem() + $key }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $recipe->product->product_name }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $recipe->user->name ?? '-' }}
                                </td>

                                <td class="border px-4 py-2 text-center">
                                    {{ $recipe->details->count() }}
                                </td>

                                <td class="border px-4 py-2 flex justify-center gap-2">

                                    <a href="{{ route('recipes.show', $recipe->id) }}"
                                        class="px-3 font-semibold py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        Detail
                                    </a>

                                    <form action="{{ route('recipes.destroy', $recipe->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin hapus resep ini?')">

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
                                <td colspan="5"
                                    class="px-4 py-2 text-center text-gray-500">
                                    Tidak ada data resep yang ditemukan.
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

                <div class="mt-4">
                    {{ $recipes->links() }}
                </div>

            </div>
        </div>
    </div>

</x-app-layout>