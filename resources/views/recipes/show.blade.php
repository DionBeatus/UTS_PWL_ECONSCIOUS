<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/70 backdrop-blur-md rounded-xl px-6 py-4 shadow flex justify-between items-center">
                <h2 class="font-semibold text-xl text-green-800 leading-tight">
                    Detail Resep
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-blue-100 shadow-sm sm:rounded-lg p-6 bg-gradient-to-b from-white to-[#CDFFC7]">

                <div class="mb-6 bg-white/50 backdrop-blur-sm p-4 rounded-xl border border-green-100 shadow-sm">

                    <h3 class="text-sm font-bold text-green-800 uppercase tracking-wider mb-3">
                        Informasi Resep
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                        <div>
                            <span class="block text-gray-500 font-medium">
                                Produk Jadi:
                            </span>

                            <span class="text-base font-semibold text-gray-800">
                                {{ $recipe->product->product_name }}
                            </span>
                        </div>

                        <div>
                            <span class="block text-gray-500 font-medium">
                                ID Resep:
                            </span>

                            <span class="text-base font-semibold text-gray-800">
                                {{ $recipe->id }}
                            </span>
                        </div>

                        <div>
                            <span class="block text-gray-500 font-medium">
                                Perubahan Oleh:
                            </span>

                            <span class="text-base font-semibold text-gray-800">
                                {{ $recipe->user->name ?? '-' }}
                            </span>
                        </div>

                        <div>
                            <span class="block text-gray-500 font-medium">
                                Tanggal Dibuat:
                            </span>

                            <span class="text-base font-semibold text-gray-800">
                                {{ $recipe->created_at->format('d M Y') }}
                            </span>
                        </div>

                    </div>

                </div>

                <div class="overflow-hidden border border-green-200 rounded-xl shadow-sm bg-white">

                    <table class="w-full text-sm border-collapse">

                        <thead class="bg-green-50 text-green-800">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    Nama Bahan
                                </th>

                                <th class="px-4 py-3 text-center">
                                    Quantity
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($recipe->details as $detail)

                            <tr>
                                <td class="px-4 py-3 font-semibold text-green-700">
                                    {{ $detail->product->product_name }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    {{ $detail->quantity }}
                                </td>
                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="flex gap-2 mt-4">

                    <a href="{{ route('recipes.edit', $recipe->id) }}"
                        class="px-4 py-2 font-semibold bg-green-600 text-white rounded hover:bg-green-700">
                        Edit Resep
                    </a>

                    <a href="{{ route('recipes.index') }}"
                        class="px-4 py-2 font-semibold bg-orange-500 text-white rounded hover:bg-orange-600">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>