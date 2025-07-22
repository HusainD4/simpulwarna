<x-layouts.app :title="__('Themes')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Add New Theme</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage data Theme</flux:heading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('successMessage'))
        <div class="mb-3 w-full rounded bg-lime-100 border border-lime-400 text-lime-800 px-4 py-3">
            {{ session()->get('successMessage') }}
        </div>
    @elseif(session()->has('errorMessage'))
        <flux:badge color="red" class="mb-3 w-full">{{session()->get('errorMessage')}}</flux:badge>
    @endif

    <form action="{{ route('themes.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        <flux:input label="Name" name="name" class="mb-3" />

        <flux:textarea label="Description" name="description" class="mb-3" />

        <flux:input label="Folder" name="folder" class="mb-3" />

        <flux:select label="Status" name="status" class="mb-6">
            <flux:select.option value="active">Active</flux:select.option>
            <flux:select.option value="inactive">Inactive</flux:select.option>
        </flux:dropdown>

        <flux:separator />

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Simpan</flux:button>
            <flux:link href="{{ route('themes.index') }}" variant="ghost" class="ml-3">Kembali</flux:link>
        </div>
    </form>
</x-layouts.app>