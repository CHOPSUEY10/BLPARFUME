<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\RESTful\ResourceController;



class Dashboard extends ResourceController {

    public function admin(){
        
        return $this->respond([
            'error'   => false,
            'redirect' => 'admin/dashboard',
            'message'  => ''
        ]);
        
    }

    public function adminpesanan(){

          return $this->respond([
            'error'   => false,
            'redirect' => 'admin/order/view',
            'message'  => ''
        ]);

    }

    public function admintransaksi(){

          return $this->respond([
            'error'   => false,
            'redirect' => 'admin/transaction/view',
            'message'  => ''
        ]);

    }

    public function adminkeuangan(){

          return $this->respond([
            'error'   => false,
            'redirect' => 'admin/finance/view',
            'message'  => ''
        ]);

    }

    public function adminproduk(){

          return $this->respond([
            'error'   => false,
            'redirect' => 'admin/product/view',
            'message'  => ''
        ]);

    }
   
}