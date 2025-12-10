<?= $this->extend('admin/__partials/layout') ?>
<?= $this->section('content') ?>

<!-- Header Section -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Riwayat Transaksi</h2>
        <p class="text-gray-600 mt-1">Pantau semua transaksi yang berhasil</p>
    </div>
    <div class="flex space-x-3">
        <a href="<?= site_url('admin/transaction/export') ?>?search=<?= urlencode($search) ?>&status=<?= urlencode($status) ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center">
            <i class="fas fa-download mr-2"></i>Export Excel
        </a>
        <button class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-black px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-lg">
            <i class="fas fa-chart-line mr-2"></i>Laporan
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Transaksi</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($stats['total_orders'] ?? 0) ?></p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-credit-card text-blue-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($stats['orders_this_month'] ?? 0) ?></p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-calendar-day text-green-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Nilai</p>
                <p class="text-2xl font-bold text-gray-900">Rp <?= number_format(($stats['total_revenue'] ?? 0) / 1000000, 1) ?>M</p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-purple-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Rata-rata</p>
                <p class="text-2xl font-bold text-gray-900">Rp <?= $stats['total_orders'] > 0 ? number_format($stats['total_revenue'] / $stats['total_orders'] / 1000, 0) : 0 ?>K</p>
            </div>
            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-bar text-orange-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <div class="flex flex-wrap items-center gap-4">
        <div class="flex-1 min-w-64">
            <input type="text" placeholder="Cari transaksi..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
        </div>
        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
            <option>Semua Status</option>
            <option>Berhasil</option>
            <option>Pending</option>
            <option>Gagal</option>
        </select>
        <input type="date" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
        <input type="date" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
        <button class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-filter"></i>
        </button>
    </div>
</div>

<!-- Transactions Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Transaksi</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Bayar</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($transactions)): ?>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-mono text-gray-900">#TRX-<?= str_pad($transaction['order_id'], 3, '0', STR_PAD_LEFT) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-gray-500 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900"><?= esc($transaction['customer_name'] ?? 'N/A') ?></div>
                                        <div class="text-sm text-gray-500"><?= esc($transaction['customer_email'] ?? 'N/A') ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">-</div>
                                <div class="text-sm text-gray-500">Lihat detail</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i class="fas fa-credit-card text-blue-500 mr-2"></i>
                                    <span class="text-sm text-gray-900">Online</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                + Rp <?= number_format($transaction['total_price'], 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $statusClass = '';
                                    $statusText = '';
                                    $statusIcon = '';
                                    switch($transaction['status']) {
                                        case 'paid':
                                            $statusClass = 'bg-green-100 text-green-800';
                                            $statusText = 'Berhasil';
                                            $statusIcon = 'fas fa-check-circle';
                                            break;
                                        case 'pending':
                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                            $statusText = 'Pending';
                                            $statusIcon = 'fas fa-clock';
                                            break;
                                        case 'cancelled':
                                            $statusClass = 'bg-red-100 text-red-800';
                                            $statusText = 'Dibatalkan';
                                            $statusIcon = 'fas fa-times-circle';
                                            break;
                                        default:
                                            $statusClass = 'bg-blue-100 text-blue-800';
                                            $statusText = 'Baru';
                                            $statusIcon = 'fas fa-info-circle';
                                    }
                                ?>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $statusClass ?>">
                                    <i class="<?= $statusIcon ?> mr-1"></i><?= $statusText ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d M Y', strtotime($transaction['tanggal_transaksi'])) ?><br>
                                <span class="text-xs"><?= date('H:i', strtotime($transaction['tanggal_transaksi'])) ?> WIB</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900" title="Lihat Detail" onclick="viewTransaction(<?= $transaction['order_id'] ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <?php if ($transaction['status'] === 'paid'): ?>
                                        <button class="text-green-600 hover:text-green-900" title="Download Invoice">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="text-orange-600 hover:text-orange-900" title="Follow Up">
                                            <i class="fas fa-phone"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-receipt text-4xl mb-2"></i>
                            <p>Belum ada transaksi</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="bg-white px-6 py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Menampilkan <span class="font-medium"><?= $pager['start_item'] ?></span> sampai <span class="font-medium"><?= $pager['end_item'] ?></span> dari <span class="font-medium"><?= $pager['total_items'] ?></span> transaksi
            </div>
            <div class="flex space-x-2">
                <?php if ($pager['current'] > 1): ?>
                    <a href="?page=<?= $pager['current'] - 1 ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($status) ?>" 
                       class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Sebelumnya
                    </a>
                <?php endif; ?>
                
                <span class="px-3 py-2 text-sm text-black bg-yellow-400 border border-yellow-400 rounded-lg font-medium">
                    <?= $pager['current'] ?>
                </span>
                
                <?php if ($pager['current'] < $pager['total_pages']): ?>
                    <a href="?page=<?= $pager['current'] + 1 ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($status) ?>" 
                       class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Selanjutnya
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<script>
// Search functionality for transactions
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[placeholder="Cari transaksi..."]');
    const statusSelect = document.querySelector('select');
    
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performTransactionSearch();
            }
        });
    }
    
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            performTransactionSearch();
        });
    }
});

function performTransactionSearch() {
    const search = document.querySelector('input[placeholder="Cari transaksi..."]').value;
    const status = document.querySelector('select').value;
    
    let url = new URL(window.location);
    url.searchParams.set('search', search);
    url.searchParams.set('status', status);
    url.searchParams.delete('page'); // Reset to first page
    
    window.location.href = url.toString();
}
</script>