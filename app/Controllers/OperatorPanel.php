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

    /**
     * Display the home page for the operator panel.
     * 
     * @routes GET / OperatorPanel/Profile
     * @return \CodeIgniter\View\View
     */
    public function index()
    {
        return view('operator_panel/home');
    }

    /**
     * Retrieves the list of products and renders the 'operator_panel/produk' view.
     * 
     * @routes GET / OperatorPanel/Produk
     * @return \CodeIgniter\View\View The rendered view.
     */
    public function produk()
    {
        return view('operator_panel/produk', [
            'data' => $this->db->table('produk')->orderBy('id_produk', 'DESC')->get()->getResultArray()
        ]);
    }

    /**
     * Adds a new product to the database.
     *
     * @routes POST / OperatorPanel/Produk
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function produk_add()
    {
        $rules = [
            'nama_produk' => [
                'rules' => 'max_length[255]',
                'errors' => [
                    'max_length' => 'Maksimal 255 karakter'
                ]
            ],
            'id_unique_produk' => [
                'rules' => 'max_length[32]|is_unique[produk.id_unique_produk]',
                'errors' => [
                    'max_length' => 'Maksimal 32 karakter',
                    'is_unique' => 'ID Produk sudah ada'
                ]
            ],
            'files' => [
                'rules' => 'mime_in[files,image/jpg,image/jpeg,image/png]|max_size[files,2048]',
                'errors' => [
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
        $f = $this->request->getFiles('files')['files'];
        // dd($f);

        foreach ($f as $key => $file) {
            $fileName = $f[$key]->getRandomName();

            if (!$f[$key]->hasMoved()) {
                $f[$key]->move('Uploads', $fileName);
            }

            $this->db->table('produk_detail_gambar')->insert([
                'id_produk' => $getId,
                'file' => $fileName
            ]);
        }

        return redirect()->to(base_url('OperatorPanel/Produk'))->with('type-status', 'success')->with('message', 'Data produk baru ditambahkan');
    }

    /**
     * Edits a product in the database.
     *
     * @routes POST / OperatorPanel/Produk
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
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
                'rules' => 'max_length[255]',
                'errors' => [
                    'max_length' => 'Maksimal 255 karakter'
                ]
            ],
            'id_unique_produk' => [
                'rules' => 'max_length[32]',
                'errors' => [
                    'max_length' => 'Maksimal 32 karakter'
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

        return redirect()->to(base_url('OperatorPanel/Produk'))->with('type-status', 'success')->with('message', 'Data produk berhasil diupdate');
    }

    /**
     * Deletes a product from the database and removes associated images.
     *
     * @param int $id The ID of the product to be deleted.
     * @routes DELETE / OperatorPanel/Produk/{id}
     * @return \CodeIgniter\HTTP\RedirectResponse The redirect response.
     */
    public function produk_delete($id)
    {
        $this->db->table('produk')->where('id_produk', $id)->delete();
        $getFiles = $this->db->table('produk_detail_gambar')->where('id_produk', $id)->get()->getResultArray();

        foreach ($getFiles as $item) {
            unlink('Uploads/' . $item['file']);
        }

        $this->db->table('produk_detail_gambar')->where('id_produk', $id)->delete();

        return redirect()->to(base_url('OperatorPanel/Produk'))->with('type-status', 'success')->with('message', 'Data produk dihapus');
    }

    public function produk_get_images($id_produk)
    {
        $getFiles = $this->db->table('produk_detail_gambar')->where('id_produk', $id_produk)->get()->getResultArray();

        return $this->response->setJSON([
            'status' => 200,
            'data' => $getFiles,
            'message' => 'success'
        ]);
    }

    /**
     * Adds a single image to a product in the database.
     *
     * @routes POST / OperatorPanel/Produk/add_single_image
     * @return \CodeIgniter\HTTP\RedirectResponse The redirect response.
     */
    public function produk_add_images()
    {
        $rules = [
            'files' => [
                'rules' => 'is_image[files]|mime_in[files,image/jpg,image/jpeg,image/gif,image/png]|max_size[files,2048]',
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

        $f = $this->request->getFiles('files')['files'];
        // dd($f);

        foreach ($f as $key => $file) {
            $fileName = $f[$key]->getRandomName();

            if (!$f[$key]->hasMoved()) {
                $f[$key]->move('Uploads', $fileName);
            }

            $this->db->table('produk_detail_gambar')->insert([
                'id_produk' => $this->request->getPost('id_produk'),
                'file' => $fileName
            ]);
        }

        return redirect()->to(base_url('OperatorPanel/Produk'))->with('type-status', 'success')->with('message', 'Gambar ditambahkan');
    }

    /**
     * Deletes a single image from the 'produk_detail_gambar' table and removes the associated file.
     *
     * @param int $id The ID of the image to be deleted.
     * @routes DELETE / OperatorPanel/Produk/delete_single_image
     * @return \CodeIgniter\HTTP\RedirectResponse The redirect response.
     */
    public function produk_delete_single_image($id)
    {

        $getFiles = $this->db->table('produk_detail_gambar')->where('id_detail_gambar', $id)->get()->getRowArray();

        unlink('Uploads/' . $getFiles['file']);

        $this->db->table('produk_detail_gambar')->where('id_detail_gambar', $id)->delete();

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'success',
            'id_produk' => $getFiles['id_produk']
        ]);
    }

    /**
     * Retrieves the list of customers from the database and renders the 'operator_panel/pelanggan' view.
     *
     * @routes GET / OperatorPanel/Pelanggan
     * @return \CodeIgniter\View\View The rendered view.
     */
    public function pelanggan()
    {
        return view('operator_panel/pelanggan', [
            'data' => $this->db->table('customer')->orderBy('id_customer', 'DESC')->get()->getResultArray()
        ]);
    }

    /**
     * Retrieves the list of coupons from the database and renders the 'operator_panel/kupon' view.
     *
     * @routes GET / OperatorPanel/Kupon
     * @return \CodeIgniter\View\View The rendered view.
     */
    public function kupon()
    {
        return view('operator_panel/kupon', [
            'data' => $this->db->table('kupon')->orderBy('id_kupon', 'DESC')->get()->getResultArray()
        ]);
    }

    /**
     * Adds a new coupon to the database.
     *
     * @routes POST / OperatorPanel/Kupon
     * @return \CodeIgniter\HTTP\RedirectResponse The redirect response.
     */
    public function kupon_add()
    {
        $rules = [
            'id_unique_kupon' => [
                'rules' => 'max_length[8]|is_unique[kupon.id_unique_kupon]',
                'errors' => [
                    'max_length' => 'ID Kupon Maksimal 8 karakter'
                ]
            ],
            'discount' => [
                'rules' => 'max_length[2]',
                'errors' => [
                    'max_length' => 'Discount Maksimal 2 karakter'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Kupon'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('kupon')->insert([
            'id_unique_kupon' => $this->request->getPost('id_unique_kupon'),
            'deskripsi_kupon' => $this->request->getPost('deskripsi_kupon'),
            'max_nominal_kupon' => $this->request->getPost('max_nominal_kupon'),
            'discount_kupon' => $this->request->getPost('discount_kupon'),
            'level_kupon' => $this->request->getPost('level_kupon')
        ]);

        return redirect()->to(base_url('OperatorPanel/Kupon'))->with('type-status', 'success')->with('message', 'Kupon ditambahkan');
    }

    /**
     * Edits a coupon in the database.
     *
     * @routes POST / OperatorPanel/Kupon
     * @return \CodeIgniter\HTTP\RedirectResponse The redirect response.
     */
    public function kupon_edit()
    {
        $rules = [
            'id_kupon' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ID Kupon harus diisi'
                ]
            ],
            'id_unique_kupon' => [
                'rules' => 'max_length[8]|is_unique[kupon.id_unique_kupon, id_kupon, {id_kupon}]',
                'errors' => [
                    'max_length' => 'ID Kupon Maksimal 8 karakter'
                ]
            ],
            'discount' => [
                'rules' => 'max_length[2]',
                'errors' => [
                    'max_length' => 'Discount Maksimal 2 karakter'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Kupon'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('kupon')->where('id_kupon', $this->request->getPost('id_kupon'))->update([
            'id_unique_kupon' => $this->request->getPost('id_unique_kupon'),
            'deskripsi_kupon' => $this->request->getPost('deskripsi_kupon'),
            'max_nominal_kupon' => $this->request->getPost('max_nominal_kupon'),
            'discount_kupon' => $this->request->getPost('discount_kupon'),
            'level_kupon' => $this->request->getPost('level_kupon')
        ]);

        return redirect()->to(base_url('OperatorPanel/Kupon'))->with('type-status', 'success')->with('message', 'Kupon diedit');
    }

    /**
     * Deletes a coupon from the database.
     *
     * @param int $id The ID of the coupon to delete.
     * @routes DELETE / OperatorPanel/Kupon/{id}
     * @return \CodeIgniter\HTTP\RedirectResponse The redirect response.
     */
    public function kupon_delete($id)
    {
        $this->db->table('kupon')->where('id_kupon', $id)->delete();
        return redirect()->to(base_url('OperatorPanel/Kupon'))->with('type-status', 'success')->with('message', 'Kupon dihapus');
    }

    /**
     * Retrieves the list of transactions and renders the 'operator_panel/transaksi' view.
     *
     * @routes GET / OperatorPanel/Transaksi
     * @return \CodeIgniter\View\View The rendered view.
     */
    public function transaksi()
    {
        return view('operator_panel/transaksi', [
            'data' => $this->db->table('transaksi')->orderBy('id_transaksi', 'DESC')->get()->getResultArray()
        ]);
    }

    /**
     * Retrieves the list of reviews and renders the 'operator_panel/review' view.
     *
     * @routes GET / OperatorPanel/Review
     * @return \CodeIgniter\View\View The rendered view.
     */
    public function review()
    {
        return view('operator_panel/review', [
            'data' => $this->db->table('produk_detail_review')
                ->join('customer', 'customer.id_customer = produk_detail_review.id_customer')
                ->join('produk', 'produk.id_produk = produk_detail_review.id_produk', 'left')
                ->orderBy('id_detail_review', 'DESC')
                ->get()->getResultArray()
        ]);
    }

    /**
     * Retrieves the list of ongkir data and renders the 'operator_panel/ongkir' view.
     *
     * @routes GET / OperatorPanel/Ongkir
     * @return \CodeIgniter\View\View The rendered view.
     */
    public function ongkir()
    {
        return view('operator_panel/ongkir', [
            'data' => $this->db->table('ongkir')->orderBy('id_ongkir', 'DESC')->get()->getResultArray()
        ]);
    }

    /**
     * Adds a new ongkir record to the database.
     *
     * @routes POST / OperatorPanel/Ongkir
     * @return \CodeIgniter\HTTP\RedirectResponse The redirect response to the ongkir page.
     */
    public function ongkir_add()
    {
        $rules = [
            'tarif' => [
                'rules' => 'max_length[5]',
                'errors' => [
                    'max_length' => 'Tarif Maksimal 5 karakter'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Ongkir'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('ongkir')->insert([
            'tarif' => $this->request->getPost('tarif'),
            'nama_kota' => $this->request->getPost('nama_kota')
        ]);

        return redirect()->to(base_url('OperatorPanel/Ongkir'))->with('type-status', 'success')->with('message', 'Ongkir ditambahkan');
    }

    /**
     * Edits the ongkir record in the database.
     *
     * @routes POST / OperatorPanel/Ongkir
     * @return \CodeIgniter\HTTP\RedirectResponse The redirect response to the ongkir page.
     */
    public function ongkir_edit()
    {
        $rules = [
            'id_ongkir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ID Ongkir harus diisi'
                ]
            ],
            'tarif' => [
                'rules' => 'max_length[5]',
                'errors' => [
                    'max_length' => 'Tarif Maksimal 5 karakter'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Ongkir'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('ongkir')->where('id_ongkir', $this->request->getPost('id_ongkir'))->update([
            'tarif' => $this->request->getPost('tarif'),
            'nama_kota' => $this->request->getPost('nama_kota')
        ]);

        return redirect()->to(base_url('OperatorPanel/Ongkir'))->with('type-status', 'success')->with('message', 'Ongkir diedit');
    }

    /**
     * Deletes a record from the 'ongkir' table with the specified ID.
     *
     * @param int $id The ID of the record to be deleted.
     * @routes DELETE / OperatorPanel/Ongkir/{id}
     * @return \CodeIgniter\HTTP\RedirectResponse The redirect response to the 'Ongkir' page.
     */
    public function ongkir_delete($id)
    {
        $this->db->table('ongkir')->where('id_ongkir', $id)->delete();
        return redirect()->to(base_url('OperatorPanel/Ongkir'))->with('type-status', 'success')->with('message', 'Ongkir dihapus');
    }
}
