<x-layouts.app :title="__('Categories')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Categories</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage data Categories</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="flex justify-between items-center mb-4">
        <form action="{{ route('categories.index') }}" method="get">
            <flux:input icon="magnifying-glass" name="q" value="{{ $q ?? '' }}" placeholder="Search Categories" />
        </form>

        <flux:link href="{{ route('categories.create') }}" variant="primary" icon="plus">
            Add New Category
        </flux:link>
    </div>

    @if(session('successMessage'))
        <div class="mb-3 w-full rounded bg-lime-100 border border-lime-400 text-lime-800 px-4 py-3">
            {{ session('successMessage') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="table-header">#</th>
                    <th class="table-header">Name</th>
                    <th class="table-header">Description</th>
                    <th class="table-header">Sync</th>
                    <th class="table-header">Created At</th>
                    <th class="table-header">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $key => $category)
                    <tr>
                        <td class="table-cell">{{ $key + 1 }}</td>
                        <td class="table-cell">{{ $category->name }}</td>
                        <td class="table-cell">{{ $category->description }}</td>
                        <td class="table-cell">
                            <form id="sync-category-{{ $category->id }}" action="{{ route('category.sync', $category->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="is_active" value="{{ $category->hub_category_id ? 1 : 0 }}">
                                <flux:switch 
                                    {{ $category->hub_category_id ? 'checked' : '' }} 
                                    onchange="document.getElementById('sync-category-{{ $category->id }}').submit()" 
                                />
                            </form>
                        </td>
                        <td class="table-cell">{{ $category->created_at }}</td>
                        <td class="table-cell">
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down">Actions</flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" href="{{ route('categories.edit', $category->id) }}">Edit</flux:menu.item>
                                    <flux:menu.item icon="trash" variant="danger"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this category?')) document.getElementById('delete-form-{{ $category->id }}').submit();">
                                        Delete
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>

                            <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>
</x-layouts.app>
