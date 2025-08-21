<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Data Barang
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow dark:bg-gray-800 sm:rounded-lg">

                <!-- Form Tambah Barang -->
                <form action="{{ route('products.store') }}" method="POST" class="flex flex-wrap gap-3 mb-6">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Barang"
                        class="border rounded p-2 flex-1 min-w-[180px]
                               bg-gray-50 dark:bg-gray-700 dark:text-white
                               focus:ring-2 focus:ring-blue-500"
                        required>

                    <input type="text" name="sku" placeholder="SKU"
                        class="w-32 p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500"
                        required>

                    <input type="number" name="stock" placeholder="Stok"
                        class="w-24 p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500"
                        required>

                    <input type="number" name="price" placeholder="Harga"
                        class="w-40 p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500"
                        required>

                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded shadow hover:bg-blue-700">
                        Tambah
                    </button>
                </form>

                <!-- Table Barang -->
                <div class="overflow-x-auto">
                    <table
                        class="min-w-full overflow-hidden text-sm border border-gray-300 rounded-lg dark:border-gray-700">
                        <thead class="text-gray-800 bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Nama</th>
                                <th class="px-4 py-2 text-left">SKU</th>
                                <th class="px-4 py-2 text-center">Stok</th>
                                <th class="px-4 py-2 text-right">Harga</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900 bg-white dark:bg-gray-800 dark:text-gray-100">
                            @forelse($products as $p)
                                <tr class="transition hover:bg-gray-200 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2">{{ $p->name }}</td>
                                    <td class="px-4 py-2">{{ $p->sku }}</td>
                                    <td class="px-4 py-2 text-center">{{ $p->stock }}</td>
                                    <td class="px-4 py-2 text-right">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                    <td class="flex justify-center gap-2 px-4 py-2 text-center">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('products.edit', $p->id) }}"
                                            class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        <!-- Tombol Delete -->
                                        <form action="{{ route('products.destroy', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus barang ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada data barang.
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
