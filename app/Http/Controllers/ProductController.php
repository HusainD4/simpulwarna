<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $products = Product::with('category')
            ->when($q, fn ($query) => $query->where('name', 'like', "%{$q}%"))
            ->latest()
            ->paginate(10);

        return view('dashboard.products.index', compact('products', 'q'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'sku'         => 'required|string|max:100|unique:products',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'weight'      => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'image_url'   => 'nullable|image|max:2048', // upload file image max 2MB
            'description' => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Generate slug otomatis dari nama produk
        $data['slug'] = Str::slug($request->name);

        // Handle upload file gambar jika ada
        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('products', 'public');
        } else {
            $data['image_url'] = null;
        }

        // Pastikan is_active bernilai boolean dan default true
        $data['is_active'] = $request->has('is_active') ? true : false;

        Product::create($data);

        return redirect()->route('products.index')->with('successMessage', 'Product created successfully');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();

        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'sku'         => 'required|string|max:100|unique:products,sku,' . $product->id,
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'weight'      => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'image_url'   => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Update slug juga otomatis kalau nama produk berubah
        $data['slug'] = Str::slug($request->name);

        // Handle upload gambar jika ada
        if ($request->hasFile('image_url')) {
            // Hapus gambar lama jika ada
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            $data['image_url'] = $request->file('image_url')->store('products', 'public');
        } else {
            // Jika tidak upload baru, jangan ubah image_url
            unset($data['image_url']);
        }

        // Pastikan is_active boolean, default false jika tidak dicek
        $data['is_active'] = $request->has('is_active') ? true : false;

        $product->update($data);

        return redirect()->route('products.index')->with('successMessage', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return redirect()->route('products.index')->with('successMessage', 'Product deleted successfully');
    }

    // Optional: method show jika perlu menampilkan detail product
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('dashboard.products.show', compact('product'));
    }

    public function sync($id, Request $request)
    {
        $product = Product::with('category')->findOrFail($id);

        $response = Http::post('https://api.phb-umkm.my.id/api/product/sync', [
            'client_id'           => env('CLIENT_ID'),
            'client_secret'       => env('CLIENT_SECRET'),
            'seller_product_id'   => (string) $product->id,
            'name'                => $product->name,
            'description'         => $product->description,
            'price'               => $product->price,
            'stock'               => $product->stock,
            'sku'                 => $product->sku,
            'image_url'           => $product->image_url ? asset('storage/' . $product->image_url) : null,
            'weight'              => $product->weight,
            'is_active'           => $product->is_active, // pakai status sebenarnya
            'category_id'         => (string) optional($product->category)->hub_category_id,
        ]);

        if ($response->successful() && isset($response['product_id'])) {
            $product->hub_product_id = $response['product_id'];
            $product->save();
        }

        session()->flash('successMessage', 'Product synced successfully');
        return redirect()->back();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category_id');
    }
}
