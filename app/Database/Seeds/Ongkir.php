<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Ongkir extends Seeder
{
    public function run()
    {
        $this->db->table('ongkir')->insertBatch([
            [
                'nama_kota' => 'Jakarta',
                'tarif' => 50000
            ],
            [
                'nama_kota' => 'Surabaya',
                'tarif' => 100000
            ],
            [
                'nama_kota' => 'Makassar',
                'tarif' => 20000
            ]
        ]);
    }
}