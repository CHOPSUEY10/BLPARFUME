<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\BasketModel;

class Home extends BaseController

{
    public function index()
    {  
        $logged_in = session()->get('user_id');
        if(!$logged_in){
            return redirect()->to('login');
        }

        $data = [
            'meta' => ['title' => 'Bl Parfume'],
        ];

        return view('main', $data);
    }

    public function shop()
    {
        $productModel = new ProductModel();
        $products = $productModel->getAllItems();

        // Group products by normalized name and collect sizes with their product IDs
        $grouped = [];
        foreach ($products as $p) {
            $rawName = $p['product_name'] ?? $p['name'] ?? null;
            if($p['stock'] === 0){
                $productModel->removeProduct($p['id_product']);
            }
            
            if ($rawName === null) {
                continue;
            }

            // Normalize name to avoid differences like trailing spaces or case
            $key = trim($rawName);
            if (function_exists('mb_strtolower')) {
                $key = mb_strtolower($key);
            } else {
                $key = strtolower($key);
            }
            if ($key === '') continue;

            $id   = $p['id_product'] ?? null;
            $size = $p['product_size'] ?? null;

            if (!isset($grouped[$key])) {
                $item = $p;
                // Keep the canonical product_name as original casing
                $item['product_name'] = $rawName;
                // Create a `sizes` array that holds arrays with id and size
                $item['sizes'] = [];
                if ($id !== null && $size !== null) {
                    $item['sizes'][] = ['id' => $id, 'size' => $size];
                }
                $grouped[$key] = $item;
            } else {
                if ($id !== null && $size !== null) {
                    // avoid duplicates by id
                    $exists = false;
                    foreach ($grouped[$key]['sizes'] as $s) {
                        if (isset($s['id']) && $s['id'] == $id) {
                            $exists = true;
                            break;
                        }
                    }
                    if (! $exists) {
                        $grouped[$key]['sizes'][] = ['id' => $id, 'size' => $size];
                    }
                }
            }
        }

        $data['products'] = array_values($grouped);

        return view('shop', $data);
    }

    public function keranjang(){
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $basketModel = new BasketModel();
        $summary = $basketModel->getBasketSummary($userId);
        
        $data['summary'] = $summary;
        return view('keranjang', $data);
    }

    // FITUR BARU: HALAMAN RIWAYAT
    public function riwayat()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('login');
        }

        $orderModel = new OrderModel();
        $data = [
            'orders' => $orderModel->getHistory($userId),
            'meta'   => ['title' => 'Riwayat Pesanan']
        ];

        return view('riwayat', $data);
    }

    public function tentang()
    {
        return view('tentang');
    }

    public function kontak(){
        return view('kontak');
    }

    public function sendContact()
    {
        // Validasi input
        if (!$this->validate([
            'nama' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'pesan' => 'required|min_length[10]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan pesan ke database
        $messageModel = new \App\Models\MessageModel();
        
        $data = [
            'name' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('telepon'),
            'message' => $this->request->getPost('pesan')
        ];
        
        if ($messageModel->save($data)) {
            return redirect()->to('kontak')->with('success', 'Pesan Anda berhasil dikirim! Tim kami akan segera merespons.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim pesan. Silakan coba lagi.');
        }
    }
}