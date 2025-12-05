<?php

namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\Config\Services;

class AdminAuth extends ResourceController
{
    protected $format = 'json';
    protected $userModel;
    protected $secret;
    protected $expire;
    protected $request;
        
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->secret = getenv('app.jwtSecret') ?: 'change_me';
        $this->expire = (int)(getenv('app.jwtExpire') ?: 3600);
        $this->request = service('request');
    }

    public function register()
    {
        $data = $this->request->getJSON(true);
        if (!isset($data['email']) || !isset($data['password'])) {
            return $this->failValidationErrors('email & password wajib');
        }

        if ($this->userModel->getUserIdByEmail($data['email'])) {
            return $this->fail('Email sudah terpakai', 400);
        }
        $now = time();
        $jti = bin2hex(random_bytes(16)); // unique token id

        $payload = [
            'iat' => $now,
            'exp' => $now + $this->expire,
            'jti' => $jti,
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        $token = JWT::encode($payload, $this->secret, 'HS256');


        $encodedIdentity = bin2hex(random_bytes(16));
        $save = [
            'id_user' => $encodedIdentity,
            'fullname'    =>$data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ];

        // TODO : ubah method untuk menyimpan model tersebut.

        try{
            $this->userModel->insertNewUser($save);

            return $this->respond([
                'message' => 'Admin terdaftar',
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $this->expire,
                'name' => $data['name']
            ]);
        }catch(\Exception $e){
            log_message('error', 'Menambahkan akun admin gagal : ' . $e->getMessage());
            
            return $this->fail([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }


    }

    public function login()
    {
        $data = $this->request->getJSON(true);
        if (!isset($data['email']) || !isset($data['password'])) {
            return $this->failValidationErrors('email & password wajib');
        }

        // TODO : ubah method model yang mencari array data user tersebut 
        $user = $this->userModel->getUserIdByEmail($data['email']);
        if (!$user) return $this->failNotFound('Admin tidak ditemukan');

        if (!password_verify($data['password'], $user['password'])) {
            return $this->fail('Password salah', 401);
        }

        $now = time();
        $jti = bin2hex(random_bytes(16)); // unique token id

        $payload = [
            'iat' => $now,
            'exp' => $now + $this->expire,
            'jti' => $jti,
            'email' => $user['email'],
            'password' => $user['password'],
        ];

        $token = JWT::encode($payload, $this->secret, 'HS256');

        return $this->respond([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->expire,
            'name' => $user['nama'],
            'message' => "Selamat datang,". $user['nama']

        ]);
    }

      public function logout()
    {
        $authHeader = $this->request->getHeaderLine('Authorization') ?: $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$authHeader || strpos($authHeader, 'Bearer ') !== 0) {
            return $this->failUnauthorized('Authorization header missing');
        }

        $token = substr($authHeader, 7);

        try {
            $decoded = JWT::decode($token, new Key($this->secret, 'HS256'));
        } catch (\Throwable $e) {
            return $this->fail('Token invalid: ' . $e->getMessage(), 401);
        }

        $jti = $decoded->jti ?? null;
        $expTs = isset($decoded->exp) ? (int)$decoded->exp : (time() + $this->expire);
        $exp = date('Y-m-d H:i:s', $expTs);

        if ($jti) {
            $db = \Config\Database::connect();
            $builder = $db->table('revoked_tokens');

            // hindari duplicate insert
            $exists = $builder->where('user_token', $jti)->get()->getRow();
            if (!$exists) {
                $builder->insert([
                    'user_token' => $jti,
                    'expired_at' => $exp
                ]);
            }
        }

        return $this->respond(['message' => 'Logout sukses, token dibatalkan di server']);
    }

}