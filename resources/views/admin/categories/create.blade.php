{{-- resources/views/admin/categories/create.blade.php --}}
<x-layouts.app :title="__('Add Category')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Add New Product Category</flux:heading>
        <flux:subheading size="lg" class="mb-6">Create a new product category</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('successMessage'))
        <div class="mb-3 w-full rounded bg-lime-100 border border-lime-400 text-lime-800 px-4 py-3">
            {{ session()->get('successMessage') }}
        </div>
    @elseif(session()->has('errorMessage'))
        <flux:badge color="red" class="mb-3 w-full">{{ session()->get('errorMessage') }}</flux:badge>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <flux:input label="Name" name="name" id="name" value="{{ old('name') }}" class="mb-3" />
        <flux:input label="Slug" name="slug" id="slug" value="{{ old('slug') }}" class="mb-3" />
        <flux:textarea label="Description" name="description" class="mb-3">{{ old('description') }}</flux:textarea>
        <flux:input type="file" label="Image" name="image" class="mb-3" />

        <flux:separator />

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Simpan</flux:button>
            <flux:link href="{{ route('admin.categories.index') }}" variant="ghost" class="ml-3">Kembali</flux:link>
        </div>
    </form>

    {{-- Script untuk otomatis generate slug --}}
    <script>
        document.getElementById('name').addEventListener('input', function () {
            let name = this.value;
            let slug = name.toLowerCase()
                .replace(/[^\w\s-]/g, '')     // Hapus karakter selain huruf, angka, spasi, -
                .trim()
                .replace(/\s+/g, '-')         // Ganti spasi dengan -
                .replace(/--+/g, '-');        // Hapus multiple tanda -
            document.getElementById('slug').value = slug;
        });
    </script>
</x-layouts.app>
