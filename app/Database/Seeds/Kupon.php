<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class Kupon extends Seeder
{
    public function run()
    {
        $kupon = [
            1 => [10, 15, 18],
            2 => [20, 25, 28],
            3 => [30, 35, 38],
        ];

        $customerId = [1, 2];

        $kuponLvl = [1, 2, 3];

        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $level = $kuponLvl[array_rand($kuponLvl)];
            $discount = $kupon[$level][array_rand($kupon[$level])];
            $this->db->table('kupon')->insert([
                'id_unique_kupon' => 'KPN' . toZeroFill($i + 1),
                'deskripsi_kupon' => $faker->sentence,
                'max_nominal_kupon' => $faker->randomFloat(2, 100000, 10000000),
                'discount_kupon' => $discount,
                'level_kupon' => $level,
            ]);
        }

        $getRandomKupon = $this->db->table('kupon')->orderBy('id_kupon', 'DESC')->get(3)->getResultArray();

        for ($i = 0; $i < 8; $i++) {
            $this->db->table('customer_kupon')->insert([
                'id_customer' => $customerId[array_rand($customerId)],
                'id_kupon' => $getRandomKupon[array_rand($getRandomKupon)]['id_kupon'],
            ]);
        }
    }
}
