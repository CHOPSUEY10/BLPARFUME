<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Sample Products
        $products = [
            [
                'product_name' => 'Parfum Signature Pria',
                'product_price' => 850000,
                'product_desc' => 'Aroma maskulin dengan sentuhan woody dan citrus yang elegan. Cocok untuk pria dewasa yang percaya diri.',
                'product_size' => '50ml'
            ],
            [
                'product_name' => 'Parfum Premium Wanita',
                'product_price' => 1200000,
                'product_desc' => 'Koleksi eksklusif dengan aroma floral yang memikat. Dibuat khusus untuk wanita modern dan berkelas.',
                'product_size' => '75ml'
            ],
            [
                'product_name' => 'Parfum Classic Unisex',
                'product_price' => 650000,
                'product_desc' => 'Aroma klasik yang timeless, cocok untuk pria dan wanita. Perpaduan sempurna antara fresh dan warm.',
                'product_size' => '30ml'
            ],
            [
                'product_name' => 'Parfum Limited Edition',
                'product_price' => 1500000,
                'product_desc' => 'Edisi terbatas dengan formula eksklusif. Hanya tersedia dalam jumlah terbatas untuk kolektor parfum.',
                'product_size' => '100ml'
            ],
            [
                'product_name' => 'Parfum Fresh Morning',
                'product_price' => 750000,
                'product_desc' => 'Aroma segar seperti pagi hari dengan sentuhan mint dan lemon. Perfect untuk aktivitas sehari-hari.',
                'product_size' => '60ml'
            ]
        ];

        foreach ($products as $product) {
            $this->db->table('products')->insert($product);
        }

        // Sample Users (customers)
        $users = [
            [
                'id_user' => bin2hex(random_bytes(16)),
                'nama' => 'John Doe',
                'email' => 'john@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'alamat' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'no_telp' => '081234567890',
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_user' => bin2hex(random_bytes(16)),
                'nama' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'alamat' => 'Jl. Thamrin No. 456, Jakarta Pusat',
                'no_telp' => '081234567891',
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_user' => bin2hex(random_bytes(16)),
                'nama' => 'Bob Wilson',
                'email' => 'bob@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'alamat' => 'Jl. Gatot Subroto No. 789, Jakarta Selatan',
                'no_telp' => '081234567892',
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        foreach ($users as $user) {
            $this->db->table('users')->insert($user);
        }

        // Get user IDs for orders
        $userIds = $this->db->table('users')->where('role', 'user')->get()->getResultArray();
        
        // Sample Orders
        $orders = [
            [
                'user_id' => $userIds[0]['id_user'],
                'total_price' => 1700000,
                'status' => 'paid',
                'tanggal_transaksi' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'user_id' => $userIds[1]['id_user'],
                'total_price' => 1200000,
                'status' => 'paid',
                'tanggal_transaksi' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'user_id' => $userIds[2]['id_user'],
                'total_price' => 1950000,
                'status' => 'pending',
                'tanggal_transaksi' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'user_id' => $userIds[0]['id_user'],
                'total_price' => 850000,
                'status' => 'paid',
                'tanggal_transaksi' => date('Y-m-d H:i:s', strtotime('-7 days'))
            ],
            [
                'user_id' => $userIds[1]['id_user'],
                'total_price' => 2250000,
                'status' => 'paid',
                'tanggal_transaksi' => date('Y-m-d H:i:s', strtotime('-10 days'))
            ],
            [
                'user_id' => $userIds[2]['id_user'],
                'total_price' => 750000,
                'status' => 'pending',
                'tanggal_transaksi' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($orders as $order) {
            $this->db->table('orders')->insert($order);
        }

        // Get product IDs for basket
        $productIds = $this->db->table('products')->get()->getResultArray();
        
        // Sample Basket items (for top products calculation)
        $basketItems = [];
        for ($i = 0; $i < 50; $i++) {
            $basketItems[] = [
                'user_id' => $userIds[array_rand($userIds)]['id_user'],
                'product_id' => $productIds[array_rand($productIds)]['id_product'],
                'item_added' => date('Y-m-d H:i:s', strtotime('-' . rand(1, 30) . ' days'))
            ];
        }

        foreach ($basketItems as $item) {
            $this->db->table('baskets')->insert($item);
        }

        echo "Sample data seeded successfully!\n";
    }
}