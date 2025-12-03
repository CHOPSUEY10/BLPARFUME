<?php

namespace App\Models;

use CodeIgniter\Model;

class BasketModel extends Model
{
    protected $table            = 'baskets';
    protected $primaryKey       = 'basket_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'product_id'];
    protected $useTimestamps    = true;
    protected $createdField     = 'item_added';
    protected $updatedField     = 'item_updated';


    /**
     * Menambahkan item ke keranjang
     */
    public function addItemToBasket($userId, $data)
    {
        // Pastikan user_id masuk ke data insert
        $data['user_id'] = $userId;
        return $this->insert($data);
    }

    /**
     * Menghapus 1 item dari keranjang berdasarkan product_id
     * Kita cari 1 baris saja yang cocok, lalu hapus.
     */
    public function removeItemFromBasket($productId, $userId)
    {
        // Cari item pertama yang cocok dengan produk dan user
        $item = $this->where('user_id', $userId)
                     ->where('product_id', $productId)
                     ->first();

        if ($item) {
            // Hapus berdasarkan ID unik baris tersebut
            return $this->delete($item['id']);
        }

        return false;
    }

    /**
     * Cek apakah keranjang kosong
     */
    public function isBasketEmpty($userId)
    {
        return $this->countAllResults(['user_id' => $userId]) === 0;
    }

    /**
     * Mengambil ringkasan keranjang (List Item + Total Harga)
     * Digunakan untuk list() dan purchase()
     */
    public function getBasketSummary($userId)
    {
        // 1. Ambil detail item yang dikelompokkan (Group By) agar rapi
        // Contoh: Dior Sauvage (Qty: 2)
        $items = $this->select('product_id, product_name, product_price, COUNT(*) as quantity, SUM(product_price) as subtotal')
                      ->where('user_id', $userId)
                      ->groupBy('product_id, product_name, product_price')
                      ->findAll();

        // 2. Hitung Grand Total
        $grandTotal = 0;
        $totalItems = 0;

        foreach ($items as $item) {
            $grandTotal += $item['subtotal'];
            $totalItems += $item['quantity'];
        }

        // Return format array lengkap
        return [
            'items' => $items,     // List detail produk
            'count' => $totalItems, // Total jumlah barang
            'total' => $grandTotal  // Total uang yang harus dibayar
        ];
    }

    /**
     * Kosongkan keranjang setelah checkout
     */
    public function clearBasket($userId)
    {
        return $this->where('user_id', $userId)->delete();
    }
}