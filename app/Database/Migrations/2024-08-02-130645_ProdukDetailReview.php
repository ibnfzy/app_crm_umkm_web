<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class ProdukDetailReview extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail_review' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_produk' => [
                'type' => 'TINYINT(3) ZEROFILL',
                'unsigned' => true
            ],
            'id_customer' => [
                'type' => 'TINYINT(3) ZEROFILL',
                'unsigned' => true
            ],
            'rating' => [
                'type' => 'CHAR(1)',
            ],
            'review' => [
                'type' => 'TINYINT'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('(CURRENT_TIMESTAMP())')
            ]
        ]);

        $this->forge->addKey('id_detail_review', true);
        $this->forge->addForeignKey('id_produk', 'produk', 'id_prouduk', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_customer', 'customer', 'id_customer', 'CASCADE', 'CASCADE');
        $this->forge->createTable('produk_detail_review');
    }

    public function down()
    {
        $this->forge->dropTable('produk_detail_review');
    }
}
