<?= $this->extend('admin/__partials/layout') ?>
<?= $this->section('content') ?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Pesanan -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['total_orders'] ?? 0) ?></p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-calendar"></i> <?= number_format($stats['orders_this_month'] ?? 0) ?> bulan ini
                </p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Pendapatan -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                <p class="text-3xl font-bold text-gray-900">Rp <?= number_format($stats['total_revenue'] ?? 0, 0, ',', '.') ?></p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-calendar"></i> Rp <?= number_format($stats['revenue_this_month'] ?? 0, 0, ',', '.') ?> bulan ini
                </p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Produk -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Produk</p>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['total_products'] ?? 0) ?></p>
                <p class="text-sm text-blue-600 mt-1">
                    <i class="fas fa-box"></i> Produk aktif
                </p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-box text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Customer Aktif -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Users</p>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['total_users'] ?? 0) ?></p>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-users"></i> Pengguna terdaftar
                </p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Sales Chart -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Penjualan Bulanan</h3>
            <select id="yearSelect" class="text-sm border border-gray-300 rounded-lg px-3 py-1">
                <?php foreach (($year_options ?? []) as $opt): ?>
                    <option value="<?= $opt ?>" <?= ((string)$opt === (string)($year ?? '')) ? 'selected' : '' ?>><?= $opt ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="height: 300px; position: relative;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Produk Terlaris</h3>
        <div class="space-y-4">
            <?php if (!empty($top_products)): ?>
                <?php foreach ($top_products as $index => $product): ?>
                    <?php 
                        $colors = ['blue', 'purple', 'green', 'orange', 'red'];
                        $color = $colors[$index % count($colors)];
                    ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-<?= $color ?>-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-spray-can text-<?= $color ?>-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900"><?= esc($product['product_name']) ?></p>
                                <p class="text-sm text-gray-500"><?= $product['total_sold'] ?> terjual</p>
                            </div>
                        </div>
                        <span class="text-green-600 font-semibold">Rp <?= number_format($product['product_price'], 0, ',', '.') ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-box-open text-4xl mb-2"></i>
                    <p>Belum ada data produk terlaris</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h3>
            <a href="<?= site_url('admin/order/view') ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Lihat Semua
            </a>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($recent_orders)): ?>
                    <?php foreach ($recent_orders as $order): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#ORD-<?= str_pad($order['order_id'], 3, '0', STR_PAD_LEFT) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= esc($order['customer_name'] ?? 'N/A') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">-</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $statusClass = '';
                                    $statusText = '';
                                    switch($order['status']) {
                                        case 'paid':
                                            $statusClass = 'bg-green-100 text-green-800';
                                            $statusText = 'Selesai';
                                            break;
                                        case 'pending':
                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                            $statusText = 'Pending';
                                            break;
                                        case 'cancel':
                                            $statusClass = 'bg-red-100 text-red-800';
                                            $statusText = 'Dibatalkan';
                                            break;
                                        case 'cancelled':
                                            $statusClass = 'bg-red-100 text-red-800';
                                            $statusText = 'Dibatalkan';
                                            break;
                                        default:
                                            $statusClass = 'bg-blue-100 text-blue-800';
                                            $statusText = 'Baru';
                                    }
                                ?>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $statusClass ?>">
                                    <?= $statusText ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d M Y', strtotime($order['tanggal_transaksi'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>Belum ada pesanan</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Sales Chart
const ctx = document.getElementById('salesChart').getContext('2d');
<?php 
    // Prepare chart data
    $chartLabels = [];
    $chartData = [];
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
    // Initialize with zeros
    for ($i = 1; $i <= 12; $i++) {
        $chartLabels[] = $months[$i-1];
        $chartData[] = 0;
    }
    
    // Fill with real data (full Rupiah values)
    if (!empty($monthly_sales)) {
        foreach ($monthly_sales as $sale) {
            $monthIndex = $sale['month'] - 1;
            $chartData[$monthIndex] = (int) $sale['total_sales'];
        }
    }
?>
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($chartLabels) ?>,
        datasets: [{
            label: 'Penjualan (Rp)',
            data: <?= json_encode($chartData) ?>,
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
            ,
            tooltip: {
                callbacks: {
                    label: function(context) { return formatRupiah(context.parsed.y); }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
                ,
                ticks: { callback: function(value) { return formatRupiah(value); } }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
// Year selector behaviour: reload with selected year
document.getElementById('yearSelect')?.addEventListener('change', function() {
    const y = this.value;
    const url = new URL(window.location);
    url.searchParams.set('year', y);
    window.location.href = url.toString();
});
</script>

<?= $this->endSection() ?>