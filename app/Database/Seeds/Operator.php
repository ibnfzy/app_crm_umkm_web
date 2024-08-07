<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Operator extends Seeder
{
    public function run()
    {
        $this->forge->addField([
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
        ]);
    }
}