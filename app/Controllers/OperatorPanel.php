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
        return view('operator_panel/produk', [
            'data' => $this->db->table('produk')->orderBy('id_produk', 'DESC')->get()->getResultArray()
        ]);
    }

    public function pelanggan()
    {
        return view('operator_panel/pelanggan', [
            'data' => $this->db->table('customer')->orderBy('id_customer', 'DESC')->get()->getResultArray()
        ]);
    }

    public function kupon()
    {
        return view('operator_panel/kupon', [
            'data' => $this->db->table('kupon')->orderBy('id_kupon', 'DESC')->get()->getResultArray()
        ]);
    }

    public function transaksi()
    {
        return view('operator_panel/transaksi', [
            'data' => $this->db->table('transaksi')->orderBy('id_transaksi', 'DESC')->get()->getResultArray()
        ]);
    }

    public function review()
    {
        return view('operator_panel/review', [
            'data' => $this->db->table('review')->join('customer', 'customer.id_customer = review.id_customer')->join('produk', 'produk.id_produk = review.id_produk', 'left')->orderBy('id_review', 'DESC')->get()->getResultArray()
        ]);
    }
}