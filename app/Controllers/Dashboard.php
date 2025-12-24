<?php
namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\UserModel;
use App\Libraries\PdfGenerator;

class Dashboard extends BaseController
{
    protected $adminModel;
    protected $productModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $userModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->userModel = new UserModel();
    }

    // Endpoint untuk update status pesanan menjadi dibatalkan
    public function cancelOrder($orderId)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }
        // Use AdminModel to update for consistency and log result
        $order = $this->adminModel->getOrderDetails($orderId);
        if (!$order) {
            log_message('warning', "cancelOrder: order {$orderId} not found by user " . session()->get('email'));
            return redirect()->to(site_url('admin/order/view'))->with('error', 'Pesanan tidak ditemukan');
        }

        // Use the DB value 'cancel' which exists in your database
        $affected = $this->adminModel->updateOrderStatus($orderId, 'cancel');

        if ($affected > 0) {
            log_message('info', "cancelOrder: order {$orderId} cancelled by user " . session()->get('email') . ". Affected rows: {$affected}");
            return redirect()->to(site_url('admin/order/view'))->with('success', 'Status pesanan berhasil diubah menjadi dibatalkan');
        } else {
            $dbError = $this->adminModel->db->error();
            log_message('error', "cancelOrder: failed to cancel order {$orderId} by user " . session()->get('email') . ". DB error: " . json_encode($dbError));
            return redirect()->to(site_url('admin/order/view'))->with('error', 'Gagal mengubah status pesanan');
        }
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

   

    protected function reportOrderTemplate($title)
    {
        try {
            $data['orders'] = $this->orderModel->getOrderData();
            $data['title'] = $title;

            // ⬇️ view dijadikan STRING
            $html = view('admin/laporan/laporanpesanan', $data);

            // sekarang $html bisa dipakai untuk:
            // - PDF
            // - Email
            // - disimpan ke file
            return $html;

        } catch (\Exception $e) {
            log_message('error', 'Error Message: ' . $e->getMessage());
            return '';
        }
    }

    protected function reportTransactionTemplate($title,$month){
        try{
            $data['title'] = $title;
            $data['transactions'] = $this->orderModel->getPaidOrderData($month);
            $data['metode'] = 'online'; 
            $html = view('admin/laporan/laporantransaksi',$data);
            return $html;
        }catch(\Exception $e){
            log_message('error', 'Error Message: ' . $e->getMessage());
            return '';
        }
    }

    protected function reportFinanceTemplate(string $title,  $monthFinance,  $yearFinance,  $monthlySales){
        try{

            $data['summary_title'] = 'SUMMARY KEUANGAN';
            $data['monthly_title'] = 'RINCIAN BULANAN';
        
            $monthFinance['periode'] = 'Bulan ini ';
            $yearFinance['periode'] = 'Tahun ini ';
            $data['finance'] = [$monthFinance , $yearFinance];

            $data['monthly_sales'] = $monthlySales;
            $data['title'] = $title;
            $html = view('admin/laporan/laporankeuangan', $data);
            return $html;


        }catch(\Exception $e){
            log_message('error', 'Error Message: ' . $e->getMessage());
            return '';
        }
    }


    public function exportOrders()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }

        $pdfgenerator = new PdfGenerator();

        $title = "Laporan_Pemesanan_".date("Y-m-d");
        $template = $this->reportOrderTemplate($title);
        $paper = "A4";
        $orientation = "potrait";

        $pdfgenerator->generate($template,$title,$paper,$orientation);
    }

    public function exportTransactions()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }

        $pdfgenerator = new PdfGenerator();

        $title = "Laporan_Transaksi_".date("Y-m-d");
        $month = date('m');
        $template = $this->reportTransactionTemplate($title,$month);
        $paper = "A4";
        $orientation = "potrait";

        $pdfgenerator->generate($template,$title,$paper,$orientation);
    }

    public function exportFinance()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }
        
        // Download Monthly Finance Report
        $monthlyFinance = $this->adminModel->getFinancialSummary('month');
        $yearlyFinance = $this->adminModel->getFinancialSummary('year');
        $monthlySales = $this->adminModel->getMonthlySalesData();
        
        $pdfgenerator = new PdfGenerator();

        $title = "Laporan_Keuangan_".date("Y-m-d");
        $template = $this->reportFinanceTemplate($title,$monthlyFinance,$yearlyFinance,$monthlySales);
        $paper = "A4";
        $orientation = "potrait";

        $pdfgenerator->generate($template,$title,$paper,$orientation);
        
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

        // Year for monthly sales chart (GET ?year=YYYY)
        $year = $this->request->getGet('year') ?? date('Y');
        $monthlySales = $this->adminModel->getMonthlySalesData($year);

        // last 5 years for selector
        $currentYear = (int) date('Y');
        $yearOptions = [];
        for ($i = 0; $i < 5; $i++) {
            $yearOptions[] = $currentYear - $i;
        }

        $data = [
            'title' => 'Dashboard Admin',
            'pageTitle' => 'Dashboard',
            'admin_name' => session()->get('email'),
            'user_id' => session()->get('user_id'),
            'stats' => $stats,
            'recent_orders' => $recentOrders,
            'top_products' => $topProducts,
            'monthly_sales' => $monthlySales,
            'year' => $year,
            'year_options' => $yearOptions
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
        $from = $this->request->getGet('from') ?? '';
        $to = $this->request->getGet('to') ?? '';
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Get orders data
        $orders = $this->adminModel->getOrders($limit, $offset, $search, $status, $from, $to);
        $totalOrders = $this->adminModel->countOrders($search, $status, $from, $to);
        $stats = $this->adminModel->getDashboardStats();
        
        $totalPages = ceil($totalOrders / $limit);
        $pager = [
            'current' => $page,
            'total_pages' => $totalPages,
            'total_items' => $totalOrders,
            'start_item' => $totalOrders > 0 ? $offset + 1 : 0,
            'end_item' => min($offset + $limit, $totalOrders)
        ];

        $data = [
            'title' => 'Manajemen Pesanan',
            'pageTitle' => 'Pesanan',
            'orders' => $orders,
            'stats' => $stats,
            'search' => $search,
            'status' => $status,
            'from' => $from,
            'to' => $to,
            'current_page' => $page,
            'pager' => $pager
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
        $from = $this->request->getGet('from') ?? '';
        $to = $this->request->getGet('to') ?? '';
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Get transactions data
        $transactions = $this->adminModel->getAllTransactions($limit, $offset, $search, $status, $from, $to);
        $totalTransactions = $this->adminModel->countTransactions($search, $status, $from, $to);
        $stats = $this->adminModel->getDashboardStats();
        
        $totalPages = ceil($totalTransactions / $limit);
        $pager = [
            'current' => $page,
            'total_pages' => $totalPages,
            'total_items' => $totalTransactions,
            'start_item' => $totalTransactions > 0 ? $offset + 1 : 0,
            'end_item' => min($offset + $limit, $totalTransactions)
        ];
        
        $data = [
            'title' => 'Manajemen Transaksi',
            'pageTitle' => 'Transaksi',
            'transactions' => $transactions,
            'stats' => $stats,
            'search' => $search,
            'status' => $status,
            'from' => $from,
            'to' => $to,
            'current_page' => $page,
            'pager' => $pager
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

        // Additional DB-driven finance metrics and monthly breakdown
        $financialMetrics = $this->adminModel->getFinancialMetrics();
        $monthlyBreakdown = $this->adminModel->getMonthlyBreakdown(12);

        $data = [
            'title' => 'Laporan Keuangan',
            'pageTitle' => 'Keuangan',
            'monthly_finance' => $monthlyFinance,
            'yearly_finance' => $yearlyFinance,
            'monthly_sales' => $monthlySales,
            'financial_metrics' => $financialMetrics,
            'monthly_breakdown' => $monthlyBreakdown
        ];
        
        return view('admin/adminkeuangan', $data);
    }

    public function adminproduk(){
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }
        
        $search = $this->request->getGet('search') ?? '';
        $page = $this->request->getGet('page') ?? 1;
        $limit = 12; // Grid view usually fits 3-4 columns
        $offset = ($page - 1) * $limit;

        // Get products data
        $products = $this->productModel->getProductsPaginated($limit, $offset, $search);
        $totalProducts = $this->productModel->countProducts($search);
        $stats = $this->adminModel->getDashboardStats();
        
        $totalPages = ceil($totalProducts / $limit);
        $pager = [
            'current' => $page,
            'total_pages' => $totalPages,
            'total_items' => $totalProducts,
            'start_item' => $totalProducts > 0 ? $offset + 1 : 0,
            'end_item' => min($offset + $limit, $totalProducts)
        ];
        
        $data = [
            'title' => 'Manajemen Produk',
            'pageTitle' => 'Produk',
            'products' => $products,
            'stats' => $stats,
            'search' => $search,
            'pager' => $pager
        ];
        
        return view('admin/adminproduk', $data);
    }

    public function exportProducts(){
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }

        $search = $this->request->getGet('search') ?? '';
        
        $products = $this->productModel->getProductsPaginated(10000, 0, $search);
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="export_produk_'.date('Y-m-d').'.csv"');
        
        $fp = fopen('php://output', 'w');
        fputcsv($fp, ['ID Produk', 'Nama Produk', 'Deskripsi', 'Ukuran', 'Harga']);
        
        foreach ($products as $p) {
            fputcsv($fp, [
                $p['id_product'],
                $p['product_name'],
                $p['product_desc'],
                $p['product_size'],
                $p['product_price']
            ]);
        }
        
        fclose($fp);
        exit;
    }

    // Message Management
    public function adminpesan(){
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

    public function deleteMessage($id){
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
    public function updateOrderStatus(){
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        
        $orderId = $this->request->getPost('order_id');
        $status = $this->request->getPost('status');
        if ($status === 'paid') {

          

            $items = $this->orderItemModel->getItemsByOrderId($orderId);

            foreach ($items as $item) {
                


                $this->productModel->reduceStock(
                    $item['product_id'],
                    $item['quantity']
                );

            }

           
        }    
    
    
        if ($this->adminModel->updateOrderStatus($orderId, $status)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status berhasil diupdate']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal update status']);
        }
    }

    public function getOrderDetails($orderId){
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
    public function createProduct(){
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }
        
        $data = [
            'title' => 'Tambah Produk',
            'pageTitle' => 'Tambah Produk Baru'
        ];
        
        return view('admin/product_create', $data);
    }

    public function storeProduct(){
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }

        $rules = [
            'product_name' => 'required|min_length[3]|max_length[255]',
            'product_price' => 'required|numeric|greater_than[0]',
            'product_desc' => 'required|min_length[10]',
            'product_size' => 'required|max_length[50]',
            'stock' => 'required|numeric|greater_than_equal_to[0]',
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
            'product_size' => $this->request->getPost('product_size'),
            'stock' => $this->request->getPost('stock')
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

    public function editProduct($productId){
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

    public function updateProduct($productId){
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }

        $rules = [
            'product_name' => 'required|min_length[3]|max_length[255]',
            'product_price' => 'required|numeric|greater_than[0]',
            'product_desc' => 'required|min_length[10]',
            'product_size' => 'required|max_length[50]',
            'stock' => 'required|numeric|greater_than_equal_to[0]',
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
            'product_size' => $this->request->getPost('product_size'),
            'stock' => $this->request->getPost('stock')
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

    public function deleteProduct($productId){
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

    public function getProductDetails($productId){
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

    public function createOrder(){
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