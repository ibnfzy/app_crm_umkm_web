<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class OperatorLogin extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('login/operator');
    }

    public function auth()
    {
        $session = session();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $data = $this->db->table('operator')->where('username', $username)->get()->getRowArray();

        if ($data) {
            $password_data = $data['password'];
            $id = $data['id_operator'];

            $verify = password_verify($password ?? '', $password_data);

            if ($verify) {
                $sessionData = [
                    'id_operator' => $data['id_operator'],
                    'fullname' => $data['fullname'],
                    'username' => $data['username'],
                    'logged_in_operator' => TRUE
                ];

                $session->set($sessionData);
                // $session->markAsTempdata('logged_in_operator', 1800); //timeout 30 menit

                return redirect()->to(base_url('OperatorPanel'))->with('type-status', 'info')
                    ->with('message', 'Selamat Datang Kembali ' . $sessionData['fullname']);
            } else {
                return redirect()->to(base_url('OperatorLogin'))->with('type-status', 'error')
                    ->with('message', 'Password tidak benar');
            }
        } else {
            return redirect()->to(base_url('OperatorLogin'))->with('type-status', 'error')
                ->with('message', 'Username tidak benar');
        }
    }

    public function logoff()
    {
        $session = session();

        $session->destroy();

        return redirect()->to(base_url('OperatorLogin'));
    }
}
