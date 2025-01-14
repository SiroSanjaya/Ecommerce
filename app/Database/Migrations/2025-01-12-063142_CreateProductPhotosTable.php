<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductPhotosTable extends Migration
{
    public function up()
    {
        // Membuat tabel 'product_photos'
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'photo_url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Menambahkan foreign key untuk 'product_id' yang merujuk ke tabel 'product_details'
        $this->forge->addForeignKey('product_id', 'product_details', 'id', 'CASCADE', 'CASCADE');

        // Menjadikan 'id' sebagai primary key
        $this->forge->addKey('id', true);

        // Membuat tabel
        $this->forge->createTable('product_photos');
    }

    public function down()
    {
        // Menghapus tabel 'product_photos' jika migrasi dibatalkan
        $this->forge->dropTable('product_photos');
    }
}
