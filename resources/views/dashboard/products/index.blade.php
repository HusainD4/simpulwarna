<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Products</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage data Products</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="flex justify-between items-center mb-4">
        <div>
            <form action="{{ route('admin.products.index') }}" method="get">
                {{-- Tidak perlu @csrf untuk method GET --}}
                <flux:input icon="magnifying-glass" name="q" value="{{ request('q') }}" placeholder="Search Products" />
            </form>
        </div>
        <div>
            <flux:button icon="plus">
                <flux:link href="{{ route('admin.products.create') }}" variant="subtle">Add New Product</flux:link>
            </flux:button>
        </div>
    </div>

    @if(session()->has('successMessage'))
        <div class="mb-3 w-full rounded bg-lime-100 border border-lime-400 text-lime-800 px-4 py-3">
            {{ session()->get('successMessage') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Image</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Category</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">SKU</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Price</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Active</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Sync</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Created At</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index => $product)
                    <tr>
                        <td class="px-5 py-5 border-b bg-white text-sm">{{ $index + $products->firstItem() }}</td>
                        <td class="px-5 py-5 border-b bg-white text-sm">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-10 w-10 object-cover rounded">
                            @else
                                <div class="h-10 w-10 bg-gray-200 flex items-center justify-center rounded">
                                    <span class="text-gray-500 text-sm">N/A</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-5 border-b bg-white text-sm">{{ $product->name }}</td>
                        <td class="px-5 py-5 border-b bg-white text-sm">{{ $product->category->name ?? 'N/A' }}</td>
                        <td class="px-5 py-5 border-b bg-white text-sm">{{ $product->sku }}</td>
                        <td class="px-5 py-5 border-b bg-white text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-5 py-5 border-b bg-white text-sm">{{ $product->is_active ? 'Yes' : 'No' }}</td>
                        <td class="px-5 py-5 border-b bg-white text-sm">
                            <form id="sync-product-{{ $product->id }}" action="{{ route('admin.products.sync', $product->id) }}" method="POST">
                                @csrf
                                @php
                                    $syncValue = $product->hub_product_id ? 0 : 1; // toggle value saat switch diubah
                                @endphp
                                <input type="hidden" name="is_active" value="{{ $syncValue }}">
                                <flux:switch
                                    @if($product->hub_product_id) checked @endif
                                    onchange="event.preventDefault(); document.getElementById('sync-product-{{ $product->id }}').submit()"
                                />
                            </form>
                        </td>
                        <td class="px-5 py-5 border-b bg-white text-sm">{{ $product->created_at->format('d M Y H:i') }}</td>
                        <td class="px-5 py-5 border-b bg-white text-sm">
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down" type="button">Actions</flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" href="{{ route('admin.products.edit', $product->id) }}">Edit</flux:menu.item>
                                    <flux:menu.item
                                        icon="trash"
                                        variant="danger"
                                        type="button"
                                        onclick="event.preventDefault(); if(confirm('Are you sure?')) document.getElementById('delete-form-{{ $product->id }}').submit();"
                                    >Delete</flux:menu.item>
                                    <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</x-layouts.app>
