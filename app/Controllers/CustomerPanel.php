<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CustomTcpdf;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerPanel extends BaseController
{
    protected $db;
    public $cart;

    public function __construct()
    {
        $this->db = db_connect();
        $this->cart = \Config\Services::cart();
        session()->set('dataCustomer', $this->db->table('customer')->join('ongkir', 'ongkir.id_ongkir = customer.id_ongkir')->where('customer.id_customer', session()->get('id_customer'))->get()->getRowArray());

        session()->set('totalNeedToPay', $this->db->table('transaksi')->where('id_customer', session()->get('id_customer'))->where('status_transaksi', 'Menunggu Bukti Pembayaran')->countAllResults());
    }

    public function index()
    {
        $kota_tersedia = $this->db->table('ongkir')->get()->getResultArray();

        $arrKota = [];

        foreach ($kota_tersedia as $key => $value) {
            $arrKota[$value['nama_kota']] = $value['tarif'];
        }

        return view('customer_panel/home', [
            'dataPembayaran' => $this->db->table('transaksi')->join('customer', 'customer.id_customer = transaksi.id_customer')->where('transaksi.status_transaksi', 'Menunggu Bukti Pembayaran')->where('transaksi.id_customer', session()->get('id_customer'))->orderBy('id_transaksi', 'DESC')->get()->getResultArray(),
            'kota_tersedia' => $arrKota
        ]);
    }

    public function orderan()
    {
        return view('customer_panel/orderan', [
            'data' => $this->db->table('transaksi')->join('customer', 'customer.id_customer = transaksi.id_customer')->where('transaksi.id_customer', session()->get('id_customer'))->orderBy('id_transaksi', 'DESC')->get()->getResultArray()
        ]);
    }

    public function review()
    {
        return view('customer_panel/review', [
            'data' => $this->db->table('produk_detail_review')->join('customer', 'customer.id_customer = produk_detail_review.id_customer')->join('produk', 'produk.id_produk = produk_detail_review.id_produk', 'left')->where('produk_detail_review.id_customer', session()->get('id_customer'))->orderBy('produk_detail_review.id_detail_review', 'DESC')->get()->getResultArray()
        ]);
    }

    public function checkIfReviewExist($id_customer, $id_produk)
    {
        return $this->db->table('produk_detail_review')->where('id_customer', $id_customer)->where('id_produk', $id_produk)->get()->getRowArray();
    }

    public function review_add()
    {
        $this->db->table('produk_detail_review')->insert([
            'id_produk' => $this->request->getPost('id_produk'),
            'id_customer' => session()->get('id_customer'),
            'review' => $this->request->getPost('review'),
            'rating' => $this->request->getPost('rating') ?? 0
        ]);

        return redirect()->to(base_url('CustomerPanel/Review'))->with('type-status', 'success')->with('message', 'Review produk berhasil ditambahkan');
    }

    public function review_delete($id)
    {
        $this->db->table('produk_detail_review')->where('id_detail_review', $id)->delete();

        return redirect()->to(base_url('CustomerPanel/Review'))->with('type-status', 'success')->with('message', 'Review produk berhasil dihapus');
    }

    public function invoice($id)
    {
        return view('customer_panel/invoice', [
            'data_transaksi' => $this->db->table('transaksi')->where('id_transaksi', $id)->get()->getRowArray(),
            'data_detail' => $this->db->table('transaksi_detail')->join('produk', 'produk.id_produk = transaksi_detail.id_produk')->where('id_transaksi', $id)->get()->getResultArray(),
            'data_toko' => $this->db->table('informasi_toko')->where('id_informasi_toko', 1)->get()->getRowArray(),
            'data_customer' => $this->db->table('customer')->join('ongkir', 'ongkir.id_ongkir = customer.id_ongkir')->where('customer.id_customer', session()->get('id_customer'))->get()->getRowArray()
        ]);
    }

    public function getRandomImageProduk($id_produk)
    {
        return $this->db->table('produk_detail_gambar')->where('id_produk', $id_produk)->orderBy('id_detail_gambar', 'RANDOM')->get(1)->getRowArray();
    }

    public function checkout()
    {
        $home = new \App\Controllers\Home;
        $i = 0;
        $cart = [];
        $hargaArr = [];
        $kupon = session()->get('discount_kupon') ?? null;
        $idCustomerKupon = session()->get('id_customer_kupon') ?? null;
        $maxPotonganKupon = session()->get('max_nominal_kupon') ?? null;
        $qtyArr = [];

        $dataCustomer = $this->db->table('customer')->where('id_customer', session()->get('id_customer'))->get()->getRowArray();

        foreach ($this->cart->contents() as $key => $value) {
            $getProduk = $this->db->table('produk')->where('id_produk', $value['id'])->get()->getRowArray();

            if ($getProduk['stok'] < $value['qty']) {
                return redirect()->to(base_url('Cart'))->with('type-status', 'error')
                    ->with('message', 'Terdapat Stok kurang pada keranjang anda, silahkan ditambahkan ulang');
            }

            $cart[] = $getProduk;
            $cart[$i]['qty'] = $value['qty'];
            $cart[$i]['total_harga'] = $value['price'] * $value['qty'];
            $cart[$i]['price'] = $value['price'];

            $hargaArr[] = $value['price'] * $value['qty'];

            $qtyArr[] = $value['qty'];

            $stok = $getProduk['stok'] - $value['qty'];
            $this->db->table('produk')->where('id_produk', $value['id'])->update(['stok' => $stok]);

            $i++;
        }

        $totalHarga = array_sum($hargaArr);

        $ongkir = $this->db->table('ongkir')->where('id_ongkir', $dataCustomer['id_ongkir'])->get()->getRowArray();

        $potongan = $totalHarga * ($kupon / 100);

        $grandTotal = $totalHarga - $potongan + $ongkir['tarif'];

        $this->db->table('transaksi')->insert([
            'id_customer' => session()->get('id_customer'),
            'total_kuantitas_belanja' => array_sum($qtyArr),
            'total_bayar_belanja' => $grandTotal,
            'batas_pembayaran' => date('Y-m-d', strtotime('+1 day')),
            'id_kupon' => $idCustomerKupon ?? 0,
            'diskon' => $kupon ?? 0,
            'max_potongan' => $maxPotonganKupon ?? 0,
        ]);


        $idTransaksi = $this->db->insertID();

        $this->db->table('customer_kupon')->where('id_customer_kupon', $idCustomerKupon)->delete();

        foreach ($cart as $key => $item) {
            $this->db->table('transaksi_detail')->insert([
                'id_transaksi' => $idTransaksi,
                'id_produk' => $item['id_produk'],
                'kuantitas' => $item['qty'],
                'harga_produk_beli' => $item['price'],
                'subtotal' => $item['total_harga'],
            ]);
        }

        $idUniqueTransaksi = 'TRX' . $idTransaksi;

        $this->db->table('transaksi')->where('id_transaksi', $idTransaksi)->update(['id_unique_transaksi' => $idUniqueTransaksi]);

        $home->clear_cart();
        session()->set('id_customer_kupon', null);
        session()->set('id_kupon', null);
        session()->set('discount_kupon', null);
        session()->set('max_nominal_kupon', null);

        return redirect()->to(base_url('CustomerPanel/Invoice/' . $idTransaksi))->with('type-status', 'success')
            ->with('message', 'Checkout berhasil, silahkan lakukan pembayaran');
    }

    public function upload_bukti()
    {
        $rules = [
            'bukti_bayar' => [
                'rules' => 'uploaded[bukti_bayar]|mime_in[bukti_bayar,image/jpg,image/jpeg,image/gif,image/png]|max_size[bukti_bayar,2048]',
                'errors' => [
                    'uploaded' => 'File gagal di upload',
                    'mime_in' => 'File yang diupload bukan gambar',
                    'max_size' => 'File yang diupload terlalu besar'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('CustomerPanel/Invoice/' . $this->request->getPost('id_transaksi')))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $file = $this->request->getFile('bukti_bayar');
        $fileName = $file->getRandomName();
        $file->move('uploads', $fileName);

        $this->db->table('transaksi')->where('id_transaksi', $this->request->getPost('id_transaksi'))->update(['bukti_bayar' => $fileName, 'status_transaksi' => 'Menunggu validasi bukti pembayaran']);

        return redirect()->to(base_url('CustomerPanel/Invoice/' . $this->request->getPost('id_transaksi')))->with('type-status', 'success')->with('message', 'Upload bukti pembayaran berhasil');
    }

    public function getKuponBaseOnTransaksi($id_customer)
    {
        $checkTransaksi = $this->db->table('transaksi')->where('id_customer', $id_customer)->get()->getResultArray();

        $GetLevel = null;

        if (count($checkTransaksi) >= 8) {
            $GetLevel = 3;
        }

        if (count($checkTransaksi) >= 5) {
            $GetLevel = 2;
        }

        if (count($checkTransaksi) >= 3) {
            $GetLevel = 1;
        }

        if ($GetLevel) {
            $getRandomKupon = $this->db->table('kupon')->where('level_kupon', $GetLevel)->orderBy('id_kupon', 'DESC')->get()->getRowArray();

            return $this->db->table('customer_kupon')->insert([
                'id_customer' => $id_customer,
                'id_kupon' => $getRandomKupon['id_kupon'],
                'expired_at' => date('Y-m-d', strtotime('+1 month')),
            ]);
        }

        return null;
    }

    public function konfirmasi_pesanan()
    {
        $this->db->table('transaksi')->where('id_transaksi', $this->request->getPost('id_transaksi'))->update(['status_transaksi' => 'Transaksi Berhasil']);

        $this->getKuponBaseOnTransaksi(session()->get('id_customer'));

        return redirect()->to(base_url('CustomerPanel/Invoice/' . $this->request->getPost('id_transaksi')))->with('type-status', 'success')->with('message', 'Konfirmasi pesanan berhasil');
    }

    public function informasi_edit()
    {
        $rules = [
            'email_customer' => [
                'rules' => 'required|valid_email|is_unique[customer.email_customer]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email harus benar',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ],
            'nama_customer' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi'
                ]
            ],
            'no_wa' => [
                'rules' => 'required|max_length[13]|is_unique[customer.no_wa]|numeric',
                'errors' => [
                    'required' => 'No. Whatsapp harus diisi',
                    'is_unique' => 'No. Whatsapp sudah terdaftar',
                    'max_length' => 'No. Whatsapp Maksimal 13 karakter',
                    'numeric' => 'No. Whatsapp harus angka'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('CustomerPanel'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $getOngkir = $this->db->table('ongkir')->where('nama_kota', $this->request->getPost('kota'))->get()->getRowArray();

        $this->db->table('customer')->where('id_customer', session()->get('id_customer'))->update([
            'email_customer' => $this->request->getPost('email_customer'),
            'password_customer' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_customer' => $this->request->getPost('nama_customer'),
            'no_wa' => '62' . $this->request->getPost('no_wa'),
            'id_ongkir' => $getOngkir['id_ongkir'],
            'alamat' => $this->request->getPost('alamat')
        ]);

        return redirect()->to(base_url('CustomerPanel'))->with('type-status', 'info')->with('message', 'Berhasil merubah informasi akun');
    }

    public function password_edit()
    {
        $this->db->table('customer')->where('id_customer', session()->get('id_customer'))->update([
            'password_customer' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to(base_url('CustomerPanel'))->with('type-status', 'success')->with('message', 'Berhasil merubah password');
    }

    public function kupon()
    {
        return view('customer_panel/kupon', [
            'data' => $this->db->table('customer_kupon')->join('kupon', 'kupon.id_kupon = customer_kupon.id_kupon')->where('customer_kupon.id_customer', session()->get('id_customer'))->get()->getResultArray()
        ]);
    }

    public function print_invoice($id_transaksi)
    {
        $dataTransaksi = $this->db->table('transaksi')->where('id_transaksi', $id_transaksi)->get()->getRowArray();
        $dataDetail = $this->db->table('transaksi_detail')->join('produk', 'produk.id_produk = transaksi_detail.id_produk')->where('id_transaksi', $id_transaksi)->get()->getResultArray();
        $dataToko = $this->db->table('informasi_toko')->where('id_informasi_toko', 1)->get()->getRowArray();
        $dataCustomer = $this->db->table('customer')->join('ongkir', 'ongkir.id_ongkir = customer.id_ongkir')->where('customer.id_customer', $dataTransaksi['id_customer'])->get()->getRowArray();

        $img_path = ROOTPATH . 'public/logo.png';
        $type = pathinfo($img_path, PATHINFO_EXTENSION);
        $data = file_get_contents($img_path);
        $img = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $pdf = new CustomTcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set informasi dokumen
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Admin Bunga Desa');
        $pdf->SetTitle('Laporan Produk');
        $pdf->SetSubject("Invoice Transaksi");
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

        $html = view('customer_panel/print_invoice', [
            'dataTransaksi' => $dataTransaksi,
            'dataDetail' => $dataDetail,
            'dataToko' => $dataToko,
            'dataCustomer' => $dataCustomer,
            'img' => $img
        ]);

        // Tulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF (D = download)
        $pdfInline = $pdf->Output('invoice.pdf', 'I');

        return $this->response->setHeader('Content-Type', 'application/pdf')->setBody($pdfInline);
    }
}
