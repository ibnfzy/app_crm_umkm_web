<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class OperatorPanel extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function index()
    {
        return view('operator_panel/home');
    }

    public function produk()
    {
        return view('operator_panel/produk');
    }

    public function pelanggan()
    {
        return view('operator_panel/pelanggan');
    }

    public function kupon()
    {
        return view('operator_panel/kupon');
    }

    public function transaksi()
    {
        return view('operator_panel/transaksi');
    }

    public function review()
    {
        return view('operator_panel/review');
    }
}
