<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Edit Barang
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow dark:bg-gray-800 sm:rounded-lg">

                <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Nama Barang</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
                            class="w-full p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">SKU</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                            class="w-full p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                            class="w-full p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300">Harga</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}"
                            class="w-full p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('products.index') }}"
                            class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
