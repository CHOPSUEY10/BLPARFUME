<?= $this->extend('admin/__partials/layout') ?>
<?= $this->section('content') ?>

<!-- Header Section -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Laporan Keuangan</h2>
        <p class="text-gray-600 mt-1">Analisis keuangan dan performa bisnis</p>
    </div>
    <div class="flex space-x-3">
        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
            <option>Bulan Ini</option>
            <option>3 Bulan Terakhir</option>
            <option>6 Bulan Terakhir</option>
            <option>Tahun Ini</option>
        </select>
        <a href="<?= site_url('admin/finance/export') ?>" class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-black px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-lg flex items-center">
            <i class="fas fa-download mr-2"></i>Export Data
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Repeat Purchase Rate</span>
                    <span class="text-sm font-semibold text-orange-600"><?= ($financial_metrics['repeat_purchase_rate'] ?? 0) ?>%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-orange-500 h-2 rounded-full" style="width: <?= ($financial_metrics['repeat_purchase_rate'] ?? 0) ?>%"></div>
                </div>
            </div>
            </div>
            <span class="text-sm bg-yellow-400/20 text-yellow-400 px-2 py-1 rounded-full font-medium">Total</span>
        </div>
        <h3 class="text-sm font-medium opacity-90">Total Pendapatan</h3>
        <p class="text-3xl font-bold">Rp <?= number_format(($yearly_finance['total_revenue'] ?? 0), 0, ',', '.') ?></p>
        <p class="text-sm opacity-75 mt-1">Tahun ini</p>
    </div>

    <!-- Monthly Revenue -->
    <div class="bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl p-6 text-white shadow-lg border-t-4 border-yellow-400">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-yellow-400/20 rounded-lg flex items-center justify-center">
                <i class="fas fa-wallet text-2xl text-yellow-400"></i>
            </div>
            <span class="text-sm bg-yellow-400/20 text-yellow-400 px-2 py-1 rounded-full font-medium">Bulan</span>
        </div>
        <h3 class="text-sm font-medium opacity-90">Pendapatan Bulan Ini</h3>
        <p class="text-3xl font-bold">Rp <?= number_format(($monthly_finance['total_revenue'] ?? 0), 0, ',', '.') ?></p>
        <p class="text-sm opacity-75 mt-1"><?= date('F Y') ?></p>
    </div>

    <!-- Average Order -->
    <div class="bg-gradient-to-br from-gray-600 to-gray-700 rounded-xl p-6 text-white shadow-lg border-t-4 border-yellow-400">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-yellow-400/20 rounded-lg flex items-center justify-center">
                <i class="fas fa-shopping-cart text-2xl text-yellow-400"></i>
            </div>
            <span class="text-sm bg-yellow-400/20 text-yellow-400 px-2 py-1 rounded-full font-medium">Avg</span>
        </div>
        <h3 class="text-sm font-medium opacity-90">Rata-rata Order</h3>
        <p class="text-3xl font-bold">Rp <?= number_format(($monthly_finance['average_order'] ?? 0), 0, ',', '.') ?></p>
        <p class="text-sm opacity-75 mt-1">Per transaksi</p>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Revenue Chart -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Tren Pendapatan</h3>
            <select class="text-sm border border-gray-300 rounded-lg px-3 py-1">
                <option>6 Bulan Terakhir</option>
                <option>12 Bulan Terakhir</option>
            </select>
        </div>
        <div style="height: 300px; position: relative;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Profit Margin Chart -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Margin Keuntungan</h3>
            <div class="flex space-x-2">
                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                <span class="text-sm text-gray-600">Keuntungan</span>
                <span class="w-3 h-3 bg-red-500 rounded-full ml-4"></span>
                <span class="text-sm text-gray-600">Biaya</span>
            </div>
        </div>
        <div style="height: 300px; position: relative;">
            <canvas id="profitChart"></canvas>
        </div>
    </div>
</div>

