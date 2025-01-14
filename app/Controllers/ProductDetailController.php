<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\ProductPhotoModel;
use App\Models\ProductDetailModel;  // Import model ProductDetailModel

class ProductDetailController extends BaseController
{
    public function index($productId)
    {
        $productModel = new ProductModel();
        $productPhotoModel = new ProductPhotoModel();
        $productDetailModel = new ProductDetailModel();  // Inisialisasi ProductDetailModel
    
        // Ambil detail produk berdasarkan ID
        $product = $productModel->getProductDetail($productId);
    
        // Cek jika produk tidak ditemukan
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Produk tidak ditemukan");
        }
    
        // Ambil gambar produk
        $product_images = $productPhotoModel->getImagesByProductId($productId);
    
        // Ambil kategori produk
        $category = $productModel->getCategoryByProductId($productId);

        // Ambil detail produk dari tabel product_details
        $productDetail = $productDetailModel->where('product_id', $productId)->first();  // Mengambil data detail berdasarkan product_id
    
        // Kirim data ke view
        $data = [
            'title' => $product['name'] . ' - Detail Produk',
            'product' => $product,
            'product_images' => $product_images,
            'category' => $category, 
            'product_detail' => $productDetail, // Kirim data detail produk ke view
        ];
    
        return view('pages/product/ProductDetail', $data);
    }
}

    



