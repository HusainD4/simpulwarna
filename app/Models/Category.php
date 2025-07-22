<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    /**
     * Nama tabel terkait model ini.
     */
    protected $table = 'product_categories';

    /**
     * Kolom yang dapat diisi.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'hub_category_id',
    ];

    /**
     * Konversi tipe data.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi: satu kategori memiliki banyak produk.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }

    /**
     * Akses URL gambar lengkap.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Set slug otomatis jika kosong.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
