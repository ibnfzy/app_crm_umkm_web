<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Slider extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_slider' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'file' => [
                'type' => 'TEXT'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('(CURRENT_TIMESTAMP())')
            ]
        ]);

        $this->forge->addKey('id_slider', true);
        $this->forge->createTable('slider');
    }

    public function down()
    {
        $this->forge->dropTable('slider');
    }
}