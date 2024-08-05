<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Kupon extends Migration
{
    /**
     * Creates a new table in the database called 'kupon' with the following fields:
     * - 'id_kupon': a SMALLINT(5) ZEROFILL field that is auto-increment and unsigned.
     * - 'id_unique_kupon': a VARCHAR field with a maximum length of 8 and nullable.
     * - 'deskripsi_kupon': a TEXT field.
     * - 'max_nominal_kupon': an INT field.
     * - 'discount_kupon': a TINYINT field.
     * - 'level_kupon': a TINYINT field. Level Kupon berdasarkan banyaknya customer melakukan transaksi
     * 1 = 3x Transaksi, 2 = 5x Transaksi, 3 = 8x Transaksi
     * - 'created_at': a DATETIME field with a default value of the current timestamp.
     *
     * @return void
     */
    public function up()
    {
        $this->forge->addField([
            'id_kupon' => [
                'type' => 'SMALLINT(5) ZEROFILL',
                'auto_increment' => true,
                'unsigned' => true
            ],
            'id_unique_kupon' => [
                'type' => 'VARCHAR',
                'constraint' => 8,
                'null' => true
            ],
            'deskripsi_kupon' => [
                'type' => 'TEXT',
            ],
            'max_nominal_kupon' => [
                'type' => 'INT'
            ],
            'discount_kupon' => [
                'type' => 'TINYINT'
            ],
            'level_kupon' => [
                'type' => 'TINYINT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('(CURRENT_TIMESTAMP())')
            ]
        ]);

        $this->forge->addKey('id_kupon', true);
        $this->forge->createTable('kupon');
    }

    public function down()
    {
        $this->forge->dropTable('kupon');
    }
}
