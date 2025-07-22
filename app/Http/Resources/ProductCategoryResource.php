<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    public $status;
    public $message;
    public $resource;

    /**
     * Resource untuk menampilkan kategori aksesoris dalam format JSON.
     *
     * @param mixed $resource
     * @param int $status
     * @param string $message
     */
    public function __construct($resource, $status = 200, $message = 'Daftar kategori aksesoris berhasil dimuat')
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * Ubah struktur respons agar sesuai dengan kebutuhan frontend.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => $this->collection ? $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_kategori' => $item->name,
                    'slug' => $item->slug,
                    'deskripsi' => $item->description ?? 'Tidak ada deskripsi',
                    'jumlah_produk' => $item->products->count() ?? 0,
                ];
            }) : $this->resource,
        ];
    }
}
