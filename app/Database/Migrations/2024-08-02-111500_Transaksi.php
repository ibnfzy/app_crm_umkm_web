<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Transaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi' => [
                'type' => 'SMALLINT(5) ZEROFILL',
                'auto_increment' => true,
                'unsigned' => true
            ],
            'id_unique_transaksi' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null' => true
            ],
            'id_customer' => [
                'type' => 'TINYINT(3) ZEROFILL',
                'unsigned' => true
            ],
            'id_kupon' => [
                'type' => 'SMALLINT(5) ZEROFILL',
                'unsigned' => true
            ],
            'total_kuantitas_belanja' => [
                'type' => 'SMALLINT'
            ],
            'total_bayar_belanja' => [
                'type' => 'INT'
            ],
            'diskon' => [
                'type' => 'INT'
            ],
            'bukti_bayar' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'tanggal_checkout' => [
                'type' => 'DATETIME',
                'default' => new RawSql('(CURRENT_TIMESTAMP())')
            ],
            'batas_pembayaran' => [
                'type' => 'DATE'
            ],
            'status_transaksi' => [
                'type' => 'VARCHAR',
                'default' => 'Menunggu Bukti Pembayaran',
                'constraint' => 255
            ],
            'max_potongan' => [
                'type' => 'INT',
            ],
            'nama_ekspedisi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'nomor_resi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
        ]);

        $this->forge->addKey('id_transaksi', true);
        $this->forge->addForeignKey('id_customer', 'customer', 'id_customer', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}
