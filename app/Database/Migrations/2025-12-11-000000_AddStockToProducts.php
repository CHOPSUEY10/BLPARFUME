<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStockToProducts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products', [
            'stock' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'null'       => false,
                'comment'    => 'Product stock quantity',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'stock');
    }
}
