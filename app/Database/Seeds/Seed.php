<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Seed extends Seeder
{
    public function run()
    {
        $this->call('Customer');
        $this->call('Operator');
        $this->call('InformasiToko');
        $this->call('Produk');
    }
}
