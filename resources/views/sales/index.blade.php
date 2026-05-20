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
                    <h3 class="text-lg text-green-700 font-bold">Daftar Transaksi Penjualan</h3>

                    <a href="{{ route('sales.create') }}"
                        class="px-4 py-2 font-semibold bg-green-600 text-white rounded hover:bg-green-700">
                        + Tambah Transaksi Penjualan
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300">
                        <thead class="bg-green-50 text-green-700">
                            <tr>
                                <th class="border px-4 py-2 text-left">No</th>
                                <th class="border px-4 py-2 text-left">Tanggal Penjualan</th>
                                <th class="border px-4 py-2 text-left">PIC</th>
                                <th class="border px-4 py-2 text-left">Nama Customer</th>
                                <th class="border px-4 py-2 text-left">Email</th>
                                <th class="border px-4 py-2 text-left">Total</th>
                                <th class="border px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($sales as $key => $sale)
                            <tr>
                                <td class="border px-4 py-2">
                                    {{ $sales->firstItem() + $key }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $sale->sale_date }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $sale->user->name }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $sale->customer_name }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $sale->customer_email }}
                                </td>

                                <td class="border px-4 py-2">
                                    Rp {{ number_format($sale->total,0,',','.') }}
                                </td>

                                <td class="border px-4 py-2 flex justify-center gap-2">
                                    <a href="{{ route('sales.show', $sale->id) }}"
                                        class="px-3 font-semibold py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        Detail
                                    </a>

                                    <form action="{{ route('sales.destroy', $sale->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="px-3 py-1 font-semibold bg-orange-600 text-white rounded hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    Tidak ada data transaksi penjualan yang ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>