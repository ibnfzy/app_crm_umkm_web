<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index(): string
    {
        return view('web/home', [
            'dataProduk' => $this->db->table('produk')->orderBy('id_produk', 'RANDOM')->get(10)->getResultArray()
        ]);
    }

    public function katalog()
    {
        return view('web/katalog', [
            'data' => $this->db->table('produk')->orderBy('id_produk', 'DESC')->get()->getResultArray()
        ]);
    }

    public function detail($id)
    {
        return view('web/detail', [
            'data' => $this->db->table('produk')->where('id_produk', $id)->get()->getRowArray(),
            'dataImg' => $this->db->table('produk_detail_gambar')->where('id_produk', $id)->get()->getResultArray(),
            'dataRekom' => $this->db->table('produk')->orderBy('id_produk', 'RANDOM')->get(10)->getResultArray()
        ]);
    }

    public function cart()
    {
        return view('web/cart');
    }
}
