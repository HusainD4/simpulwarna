<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Category;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $categories = Category::query()
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.categories.index', compact('categories', 'q'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:categories,slug',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $imageName  = time() . '_' . $image->getClientOriginalName();
            $imagePath  = $image->storeAs('uploads/categories', $imageName, 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return redirect()->route('categories.index')->with('successMessage', 'Kategori berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;

        // Upload image baru jika ada
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $imageName  = time() . '_' . $image->getClientOriginalName();
            $imagePath  = $image->storeAs('uploads/categories', $imageName, 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return redirect()->route('categories.index')->with('successMessage', 'Kategori berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('successMessage', 'Kategori berhasil dihapus.');
    }

    public function sync($id, Request $request)
    {
        $category = Category::findOrFail($id);

        $response = Http::post('https://api.phb-umkm.my.id/api/product-category/sync', [
            'client_id'                  => env('CLIENT_ID'),
            'client_secret'              => env('CLIENT_SECRET'),
            'seller_product_category_id' => (string) $category->id,
            'name'                       => $category->name,
            'description'                => $category->description,
            'is_active'                  => $request->is_active == 1 ? false : true,
        ]);

        if ($response->successful() && isset($response['product_category_id'])) {
            $category->hub_category_id = $request->is_active == 1 ? null : $response['product_category_id'];
            $category->save();
        }

        return redirect()->back()->with('successMessage', 'Kategori berhasil disinkronisasi.');
    }
}
