<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToUsers extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('role', 'users')) {
            $this->forge->addColumn('users', [
                'role' => [
                    'type' => 'ENUM',
                    'constraint' => ['admin', 'user'],
                    'default' => 'user',
                    'after' => 'password'
                ]
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'role');
    }
}