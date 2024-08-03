<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class ProdukDetailGambar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail_gambar' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_produk' => [
                'type' => 'TINYINT(3) ZEROFILL',
                'unsigned' => true
            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('(CURRENT_TIMESTAMP())')
            ]
        ]);

        $this->forge->addKey('id_detail_gambar', true);
        $this->forge->addForeignKey('id_produk', 'produk', 'id_produk', 'CASCADE', 'CASCADE');
        $this->forge->createTable('produk_detail_gambar');
    }

    public function down()
    {
        $this->forge->dropTable('produk_detail_gambar');
    }
}
