<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageToProducts extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('product_image', 'products')) {
            $this->forge->addColumn('products', [
                'product_image' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'product_size'
                ]
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'product_image');
    }
}