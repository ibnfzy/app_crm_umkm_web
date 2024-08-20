<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Customer extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_customer' => [
                'type' => 'TINYINT(3) ZEROFILL',
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'id_unique_customer' => [
                'type' => 'VARCHAR',
                'null' => true,
                'constraint' => 32,
            ],
            'id_ongkir' => [
                'type' => 'INT',
            ],
            'nama_customer' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'email_customer' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'password_customer' => [
                'type' => 'TEXT'
            ],
            'no_wa' => [
              'type' => 'VARCHAR',
              'constraint' => 13
            ],
            'alamat' => [
                'type' => 'TEXT'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('(CURRENT_TIMESTAMP())')
            ],
        ]);

        $this->forge->addKey('id_customer', true);

        $this->forge->createTable('customer');
    }

    public function down()
    {
        $this->forge->dropTable('customer');
    }
}
