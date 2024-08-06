<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerPanel extends BaseController
{
    public function index()
    {
        return view('customer_panel/home');
    }

    public function orderan()
    {
        return view('customer_panel/orderan');
    }

    public function review()
    {
        return view('customer_panel/review');
    }
}