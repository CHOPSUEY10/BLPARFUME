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
                    'password' => 'required|min_length[6]|max_length[256]',
                ];

                if (!$this->validate($rules)) {
                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }

                $email = trim($this->request->getPost('email'));
                $password = trim($this->request->getPost('password'));
                // echo($email . $password);
              
                try {
                    
                    $user = $this->userModel->getUserIdByEmail($email);
                    
                    // 1. Cek apakah user ditemukan DAN password cocok
                    if ($user && password_verify($password, $user['password'])) {
                        
                        // LOGIN BERHASIL
                        $sessionData = [
                            'user_id'   => $user['id_user'],
                            'email'     => $user['email'],
                            'role'      => $user['role'] ?? 'user',
                            'logged_in' => true,
                        ];
                        
                        session()->set($sessionData);
                        
                        // Redirect berdasarkan role
                        if ($user['role'] === 'admin') {
                            return redirect()->to('admin/dashboard')->with('success','Selamat datang Admin!');
                        } else {
                            return redirect()->to('tentang')->with('success','Berhasil login');
                        }

                    }
                    
                    
                } catch (\Exception $e) {
    
                    // HANYA UNTUK ERROR DATABASE/SISTEM (EXCEPTION)
                    log_message('error', 'Database Error during login: ' . $e->getMessage());
                    
                    // Redirect dengan pesan yang lebih umum
                    return redirect()->back()->with('error','Password atau Email salah');
                }
                return redirect()->back()->with('error','User tidak ditemukan');

                                
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
                    'name' => [
                        'rules'  => 'permit_empty|max_length[100]',
                        'errors' => [
                            'max_length' => 'Nama lengkap maksimal 100 karakter',
                        ]
                    ],
                    'address' => [
                        'rules'  => 'max_length[150]',
                        'errors' => [
                            'max_length' => 'Alamat Maksimal 150 karakter',
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
                
                $name = trim($this->request->getPost('name'));
                $email = trim($this->request->getPost('email'));
                $password = trim($this->request->getPost('password'));
                $phone = trim($this->request->getPost('phone'));
                $address = trim($this->request->getPost('address'));

               
                $encodedIdentity = bin2hex(random_bytes(16));

                // Prepare data
                $userData = [
                    'id_user'    => $encodedIdentity,
                    'email'      => $email,
                    'password'   => password_hash($password, PASSWORD_DEFAULT), // Hash password
                    'fullname'   => $name ?? '',
                    'phone'      => $phone ?? '',
                    'address'    => $address ?? '',
                ];

                // Save to database
                try{
                    $userId = $this->userModel->insertNewUser($userData);
                    log_message('debug', $userId);
                    
                        
                        // ✅ Auto login setelah register berhasil
                        $sessionData = [
                            'user_id'   => $encodedIdentity,
                            'email'      => $email,
                            'role'       => 'user', // Default role untuk register
                            'logged_in'  => true,
                        ];
                        
                        session()->set($sessionData);
                        
                        // Redirect to dashboard with success message
                        return redirect()->to('/')
                                ->with('success', 'Registrasi berhasil! Selamat datang, ' . $name);


                }catch(Exception $e){
                    return redirect()->back()->with('error', 'Gagal mendaftar. Silakan coba lagi.');
                }
            break;
            default : 
                 
                return view('register');
            
        }

    }

        
        


}