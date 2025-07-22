<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Products</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage data Product</flux:subheading>
        <flux:separator variant="subtle" />
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
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-xs font-semibold text-gray-600 uppercase">ID</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-xs font-semibold text-gray-600 uppercase">Name</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-xs font-semibold text-gray-600 uppercase">Stock</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-xs font-semibold text-gray-600 uppercase">Price</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-xs font-semibold text-gray-600 uppercase">Sync</th>
                    <th class="px-5 py-3 border-b-2 bg-gray-100 text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="px-5 py-5 border-b bg-white text-sm">{{ $product->id }}</td>
                        <td class="px-5 py-5 border-b bg-white text-sm">{{ $product->name }}</td>
                        <td class="px-5 py-5 border-b bg-white text-sm">{{ $product->stock }}</td>
                        <td class="px-5 py-5 border-b bg-white text-sm">{{ number_format($product->price, 0) }}</td>
                        <td class="px-5 py-5 border-b bg-white text-sm">
                            <form id="sync-product-{{ $product->id }}" action="{{ route('products.sync', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="is_active" value="{{ $product->hub_product_id ? 1 : 0 }}">
                                <flux:switch 
                                    {{ $product->hub_product_id ? 'checked' : '' }} 
                                    onchange="document.getElementById('sync-product-{{ $product->id }}').submit()" />
                            </form>
                        </td>
                        <td class="px-5 py-5 border-b bg-white text-sm">
                            <!-- Actions: Edit/Delete -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">{{ $products->links() }}</div>
    </div>
</x-layouts.app>
