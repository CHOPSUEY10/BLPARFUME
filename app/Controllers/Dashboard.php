<?php

namespace App\Controllers;

class Dashboard extends BaseController
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

     public function adminlogin(){
        return view('admin/adminlogin');
    }

    public function adminregister(){
        return view('admin/adminregister');
    }

    public function admin(){
        return view('admin/admindashboard');
    }

     public function adminpesanan(){
         return view('admin/adminpesanan');
     
    }
        
    public function admintransaksi(){
            
        return view('admin/admintransaksi');
    }
    
    public function adminkeuangan(){

        return view('admin/adminkeuangan');
        
    }
    
    public function adminproduk(){
        
        return view('admin/adminproduk');
    
    }


}