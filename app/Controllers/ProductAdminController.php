<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class ProductAdminController extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        
        // Mengambil semua data produk
        $products = $productModel->findAll();
        
        // Menambahkan kategori untuk setiap produk
        foreach ($products as &$product) {
            $category = $productModel->getCategoryByProductId($product['id']);
            $product['category_name'] = $category ? $category['category_name'] : 'No Category';
        }

        $data = [
            'title' => 'Product Admin Page',
            'products' => $products, // Mengirimkan data produk beserta kategori
        ];

        return view('/admin/product/index', $data);
    }
    public function create()
    {
        // Load model kategori
        $categoryModel = new CategoryModel();
    
        // Ambil semua data kategori dari database
        $categories = $categoryModel->findAll();
    
        // Kirim data kategori ke view
        $data = [
            'title' => 'Product Create Page',
            'categories' => $categories, // Tambahkan data kategori ke array
        ];
    
        // Tampilkan view dengan data
        return view('/admin/product/create', $data);
    }
    

    public function store()
{
    // Inisialisasi model
    $productModel = new ProductModel();

    // Validasi input
    $validationRules = [
        'name' => 'required|min_length[3]',
        'description' => 'required|min_length[10]',
        'price' => 'required|numeric',
        'category_id' => 'required|integer',
        'color' => 'required', // Validasi untuk color
        'photo' => 'uploaded[photo]|max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
    ];

    if (!$this->validate($validationRules)) {
        // Kembalikan ke form dengan pesan error
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Ambil data dari input
    $data = [
        'name' => $this->request->getPost('name'),
        'description' => $this->request->getPost('description'),
        'price' => $this->request->getPost('price'),
        'category_id' => $this->request->getPost('category_id'),
        'color' => $this->request->getPost('color'), // Tambahkan color
        'status' => $this->request->getPost('status') ?? 'available', // Default ke 'available'
    ];

    // Proses upload gambar
    $photo = $this->request->getFile('photo');
    if ($photo->isValid() && !$photo->hasMoved()) {
        $newName = $photo->getRandomName(); // Generate nama file baru
        $photo->move('uploads/products', $newName); // Pindahkan file ke folder tujuan
        $data['photo'] = $newName; // Simpan nama file ke database
    }

    // Simpan data ke database
    $productModel->save($data);

    // Redirect dengan pesan sukses
    return redirect()->to('/admin/Product')->with('success', 'Product berhasil ditambahkan!');
}
    
public function edit($id)
{
    // Load model kategori dan produk
    $categoryModel = new CategoryModel();
    $productModel = new ProductModel();

    // Ambil data produk berdasarkan ID
    $product = $productModel->find($id);

    // Validasi jika produk tidak ditemukan
    if (!$product) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
    }

    // Ambil semua data kategori dari database
    $categories = $categoryModel->findAll();

    // Daftar opsi status
    $statuses = [
        'available' => 'Available',
        'sold_out' => 'Sold Out',
    ];

    // Kirim data produk, kategori, status, dan error ke view
    $data = [
        'title' => 'Edit Produk',
        'product' => $product,
        'categories' => $categories,
        'status' => $statuses, // Daftar status
        'errors' => session()->getFlashdata('errors'),
    ];

    // Tampilkan view dengan data
    return view('/admin/product/edit', $data);
}


 // Fungsi untuk memproses update produk
public function update($id)
{
    // Load model kategori dan produk
    $categoryModel = new CategoryModel();
    $productModel = new ProductModel();
    
    // Ambil input data dari form
    $name = $this->request->getPost('name');
    $description = $this->request->getPost('description');
    $price = $this->request->getPost('price');
    $color = $this->request->getPost('color');
    $category_id = $this->request->getPost('category_id');
    $status = $this->request->getPost('status'); // Ambil nilai status
    $photo = $this->request->getFile('photo');

    // Validasi data jika diperlukan
    if (!$this->validate([
        'name' => 'required|min_length[3]',
        'description' => 'required|min_length[5]',
        'price' => 'required|numeric',
        'color' => 'required',
        'category_id' => 'required',
        'status' => 'required|in_list[available,sold out]', // Validasi status
        'photo' => 'permit_empty|is_image[photo]',
    ])) {
        // Kembali ke form edit dengan pesan error
        return redirect()->to('/admin/product/edit/' . $id)->withInput()->with('errors', $this->validator->getErrors());
    }

    // Jika ada file foto baru
    if ($photo && $photo->isValid()) {
        // Pindahkan foto ke direktori public/uploads/products
        $photo->move(ROOTPATH . 'public/uploads/products');
        $photoPath = 'uploads/products/' . $photo->getName();
    } else {
        // Jika tidak ada foto baru, gunakan foto lama
        $product = $productModel->find($id);
        $photoPath = $product['photo'];
    }

    // Siapkan data untuk update
    $data = [
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'color' => $color,
        'category_id' => $category_id,
        'photo' => $photoPath,  // Simpan path foto
        'status' => $status,    // Menyimpan status yang dipilih
    ];

    // Update data produk
    $productModel->update($id, $data);

    // Redirect setelah update berhasil
    return redirect()->to('/admin/Product')->with('success', 'Product updated successfully');
}

public function delete($id)
{
    $productModel = new ProductModel();

    // Cari produk berdasarkan ID
    $product = $productModel->find($id);

    if (!$product) {
        // Jika produk tidak ditemukan, tampilkan pesan error
        return redirect()->to('/admin/Product')->with('error', 'Product not found');
    }

    // Hapus file foto jika ada
    if (!empty($product['photo']) && file_exists(ROOTPATH . 'public/' . $product['photo'])) {
        unlink(ROOTPATH . 'public/' . $product['photo']);
    }

    // Hapus produk dari database
    $productModel->delete($id);

    // Redirect dengan pesan sukses
    return redirect()->to('/admin/Product')->with('success', 'Product deleted successfully');
}


}
