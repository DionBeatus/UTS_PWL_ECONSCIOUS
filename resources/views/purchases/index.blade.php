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
                    <h3 class="text-lg text-green-700 font-bold">Daftar Pembelian</h3>
                    <a href="{{ route('purchases.create') }}"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        + Tambah Pembelian
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300">
                        <thead class="bg-green-50 text-green-700">
                            <tr>
                                <th class="border px-4 py-2 text-left">No</th>
                                <th class="border px-4 py-2 text-left">Tanggal</th>
                                <th class="border px-4 py-2 text-left">Store</th>
                                <th class="border px-4 py-2 text-left">Pembeli</th>
                                <th class="border px-4 py-2 text-left">Produk</th>
                                <th class="border px-4 py-2 text-left">Jumlah</th>
                                <th class="border px-4 py-2 text-left">Harga</th>
                                <th class="border px-4 py-2 text-left">Total</th>
                                <th class="border px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($purchases as $key => $purchase)
                            <tr>
                                <td class="border px-4 py-2">{{ $purchases->firstItem() + $key }}</td>
                                <td class="border px-4 py-2">{{ $purchase->purchase_date }}</td>
                                <td class="border px-4 py-2">{{ $purchase->store_name }}</td>
                                <td class="border px-4 py-2">{{ $purchase->user->name ?? '-'}}</td>
                                <td class="border px-4 py-2">{{ $purchase->product->name ?? '-'}}</td>
                                <td class="border px-4 py-2">{{ $purchase->quantity }}</td>
                                <td class="border px-4 py-2">Rp {{ number_format($purchase->price,0,',','.') }}</td>
                                <td class="border px-4 py-2">Rp {{ number_format($purchase->total,0,',','.') }}</td>
                                <td class="border px-4 py-2 flex gap-2">
                                    <a href="{{ route('purchases.edit', $purchase->id) }}"
                                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Edit
                                    </a>
                                    <form action="{{ route('purchases.destroy', $purchase->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin hapus data pembelian ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-orange-600 text-white rounded hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-4 py-2 text-center text-gray-500">
                                    Belum ada data pembelian.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $purchases->links() }}
                </div>
            </div>
            <img src="{{ asset('asset/bg.png') }}" class="h-450 pb-50 w-auto object-contain">
        </div>
    </div>
</x-app-layout>