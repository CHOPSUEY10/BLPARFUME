<?= $this->extend('admin/__partials/layout') ?>
<?= $this->section('content') ?>

<!-- Success/Error Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <i class="fas fa-exclamation-circle mr-2"></i><?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Header Section -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Manajemen Produk</h2>
        <p class="text-gray-600 mt-1">Kelola katalog parfum Anda</p>
    </div>
    <div class="flex space-x-3">
        <a href="<?= site_url('admin/product/export') ?>?search=<?= urlencode($search) ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
            <i class="fas fa-download mr-2"></i>Export
        </a>
        <a href="<?= site_url('admin/product/create') ?>" class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-black px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-lg inline-block">
            <i class="fas fa-plus mr-2"></i>Tambah Produk
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Produk</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($stats['total_products'] ?? 0) ?></p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-box text-blue-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Pesanan</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($stats['total_orders'] ?? 0) ?></p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-shopping-cart text-green-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Users</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($stats['total_users'] ?? 0) ?></p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-purple-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Pendapatan</p>
                <p class="text-2xl font-bold text-gray-900">Rp <?= number_format(($stats['total_revenue'] ?? 0), 0, ',', '.') ?></p>
            </div>
            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-orange-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <form method="get" class="flex flex-wrap items-center gap-4">
        <div class="flex-1 min-w-64">
            <input id="productSearch" name="search" type="text" placeholder="Cari produk..." value="<?= esc($search ?? '') ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
        </div>
        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
            <option>Semua Kategori</option>
            <option>Parfum Pria</option>
            <option>Parfum Wanita</option>
            <option>Parfum Unisex</option>
        </select>
        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500">
            <option>Semua Status</option>
            <option>Aktif</option>
            <option>Tidak Aktif</option>
            <option>Stok Habis</option>
        </select>
        <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-filter"></i>
        </button>
    </form>
</div>

<!-- Products Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="aspect-square bg-gray-100 flex items-center justify-center overflow-hidden">
                    <?php if (!empty($product['product_image'])): ?>
                        <img src="<?= product_image_url($product['product_image']) ?>" 
                             alt="<?= esc($product['product_name']) ?>"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    <?php else: ?>
                        <div class="text-center">
                            <i class="fas fa-spray-can text-4xl text-gray-400 mb-2"></i>
                            <p class="text-xs text-gray-500">No Image</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-1"><?= esc($product['product_name']) ?></h3>
                    <p class="text-sm text-gray-500 mb-2"><?= truncate_text($product['product_desc'], 50) ?></p>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-lg font-bold text-gray-900"><?= format_rupiah($product['product_price']) ?></span>
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Aktif</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-sm text-gray-500 mb-3">
                        <span>ID: <?= $product['id_product'] ?></span>
                        <span>Ukuran: <?= esc($product['product_size'] ?? '-') ?></span>
                        <span class="col-span-2">Stok: <span class="font-semibold <?= ($product['stock'] ?? 0) > 0 ? 'text-green-600' : 'text-red-600' ?>"><?= $product['stock'] ?? 0 ?></span> unit</span>
                    </div>
                    <div class="flex space-x-2">
                        <a href="<?= site_url('admin/product/edit/' . $product['id_product']) ?>" class="flex-1 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-black py-2 px-3 rounded-lg text-sm transition-colors font-medium text-center inline-block">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-600 py-2 px-3 rounded-lg text-sm transition-colors" onclick="deleteProduct(<?= $product['id_product'] ?>, '<?= esc($product['product_name']) ?>')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full text-center py-12">
            <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada produk</h3>
            <p class="text-gray-500 mb-4">Mulai dengan menambahkan produk pertama Anda</p>
            <a href="<?= site_url('admin/product/create') ?>" class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-black px-6 py-2 rounded-lg transition-colors font-medium shadow-lg inline-block">
                <i class="fas fa-plus mr-2"></i>Tambah Produk
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 px-6 py-4">
    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-700">
            Menampilkan <span class="font-medium"><?= $pager['start_item'] ?></span> sampai <span class="font-medium"><?= $pager['end_item'] ?></span> dari <span class="font-medium"><?= $pager['total_items'] ?></span> produk
        </div>
        <div class="flex space-x-2">
            <?php if ($pager['current'] > 1): ?>
                <a href="?page=<?= $pager['current'] - 1 ?>&search=<?= urlencode($search) ?>" 
                   class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Sebelumnya
                </a>
            <?php endif; ?>
            
            <span class="px-3 py-2 text-sm text-black bg-yellow-400 border border-yellow-400 rounded-lg font-medium">
                <?= $pager['current'] ?>
            </span>
            
            <?php if ($pager['current'] < $pager['total_pages']): ?>
                <a href="?page=<?= $pager['current'] + 1 ?>&search=<?= urlencode($search) ?>" 
                   class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Selanjutnya
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
