<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CustomerKupon extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_customer_kupon' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'id_customer' => [
                'type' => 'TINYINT(3) ZEROFILL',
                'unsigned' => true
            ],
            'id_kupon' => [
                'type' => 'SMALLINT(5) ZEROFILL',
                'unsigned' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('(CURRENT_TIMESTAMP())')
            ],
            'expired_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id_customer_kupon', true);
        $this->forge->addForeignKey('id_customer', 'customer', 'id_customer', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kupon', 'kupon', 'id_kupon', 'CASCADE', 'CASCADE');
        $this->forge->createTable('customer_kupon');
    }

    public function down()
    {
        $this->forge->dropTable('customer_kupon');
    }
}
