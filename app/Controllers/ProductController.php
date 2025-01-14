<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends BaseController
{
    public function Product()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->findAll(); // Ambil semua produk
        return view('MarketPlace', $data); // Render view MarketPlace
    }
}
