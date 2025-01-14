<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductDetailModel extends Model
{
    protected $table = 'product_details';  // Nama tabel di database
    protected $primaryKey = 'id';         // Primary key dari tabel
    protected $allowedFields = ['name', 'description','highlight','detail'];  // Kolom yang boleh di-insert/update

    // Fungsi untuk mengambil data yang berelasi dengan product_photos
    public function getPhotos($productId)
    {
        $photoModel = new ProductPhotoModel();
        return $photoModel->where('product_detail_id', $productId)->findAll();
    }
}
