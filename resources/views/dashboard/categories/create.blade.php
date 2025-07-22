<x-layouts.app :title="__('Categories')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Add New Product Categories</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage data Product Categories</flux:subheading>
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
    <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <flux:input label="Name" name="name" class="mb-3" value="{{ old('name') }}" />
        @error('name')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        <flux:input label="Slug" name="slug" class="mb-3" value="{{ old('slug') }}" />
        @error('slug')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        <flux:textarea label="Description" name="description" class="mb-3">
            {{ old('description') }}
        </flux:textarea>
        @error('description')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        <flux:input type="file" label="Image" name="image" class="mb-3" />
        @error('image')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror

        <flux:separator />

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Simpan</flux:button>
            <flux:link href="{{ route('categories.index') }}" variant="ghost" class="ml-3">Kembali</flux:link>
        </div>
    </form>
</x-layouts.app>
