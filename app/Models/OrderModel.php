<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'order_id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'total_price', 'items_count', 'status', 'created_at'];
    protected $useAutoIncrement = true;
    protected $useTimestamps    = true;
    protected $createdField     = 'tanggal_transaksi'; // Sesuai database Anda
    protected $updatedField     = ''; 

    // Fungsi untuk membuat pesanan baru
    public function createOrder($userId, $summary)
    {
        $data = [
            'user_id'      => $userId,
            'total_price'  => $summary['total'], 
            'status'       => 'pending' 
        ];

        return $this->insert($data);
    }

    // Fungsi untuk mengambil riwayat pesanan user
    public function getHistory($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('tanggal_transaksi', 'DESC')
                    ->findAll();
    }

    // Fungsi untuk update status pesanan
    public function updateOrderStatus($orderId, $status)
    {
        return $this->update($orderId, ['status' => $status]);
    }
}