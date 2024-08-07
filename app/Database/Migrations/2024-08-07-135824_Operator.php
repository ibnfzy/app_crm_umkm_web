<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Operator extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_operator' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('(CURRENT_TIMESTAMP())')
            ]
        ]);

        $this->forge->addKey('id_operator', true);
        $this->forge->createTable('operator');
    }

    public function down()
    {
        $this->forge->dropTable('operator');
    }
}