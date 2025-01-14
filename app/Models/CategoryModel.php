<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories'; // Nama tabel di database
    protected $primaryKey = 'id';    // Primary key
    protected $allowedFields = ['name', 'description', 'image']; // Kolom yang bisa diisi
}
