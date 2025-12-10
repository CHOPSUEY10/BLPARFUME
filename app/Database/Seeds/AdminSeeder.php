<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id_user'    => bin2hex(random_bytes(16)),
            'nama'       => 'Administrator',
            'email'      => 'admin@blparfume.com',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'alamat'     => 'Kantor Pusat BL Parfume',
            'no_telp'    => '081234567890',
            'role'       => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($data);
    }
}