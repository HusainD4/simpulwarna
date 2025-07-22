<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Add New Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage data Products</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- Flash Messages --}}
    @if(session()->has('successMessage'))
        <div class="mb-3 w-full rounded bg-lime-100 border border-lime-400 text-lime-800 px-4 py-3">
            {{ session()->get('successMessage') }}
        </div>
    @elseif(session()->has('errorMessage'))
        <flux:badge color="red" class="mb-3 w-full">
            {{ session()->get('errorMessage') }}
        </flux:badge>
    @endif

    {{-- Form --}}
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <flux:input label="Name" name="name" class="mb-3" value="{{ old('name') }}" id="product-name" />
        @error('name')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        <flux:input label="Slug" name="slug" class="mb-3" value="{{ old('slug') }}" id="product-slug" readonly />
        @error('slug')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        <flux:input label="SKU" name="sku" class="mb-3" value="{{ old('sku') }}" />
        @error('sku')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        <flux:input label="Price" name="price" class="mb-3" value="{{ old('price') }}" />
        @error('price')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        <flux:input label="Stock" name="stock" class="mb-3" value="{{ old('stock') }}" />
        @error('stock')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        <flux:select label="Category" name="product_category_id" class="mb-3">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </flux:select>
        @error('product_category_id')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        <flux:textarea label="Description" name="description" class="mb-3">{{ old('description') }}</flux:textarea>
        @error('description')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        <flux:input type="file" label="Image" name="image" class="mb-3" />
        @error('image')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        <flux:checkbox label="Active" name="is_active" class="mb-6" {{ old('is_active', true) ? 'checked' : '' }} />
        @error('is_active')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        <flux:separator />

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Simpan</flux:button>
            <flux:link href="{{ route('products.index') }}" variant="ghost" class="ml-3">Kembali</flux:link>
        </div>
    </form>

    {{-- Slugify Script --}}
    <script>
        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start
                .replace(/-+$/, '');            // Trim - from end
        }

        document.getElementById('product-name').addEventListener('input', function () {
            const name = this.value;
            const slug = slugify(name);
            document.getElementById('product-slug').value = slug;
        });
    </script>
</x-layouts.app>
