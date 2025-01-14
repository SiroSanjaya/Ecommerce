<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    public function index()
    {
        // Buat instance dari CategoryModel
        $model = new CategoryModel();

        // Ambil semua data kategori
        $categories = $model->findAll();

        // Kirim data ke view 'home'
        return view('home', ['categories' => $categories]);
    }
}
