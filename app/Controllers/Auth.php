<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = model('UserModel');
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            
            // ✅ Simpan session setelah login berhasil
            $sessionData = [
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'email'      => $user['email'],
                'role'       => $user['role'] ?? 'customer',
                'logged_in'  => true,
            ];
            
            session()->set($sessionData);
            
            // Atau bisa satu-satu
            // session()->set('user_id', $user['id']);
            // session()->set('username', $user['username']);
            // session()->set('logged_in', true);
            
            return redirect()->to('/dashboard')->with('success', 'Login berhasil!');
            
        } else {
            return redirect()->back()->with('error', 'Email atau password salah!');
        }
    }

    public function logout()
    {
        // Hapus semua session
        session()->destroy();
        
        // Atau hapus session tertentu
        // session()->remove('user_id');
        // session()->remove('username');
        // session()->remove('logged_in');
        
        return redirect()->to('/login')->with('success', 'Logout berhasil!');
    }
}