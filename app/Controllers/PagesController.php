<?php

namespace App\Controllers;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class PagesController extends BaseController
{
    public function index()
    {
        // Buat instance dari model
        $categoryModel = new CategoryModel();

        // Ambil semua data kategori
        $categories = $categoryModel->findAll();

        // Masukkan data ke array
        $data = [
            'title' => 'Home Page',
            'categories' => $categories, // Tambahkan data kategori
        ];

        // Tampilkan view
        return view('pages/Home', $data);
    }
    public function Login()
    {
        $data = [
            'title' => 'Login Page',
        ];
        return view('pages/Login', $data);
    }

    public function MarketPlaces()
    {
        $productModel = new ProductModel();
        $products = $productModel->findAll(); // Mengambil semua data produk

        $data = [
            'title' => 'MarketPlaces Page',
            'products' => $products, // Mengirimkan data produk ke view
        ];

        return view('pages/MarketPlaces', $data);
    }

    public function CategoryProduct()
    {
        $data = [
            'title' => 'CategoryProduct',
        ];
        return view('pages/product/CategoryProduct', $data);
    }
    public function Checkout()
    {
        $data = [
            'title' => 'Product Detail Page',
        ];
        return view('pages/product/Checkout', $data);
    }

}
