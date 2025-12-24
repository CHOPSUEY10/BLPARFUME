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

    public function getOrderData(){
        try{
            return $this->select('orders.order_id, users.nama, users.email, orders.total_price, orders.status, orders.tanggal_transaksi')
            ->join('users','users.id_user = orders.user_id')
            ->findAll();
        }catch(\Exception $e){
            log_message('error', 'error message :'. $e->getMessage());
        }
    }

  public function getPaidOrderData(int $month)
    {
    try {
        return $this->select('
                orders.order_id,
                users.nama,
                users.email,
                orders.total_price,
                orders.status,
                orders.tanggal_transaksi
            ')
            ->join('users', 'users.id_user = orders.user_id')
            ->where('orders.status', 'paid')
            ->where('MONTH(orders.tanggal_transaksi)', $month, false)
            ->where('YEAR(orders.tanggal_transaksi)', date('Y'), false)
            ->orderBy('orders.tanggal_transaksi', 'ASC')
            ->findAll();

    } catch (\Exception $e) {
        log_message('error', 'getPaidOrderData error: ' . $e->getMessage());
        return []; // ⬅️ WAJIB
    }
}

    
}