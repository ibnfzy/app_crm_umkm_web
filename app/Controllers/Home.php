<?php

namespace App\Controllers;

class Home extends BaseController
{
    public $cart;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->cart = \Config\Services::cart();
    }

    public function index(): string
    {
        return view('web/home', [
            'dataProduk' => $this->db->table('produk')->orderBy('id_produk', 'RANDOM')->get(10)->getResultArray(),
            'dataSlider' => $this->db->table('slider')->get()->getResultArray()
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
        $notice = false;
        if (!session()->get('logged_in_customer')) {
            return redirect()->to(base_url('CustomerAuth'))->with('type-status', 'error')->with('message', 'Anda Harus Login Terlebih Dahulu');
        }

        foreach ($this->cart->contents() as $item) {
            $get = $this->db->table('produk')->where('id_produk', $item['id'])->get()->getRowArray();

            if ($get['stok'] < $item['qty']) {
                $this->cart->remove($item['rowid']);
                $notice = true;
            } else {
                $this->cart->update([
                    'rowid' => $item['rowid'],
                    'stok' => $get['stok']
                ]);
            }
        }

        return view('web/cart', [
            'notice_delete' => $notice,
            'dataRekom' => $this->db->table('produk')->orderBy('id_produk', 'RANDOM')->get(10)->getResultArray(),
            'dataCustomer' => $this->db->table('customer')->where('id_customer', session()->get('id_customer'))->get()->getRowArray(),
            'dataKupon' => $this->db->table('customer_kupon')->join('kupon', 'kupon.id_kupon = customer_kupon.id_kupon')->where('customer_kupon.id_customer', session()->get('id_customer'))->get()->getResultArray()
        ]);
    }

    public function add_barang()
    {
        sleep(2);

        $get = $this->db->table('produk')->where('id_produk', $this->request->getPost('id_produk'))->get()->getRowArray();
        $getImg = $this->db->table('produk_detail_gambar')->where('id_produk', $this->request->getPost('id_produk'))->orderBy('id_detail_gambar', 'RANDOM')->get()->getRowArray();

        if ($this->request->getPost('qty') > $get['stok']) {
            return redirect()->to(previous_url())->with('type-status', 'error')
                ->with('message', 'Stok Tidak Mencukupi, silahkan hubungi toko');
        }

        $this->cart->insert([
            'id' => $get['id_produk'],
            'qty' => $this->request->getPost('qty'),
            'price' => $get['harga_promo'] ? $get['harga_promo'] : $get['harga_produk'],
            'name' => $get['nama_produk'],
            'gambar' => $getImg['file'],
            'stok' => $get['stok'],
            'id_customer' => session()->get('id_customer')
        ]);

        return redirect()->to(base_url('Cart'));
    }

    public function remove_barang($rowId)
    {
        $this->cart->remove($rowId);

        return redirect()->to(base_url('Cart'))->with('type-status', 'success')->with('message', 'Barang Berhasilsil Dihapus');
    }

    public function clear_cart()
    {
        $destroy = new \CodeIgniterCart\Config\Services;

        $destroy->cart()->destroy();

        return redirect()->to(base_url('Cart'));
    }

    public function update_cart()
    {
        $rowid = $this->request->getPost('rowid');
        $qty = $this->request->getPost('qtybutton');
        $stok = $this->request->getPost('stok');
        $status = true;

        foreach ($this->cart->contents() as $i => $item) {
            if ($qty[$i] > $stok[$i]) {
                $status = false;
                break;
            }

            $this->cart->update([
                'rowid' => $rowid[$i],
                'qty' => $qty[$i]
            ]);
        }

        if ($status == false) {
            return redirect()->to(base_url('Cart'))->with('type-status', 'error')
                ->with('message', 'Kuantitas barang melebihi stok');
        }

        return redirect()->to(base_url('Cart'))->with('type-status', 'success')
            ->with('message', 'Berhasil diperbaruhi');
    }

    public function review_star($id)
    {
        $get = $this->db->table('produk_detail_review')->where('id_produk', $id)->get()->getResultArray();

        $rt = [];
        $i = 1;

        foreach ($get as $barang) {
            $rt[] = $barang['rating'];
        }

        $nilai = array_sum($rt);

        $pbagi = count($rt);

        try {
            $rating = $nilai / $pbagi;
        } catch (\Throwable $th) {
            $rating = 0;
        }

        $nbulat = round($rating);
        $nbulat = ($nbulat > 5) ? 5 : $nbulat;
        $star = '<i class="fa fa-star" style="color: lightgrey"></i>';

        if ($nbulat == 1) {
            $star = '<i class="fa fa-star text-warning"></i>';
        } else if ($nbulat == 2) {
            $star = '<i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>';
        } else if ($nbulat == 3) {
            $star = '<i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>';
        } else if ($nbulat == 4) {
            $star = '<i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>';
        } else if ($nbulat == 5) {
            $star = '<i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>
                      <i class="fa fa-star text-warning"></i>';
        }

        return $star;
    }

    public function total_review($id)
    {
        $get = $this->db->table('produk_detail_review')->where('id_produk', $id)->get()->getResultArray();

        return count($get);
    }

    public function review($id)
    {
        return $this->db->table('produk_detail_review')->where('id_produk', $id)->get()->getResultArray();
    }

    public function getDataCustomerSingle($id_customer)
    {
        return $this->db->table('customer')->where('id_customer', $id_customer)->get()->getRowArray();
    }

    public function getDataOngkirCustomer($id_ongkir)
    {
        return $this->db->table('ongkir')->where('id_ongkir', $id_ongkir)->get()->getRowArray();
    }

    public function useKupon()
    {
        $idCustomerKupon = $this->request->getPost('voucher_id');
        $getCustomerKupon = $this->db->table('customer_kupon')->where('customer_kupon.id_customer_kupon', $idCustomerKupon)->where('customer_kupon.id_customer', session()->get('id_customer'))->join('kupon', 'kupon.id_kupon = customer_kupon.id_kupon')->get()->getRowArray();

        session()->set('id_customer_kupon', $idCustomerKupon);
        session()->set('id_kupon', $getCustomerKupon['id_kupon']);
        session()->set('discount_kupon', $getCustomerKupon['discount_kupon']);
        session()->set('max_nominal_kupon', $getCustomerKupon['max_nominal_kupon']);

        return redirect()->to(base_url('Cart'))->with('type-status', 'success')->with('message', 'Kupon Berhasil Digunakan');
    }

    public function informasi()
    {
        return view('web/informasi', [
            'dataRekom' => $this->db->table('produk')->orderBy('id_produk', 'RANDOM')->get(10)->getResultArray(),
            'data' => $this->db->table('informasi_toko')->where('id_informasi_toko', 1)->get()->getRowArray()
        ]);
    }

    public function testimoni()
    {
        return view('web/testimoni', [
            'dataRekom' => $this->db->table('produk')->orderBy('id_produk', 'RANDOM')->get(10)->getResultArray(),
            'data' => $this->db->table('produk_detail_review')->join('customer', 'customer.id_customer = produk_detail_review.id_customer')->join('produk', 'produk.id_produk = produk_detail_review.id_produk')->get()->getResultArray()
        ]);
    }
}
