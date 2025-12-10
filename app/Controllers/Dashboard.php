<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $adminModel;
    protected $productModel;
    protected $orderModel;
    protected $userModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
    }

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

    public function admin(){
        // Validasi tambahan (meskipun sudah ada filter)
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }
        
        // Get real dashboard statistics
        $stats = $this->adminModel->getDashboardStats();
        $recentOrders = $this->adminModel->getRecentOrders(5);
        $topProducts = $this->adminModel->getTopProducts(3);
        $monthlySales = $this->adminModel->getMonthlySalesData();
        
        $data = [
            'title' => 'Dashboard Admin',
            'pageTitle' => 'Dashboard',
            'admin_name' => session()->get('email'),
            'user_id' => session()->get('user_id'),
            'stats' => $stats,
            'recent_orders' => $recentOrders,
            'top_products' => $topProducts,
            'monthly_sales' => $monthlySales
        ];
        
        return view('admin/admindashboard', $data);
    }

    public function adminpesanan(){
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }
        
        // Get search and filter parameters
        $search = $this->request->getGet('search') ?? '';
        $status = $this->request->getGet('status') ?? '';
        $page = $this->request->getGet('page') ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Get orders data
        $orders = $this->adminModel->getAllOrders($limit, $offset, $search, $status);
        $stats = $this->adminModel->getDashboardStats();
        
        $data = [
            'title' => 'Manajemen Pesanan',
            'pageTitle' => 'Pesanan',
            'orders' => $orders,
            'stats' => $stats,
            'search' => $search,
            'status' => $status,
            'current_page' => $page
        ];
        
        return view('admin/adminpesanan', $data);
    }
        
    public function admintransaksi(){
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }
        
        // Get search and filter parameters
        $search = $this->request->getGet('search') ?? '';
        $status = $this->request->getGet('status') ?? '';
        $page = $this->request->getGet('page') ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Get transactions data
        $transactions = $this->adminModel->getAllTransactions($limit, $offset, $search, $status);
        $stats = $this->adminModel->getDashboardStats();
        
        $data = [
            'title' => 'Manajemen Transaksi',
            'pageTitle' => 'Transaksi',
            'transactions' => $transactions,
            'stats' => $stats,
            'search' => $search,
            'status' => $status,
            'current_page' => $page
        ];
        
        return view('admin/admintransaksi', $data);
    }
    
    public function adminkeuangan(){
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }
        
        // Get financial data
        $monthlyFinance = $this->adminModel->getFinancialSummary('month');
        $yearlyFinance = $this->adminModel->getFinancialSummary('year');
        $monthlySales = $this->adminModel->getMonthlySalesData();
        
        $data = [
            'title' => 'Laporan Keuangan',
            'pageTitle' => 'Keuangan',
            'monthly_finance' => $monthlyFinance,
            'yearly_finance' => $yearlyFinance,
            'monthly_sales' => $monthlySales
        ];
        
        return view('admin/adminkeuangan', $data);
    }

    public function adminproduk(){
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }
        
        // Get all products
        $products = $this->productModel->getAllItems();
        $stats = $this->adminModel->getDashboardStats();
        
        $data = [
            'title' => 'Manajemen Produk',
            'pageTitle' => 'Produk',
            'products' => $products,
            'stats' => $stats
        ];
        
        return view('admin/adminproduk', $data);
    }

    // Message Management
    public function adminpesan()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }

        $messageModel = new \App\Models\MessageModel();
        
        $data = [
            'title' => 'Kotak Masuk',
            'pageTitle' => 'Pesan Masuk',
            'messages' => $messageModel->getMessages()
        ];
        
        return view('admin/adminpesan', $data);
    }

    public function deleteMessage($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
        }

        $messageModel = new \App\Models\MessageModel();
        
        if ($messageModel->delete($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Pesan berhasil dihapus']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus pesan']);
        }
    }

    // API Methods for AJAX calls
    public function updateOrderStatus()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        
        $orderId = $this->request->getPost('order_id');
        $status = $this->request->getPost('status');
        
        if ($this->adminModel->updateOrderStatus($orderId, $status)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status berhasil diupdate']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal update status']);
        }
    }

    public function getOrderDetails($orderId)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        
        $order = $this->adminModel->getOrderDetails($orderId);
        
        if ($order) {
            return $this->response->setJSON(['success' => true, 'data' => $order]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Order tidak ditemukan']);
        }
    }

    // Product CRUD Methods
    public function createProduct()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }
        
        $data = [
            'title' => 'Tambah Produk',
            'pageTitle' => 'Tambah Produk Baru'
        ];
        
        return view('admin/product_create', $data);
    }

    public function storeProduct()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }

        $rules = [
            'product_name' => 'required|min_length[3]|max_length[255]',
            'product_price' => 'required|numeric|greater_than[0]',
            'product_desc' => 'required|min_length[10]',
            'product_size' => 'required|max_length[50]',
            'product_image' => 'permit_empty|uploaded[product_image]|max_size[product_image,2048]|is_image[product_image]|mime_in[product_image,image/jpg,image/jpeg,image/png,image/gif]'
        ];

        // Additional image validation using helper
        $imageFile = $this->request->getFile('product_image');
        if ($imageFile && $imageFile->isValid()) {
            $imageErrors = validate_image_file($imageFile);
            if (!empty($imageErrors)) {
                return redirect()->back()->withInput()->with('error', implode(', ', $imageErrors));
            }
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'product_name' => $this->request->getPost('product_name'),
            'product_price' => $this->request->getPost('product_price'),
            'product_desc' => $this->request->getPost('product_desc'),
            'product_size' => $this->request->getPost('product_size')
        ];

        // Handle file upload
        $imageFile = $this->request->getFile('product_image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Create upload directory if it doesn't exist
            $uploadPath = ROOTPATH . 'public/uploads/products';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $newName = $imageFile->getRandomName();
            if ($imageFile->move($uploadPath, $newName)) {
                $data['product_image'] = $newName;
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload gambar!');
            }
        }

        if ($this->productModel->insertProduct($data)) {
            return redirect()->to('admin/product/view')->with('success', 'Produk berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan produk!');
        }
    }

    public function editProduct($productId)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }

        $product = $this->productModel->getItemById($productId);
        
        if (!$product) {
            return redirect()->to('admin/product/view')->with('error', 'Produk tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Produk',
            'pageTitle' => 'Edit Produk',
            'product' => $product
        ];
        
        return view('admin/product_edit', $data);
    }

    public function updateProduct($productId)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }

        $rules = [
            'product_name' => 'required|min_length[3]|max_length[255]',
            'product_price' => 'required|numeric|greater_than[0]',
            'product_desc' => 'required|min_length[10]',
            'product_size' => 'required|max_length[50]',
            'product_image' => 'permit_empty|uploaded[product_image]|max_size[product_image,2048]|is_image[product_image]|mime_in[product_image,image/jpg,image/jpeg,image/png,image/gif]'
        ];

        // Additional image validation using helper
        $imageFile = $this->request->getFile('product_image');
        if ($imageFile && $imageFile->isValid()) {
            $imageErrors = validate_image_file($imageFile);
            if (!empty($imageErrors)) {
                return redirect()->back()->withInput()->with('error', implode(', ', $imageErrors));
            }
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get current product data
        $currentProduct = $this->productModel->getItemById($productId);
        
        $data = [
            'product_name' => $this->request->getPost('product_name'),
            'product_price' => $this->request->getPost('product_price'),
            'product_desc' => $this->request->getPost('product_desc'),
            'product_size' => $this->request->getPost('product_size')
        ];

        // Handle file upload
        $imageFile = $this->request->getFile('product_image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Create upload directory if it doesn't exist
            $uploadPath = ROOTPATH . 'public/uploads/products';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Delete old image if exists
            if (!empty($currentProduct['product_image'])) {
                $oldImagePath = $uploadPath . '/' . $currentProduct['product_image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            // Upload new image
            $newName = $imageFile->getRandomName();
            if ($imageFile->move($uploadPath, $newName)) {
                $data['product_image'] = $newName;
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload gambar!');
            }
        }

        if ($this->productModel->updateProduct($data, $productId)) {
            return redirect()->to('admin/product/view')->with('success', 'Produk berhasil diupdate!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate produk!');
        }
    }

    public function deleteProduct($productId)
    {
        // Set response type to JSON
        $this->response->setContentType('application/json');
        
        // Basic validation
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak!']);
        }

        if (empty($productId) || !is_numeric($productId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID produk tidak valid!']);
        }

        try {
            // Get product data first
            $product = $this->productModel->getItemById($productId);
            
            if (!$product) {
                return $this->response->setJSON(['success' => false, 'message' => 'Produk tidak ditemukan!']);
            }
            
            // Try to delete from database
            if ($this->productModel->removeProduct($productId)) {
                // Delete image file if exists
                if (!empty($product['product_image'])) {
                    $imagePath = ROOTPATH . 'public/uploads/products/' . $product['product_image'];
                    if (file_exists($imagePath)) {
                        @unlink($imagePath);
                    }
                }
                
                return $this->response->setJSON(['success' => true, 'message' => 'Produk berhasil dihapus!']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus produk!']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function getProductDetails($productId)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        
        $product = $this->productModel->getItemById($productId);
        
        if ($product) {
            return $this->response->setJSON(['success' => true, 'data' => $product]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Produk tidak ditemukan']);
        }
    }

    public function createOrder()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak!']);
        }

        $email = $this->request->getPost('email');
        $totalPrice = $this->request->getPost('total_price');
        $status = $this->request->getPost('status');

        // Find user by email
        $user = $this->userModel->getUserIdByEmail($email);
        
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User dengan email tersebut tidak ditemukan']);
        }

        // Create order
        $orderData = [
            'user_id' => $user['id_user'],
            'total_price' => $totalPrice,
            'status' => $status,
            'tanggal_transaksi' => date('Y-m-d H:i:s')
        ];

        $db = \Config\Database::connect();
        if ($db->table('orders')->insert($orderData)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Pesanan berhasil ditambahkan']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menambahkan pesanan']);
        }
    }
}