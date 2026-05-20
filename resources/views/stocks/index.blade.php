<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg text-green-700 font-bold">Daftar Stok Barang</h3>
                    <a href="{{ route('stocks.create') }}"
                        class="px-4 py-2 font-semibold bg-green-600 text-white rounded hover:bg-green-700 transition">
                        + Tambah Data Stok Awal
                    </a>
                </div>

                <form action="{{ route('stocks.index') }}" method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-3 bg-green-50 p-4 rounded-xl border border-green-200">
                    <div>
                        <label class="block text-sm font-medium text-green-800 mb-1">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full border-gray-300 rounded px-3 py-1.5 text-sm bg-white focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-green-800 mb-1">Kategori</label>
                        <select name="category" class="w-full border-gray-300 rounded px-3 py-1.5 text-sm bg-white focus:ring-green-500 focus:border-green-500">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $categoryName)
                            <option value="{{ $categoryName }}" @selected(request('category')==$categoryName)>
                                {{ $categoryName }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-green-800 mb-1">Status Stok</label>
                        <select name="status" class="w-full border-gray-300 rounded px-3 py-1.5 text-sm bg-white focus:ring-green-500 focus:border-green-500">
                            <option value="">Semua Status</option>
                            <option value="aman" @selected(request('status')=='aman' )>Aman</option>
                            <option value="menipis" @selected(request('status')=='menipis' )>Menipis</option>
                            <option value="habis" @selected(request('status')=='habis' )>Habis</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 px-4 py-1.5 font-semibold bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                            Cari & Filter
                        </button>
                        <a href="{{ route('stocks.index') }}" class="px-4 font-semibold py-1.5 bg-gray-400 text-white text-sm rounded hover:bg-gray-500 transition text-center">
                            Reset
                        </a>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300">
                        <thead class="bg-green-50 text-green-700">
                            <tr>
                                <th class="border px-4 py-2 text-left">No</th>
                                <th class="border px-4 py-2 text-left">PIC</th>
                                <th class="border px-4 py-2 text-left">Nama Produk</th>
                                <th class="border px-4 py-2 text-left">Kategori</th>
                                <th class="border px-4 py-2 text-center">Jumlah Stok</th>
                                <th class="border px-4 py-2 text-center">Status</th>
                                <th class="border px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stocks as $key => $stock)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $stocks->firstItem() + $key }}</td>
                                <td class="border px-4 py-2">{{ $stock->user->name ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $stock->product->product_name ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $stock->product->category ?? '-' }}</td>
                                <td class="border px-4 py-2 text-center">{{ $stock->quantity }}</td>
                                <td class="border px-4 py-2 text-center">
                                    @if($stock->status === 'Aman')
                                    <span class="px-2.5 py-1 bg-green-100 text-green-800 text-xs rounded-full font-semibold">Aman</span>
                                    @elseif($stock->status === 'Menipis')
                                    <span class="px-2.5 py-1 bg-orange-100 text-orange-800 text-xs rounded-full font-semibold">Menipis</span>
                                    @else
                                    <span class="px-2.5 py-1 bg-red-100 text-red-800 text-xs rounded-full font-semibold">Habis</span>
                                    @endif
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('stocks.edit', $stock->id) }}"
                                            class="px-3 font-semibold py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                            Edit
                                        </a>
                                        <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus data master stok untuk produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 font-semibold py-1 bg-orange-600 text-white rounded hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                    Tidak ditemukan data stok yang cocok.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $stocks->links() }}
                </div>
            </div>
            <img src="{{ asset('asset/bg.png') }}" class="h-450 pb-50 w-auto object-contain">
        </div>
    </div>
</x-app-layout>