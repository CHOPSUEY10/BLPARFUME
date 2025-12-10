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
        $data['products'] = $productModel->getAllItems();
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