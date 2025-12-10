<?php $uri = service('uri'); ?>

<nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center gap-3">
                <a href="<?= site_url('admin/dashboard') ?>" class="flex items-center gap-2">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="BL Parfume" class="h-10 w-auto">
                </a>
            </div>
            
            <div class="hidden md:flex items-center space-x-8">
                
                <?php 
                    // Fungsi Helper untuk Active State
                    function setMenu($path) {
                        return strpos(uri_string(), $path) !== false 
                            ? 'text-black font-bold border-b-2 border-black' 
                            : 'text-gray-500 hover:text-black font-medium';
                    }
                ?>

                <a href="<?= site_url('admin/dashboard') ?>" class="<?= setMenu('admin/dashboard') ?> transition py-2">
                   Dashboard
                </a>

                <a href="<?= site_url('admin/keuangan') ?>" class="<?= setMenu('admin/keuangan') ?> transition py-2">
                   Keuangan
                </a>

                <a href="<?= site_url('admin/pesanan') ?>" class="<?= setMenu('admin/pesanan') ?> transition py-2">
                   Pesanan
                </a>

                <a href="<?= site_url('admin/produk') ?>" class="<?= setMenu('admin/produk') ?> transition py-2">
                   Produk
                </a>

                <a href="<?= site_url('admin/transaksi') ?>" class="<?= setMenu('admin/transaksi') ?> transition py-2">
                   Transaksi
                </a>
                
                <div class="flex items-center space-x-4 ml-4 border-l pl-6 border-gray-200">
                    <span class="block text-sm font-bold text-gray-800">
                        <?= session()->get('user_name') ?? 'Admin' ?>
                    </span>
                    <a href="<?= site_url('logout') ?>" class="text-red-500 hover:text-red-700 font-bold text-sm">
                        Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>