<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categories;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar produk
     */
    public function index()
    {
        $products = Product::with('categories')->paginate(10); // include category if needed
        $productCount = Product::count();
        $categoryCount = Category::count();
        $syncedProducts = Product::whereNotNull('hub_product_id')->count();
        $syncedCategories = Category::whereNotNull('hub_category_id')->count();

        return view('admin.products.index', compact(
            'products',
            'productCount',
            'categoryCount',
            'syncedProducts',
            'syncedCategories'
        ));
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        $categories = Category::all(); // optional
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.products.index')->with('successMessage', 'Produk berhasil ditambahkan.');
    }

    /**
     * Form edit produk
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); // optional
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Simpan perubahan produk
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name'        => $request->name,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.products.index')->with('successMessage', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('successMessage', 'Produk berhasil dihapus.');
    }

    /**
     * Sinkronisasi produk (toggle)
     */
    public function sync($id)
    {
        $product = Product::findOrFail($id);

        if ($product->hub_product_id) {
            $product->hub_product_id = null;
        } else {
            $product->hub_product_id = rand(1000, 9999);
        }

        $product->save();

        return back()->with('successMessage', 'Status sinkronisasi produk diperbarui.');
    }
}
