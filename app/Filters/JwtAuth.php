<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\Config\Services;

class JwtAuth implements FilterInterface
{
    // JWT mengamankan "Siapa yang meminta" (Authentication).
    public function before(RequestInterface $request, $arguments = null)
    {
        // mengambil value dari key header requests
        $authHeader = $request->getHeaderLine('Authorization') ?: $request->getServer('HTTP_AUTHORIZATION');
        if (!$authHeader) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON([
                    'error' => true,
                    'message' => 'Authorization header missing'
                ]);
        }

        // memastikan String 'Bearer' ada pada posisi pertama
        if (strpos($authHeader, 'Bearer ') !== 0) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON([
                    'error' => true,
                    'message' => 'Invalid Authorization header format'
                ]);
        }

        // mengambil token dengan memangkas 7 string awal pada Authorization
        $token = substr($authHeader, 7);
        // mengambil  kunci rahasia untuk decode token
        $secret = getenv('app.jwtSecret') ?: 'change_me';

        try {
            // decode token berdasarkan kunci rahasia dan algoritma encoder
            $decoded = JWT::decode($token, new Key($secret, 'HS256'));
            
            //cek revoked tokens
            $user_token = $decoded->user_token ?? null;
            if ($user_token) {
                $db = \Config\Database::connect();
                $row = $db->table('revoked_tokens')->where('user_token', $user_token)->get()->getRow();
                if ($row) {
                    return Services::response()
                        ->setStatusCode(401)
                        ->setJSON([
                            'error' => true,
                            'message' => 'Token has been revoked'
                        ]);
                }    
            }

            // expose decoded for controllers
            $request->decoded = $decoded;
        } catch (\Throwable $e) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['error' => 'Token tidak valid atau kedaluwarsa', 'msg' => $e->getMessage()]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing
    }
}
