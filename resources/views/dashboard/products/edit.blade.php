<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Update Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage data Products</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('successMessage'))
        <div class="mb-3 w-full rounded bg-lime-100 border border-lime-400 text-lime-800 px-4 py-3">
            {{ session()->get('successMessage') }}
        </div>
    @elseif(session()->has('errorMessage'))
        <flux:badge color="red" class="mb-3 w-full">{{ session()->get('errorMessage') }}</flux:badge>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @method('patch')
        @csrf

        <flux:input label="Name" name="name" id="name" value="{{ old('name', $product->name) }}" class="mb-3" />

        <flux:input label="Slug" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" class="mb-3" />

        <flux:input label="SKU" name="sku" value="{{ old('sku', $product->sku) }}" class="mb-3" />

        <flux:input label="Price" name="price" value="{{ old('price', $product->price) }}" class="mb-3" />

        <flux:input label="Stock" name="stock" value="{{ old('stock', $product->stock) }}" class="mb-3" />

        <flux:select label="Category" name="product_category_id" class="mb-3">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ (old('product_category_id', $product->product_category_id) == $category->id) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </flux:select>

        <flux:textarea label="Description" name="description" class="mb-3">{{ old('description', $product->description) }}</flux:textarea>

        @if($product->image_url)
            <div class="mb-3">
                <img src="{{ Storage::url($product->image_url) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded" />
            </div>
        @endif

        <flux:input type="file" label="Image" name="image" class="mb-3" />

        <flux:checkbox label="Active" name="is_active" class="mb-6" {{ old('is_active', $product->is_active) ? 'checked' : '' }} />

        <flux:separator variant="subtle" />

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Update</flux:button>
            <flux:link href="{{ route('products.index') }}" variant="ghost" class="ml-3">Back</flux:link>
        </div>
    </form>

    <script>
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        function slugify(text) {
            return text.toString().toLowerCase()
                .trim()
                .replace(/\s+/g, '-')       // Ganti spasi dengan dash
                .replace(/[^\w\-]+/g, '')   // Hapus karakter non-alphanumeric
                .replace(/\-\-+/g, '-')     // Ganti multiple dash dengan satu
                .replace(/^-+/, '')         // Hapus dash di awal
                .replace(/-+$/, '');        // Hapus dash di akhir
        }

        // Cegah overwrite jika user sudah edit slug manual
        let isSlugEditedManually = false;

        slugInput.addEventListener('input', () => {
            isSlugEditedManually = true;
        });

        nameInput.addEventListener('input', () => {
            if (!isSlugEditedManually) {
                slugInput.value = slugify(nameInput.value);
            }
        });
    </script>
</x-layouts.app>
