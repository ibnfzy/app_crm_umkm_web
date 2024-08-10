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

    public function produk_add()
    {
        $rules = [
            'nama_produk' => [
                'rules' => 'max_lenght[255]',
                'errors' => [
                    'max_lenght' => 'Maksimal 255 karakter'
                ]
            ],
            'id_unique_produk' => [
                'rules' => 'max_lenght[32]',
                'errors' => [
                    'max_lenght' => 'Maksimal 32 karakter'
                ]
            ],
            'file' => [
                'rules' => 'is_image[file]|mime_in[file,image/jpg,image/jpeg,image/gif,image/png]|max_size[file,2048]',
                'errors' => [
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'File harus berupa gambar',
                    'max_size' => 'Ukuran file terlalu besar'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Produk'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('produk')->insert([
            'id_unique_produk' => $this->request->getPost('id_unique_produk'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga_produk' => $this->request->getPost('harga_produk'),
            'stok' => $this->request->getPost('stok'),
            'harga_promo' => $this->request->getPost('harga_promo')
        ]);

        $getId = $this->db->query("SELECT LAST_INSERT_ID()")->getRowArray()['LAST_INSERT_ID()'];
        $f = $this->request->getFiles('file');

        foreach ($f as $file) {
            $fileName = $file->getRandomName();
            $file->move('Uploads', $fileName);
            $this->db->table('produk_detail_gambar')->insert([
                'id_produk' => $getId,
                'file' => $fileName
            ]);
        }

        return redirect()->to(base_url('OperatorPanel/Produk'))->with('type-status', 'success')->with('dataMessage', 'Data produk baru ditambahkan');
    }

    public function produk_edit()
    {
        $rules = [
            'id_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Id produk harus diisi'
                ]
            ],
            'nama_produk' => [
                'rules' => 'max_lenght[255]',
                'errors' => [
                    'max_lenght' => 'Maksimal 255 karakter'
                ]
            ],
            'id_unique_produk' => [
                'rules' => 'max_lenght[32]',
                'errors' => [
                    'max_lenght' => 'Maksimal 32 karakter'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Produk'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('produk')->insert([
            'id_unique_produk' => $this->request->getPost('id_unique_produk'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga_produk' => $this->request->getPost('harga_produk'),
            'stok' => $this->request->getPost('stok'),
            'harga_promo' => $this->request->getPost('harga_promo')
        ]);

        return redirect()->to(base_url('OperatorPanel/Produk'))->with('type-status', 'success')->with('dataMessage', 'Data produk berhasil diupdate');
    }

    public function produk_delete($id)
    {
        $this->db->table('produk')->where('id_produk', $id)->delete();
        $getFiles = $this->db->table('produk_detail_gambar')->where('id_produk', $id)->get()->getResultArray();

        foreach ($getFiles as $item) {
            unlink('Uploads/' . $item['file']);
        }

        $this->db->table('produk_detail_gambar')->where('id_produk', $id)->delete();

        return redirect()->to(base_url('OperatorPanel/Produk'))->with('type-status', 'success')->with('dataMessage', 'Data produk dihapus');
    }

    public function produk_add_single_image()
    {
        $rules = [
            'file' => [
                'rules' => 'is_image[file]|mime_in[file,image/jpg,image/jpeg,image/gif,image/png]|max_size[file,2048]',
                'errors' => [
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'File harus berupa gambar',
                    'max_size' => 'Ukuran file terlalu besar'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Produk'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $file->move('Uploads', $fileName);
        $this->db->table('produk_detail_gambar')->insert([
            'id_produk' => $this->request->getPost('id_produk'),
            'file' => $fileName
        ]);

        return redirect()->to(base_url('OperatorPanel/Produk'))->with('type-status', 'success')->with('dataMessage', 'Gambar ditambahkan');
    }

    public function produk_delete_single_image($id)
    {
        $this->db->table('produk_detail_gambar')->where('id_gambar', $id)->delete();
        $getFiles = $this->db->table('produk_detail_gambar')->where('id_detail_gambar', $id)->get()->getRowArray();
        unlink('Uploads/' . $getFiles[0]['file']);

        return redirect()->to(base_url('OperatorPanel/Produk'))->with('type-status', 'success')->with('dataMessage', 'Gambar berhasil dihapus');
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
