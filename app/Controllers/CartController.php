<?php

namespace App\Controllers;

use App\Models\BasketModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel;


class CartController extends BaseController 
{
    /**
     * Menambahkan Item Baru ke Keranjang
     */
    public function addBasket()
    {
        if (!$this->request->isAJAX()) {
             return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid Request']);
        }

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON([
                'success' => false, 
                'message' => 'Silakan login terlebih dahulu.',
                'token'   => csrf_hash()
            ]);
        }

        $json = $this->request->getJSON();
        $productId = $json->product_id ?? null;

        if (!$productId) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false, 
                'message' => 'Produk tidak ditemukan.',
                'token'   => csrf_hash()
            ]);
        }

        $basketModel = new BasketModel();
        $dataInsert = ['product_id' => $productId];

        try {
            $basketModel->addItemToBasket($userId, $dataInsert);
            
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Produk berhasil masuk keranjang!',
                'token'   => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false, 
                'message' => 'Gagal menyimpan: ' . $e->getMessage(),
                'token'   => csrf_hash()
            ]);
        }
    }

    /**
     * Mengupdate Jumlah Item (+ / -)
     */
    public function updateBasket()
    {
        if (!$this->request->isAJAX()) return $this->response->setStatusCode(400);

        $userId = session()->get('user_id');
        if (!$userId) return $this->response->setStatusCode(401);

        $json = $this->request->getJSON();
        $productId = $json->product_id;
        $action    = $json->action; 

        $basketModel = new BasketModel();
        $success = false;

        if ($action === 'increase') {
            $basketModel->increaseItem($userId, $productId);
            $success = true;
        } elseif ($action === 'decrease') {
            $basketModel->decreaseItem($userId, $productId);
            $success = true;
        }

        return $this->response->setJSON([
            'success' => $success,
            'message' => 'Keranjang diperbarui',
            'token'   => csrf_hash()
        ]);
    }

    /**
     * Menghapus Produk Total (Trash)
     */
    public function deleteBasket()
    {
        if (!$this->request->isAJAX()) return $this->response->setStatusCode(400);

        $userId = session()->get('user_id');
        if (!$userId) return $this->response->setStatusCode(401);

        $json = $this->request->getJSON();
        $productId = $json->product_id;

        $basketModel = new BasketModel();
        $basketModel->removeProductCompletely($userId, $productId);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang',
            'token'   => csrf_hash()
        ]);
    }

    /**
     * PROSES CHECKOUT (Simpan Order -> Hapus Keranjang -> Respon Sukses)
     */
    public function checkout()
    {
        if (!$this->request->isAJAX()) return $this->response->setStatusCode(400);

        $userId = session()->get('user_id');
        if (!$userId) return $this->response->setStatusCode(401);

        // 1. Ambil Data Keranjang
        $basketModel = new BasketModel();
        $summary = $basketModel->getBasketSummary($userId);

        if (empty($summary['items'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Keranjang kosong',
                'token'   => csrf_hash()
            ]);
        }

        
        // 2. Simpan ke Tabel Orders
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $productModel = new ProductModel();

        $productIds = array_column($summary['items'], 'product_id');

        $productStock = $productModel->getStockProductMap($productIds);
        foreach($summary['items'] as  $item ){
            $productId = $item['product_id'];
            $qty = $item['quantity'];
            $stock = $productStock[$productId] ?? 0;
            
            if ($stock < $qty) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Stok produk tidak mencukupi',
                    'product_id' => $productId,
                    'token'   => csrf_hash()
                ]);
            }
        }
        
        $orderId = $orderModel->insert([
            'user_id'     => $userId,
            'total_price' => $summary['total'],
            'status'      => 'pending'
        ]);

       

        if ($orderId) {
            // 3. KOSONGKAN KERANJANG (INI BAGIAN UTAMANYA)
            foreach($summary['items'] as $items){
                $orderItemModel->createOrder($orderId,$items);
            }
            $basketModel->clearBasket($userId); 
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Pesanan dibuat',
                'order_id'=> $orderId, 
                'token'   => csrf_hash()
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal membuat pesanan',
            'token'   => csrf_hash()
        ]);
    }
}