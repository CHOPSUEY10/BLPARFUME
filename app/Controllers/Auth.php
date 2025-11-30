<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;

class Auth extends Controller
{
    protected $userModel;
    public function __construct(){
        $this->userModel = new UserModel();
    }


    public function login()
    {
        $method = $this->request->getMethod(true);
        
        switch($method){
            case 'POST':
                $rules = [
                    'email'    => 'required|valid_email',
                    'password' => 'required|min_length[6]',
                ];

                if (!$this->validate($rules)) {
                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }

                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');

            // Medapatkan id user berdasarkan input email

                $user = $this->userModel->getUserIdByEmail($email);
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
            break;
            default:
                return view('login');
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

    public function register()
    {

        $method = $this->request->getMethod(true);
        if(!$method){
            return $this->response()->setStatusCode(400)->setMessage('Bad Request');
        }

        switch($method){

            case 'POST' : 
                $rules = [
                    'username' => [
                        'rules'  => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                        'errors' => [
                            'required'    => 'Username wajib diisi',
                            'min_length'  => 'Username minimal 3 karakter',
                            'max_length'  => 'Username maksimal 50 karakter',
                            'is_unique'   => 'Username sudah digunakan',
                        ]
                    ],
                    'email' => [
                        'rules'  => 'required|valid_email|is_unique[users.email]',
                        'errors' => [
                            'required'    => 'Email wajib diisi',
                            'valid_email' => 'Email tidak valid',
                            'is_unique'   => 'Email sudah terdaftar',
                        ]
                    ],
                    'password' => [
                        'rules'  => 'required|min_length[6]|max_length[255]',
                        'errors' => [
                            'required'   => 'Password wajib diisi',
                            'min_length' => 'Password minimal 6 karakter',
                        ]
                    ],
                    'password_confirm' => [
                        'rules'  => 'required|matches[password]',
                        'errors' => [
                            'required' => 'Konfirmasi password wajib diisi',
                            'matches'  => 'Konfirmasi password tidak cocok',
                        ]
                    ],
                    'fullname' => [
                        'rules'  => 'permit_empty|max_length[100]',
                        'errors' => [
                            'max_length' => 'Nama lengkap maksimal 100 karakter',
                        ]
                    ],
                    'phone' => [
                        'rules'  => 'permit_empty|numeric|min_length[10]|max_length[15]',
                        'errors' => [
                            'numeric'    => 'Nomor telepon harus berupa angka',
                            'min_length' => 'Nomor telepon minimal 10 digit',
                            'max_length' => 'Nomor telepon maksimal 15 digit',
                        ]
                    ],
                ];

                // Validate input
                if (!$this->validate($rules)) {
                    return redirect()->back()
                                ->withInput()
                                ->with('errors', $this->validator->getErrors());
                }

                // Get form data
                $username = $this->request->getPost('username');
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                $fullname = $this->request->getPost('fullname');
                $phone = $this->request->getPost('phone');

                // Prepare data
                $userData = [
                    'username'   => $username,
                    'email'      => $email,
                    'password'   => password_hash($password, PASSWORD_DEFAULT), // Hash password
                    'fullname'   => $fullname ?? '',
                    'phone'      => $phone ?? '',
                    'role'       => 'customer', // Default role
                    'is_active'  => 1, // Active by default
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                // Save to database
                try{
                    $userId = $this->userModel->insertNewUser($userData);

                    if (!$userId) {
                        // If insert failed
                        return redirect()->back()
                                    ->withInput()
                                    ->with('error', 'Gagal mendaftar. Silakan coba lagi.');
                    }

                    // ✅ Auto login setelah register berhasil
                    $sessionData = [
                        'user_id'    => $userId,
                        'username'   => $username,
                        'email'      => $email,
                        'logged_in'  => true,
                    ];
                    
                    session()->set($sessionData);

                    // Redirect to dashboard with success message
                    return redirect()->to('/dashboard')
                                ->with('success', 'Registrasi berhasil! Selamat datang, ' . $username);
                }catch(Exception $e){
                    return redirect()->back()
                                ->withInput()
                                ->with('error', 'Gagal mendaftar. Silakan coba lagi.');
                }
            break;
            default : 
                 
                return view('register');
            break;
        }

    }

        
        


}