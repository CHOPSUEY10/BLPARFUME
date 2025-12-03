<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'order_id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'total_price', 'items_count', 'status'];
    protected $useAutoIncrement = true;
    protected $useTimestamps    = true;
    protected $createdField     = 'tanggal_transaksi';

    /**
     * Membuat Order baru berdasarkan data dari BasketSummary
     */
    public function createOrder($userId, $summary)
    {
        $data = [
            'user_id'      => $userId,
            'total_amount' => $summary['total'], // Ambil dari hasil getBasketSummary
            'items_count'  => $summary['count'],
            'status'       => 'pending' // Default status
        ];

        $this->insert($data);
        
        return $this->getInsertID(); // Mengembalikan ID Order yang baru dibuat
    }
}