<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // Nama tabel
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'role', 'google_id', 'profile_pic']; // Menambahkan profile_pic
    protected $useTimestamps = true;

    // Menambahkan validasi untuk memastikan bahwa name dan email tidak kosong
    protected $validationRules = [
        'name' => 'required',
        'email' => 'required|valid_email',
        'google_id' => 'required',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Name cannot be empty',
        ],
        'email' => [
            'required' => 'Email cannot be empty',
            'valid_email' => 'Email is not valid',
        ],
        'google_id' => [
            'required' => 'Google ID cannot be empty',
        ],
    ];
}
