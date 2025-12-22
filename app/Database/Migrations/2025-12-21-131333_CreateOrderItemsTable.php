<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_item_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'product_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'product_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'quantity' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('order_item_id', true);

        // Foreign Keys
        $this->forge->addForeignKey(
            'order_id',
            'orders',
            'id_order',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'product_id',
            'products',
            'id_product',
            'RESTRICT',
            'CASCADE'
        );

        $this->forge->createTable('order_items');
    }

    public function down()
    {
        $this->forge->dropTable('order_items');
    }
}
