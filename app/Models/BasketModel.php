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

    public function addItemToBasket($userId, $data)
    {
        $data['user_id'] = $userId;
        return $this->insert($data);
    }

    public function getBasketSummary($userId)
    {
        $items = $this->select('baskets.product_id, products.product_name, products.product_price, products.product_size, COUNT(baskets.product_id) as quantity')
                      ->join('products', 'products.id_product = baskets.product_id')
                      ->where('baskets.user_id', $userId)
                      ->groupBy('baskets.product_id, products.product_name, products.product_price, products.product_size')
                      ->findAll();

        $grandTotal = 0;
        $totalItems = 0;

        foreach ($items as &$item) {
            $item['subtotal'] = $item['quantity'] * $item['product_price'];
            $grandTotal += $item['subtotal'];
            $totalItems += $item['quantity'];
        }

        return ['items' => $items, 'count' => $totalItems, 'total' => $grandTotal];
    }

    public function increaseItem($userId, $productId)
    {
        return $this->insert(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function decreaseItem($userId, $productId)
    {
        $item = $this->where('user_id', $userId)
                     ->where('product_id', $productId)
                     ->orderBy('basket_id', 'DESC') 
                     ->first();

        if ($item) {
            return $this->delete($item['basket_id']);
        }
        return false;
    }

    public function removeProductCompletely($userId, $productId)
    {
        return $this->where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->delete();
    }
    
    // FUNGSI INI YANG DIPANGGIL UNTUK MENGHAPUS SEMUA ISI
    public function clearBasket($userId)
    {
        return $this->where('user_id', $userId)->delete();
    }
}