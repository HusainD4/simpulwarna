<x-layouts.app :title="'Edit Produk'">
    <div class="container mx-auto px-4 py-6 text-black">
        <h1 class="text-2xl font-semibold mb-4">Edit Produk</h1>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-medium">Nama Produk</label>
                <input type="text" name="name" id="name" class="border rounded w-full p-2 text-black"
                    value="{{ old('name', $product->name) }}" required>
            </div>

            <div>
                <label for="slug" class="block font-medium">Slug</label>
                <input type="text" name="slug" id="slug" class="border rounded w-full p-2 text-black bg-gray-100"
                    value="{{ $product->slug }}" readonly disabled>
            </div>

            <div>
                <label for="description" class="block font-medium">Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="border rounded w-full p-2 text-black"
                    required>{{ old('description', $product->description) }}</textarea>
            </div>

            <div>
                <label for="sku" class="block font-medium">SKU</label>
                <input type="text" name="sku" id="sku" class="border rounded w-full p-2 text-black"
                    value="{{ old('sku', $product->sku) }}" required>
            </div>

            <div>
                <label for="price" class="block font-medium">Harga</label>
                <input type="number" name="price" id="price" class="border rounded w-full p-2 text-black"
                    value="{{ old('price', $product->price) }}" required min="0" step="0.01">
            </div>

            <div>
                <label for="stock" class="block font-medium">Stok</label>
                <input type="number" name="stock" id="stock" class="border rounded w-full p-2 text-black"
                    value="{{ old('stock', $product->stock) }}" required min="0">
            </div>

            <div>
                <label for="product_category_id" class="block font-medium">Kategori Produk</label>
                <select name="product_category_id" id="product_category_id" class="border rounded w-full p-2 text-black" required>
                    <option value="" disabled selected>Pilih kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->product_category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="image" class="block font-medium">Gambar Produk</label>
                <input type="file" name="image" id="image" class="border rounded w-full p-2 text-black" accept="image/*">
                @if ($product->image_url)
                    <p class="mt-1 text-sm">Gambar saat ini: <a href="{{ asset('storage/'.$product->image_url) }}" target="_blank" class="text-blue-600 underline">Lihat</a></p>
                @endif
            </div>

            <div>
                <input type="hidden" name="is_active" value="0">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="form-checkbox text-black"
                        {{ $product->is_active ? 'checked' : '' }}>
                    <span class="ml-2">Aktif</span>
                </label>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update
            </button>
        </form>
    </div>

    <script>
        document.getElementById('name').addEventListener('input', function () {
            const slugInput = document.getElementById('slug');
            const slug = this.value.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
            slugInput.value = slug;
        });
    </script>
</x-layouts.app>
