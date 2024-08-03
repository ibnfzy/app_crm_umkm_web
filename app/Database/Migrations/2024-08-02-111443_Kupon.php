<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Kupon extends Migration
{
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
                'type' => 'INT'
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
