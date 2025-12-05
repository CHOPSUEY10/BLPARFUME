<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\RESTful\ResourceController;
use App\Models\BasketModel;
use App\Models\OrderModel;

/**
 * @property \CodeIgniter\HTTP\IncomingRequest $request
 */

// TODO : kirim data sesuai method modelnya 
// Buatin Modelnya 
// id_basket dari fetch api pengguna, jadi id_basket itu varchar
// lalu buatkan kolom nama_produk, total_harga
    

class Basket extends ResourceController
{

    protected $format    = 'json';  
    protected $basketModel;
    protected $orderModel;

    public function __construct()
    {
        // Load models di constructor
        $this->basketModel = new BasketModel();
        $this->orderModel = new OrderModel();
    }
    /**
     * Add item to basket
     * POST /basket/api/add
     */
    public function add()
    {
        try {

            if (!session()->get('logged_in')) {
                return $this->fail([
                    'success' => false,
                    'message' => 'Please login first'
                ], 401);
            }

            // PERBAIKAN 1: Gunakan getVar() atau getJSON() dengan cara yang benar
            $json = $this->request->getJSON();
            
            // Convert to array
            if ($json) {
                $data = (array) $json;
            } else {
                // Fallback jika bukan JSON
                $data = $this->request->getPost();
            }

            // Validation rules
            $rules = [
                'product_name'  => 'required|min_length[3]',
                'product_price' => 'required',
                'product_id'    => 'required',
            ];

            if (!$this->validate($rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $userId = session()->get('user_id');
            // Prepare data
            $insertData = [
                'product_id'    => $data['product_id'],
                'user_id'       => $userId,
                'product_name'  => $data['product_name'],
                'product_price' => $data['product_price'],
                
            ];

            // Insert to database
            
            for($i = 0; $i < $data['quantity']; $i++ ){
                $insertResult = $this->basketModel->addItemToBasket($userId,$insertData);
                
                if (!$insertResult) {
                    return $this->fail([
                        'success' => false,
                        'message' => 'Failed to add item to basket'
                    ], 500);
                }    
            }
            
            
            return $this->respondCreated([
                'success' => true,
                'message' => 'Item added to basket successfully',
                
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Basket Add Error: ' . $e->getMessage());
            
            return $this->fail([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * PERBAIKAN 2: Ganti nama method delete() menjadi removeItem()
     * karena bentrok dengan parent class
     * POST /basket/api/delete
    */
    public function removeItem()
    {
        try {
            $json = $this->request->getJSON();
            
            if ($json) {
                $data = (array) $json;
            } else {
                $data = $this->request->getPost();
            }
            
            $rules = [
                'product_id' => 'required|numeric',
            ];
            
            if (!$this->validate($rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }
            
            $productId = intval($data['product_id']);
            
            
            $userId = session()->get('user_id');
            $deleted = $this->basketModel->removeItemFromBasket($productId, $userId);
            
            if (!$deleted) {
                return $this->failNotFound('Basket item not found or unauthorized');
            }


            return $this->respond([
                'success' => true,
                'message' => 'Item deleted successfully'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Removing Product From Basket Error: ' . $e->getMessage());
            
            return $this->fail([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Purchase/Checkout basket
     * POST /basket/api/purchase
     */
    public function purchase()
    {
        try {
            if (!session()->get('logged_in')) {
                return $this->fail([
                    'success' => false,
                    'message' => 'Please login first'
                ], 401);
            }
            $json = $this->request->getJSON();
            
            if ($json) {
                $data = (array) $json;
            } else {
                $data = $this->request->getPost();
            }
            
            $userId = session()->get('user_id') ?? 1;

           

            // ✅ Cek apakah basket kosong
            if ($this->basketModel->isBasketEmpty($userId)) {
                return $this->fail([
                    'success' => false,
                    'message' => 'Basket is empty'
                ], 400);
            }

            // ✅ Get summary
            $summary = $this->basketModel->getBasketSummary($userId);
             // TODO: Create order, process payment, etc.
           
            $orderId = $this->orderModel->createOrder($userId, $summary);
          
            // ✅ Clear basket
            $this->basketModel->clearBasket($userId);

            return $this->respond([
                'success' => true,
                'message' => 'Purchase completed successfully',
                'data' => [
                    'total_amount' => $summary['total'],
                    'items_count' => $summary['count'],
                ]
            ], 201);

        } catch (\Exception $e) {
            log_message('error', 'Basket Purchase Error: ' . $e->getMessage());
            
            return $this->fail([
                'success' => false,
                'message' => 'An error occurred during purchase',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get basket items
     * GET /basket/api/list
     */
    public function list()
    {
        try {
            $userId = session()->get('user_id') ?? 1;
            
          
            $summary = $this->basketModel->getBasketSummary($userId);

            return $this->respond([
                'success' => true,
                'data' => $summary
            ]);
        } catch (\Exception $e) {
            return $this->fail([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}