<!-- Financial Summary -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Monthly Breakdown -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Ringkasan Bulanan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bulan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pendapatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Biaya</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keuntungan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Margin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (!empty($monthly_breakdown)): ?>
                        <?php foreach ($monthly_breakdown as $month): ?>
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= $month['month'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-900">Rp <?= number_format($month['revenue'], 0, ',', '.') ?></td>
                                <td class="px-6 py-4 text-sm text-red-600">Rp <?= number_format($month['costs'], 0, ',', '.') ?></td>
                                <td class="px-6 py-4 text-sm font-semibold text-green-600">Rp <?= number_format($month['profit'], 0, ',', '.') ?></td>
                                <td class="px-6 py-4 text-sm text-gray-900"><?= $month['margin'] ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Metrik Kunci</h3>
        
        <div class="space-y-6">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">ROI (Return on Investment)</span>
                    <span class="text-sm font-semibold text-green-600"><?= ($financial_metrics['roi'] ?? 0) ?>%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: <?= min(($financial_metrics['roi'] ?? 0), 100) ?>%"></div>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Customer Lifetime Value</span>
                    <span class="text-sm font-semibold text-blue-600">Rp <?= number_format(($financial_metrics['clv'] ?? 0), 0, ',', '.') ?></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 70%"></div>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Cost per Acquisition</span>
                    <span class="text-sm font-semibold text-purple-600">Rp <?= number_format(($financial_metrics['cpa'] ?? 0), 0, ',', '.') ?></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-purple-500 h-2 rounded-full" style="width: 60%"></div>
                </div>
            </div>

            <div>
                <?php $rpr = intval($financial_metrics['repeat_purchase_rate'] ?? 0); $rpr = max(0, min(100, $rpr)); ?>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Repeat Purchase Rate</span>
                    <span class="text-sm font-semibold text-orange-600"><?= $rpr ?>%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 relative">
                    <div class="bg-orange-500 h-2 rounded-full" style="width: <?= $rpr ?>%"></div>
                    <div class="absolute right-0 -top-6 text-xs text-gray-600"><?= $rpr ?>%</div>
                </div>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="text-center">
                <p class="text-2xl font-bold text-gray-900">Rp <?= number_format(($monthly_finance['total_revenue'] ?? 0), 0, ',', '.') ?></p>
                <p class="text-sm text-gray-500">Total Pendapatan Bulan Ini</p>
                <div class="mt-2 flex items-center justify-center text-green-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span class="text-sm font-medium">Data dari database</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
<?php 
    // Prepare chart data for last 6 months
    $revenueLabels = [];
    $revenueData = [];
    
    // Get last 6 months
    for ($i = 5; $i >= 0; $i--) {
        $date = date('Y-m', strtotime("-$i months"));
        $monthName = date('M', strtotime("-$i months"));
        $revenueLabels[] = $monthName;
        $revenueData[] = 0;
    }
    
    // Fill with real data
    if (!empty($monthly_sales)) {
        foreach ($monthly_sales as $sale) {
            $saleMonth = date('M', mktime(0, 0, 0, $sale['month'], 1));
            $index = array_search($saleMonth, $revenueLabels);
            if ($index !== false) {
                $revenueData[$index] = (int) $sale['total_sales'];
            }
        }
    }
?>
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($revenueLabels) ?>,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: <?= json_encode($revenueData) ?>,
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
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Profit Chart
const profitCtx = document.getElementById('profitChart').getContext('2d');
<?php 
    // Calculate average profit margin from monthly breakdown
    $totalMargin = 0;
    $dataCount = count($monthly_breakdown);
    foreach ($monthly_breakdown as $month) {
        $totalMargin += $month['margin'];
    }
    $avgMargin = $dataCount > 0 ? round($totalMargin / $dataCount) : 0;
    $profitPercentage = $avgMargin;
    $costPercentage = 100 - $avgMargin;
?>
new Chart(profitCtx, {
    type: 'doughnut',
    data: {
        labels: ['Keuntungan', 'Biaya Operasional'],
        datasets: [{
            data: [<?= $profitPercentage ?>, <?= $costPercentage ?>],
            backgroundColor: [
                'rgb(34, 197, 94)',
                'rgb(239, 68, 68)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>

<?= $this->endSection() ?>