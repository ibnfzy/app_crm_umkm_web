<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Produk extends Seeder
{
    public function run()
    {
        $img = [
            'product-1.jpg',
            'product-2.jpg',
            'product-3.jpg',
            'product-4.jpg',
            'product-5.jpg',
            'product-6.jpg',
            'product-7.jpg',
            'product-8.jpg',
        ];


        function toZeroFill($number, $length = 3)
        {
            return str_pad((string) $number, $length, '0', STR_PAD_LEFT);
        }

        for ($i = 0; $i < 100; $i++) {
            $this->db->table('produk')->insert([
                'id_unique_produk' => 'P' . toZeroFill($i + 1),
                'nama_produk' => 'Product ' . toZeroFill($i + 1),
                'harga_produk' => rand(10000, 100000),
                'harga_promo' => rand(1000, 10000),
                'stok' => rand(1, 999)
            ]);

            $this->db->table('produk_detail_gambar')->insertBatch([
                [
                    'id_produk' => $i + 1,
                    'file' => $img[array_rand($img)]
                ],
                [
                    'id_produk' => $i + 1,
                    'file' => $img[array_rand($img)]
                ],
                [
                    'id_produk' => $i + 1,
                    'file' => $img[array_rand($img)]
                ],
                [
                    'id_produk' => $i + 1,
                    'file' => $img[array_rand($img)]
                ],
                [
                    'id_produk' => $i + 1,
                    'file' => $img[array_rand($img)]
                ]
            ]);
        }
    }
}
