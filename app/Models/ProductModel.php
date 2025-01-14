<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products'; // Nama tabel produk
    protected $primaryKey = 'id'; // Primary key tabel produk
    protected $allowedFields = [
        'name', 
        'description', 
        'price', 
        'category_id', 
        'status', 
        'photo'
    ];

    // Metode untuk mengambil detail produk berdasarkan ID
    public function getProductDetail($productId)
    {
        return $this->where('id', $productId)->first(); // Mengambil produk berdasarkan ID
    }

    // Metode untuk mengambil kategori produk berdasarkan ID produk
   // Menambah select dengan kategori id
public function getCategoryByProductId($productId)
{
    // Mengambil data kategori lengkap berdasarkan ID produk
    return $this->select('categories.id as category_id, categories.name as category_name')
                ->join('categories', 'categories.id = products.category_id')
                ->where('products.id', $productId)
                ->first(); // Mengambil data kategori lengkap
}

}

