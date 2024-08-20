<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class Customer extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $this->db->table('customer')->insert([
            'id_unique_customer' => 'C001',
            'nama_customer' => $faker->name,
            'email_customer' => $faker->email,
            'password_customer' => password_hash('12345', PASSWORD_DEFAULT),
            'no_wa' => '623211232123',
            'id_ongkir' => 1,
            'alamat' => 'Jl Adiaksa'
        ]);

        $this->db->table('customer')->insert([
            'id_unique_customer' => 'C002',
            'nama_customer' => $faker->name,
            'email_customer' => 'a@a.com',
            'password_customer' => password_hash('12345', PASSWORD_DEFAULT),
            'no_wa' => '623211232123',
            'id_ongkir' => 1,
            'alamat' => 'Jl Adiaksa'
        ]);
    }
}