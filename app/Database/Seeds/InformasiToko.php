<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class InformasiToko extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        $this->db->table('informasi_toko')->insert([
            'tentang' => $faker->text(200),
            'kontak_wa' => '623211232123',
            'alamat' => $faker->address,
            'nama_toko' => 'Bunga Desa',
            'rekening_toko' => 'BRI 1234567890 a.n. Bunga Desa'
        ]);
    }
}
