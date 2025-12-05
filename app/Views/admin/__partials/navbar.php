  <nav class="bg-white shadow-xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- <span class="text-xl font-bold text-gray-800">BL PARFUME</span> -->
                        <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" width="150" height="150">
                    </div>
                    <div class="hidden md:flex items-center space-x-8">
                        
                        <a href="<?= site_url('pesanan') ?>" class="text-gray-700 hover:text-gray-900">Pemesanan</a>
                        <a href="<?= site_url('transaksi') ?>" class="text-gray-700 hover:text-gray-900">Transaksi</a>
                        <a href="<?= site_url('keuangan') ?>" class="text-gray-700 hover:text-gray-900">Keuangan</a>
                        <a href="<?= site_url('produk') ?>" class="text-gray-700 hover:text-gray-900">Produk</a>
                        <a href="<?= site_url('logout') ?>" class="text-gray-700 hover:text-gray-900">Logout</a>

                        
                        <?php if (session()->get('user_id')) : ?>
    
                        <a href="<?= site_url('logout') ?>" class="text-red-700 hover:text-gray-900s font-weight-bold">
                            Keluar
                        </a>
                        <?php endif; ?>
                    </div>
            </div>
            </div>
        </nav>
