<x-layouts.app :title="'Daftar Produk'">
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-black">Daftar Produk</h1>
            <a href="{{ route('admin.products.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm transition">
                + Tambah Produk
            </a>
        </div>

        @if (session('successMessage'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('successMessage') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-300 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 w-12 text-left text-black font-medium">#</th>
                        <th class="px-4 py-3 w-24 text-left text-black font-medium">Gambar</th>
                        <th class="px-4 py-3 text-left text-black font-medium">Nama</th>
                        <th class="px-4 py-3 w-28 text-left text-black font-medium">SKU</th>
                        <th class="px-4 py-3 w-28 text-left text-black font-medium">Harga</th>
                        <th class="px-4 py-3 w-20 text-left text-black font-medium">Stok</th>
                        <th class="px-4 py-3 w-36 text-left text-black font-medium">Kategori</th>
                        <th class="px-4 py-3 w-32 text-left text-black font-medium">Status</th>
                        <th class="px-4 py-3 w-40 text-center text-black font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($products as $index => $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 align-middle text-black">{{ $products->firstItem() + $index }}</td>

                            <td class="px-4 py-3 align-middle">
                                @if ($product->image_url)
                                    <img 
                                        src="{{ Storage::url($product->image_url) }}" 
                                        alt="Gambar {{ $product->name }}" 
                                        class="h-12 w-12 object-cover rounded-md shadow-sm" 
                                        loading="lazy"
                                    >
                                @else
                                    <span class="text-gray-400 italic text-xs">No image</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 align-middle text-black">{{ $product->name }}</td>
                            <td class="px-4 py-3 align-middle text-black">{{ $product->sku }}</td>
                            <td class="px-4 py-3 align-middle text-black">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 align-middle text-black">{{ $product->stock }}</td>
                            <td class="px-4 py-3 align-middle text-black">
                                {{ $product->category ? $product->category->name : '-' }}
                            </td>
                            <td class="px-4 py-3 align-middle">
                                @if ($product->hub_product_id)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">Tersinkron</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">Belum Sinkron</span>
                                @endif
                                <br>
                                <span class="mt-1 block text-xs {{ $product->is_active ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center align-middle">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="px-2 py-1 bg-yellow-400 text-black rounded text-xs hover:bg-yellow-500 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.products.sync', $product->id) }}" method="POST" 
                                          onsubmit="return confirm('Sinkronisasi produk ini?')" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="px-2 py-1 bg-blue-600 text-black rounded text-xs hover:bg-blue-700 transition">
                                            {{ $product->hub_product_id ? 'Hapus Sinkronisasi' : 'Sinkronkan' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-6 text-center text-gray-500 italic">Tidak ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</x-layouts.app>
