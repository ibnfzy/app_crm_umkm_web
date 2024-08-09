<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InformasiToko extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_informasi_toko' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'tentang' => [
                'type' => 'TEXT'
            ],
            'kontak_wa' => [
                'type' => 'VARCHAR',
                'constraint' => 13
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
        ]);

        $this->forge->addKey('id_informasi_toko', true);
        $this->forge->createTable('informasi_toko');
    }

    public function down()
    {
        $this->forge->dropTable('informasi_toko');
    }
}
