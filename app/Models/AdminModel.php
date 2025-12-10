<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // Dashboard Statistics
    public function getDashboardStats()
    {
        $stats = [];
        
        // Total Orders
        $stats['total_orders'] = $this->db->table('orders')->countAllResults();
        
        // Total Revenue
        $revenueQuery = $this->db->table('orders')
            ->selectSum('total_price')
            ->where('status', 'paid')
            ->get();
        $stats['total_revenue'] = $revenueQuery->getRow()->total_price ?? 0;
        
        // Total Products
        $stats['total_products'] = $this->db->table('products')->countAllResults();
        
        // Total Active Users
        $stats['total_users'] = $this->db->table('users')
            ->where('role', 'user')
            ->countAllResults();
        
        // Orders this month
        $stats['orders_this_month'] = $this->db->table('orders')
            ->where('MONTH(tanggal_transaksi)', date('m'))
            ->where('YEAR(tanggal_transaksi)', date('Y'))
            ->countAllResults();
        
        // Revenue this month
        $monthlyRevenueQuery = $this->db->table('orders')
            ->selectSum('total_price')
            ->where('status', 'paid')
            ->where('MONTH(tanggal_transaksi)', date('m'))
            ->where('YEAR(tanggal_transaksi)', date('Y'))
            ->get();
        $stats['revenue_this_month'] = $monthlyRevenueQuery->getRow()->total_price ?? 0;
        
        return $stats;
    }

    // Get Recent Orders
    public function getRecentOrders($limit = 10)
    {
        return $this->db->table('orders o')
            ->select('o.order_id, o.total_price, o.status, o.tanggal_transaksi, u.nama as customer_name, u.email as customer_email')
            ->join('users u', 'u.id_user = o.user_id', 'left')
            ->orderBy('o.tanggal_transaksi', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    // Get All Orders with pagination
    public function getAllOrders($limit = 10, $offset = 0, $search = '', $status = '')
    {
        $builder = $this->db->table('orders o')
            ->select('o.order_id, o.total_price, o.status, o.tanggal_transaksi, u.nama as customer_name, u.email as customer_email')
            ->join('users u', 'u.id_user = o.user_id', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                ->like('u.nama', $search)
                ->orLike('u.email', $search)
                ->orLike('o.order_id', $search)
                ->groupEnd();
        }
        
        if (!empty($status)) {
            $builder->where('o.status', $status);
        }
        
        return $builder->orderBy('o.tanggal_transaksi', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }

    public function countOrders($search = '', $status = '')
    {
        $builder = $this->db->table('orders o')
            ->join('users u', 'u.id_user = o.user_id', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                ->like('u.nama', $search)
                ->orLike('u.email', $search)
                ->orLike('o.order_id', $search)
                ->groupEnd();
        }
        
        if (!empty($status)) {
            $builder->where('o.status', $status);
        }
        
        return $builder->countAllResults();
    }

    // Get Monthly Sales Data for Chart
    public function getMonthlySalesData($year = null)
    {
        if (!$year) {
            $year = date('Y');
        }
        
        $query = $this->db->query("
            SELECT 
                MONTH(tanggal_transaksi) as month,
                MONTHNAME(tanggal_transaksi) as month_name,
                SUM(total_price) as total_sales,
                COUNT(*) as total_orders
            FROM orders 
            WHERE YEAR(tanggal_transaksi) = ? AND status = 'paid'
            GROUP BY MONTH(tanggal_transaksi), MONTHNAME(tanggal_transaksi)
            ORDER BY MONTH(tanggal_transaksi)
        ", [$year]);
        
        return $query->getResultArray();
    }

    // Get Top Products
    public function getTopProducts($limit = 5)
    {
        // Assuming we have order_items table or basket data
        return $this->db->table('baskets b')
            ->select('p.product_name, p.product_price, COUNT(b.product_id) as total_sold')
            ->join('products p', 'p.id_product = b.product_id')
            ->groupBy('b.product_id, p.product_name, p.product_price')
            ->orderBy('total_sold', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    // Get All Transactions
    public function getAllTransactions($limit = 10, $offset = 0, $search = '', $status = '')
    {
        $builder = $this->db->table('orders o')
            ->select('o.order_id, o.total_price, o.status, o.tanggal_transaksi, u.nama as customer_name, u.email as customer_email')
            ->join('users u', 'u.id_user = o.user_id', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                ->like('u.nama', $search)
                ->orLike('u.email', $search)
                ->orLike('o.order_id', $search)
                ->groupEnd();
        }
        
        if (!empty($status)) {
            $builder->where('o.status', $status);
        }
        
        return $builder->orderBy('o.tanggal_transaksi', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }

    // Get Financial Summary
    public function getFinancialSummary($period = 'month')
    {
        $summary = [];
        
        switch ($period) {
            case 'month':
                $dateCondition = "MONTH(tanggal_transaksi) = MONTH(CURDATE()) AND YEAR(tanggal_transaksi) = YEAR(CURDATE())";
                break;
            case 'year':
                $dateCondition = "YEAR(tanggal_transaksi) = YEAR(CURDATE())";
                break;
            default:
                $dateCondition = "1=1";
        }
        
        // Total Revenue
        $revenueQuery = $this->db->query("
            SELECT SUM(total_price) as total_revenue 
            FROM orders 
            WHERE status = 'paid' AND {$dateCondition}
        ");
        $summary['total_revenue'] = $revenueQuery->getRow()->total_revenue ?? 0;
        
        // Total Orders
        $ordersQuery = $this->db->query("
            SELECT COUNT(*) as total_orders 
            FROM orders 
            WHERE {$dateCondition}
        ");
        $summary['total_orders'] = $ordersQuery->getRow()->total_orders ?? 0;
        
        // Average Order Value
        if ($summary['total_orders'] > 0) {
            $summary['average_order'] = $summary['total_revenue'] / $summary['total_orders'];
        } else {
            $summary['average_order'] = 0;
        }
        
        return $summary;
    }

    // Update Order Status
    public function updateOrderStatus($orderId, $status)
    {
        return $this->db->table('orders')
            ->where('order_id', $orderId)
            ->update(['status' => $status]);
    }

    // Get Order Details
    public function getOrderDetails($orderId)
    {
        return $this->db->table('orders o')
            ->select('o.*, u.nama as customer_name, u.email as customer_email, u.alamat as customer_address, u.no_telp as customer_phone')
            ->join('users u', 'u.id_user = o.user_id', 'left')
            ->where('o.order_id', $orderId)
            ->get()
            ->getRowArray();
    }

    public function countTransactions($search = '', $status = '')
    {
        // Reusing countOrders logic since transactions view uses the same table
        return $this->countOrders($search, $status);
    }

    // Get Financial Metrics (ROI, CLV, CPA, Repeat Purchase Rate)
    public function getFinancialMetrics()
    {
        $metrics = [];
        
        // Total Revenue All Time
        $totalRevenueQuery = $this->db->table('orders')
            ->selectSum('total_price')
            ->where('status', 'paid')
            ->get();
        $totalRevenue = $totalRevenueQuery->getRow()->total_price ?? 0;
        
        // Total Paid Orders (all time)
        $totalPaidOrders = $this->db->table('orders')
            ->where('status', 'paid')
            ->countAllResults();
        
        // Calculate average cost per order (assuming 30% of revenue as costs)
        $costPerOrder = $totalRevenue > 0 ? ($totalRevenue * 0.30) / $totalPaidOrders : 0;
        
        // ROI - Return on Investment (assuming 30% initial investment)
        $initialInvestment = $totalRevenue * 0.30;
        $profit = $totalRevenue - $initialInvestment;
        $metrics['roi'] = $initialInvestment > 0 ? round(($profit / $initialInvestment) * 100) : 0;
        
        // CLV - Customer Lifetime Value
        $totalUniqueCustomers = $this->db->table('orders')
            ->distinct()
            ->where('status', 'paid')
            ->countAllResults();
        $metrics['clv'] = $totalUniqueCustomers > 0 ? round($totalRevenue / $totalUniqueCustomers) : 0;
        
        // CPA - Cost per Acquisition (assuming Rp 125K marketing cost per new customer)
        $metrics['cpa'] = 125000; // Fixed assumed value, can be updated based on actual marketing spend table
        
        // Repeat Purchase Rate
        $repeatCustomersQuery = $this->db->query("
            SELECT COUNT(DISTINCT user_id) as repeat_customers
            FROM orders
            WHERE user_id IN (
                SELECT user_id FROM orders 
                WHERE status = 'paid'
                GROUP BY user_id 
                HAVING COUNT(*) > 1
            ) AND status = 'paid'
        ");
        $repeatCustomers = $repeatCustomersQuery->getRow()->repeat_customers ?? 0;
        $metrics['repeat_purchase_rate'] = $totalUniqueCustomers > 0 ? round(($repeatCustomers / $totalUniqueCustomers) * 100) : 0;
        
        return $metrics;
    }

    // Get Monthly Financial Breakdown (last 12 months)
    public function getMonthlyBreakdown()
    {
        $breakdown = [];
        
        // Get last 12 months of data
        for ($i = 11; $i >= 0; $i--) {
            $date = strtotime("-$i months");
            $month = date('Y-m', $date);
            $monthName = date('F Y', $date);
            
            // Revenue for the month
            $revenueQuery = $this->db->table('orders')
                ->selectSum('total_price')
                ->where('status', 'paid')
                ->where('YEAR(tanggal_transaksi)', date('Y', $date))
                ->where('MONTH(tanggal_transaksi)', date('m', $date))
                ->get();
            $revenue = $revenueQuery->getRow()->total_price ?? 0;
            
            // Calculate costs (assuming 30% of revenue)
            $costs = $revenue * 0.30;
            
            // Calculate profit
            $profit = $revenue - $costs;
            
            // Calculate margin percentage
            $margin = $revenue > 0 ? round(($profit / $revenue) * 100) : 0;
            
            $breakdown[] = [
                'month' => $monthName,
                'revenue' => $revenue,
                'costs' => $costs,
                'profit' => $profit,
                'margin' => $margin
            ];
        }
        
        return $breakdown;
    }
}