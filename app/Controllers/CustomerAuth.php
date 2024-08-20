<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerAuth extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function index()
    {
        return view('login/customer');
    }

    public function register()
    {
        $kota_tersedia = $this->db->table('ongkir')->get()->getResultArray();

        $arrKota = [];

        foreach ($kota_tersedia as $key => $value) {
            $arrKota[$value['nama_kota']] = $value['tarif'];
        }

        return view('login/customer_daftar', [
            'kota_tersedia' => $arrKota
        ]);
    }

    public function auth()
    {
        $session = session();

        $username = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $data = $this->db->table('customer')->where('email_customer', $username)->get()->getRowArray();

        if ($data) {
            $password_data = $data['password_customer'];

            $verify = password_verify($password ?? '', $password_data);

            if ($verify) {
                $sessionData = [
                    'id_customer' => $data['id_customer'],
                    'nama_customer' => $data['nama_customer'],
                    'email_customer' => $data['email_customer'],
                    'no_wa' => $data['no_wa'],
                    'alamat' => $data['alamat'],
                    'logged_in_customer' => TRUE
                ];

                $session->set($sessionData);
                // $session->markAsTempdata('logged_in_customer', 1800); //timeout 30 menit

                return redirect()->to(base_url('CustomerPanel'))->with('type-status', 'info')
                    ->with('message', 'Selamat Datang Kembali ' . $sessionData['nama_customer']);
            } else {
                return redirect()->to(base_url('CustomerLogin'))->with('type-status', 'error')
                    ->with('message', 'Password tidak benar');
            }
        } else {
            return redirect()->to(base_url('CustomerLogin'))->with('type-status', 'error')
                ->with('message', 'Email tidak benar');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('CustomerAuth'));
    }

    public function register_action()
    {
        $rules = [
            'email' => [
                'rules' => 'required|valid_email|is_unique[customer.email]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email harus benar',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Password minimal 5 karakter'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches' => 'Konfirmasi password tidak sama'
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
            'kota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kota harus diisi'
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
            return redirect()->to(base_url('CustomerLogin/Register'))->with('type-status', 'error')->with('dataMessage', $this->validator->getErrors());
        }

        $getOngkir = $this->db->table('ongkir')->where('nama_kota', $this->request->getPost('kota'))->get()->getRowArray();

        $this->db->table('customer')->insert([
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_customer' => $this->request->getPost('nama_customer'),
            'no_wa' => $this->request->getPost('no_wa'),
            'id_ongkir' => $getOngkir['id_ongkir'],
            'alamat' => $this->request->getPost('alamat')
        ]);

        return redirect()->to(base_url('CustomerLogin'))->with('type-status', 'info')->with('message', 'Akun anda sudah terdaftar silahkan login');
    }
}
