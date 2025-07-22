<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // Model kategori yang sudah di-set tabelnya ke product_categories
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all(); // Ambil kategori dari tabel product_categories
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            // Validasi tabel product_categories
            'product_category_id' => 'required|exists:product_categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sku' => $request->sku,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'product_category_id' => $request->product_category_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'required|exists:product_categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sku' => $request->sku,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'product_category_id' => $request->product_category_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }
            $data['image_url'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }

    public function sync($id)
    {
        $product = Product::with('category')->findOrFail($id);

        $payload = [
            'client_id'         => env('CLIENT_ID'),
            'client_secret'     => env('CLIENT_SECRET'),
            'seller_product_id' => (string) $product->id,
            'name'              => $product->name,
            'description'       => $product->description,
            'price'             => $product->price,
            'stock'             => $product->stock,
            'sku'               => $product->sku,
            'image_url'         => $product->image_url,
            'weight'            => $product->weight ?? 0,
            // Jika sudah disinkron, is_active false artinya untuk "hapus sinkron"
            'is_active'         => $product->hub_product_id ? false : true,
            'category_id'       => optional($product->category)->hub_category_id,
        ];

        $response = Http::post('https://api.phb-umkm.my.id/api/product/sync', $payload);

        if ($response->successful() && isset($response['product_id'])) {
            // Toggle hub_product_id: hapus jika sudah ada, simpan id baru jika belum
            $product->hub_product_id = $product->hub_product_id ? null : $response['product_id'];
            $product->save();

            return redirect()->back()->with('success', 'Produk berhasil disinkronisasi.');
        }

        return redirect()->back()->with('error', 'Gagal menyinkronkan produk.');
    }
}
