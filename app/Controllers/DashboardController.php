<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard Admin',
        ];
        return view('admin/Dashboard', $data);
    }
}
