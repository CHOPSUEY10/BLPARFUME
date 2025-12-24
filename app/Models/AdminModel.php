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
    public function getOrders($limit = 10, $offset = 0, $search = '', $status = '', $from = '', $to = '')
    {
        $builder = $this->db->table('orders o')
        ->select('
            o.order_id,
            o.total_price,
            o.status,
            o.tanggal_transaksi,

            u.nama  AS customer_name,
            u.email AS customer_email,

        ')
        ->join('users u', 'u.id_user = o.user_id', 'left')
        ->where('o.status','pending')->orWhere('o.status','cancel');
        

        
        if (!empty($search)) {
            $builder->groupStart()
                ->like('u.nama', $search)
                ->orLike('u.email', $search)
                ->orLike('o.order_id', $search)
                ->groupEnd();
        }
        
        if (!empty($status)) {
            // Support both 'cancel' and 'cancelled' values in DB
            if (in_array($status, ['cancel', 'cancelled'])) {
                $builder->whereIn('o.status', ['cancel', 'cancelled']);
            } else {
                $builder->where('o.status', $status);
            }
        }

        if (!empty($from)) {
            $builder->where('DATE(o.tanggal_transaksi) >=', $from);
        }

        if (!empty($to)) {
            $builder->where('DATE(o.tanggal_transaksi) <=', $to);
        }
        
        return $builder->orderBy('o.tanggal_transaksi', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }


    // Get All Orders with pagination
    public function getAllOrders($limit = 10, $offset = 0, $search = '', $status = '', $from = '', $to = '')
    {
        $builder = $this->db->table('orders o')
        ->select('
            o.order_id,
            o.total_price,
            o.status,
            o.tanggal_transaksi,

            u.nama  AS customer_name,
            u.email AS customer_email,

        ')
        ->join('users u', 'u.id_user = o.user_id', 'left');
       
        

        
        if (!empty($search)) {
            $builder->groupStart()
                ->like('u.nama', $search)
                ->orLike('u.email', $search)
                ->orLike('o.order_id', $search)
                ->groupEnd();
        }
        
        if (!empty($status)) {
            // Support both 'cancel' and 'cancelled' values in DB
            if (in_array($status, ['cancel', 'cancelled'])) {
                $builder->whereIn('o.status', ['cancel', 'cancelled']);
            } else {
                $builder->where('o.status', $status);
            }
        }

        if (!empty($from)) {
            $builder->where('DATE(o.tanggal_transaksi) >=', $from);
        }

        if (!empty($to)) {
            $builder->where('DATE(o.tanggal_transaksi) <=', $to);
        }
        
        return $builder->orderBy('o.tanggal_transaksi', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }

    public function countOrders($search = '', $status = '', $from = '', $to = '')
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
            if (in_array($status, ['cancel', 'cancelled'])) {
                $builder->whereIn('o.status', ['cancel', 'cancelled']);
            } else {
                $builder->where('o.status', $status);
            }
        }

        if (!empty($from)) {
            $builder->where('DATE(o.tanggal_transaksi) >=', $from);
        }

        if (!empty($to)) {
            $builder->where('DATE(o.tanggal_transaksi) <=', $to);
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
     public function getAllTransactions($limit = 10, $offset = 0, $search = '', $status = '', $from = '', $to = ''){
        $builder = $this->db->table('orders o')
            ->select('
                o.order_id,
                o.total_price,
                o.status,
                o.tanggal_transaksi,
                u.nama  AS customer_name,
                u.email AS customer_email
            ')
            ->join('users u', 'u.id_user = o.user_id', 'left');

        if ($search) {
            $builder->groupStart()
                ->like('u.nama', $search)
                ->orLike('u.email', $search)
                ->orLike('o.order_id', $search)
                ->groupEnd();
        }

        if ($status) {
            in_array($status, ['cancel', 'cancelled'])
                ? $builder->whereIn('o.status', ['cancel', 'cancelled'])
                : $builder->where('o.status', $status);
        }

        if ($from) $builder->where('DATE(o.tanggal_transaksi) >=', $from);
        if ($to)   $builder->where('DATE(o.tanggal_transaksi) <=', $to);

        return $builder
            ->orderBy('o.tanggal_transaksi', 'DESC')
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
        $builder = $this->db->table('orders')
            ->where('order_id', $orderId)
            ->update(['status' => $status]);

        // Return number of affected rows for diagnostics
        $affected = $this->db->affectedRows();
        return $affected;
    }

    // Get Order Details
    public function getOrderDetails($orderId)
    {
        // 1️⃣ Ambil data order (header)
        $order = $this->db->table('orders o')
            ->select('
                o.*,
                u.nama   AS customer_name,
                u.email  AS customer_email,
                u.alamat AS customer_address,
                u.no_telp AS customer_phone
            ')
            ->join('users u', 'u.id_user = o.user_id', 'left')
            ->where('o.order_id', $orderId)
            ->get()
            ->getRowArray();

        if (!$order) {
            return null;
        }

        // 2️⃣ Ambil item produk dalam order
        $items = $this->db->table('order_items oi')
            ->select('

                oi.product_name,
                oi.product_price,
                oi.quantity,
                oi.product_size,
                oi.product_id
            ')
            ->where('oi.order_id', $orderId)
            ->get()
            ->getResultArray();

        // 3️⃣ Gabungkan
        $order['items'] = $items;

        return $order;
    }

    public function countTransactions($search = '', $status = '', $from = '', $to = '')
    {
        // Reusing countOrders logic since transactions view uses the same table
        return $this->countOrders($search, $status, $from, $to);
    }

    // Get key financial metrics (uses simple assumptions where needed)
    public function getFinancialMetrics()
    {
        $metrics = [];

        // Total revenue (paid)
        $rev = $this->db->query("SELECT SUM(total_price) as total_revenue FROM orders WHERE status = 'paid'");
        $metrics['total_revenue'] = $rev->getRow()->total_revenue ?? 0;

        // Total unique customers (who made paid orders)
        $cust = $this->db->query("SELECT COUNT(DISTINCT user_id) as unique_customers FROM orders WHERE status = 'paid'");
        $metrics['unique_customers'] = $cust->getRow()->unique_customers ?? 0;

        // CLV (approx avg revenue per customer)
        if ($metrics['unique_customers'] > 0) {
            $metrics['clv'] = $metrics['total_revenue'] / $metrics['unique_customers'];
        } else {
            $metrics['clv'] = 0;
        }

        // CPA placeholder
        $metrics['cpa'] = 125000;

        // Repeat Purchase Rate
        $rprQuery = $this->db->query("SELECT
                SUM(case when cnt > 1 then 1 else 0 end) as repeat_customers,
                SUM(1) as total_customers
            FROM (
                SELECT user_id, COUNT(*) as cnt FROM orders WHERE status = 'paid' GROUP BY user_id
            ) t");
        $rprRow = $rprQuery->getRow();
        $repeat = $rprRow->repeat_customers ?? 0;
        $totalCust = $rprRow->total_customers ?? 0;
        $metrics['repeat_purchase_rate'] = $totalCust > 0 ? ($repeat / $totalCust) * 100 : 0;

        // ROI assuming cost is 30% of revenue
        $assumed_cost = $metrics['total_revenue'] * 0.3;
        if ($assumed_cost > 0) {
            $metrics['roi'] = (($metrics['total_revenue'] - $assumed_cost) / $assumed_cost) * 100;
        } else {
            $metrics['roi'] = 0;
        }

        return $metrics;
    }

    // Get monthly breakdown for last N months (only months with paid orders)
    public function getMonthlyBreakdown($months = 12)
    {
        $query = $this->db->query("SELECT
                YEAR(tanggal_transaksi) as yr,
                MONTH(tanggal_transaksi) as mth,
                DATE_FORMAT(tanggal_transaksi, '%Y-%m') as ym,
                MONTHNAME(tanggal_transaksi) as month_name,
                SUM(total_price) as revenue,
                COUNT(*) as orders
            FROM orders
            WHERE status = 'paid' AND tanggal_transaksi >= (DATE_SUB(LAST_DAY(CURDATE()), INTERVAL ? MONTH) + INTERVAL 1 DAY)
            GROUP BY YEAR(tanggal_transaksi), MONTH(tanggal_transaksi)
            ORDER BY YEAR(tanggal_transaksi), MONTH(tanggal_transaksi)", [$months]);

        $rows = $query->getResultArray();
        $result = [];
        foreach ($rows as $r) {
            $revenue = (float) $r['revenue'];
            $costs = $revenue * 0.3; // assumed costs
            $profit = $revenue - $costs;
            $margin = $revenue > 0 ? ($profit / $revenue) * 100 : 0;

            $result[] = [
                'year' => $r['yr'],
                'month' => $r['mth'],
                'ym' => $r['ym'],
                'month_name' => $r['month_name'],
                'revenue' => (float) $revenue,
                'orders' => (int) $r['orders'],
                'costs' => (float) $costs,
                'profit' => (float) $profit,
                'margin' => (float) $margin
            ];
        }

        return $result;
    }
}