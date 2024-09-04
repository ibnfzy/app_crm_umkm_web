<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CustomTcpdf;
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
        return view('operator_panel/home', [
            'dataTransaksiValidasi' => $this->db->table('transaksi')->join('customer', 'customer.id_customer = transaksi.id_customer')->where('transaksi.status_transaksi', 'Menunggu validasi bukti pembayaran')->orderBy('transaksi.id_transaksi', 'DESC')->get()->getResultArray(),
        ]);
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
            'data' => $this->db->table('transaksi')->join('customer', 'customer.id_customer = transaksi.id_customer')->orderBy('transaksi.id_transaksi', 'DESC')->get()->getResultArray()
        ]);
    }

    public function invoice($id)
    {
        $getDataTransaksi = $this->db->table('transaksi')->where('id_transaksi', $id)->get()->getRowArray();

        return view('operator_panel/invoice', [
            'data_transaksi' => $getDataTransaksi,
            'data_detail' => $this->db->table('transaksi_detail')->join('produk', 'produk.id_produk = transaksi_detail.id_produk')->where('id_transaksi', $id)->get()->getResultArray(),
            'data_toko' => $this->db->table('informasi_toko')->where('id_informasi_toko', 1)->get()->getRowArray(),
            'data_customer' => $this->db->table('customer')->join('ongkir', 'ongkir.id_ongkir = customer.id_ongkir')->where('customer.id_customer', $getDataTransaksi['id_customer'])->get()->getRowArray()
        ]);
    }

    public function validasi()
    {
        $this->db->table('transaksi')->where('id_transaksi', $this->request->getPost('id_transaksi'))->update([
            'status_transaksi' => 'Pembayaran diterima, menunggu pesanan diproses'
        ]);

        return redirect()->to(base_url('OperatorPanel/Invoice/' . $this->request->getPost('id_transaksi')))->with('type-status', 'success')->with('message', 'Transaksi diterima');
    }

    public function proses()
    {
        $this->db->table('transaksi')->where('id_transaksi', $this->request->getPost('id_transaksi'))->update([
            'status_transaksi' => 'Pesanan diserahkan ke ekspedisi',
            'nama_ekspedisi' => $this->request->getPost('nama_ekspedisi'),
            'nomor_resi' => $this->request->getPost('nomor_resi')
        ]);

        return redirect()->to(base_url('OperatorPanel/Invoice/' . $this->request->getPost('id_transaksi')))->with('type-status', 'success')->with('message', 'Transaksi diproses');
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
            return redirect()->to(base_url('OperatorPanel/Ongkos_kirim'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('ongkir')->insert([
            'tarif' => $this->request->getPost('tarif'),
            'nama_kota' => $this->request->getPost('nama_kota')
        ]);

        return redirect()->to(base_url('OperatorPanel/Ongkos_kirim'))->with('type-status', 'success')->with('message', 'Ongkir ditambahkan');
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
            return redirect()->to(base_url('OperatorPanel/Ongkos_kirim'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('ongkir')->where('id_ongkir', $this->request->getPost('id_ongkir'))->update([
            'tarif' => $this->request->getPost('tarif'),
            'nama_kota' => $this->request->getPost('nama_kota')
        ]);

        return redirect()->to(base_url('OperatorPanel/Ongkos_kirim'))->with('type-status', 'success')->with('message', 'Ongkir diedit');
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
        return redirect()->to(base_url('OperatorPanel/Ongkos_kirim'))->with('type-status', 'success')->with('message', 'Ongkir dihapus');
    }

    public function slider()
    {
        return view('operator_panel/slider', [
            'data' => $this->db->table('slider')->orderBy('id_slider', 'DESC')->get()->getResultArray()
        ]);
    }

    public function slider_add()
    {
        $rules = [
            'file' => [
                'rules' => 'uploaded[file]|max_size[file, 1024]|is_image[file]|mime_in[file,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'uploaded' => 'File harus diunggah',
                    'max_size' => 'Ukuran file terlalu besar',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'File harus berupa gambar'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Slider'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $file->move('uploads', $fileName);

        $this->db->table('slider')->insert([
            'file' => $fileName
        ]);

        return redirect()->to(base_url('OperatorPanel/Slider'))->with('type-status', 'success')->with('message', 'Slider ditambahkan');
    }

    public function slider_delete($id)
    {
        $getFiles = $this->db->table('slider')->where('id_slider', $id)->get()->getResultArray();

        foreach ($getFiles as $item) {
            if (file_exists('uploads/' . $item['file'])) {
                unlink('uploads/' . $item['file']);
            }
        }

        $this->db->table('slider')->where('id_slider', $id)->delete();
        return redirect()->to(base_url('OperatorPanel/Slider'))->with('type-status', 'success')->with('message', 'Slider dihapus');
    }

    public function slider_edit()
    {
        $rules = [
            'file' => [
                'rules' => 'max_size[file, 1024]|is_image[file]|mime_in[file,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran file terlalu besar',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'File harus berupa gambar'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel/Slider'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $getFiles = $this->db->table('slider')->where('id_slider', $this->request->getPost('id_slider'))->get()->getResultArray();

        foreach ($getFiles as $item) {
            if (file_exists('uploads/' . $item['file'])) {
                unlink('uploads/' . $item['file']);
            }
        }

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $file->move('uploads', $fileName);

        $this->db->table('slider')->where('id_slider', $this->request->getPost('id_slider'))->update([
            'file' => $fileName
        ]);

        return redirect()->to(base_url('OperatorPanel/Slider'))->with('type-status', 'success')->with('message', 'Slider diedit');
    }

    public function informasi_edit()
    {
        $rules = [
            'username' => [
                'rules' => 'max_length[255]',
                'errors' => [
                    'max_length' => 'Username Maksimal 255 karakter'
                ]
            ],
            'nama_toko' => [
                'rules' => 'max_length[255]',
                'errors' => [
                    'max_length' => 'Nama Toko Maksimal 255 karakter'
                ]
            ],
            'kontak_wa' => [
                'rules' => 'max_length[13]',
                'errors' => [
                    'max_length' => 'Kontak Whatsapp Maksimal 13 karakter'
                ]
            ],
            'alamat' => [
                'rules' => 'max_length[255]',
                'errors' => [
                    'max_length' => 'Alamat Maksimal 255 karakter'
                ]
            ],
            'rekening_toko' => [
                'rules' => 'max_length[255]',
                'errors' => [
                    'max_length' => 'Rekening TokoMaksimal 255 karakter'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('OperatorPanel'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $this->db->table('informasi_toko')->where('id_informasi', '1')->update([
            'nama_toko' => $this->request->getPost('nama_toko'),
            'kontak_wa' => $this->request->getPost('kontak_wa'),
            'alamat' => $this->request->getPost('alamat'),
            'rekening_toko' => $this->request->getPost('rekening_toko'),
            'tentang' => $this->request->getPost('tentang')
        ]);

        $this->db->table('operator')->where('id_operator', $this->request->getPost('id_operator'))->update([
            'username' => $this->request->getPost('username')
        ]);

        return redirect()->to(base_url('OperatorPanel'))->with('type-status', 'success')->with('message', 'Informasi diedit');
    }

    public function password_edit()
    {
        $this->db->table('operator')->where('id_operator', $this->request->getPost('id_operator'))->update([
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ]);

        return redirect()->to(base_url('OperatorPanel'))->with('type-status', 'success')->with('message', 'Password diedit');
    }

    public function get_pdf_laporan_produk($id_produk)
    {
        $getTransaksi = $this->db->table('transaksi_detail')->join('transaksi', 'transaksi_detail.id_transaksi = transaksi.id_transaksi')->join('customer', 'transaksi.id_customer = customer.id_customer')->where('id_produk', $id_produk)->get()->getResultArray();
        $getProduk = $this->db->table('produk')->where('id_produk', $id_produk)->get()->getRowArray();
        $informasiToko = $this->db->table('informasi_toko')->where('id_informasi_toko', 1)->get()->getRowArray();

        $img_path = ROOTPATH . 'public/logo.png';
        $type = pathinfo($img_path, PATHINFO_EXTENSION);
        $data = file_get_contents($img_path);
        $img = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $pdf = new CustomTcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set informasi dokumen
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Admin Bunga Desa');
        $pdf->SetTitle('Laporan Produk');
        $pdf->SetSubject("Laporan Produk {$getProduk['nama_produk']}");
        $pdf->SetKeywords('Laporan, Produk');

        // Set header dan footer
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(false);
        $pdf->SetFooterMargin(false);

        // Tambahkan halaman
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Ambil view untuk template PDF
        $html = view('operator_panel/laporan_produk', [
            'data' => $getTransaksi,
            'getProduk' => $getProduk,
            'img' => $img,
            'informasiToko' => $informasiToko
        ]);

        // Tulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF (D = download)
        return $pdf->Output('laporan_produk.pdf', 'D');
    }

    public function laporan_bulanan()
    {
        $getTransaksiDetail = $this->db->table('transaksi_detail')->join('transaksi', 'transaksi_detail.id_transaksi = transaksi.id_transaksi')->join('customer', 'transaksi.id_customer = customer.id_customer')->where('transaksi.status_transaksi', 'Transaksi Berhasil')->where('MONTH(transaksi.tanggal_checkout)', date('m/Y', strtotime($this->request->getPost('bulan'))))->get()->getResultArray();

        $informasiToko = $this->db->table('informasi_toko')->where('id_informasi_toko', 1)->get()->getRowArray();

        $img_path = ROOTPATH . 'public/logo.png';
        $type = pathinfo($img_path, PATHINFO_EXTENSION);
        $data = file_get_contents($img_path);
        $img = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $pdf = new CustomTcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set informasi dokumen
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Admin Bunga Desa');
        $pdf->SetTitle('Laporan Produk');
        $pdf->SetSubject("Laporan Transaksi Bulanan");
        $pdf->SetKeywords('Laporan, Produk');

        // Set header dan footer
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(false);
        $pdf->SetFooterMargin(false);

        // Tambahkan halaman
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        $html = view('operator_panel/laporan_transaksi_bulanan', [
            'data' => $getTransaksiDetail,
            'img' => $img,
            'informasiToko' => $informasiToko
        ]);

        // Tulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF (D = download)
        return $pdf->Output('laporan_transaksi_bulanan.pdf', 'D');
    }

    public function pelanggann_detail($id)
    {
        return view('operator_panel/pelanggan_detail', [
            'dataTransaksiCount' => $this->db->table('transaksi')->join('customer', 'transaksi.id_customer = customer.id_customer')->where('customer.id_unique_customer', $id)->countAllResults(),
            'dataTransaksi' => $this->db->table('transaksi')->join('customer', 'transaksi.id_customer = customer.id_customer')->where('customer.id_unique_customer', $id)->get()->getResultArray(),
            'dataKupon' => $this->db->table('customer_kupon')->where('id_customer', $id)->get()->getResultArray()
        ]);
    }
}
