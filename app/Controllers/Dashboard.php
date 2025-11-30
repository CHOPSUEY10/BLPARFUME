<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        // Cara 1: Menggunakan helper session()
        $userId = session()->get('user_id');
        $username = session()->get('username');
        $isLoggedIn = session()->get('logged_in');
        
        // Cara 2: Menggunakan service
        $session = \Config\Services::session();
        $userId = $session->get('user_id');
        
        // Cek apakah session ada
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu!');
        }
        
        // Ambil semua session
        $allSession = session()->get();
        
        $data = [
            'user_id' => $userId,
            'username' => $username,
        ];
        
        return view('dashboard', $data);
    }
}