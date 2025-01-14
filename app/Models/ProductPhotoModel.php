<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductPhotoModel extends Model
{
    protected $table = 'product_photos';  // Nama tabel
    protected $primaryKey = 'id';         // Primary key
    protected $allowedFields = ['product_detail_id', 'photo_url', 'alt']; // Kolom yang boleh di-insert/update

    // Menambahkan metode untuk mendapatkan gambar berdasarkan product_detail_id
    public function getImagesByProductId($productId)
    {
        return $this->where('product_detail_id', $productId)->findAll();  // Mengambil semua gambar berdasarkan product_detail_id
    }
}
