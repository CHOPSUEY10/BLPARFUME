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
        <button class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-black px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-lg">
            <i class="fas fa-download mr-2"></i>Export PDF
        </button>
    </div>
</div>

<!-- Revenue Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Revenue -->
    <div class="bg-gradient-to-br from-gray-800 to-black rounded-xl p-6 text-white shadow-lg border-t-4 border-yellow-400">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-yellow-400/20 rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-line text-2xl text-yellow-400"></i>
            </div>
            <span class="text-sm bg-yellow-400/20 text-yellow-400 px-2 py-1 rounded-full font-medium">Total</span>
        </div>
        <h3 class="text-sm font-medium opacity-90">Total Pendapatan</h3>
        <p class="text-3xl font-bold">Rp <?= number_format(($yearly_finance['total_revenue'] ?? 0) / 1000000, 1) ?>M</p>
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
        <p class="text-3xl font-bold">Rp <?= number_format(($monthly_finance['total_revenue'] ?? 0) / 1000000, 1) ?>M</p>
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
        <p class="text-3xl font-bold">Rp <?= number_format(($monthly_finance['average_order'] ?? 0) / 1000, 0) ?>K</p>
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
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">Desember 2024</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rp 45.2M</td>
                        <td class="px-6 py-4 text-sm text-red-600">Rp 13.1M</td>
                        <td class="px-6 py-4 text-sm font-semibold text-green-600">Rp 32.1M</td>
                        <td class="px-6 py-4 text-sm text-gray-900">71%</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">November 2024</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rp 38.7M</td>
                        <td class="px-6 py-4 text-sm text-red-600">Rp 11.8M</td>
                        <td class="px-6 py-4 text-sm font-semibold text-green-600">Rp 26.9M</td>
                        <td class="px-6 py-4 text-sm text-gray-900">69%</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">Oktober 2024</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rp 42.1M</td>
                        <td class="px-6 py-4 text-sm text-red-600">Rp 12.9M</td>
                        <td class="px-6 py-4 text-sm font-semibold text-green-600">Rp 29.2M</td>
                        <td class="px-6 py-4 text-sm text-gray-900">69%</td>
                    </tr>
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
                    <span class="text-sm font-semibold text-green-600">245%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Customer Lifetime Value</span>
                    <span class="text-sm font-semibold text-blue-600">Rp 2.1M</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 70%"></div>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Cost per Acquisition</span>
                    <span class="text-sm font-semibold text-purple-600">Rp 125K</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-purple-500 h-2 rounded-full" style="width: 60%"></div>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Repeat Purchase Rate</span>
                    <span class="text-sm font-semibold text-orange-600">68%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-orange-500 h-2 rounded-full" style="width: 68%"></div>
                </div>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="text-center">
                <p class="text-2xl font-bold text-gray-900">Rp 45.2M</p>
                <p class="text-sm text-gray-500">Total Pendapatan Bulan Ini</p>
                <div class="mt-2 flex items-center justify-center text-green-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span class="text-sm font-medium">+12% dari bulan lalu</span>
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
                $revenueData[$index] = round($sale['total_sales'] / 1000000, 1);
            }
        }
    }
?>
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($revenueLabels) ?>,
        datasets: [{
            label: 'Pendapatan (Juta Rupiah)',
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
new Chart(profitCtx, {
    type: 'doughnut',
    data: {
        labels: ['Keuntungan', 'Biaya Operasional'],
        datasets: [{
            data: [71, 29],
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