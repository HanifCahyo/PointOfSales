<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Transaksi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow dark:bg-gray-800 sm:rounded-lg">

                <!-- Alert untuk error -->
                @if (session('error'))
                    <div
                        class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded dark:bg-red-900 dark:text-red-300 dark:border-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Form transaksi -->
                <form method="POST" action="{{ route('transactions.store') }}" class="mb-6">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">
                        @foreach ($products as $p)
                            <div class="p-3 border rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200">{{ $p->name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Stok: {{ $p->stock }}</p>
                                <p class="font-bold text-gray-800 dark:text-gray-200">Rp {{ number_format($p->price) }}
                                </p>
                                <input type="hidden" name="products[{{ $loop->index }}][id]"
                                    value="{{ $p->id }}">
                                <input type="number" name="products[{{ $loop->index }}][qty]"
                                    class="w-full p-2 mt-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-blue-500"
                                    placeholder="Qty">
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded shadow hover:bg-green-700">
                        Simpan Transaksi
                    </button>
                </form>

                <!-- Tabel transaksi -->
                <div class="overflow-x-auto">
                    <table
                        class="min-w-full overflow-hidden text-sm border border-gray-300 rounded-lg dark:border-gray-700">
                        <thead class="text-gray-800 bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Invoice</th>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-right">Total</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900 bg-white dark:bg-gray-800 dark:text-gray-100">
                            @forelse($transactions as $t)
                                <tr class="transition hover:bg-gray-200 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2">{{ $t->invoice_number }}</td>
                                    <td class="px-4 py-2">{{ $t->date }}</td>
                                    <td class="px-4 py-2 text-right">Rp
                                        {{ number_format($t->total_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('transactions.invoice', $t->id) }}" target="_blank"
                                            class="px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700">
                                            Cetak PDF
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada data transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
