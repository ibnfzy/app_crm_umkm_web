<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Produk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_produk' => [
                'type' => 'SMALLINT(5) ZEROFILL',
                'auto_increment' => true,
                'unsigned' => true
            ],
            'id_unique_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null' => true
            ],
            'nama_produk' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'harga_produk' => [
                'type' => 'INT'
            ],
            'harga_promo' => [
                'type' => 'INT',
                'null' => true
            ],
            'stok' => [
                'type' => 'INT'
            ],
            'deskripsi' => [
                'type' => 'TEXT'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('(CURRENT_TIMESTAMP())')
            ]
        ]);

        $this->forge->addKey('id_produk', true);

        $this->forge->createTable('produk');
    }

    public function down()
    {
        $this->forge->dropTable('produk');
    }
}
