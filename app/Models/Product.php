<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Binafy\LaravelCart\Cartable;
use App\Models\Category;

class Product extends Model implements Cartable
{
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'price',
        'stock',
        'product_category_id',
        'description',
        'image_url',
        'is_active',
        'weight',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category_id');
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
