<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerAuth extends BaseController
{
    public function index()
    {
        return view('login/customer');
    }

    public function register()
    {
        return view('login/customer_daftar');
    }
}