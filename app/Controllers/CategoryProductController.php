<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class CategoryProductController extends BaseController
{
    protected $categoryModel;
    protected $productModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
    }

    public function categoryProduct($category_id)
    {
        // Ambil data kategori berdasarkan ID
        $category = $this->categoryModel->find($category_id);
        if (!$category) {
            // Jika kategori tidak ditemukan, tampilkan error
            return redirect()->to('/')->with('error', 'Category not found');
        }

        // Ambil produk berdasarkan category_id
        $products = $this->productModel->where('category_id', $category_id)->findAll();

        // Buat data yang akan dikirim ke view
        $data = [
            'title' => $category['name'] . ' Products', // Title sesuai kategori
            'category' => $category,
            'products' => $products,
        ];

        // Kirim data ke view
        return view('pages/product/CategoryProduct', $data);
    }
}
