<x-layouts.app :title="__('Themes')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Edit Theme</flux:heading>
        <flux:subheading size="lg" class="mb-6">Update data Theme</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('successMessage'))
        <flux:badge color="lime" class="mb-3 w-full">{{ session()->get('successMessage') }}</flux:badge>
    @elseif(session()->has('errorMessage'))
        <flux:badge color="red" class="mb-3 w-full">{{ session()->get('errorMessage') }}</flux:badge>
    @endif

    <form action="{{ route('themes.update', $theme->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <flux:input label="Name" name="name" class="mb-3" :value="old('name', $theme->name)" />

        <flux:textarea label="Description" name="description" class="mb-3">{{ old('description', $theme->description) }}</flux:textarea>

        <flux:input label="Folder" name="folder" class="mb-3" :value="old('folder', $theme->folder)" />

        <flux:select label="Status" name="status" class="mb-6">
            <flux:select.option value="active">Active</flux:select.option>
            <flux:select.option value="inactive">Inactive</flux:select.option>
        </flux:select>

        <flux:separator />

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Update</flux:button>
            <flux:link href="{{ route('themes.index') }}" variant="ghost" class="ml-3">Kembali</flux:link>
        </div>
    </form>
</x-layouts.app>