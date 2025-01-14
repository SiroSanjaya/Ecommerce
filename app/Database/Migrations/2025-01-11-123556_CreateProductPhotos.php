<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductPhotos extends Migration
{
    public function up()
    {
        // Membuat tabel product_details
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'unsigned'      => true,
                'auto_increment' => true,
            ],
            'product_id'  => [
                'type'       => 'INT',
                'unsigned'  => true,
            ],
            'type'         => [
                'type'       => 'ENUM',
                'constraint' => ['description', 'highlight', 'detail'],
            ],
            'description'  => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'highlight'    => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'detail'       => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_details');

        // Membuat tabel product_photos
        $this->forge->addField([
            'id'              => [
                'type'           => 'INT',
                'unsigned'      => true,
                'auto_increment' => true,
            ],
            'product_detail_id' => [
                'type'       => 'INT',
                'unsigned'  => true,
            ],
            'photo_url'        => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at'       => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('product_detail_id', 'product_details', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_photos');
    }

    public function down()
    {
        // Drop tabel jika migrasi di-revert
        $this->forge->dropTable('product_photos');
        $this->forge->dropTable('product_details');
    }
}