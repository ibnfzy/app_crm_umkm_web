<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransaksiDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail_transaksi' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_transaksi' => [
                'type' => 'SMALLINT(5) ZEROFILL',
                'unsigned' => true
            ],
            'id_produk' => [
                'type' => 'TINYINT(3) ZEROFILL',
                'unsigned' => true
            ],
            'id_customer' => [
                'type' => 'TINYINT(3) ZEROFILL',
                'unsigned' => true
            ],
            'kuantitas' => [
                'type' => 'SMALLINT'
            ],
            'harga_produk_beli' => [
                'type' => 'INT'
            ],
            'subtotal' => [
                'type' => 'INT'
            ]
        ]);

        $this->forge->addKey('id_detail_transaksi', true);
        $this->forge->addForeignKey('id_transaksi', 'transaksi', 'id_transaksi');
        $this->forge->addForeignKey('id_produk', 'produk', 'id_produk');
        $this->forge->addForeignKey('id_customer', 'customer', 'id_customer');
        $this->forge->createTable('transaksi_detail');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi_detail');
    }
}
