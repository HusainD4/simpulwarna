<x-layouts.app :title="'Tambah Produk'">
    <div class="container mx-auto px-4 py-6 text-black">
        <h1 class="text-2xl font-semibold mb-4">Tambah Produk</h1>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block font-medium">Nama Produk</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="border rounded w-full p-2 text-black" 
                    value="{{ old('name') }}"
                    required>
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="block font-medium">Slug</label>
                <input 
                    type="text" 
                    name="slug" 
                    id="slug" 
                    class="border rounded w-full p-2 text-black bg-gray-100" 
                    value="{{ old('slug') }}" 
                    readonly disabled>
            </div>

            <div>
                <label for="description" class="block font-medium">Deskripsi</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4" 
                    class="border rounded w-full p-2 text-black" 
                    required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="sku" class="block font-medium">SKU</label>
                <input 
                    type="text" 
                    name="sku" 
                    id="sku" 
                    class="border rounded w-full p-2 text-black" 
                    value="{{ old('sku') }}">
                @error('sku')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="block font-medium">Harga</label>
                <input 
                    type="number" 
                    name="price" 
                    id="price" 
                    class="border rounded w-full p-2 text-black" 
                    value="{{ old('price') }}" 
                    required 
                    min="0" 
                    step="0.01">
                @error('price')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stock" class="block font-medium">Stok</label>
                <input 
                    type="number" 
                    name="stock" 
                    id="stock" 
                    class="border rounded w-full p-2 text-black" 
                    value="{{ old('stock') }}" 
                    required 
                    min="0">
                @error('stock')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="product_category_id" class="block font-medium">Kategori Produk</label>
                <select 
                    name="product_category_id" 
                    id="product_category_id" 
                    class="border rounded w-full p-2 text-black" 
                    required>
                    <option value="" disabled {{ old('product_category_id') ? '' : 'selected' }}>Pilih kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_category_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block font-medium">Gambar Produk</label>
                <input 
                    type="file" 
                    name="image" 
                    id="image" 
                    class="border rounded w-full p-2 text-black" 
                    accept="image/*">
                @error('image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input type="hidden" name="is_active" value="0">
                <label class="inline-flex items-center">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        value="1" 
                        class="form-checkbox text-black" 
                        {{ old('is_active', 1) ? 'checked' : '' }}>
                    <span class="ml-2">Aktif</span>
                </label>
            </div>

            <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                Simpan
            </button>
        </form>
    </div>

    <script>
        document.getElementById('name').addEventListener('input', function () {
            const slugInput = document.getElementById('slug');
            const slug = this.value.toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
            slugInput.value = slug;
        });
    </script>
</x-layouts.app>
