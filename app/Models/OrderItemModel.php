<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table            = 'order_items';
    protected $primaryKey       = 'order_item_id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['order_id','product_id','product_name','product_price','quantity','subtotal','product_size'];
    protected $useAutoIncrement = true;
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at'; // Sesuai database Anda
    protected $updatedField     = 'updated_at'; 

    // Fungsi untuk membuat pesanan baru
    public function createOrder($orderId, $summary)
    {
        $data = [
            'order_id'  => $orderId,
            'product_id' => $summary['product_id'],
            'product_price' => $summary['product_price'],
            'product_name'  =>$summary['product_name'],
            'product_size'  =>$summary['product_size'],
            'quantity'  => $summary['quantity'],  
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

    public function getItemsByOrderId($orderId)
    {
        if(empty($orderId)){
            return false;
        }
        // Ambil item dari order_items

        try{

            $items = $this->select('product_id, quantity')
            ->where('order_id', $orderId)
            ->get()
            ->getResultArray();

            return $items;

        }catch(\Exception $e){

            log_message('error', 'Error Message : '.$e->getMessage());
            return false;

        }




        
    }
}