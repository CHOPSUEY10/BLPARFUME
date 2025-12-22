<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title><?= $title ?? 'Admin Panel' ?> - BL Parfume</title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link rel="icon" href="<?= base_url('assets/images/favicon.png') ?>" type="image/png">

    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>
    <script>
        // Format number to Indonesian Rupiah string, e.g. Rp 1.234.567
        function formatRupiah(value) {
            if (value === null || value === undefined) return 'Rp 0';
            var n = Number(value);
            if (isNaN(n)) return 'Rp 0';
            return 'Rp ' + n.toLocaleString('id-ID');
        }
    </script>
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .sidebar-transition { transition: all 0.3s ease; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-black transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0" 
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Logo -->
            <div class="flex items-center justify-center h-20 bg-gray-900 border-b border-yellow-400/20">
                <div class="flex items-center gap-2">
                    <i class="fas fa-spray-can text-yellow-400 text-2xl"></i>
                    <span class="text-white text-xl font-bold">BL Parfume</span>
                    <span class="text-yellow-400 text-xs bg-yellow-400/20 px-2 py-1 rounded-full ml-2">ADMIN</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-8">
                <?php 
                    $currentPath = uri_string();
                    function isActive($path) {
                        return strpos(uri_string(), $path) !== false 
                            ? 'bg-gray-800 text-white border-r-4 border-yellow-400' 
                            : 'text-gray-300 hover:bg-gray-800 hover:text-white';
                    }
                ?>
                
                <a href="<?= site_url('admin/dashboard') ?>" 
                   class="<?= isActive('admin/dashboard') ?> flex items-center px-6 py-3 text-sm font-medium transition-colors">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>

                <a href="<?= site_url('admin/order/view') ?>" 
                   class="<?= isActive('admin/order') ?> flex items-center px-6 py-3 text-sm font-medium transition-colors">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    Pesanan
                </a>

                <a href="<?= site_url('admin/product/view') ?>" 
                   class="<?= isActive('admin/product') ?> flex items-center px-6 py-3 text-sm font-medium transition-colors">
                    <i class="fas fa-box mr-3"></i>
                    Produk
                </a>

                <a href="<?= site_url('admin/transaction/view') ?>" 
                   class="<?= isActive('admin/transaction') ?> flex items-center px-6 py-3 text-sm font-medium transition-colors">
                    <i class="fas fa-credit-card mr-3"></i>
                    Transaksi
                </a>

                <a href="<?= site_url('admin/finance/view') ?>" 
                   class="<?= isActive('admin/finance') ?> flex items-center px-6 py-3 text-sm font-medium transition-colors">
                    <i class="fas fa-chart-line mr-3"></i>
                    Keuangan
                </a>

                <a href="<?= site_url('admin/message/view') ?>" 
                   class="<?= isActive('admin/message') ?> flex items-center px-6 py-3 text-sm font-medium transition-colors">
                    <i class="fas fa-envelope mr-3"></i>
                    Pesan
                </a>

                <div class="border-t border-gray-800 mt-8 pt-4">
                    <a href="<?= site_url('logout') ?>" 
                       class="text-red-400 hover:bg-red-600 hover:text-white flex items-center px-6 py-3 text-sm font-medium transition-colors">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Keluar
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="ml-4 text-2xl font-semibold text-gray-900"><?= $pageTitle ?? 'Dashboard' ?></h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-black text-sm"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">
                                <?= session()->get('email') ?? 'Admin' ?>
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 flex items-start space-x-3">
                        <i class="fas fa-check-circle mt-1"></i>
                        <span><?= esc(session()->getFlashdata('success')) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 flex items-start space-x-3">
                        <i class="fas fa-circle-exclamation mt-1"></i>
                        <span><?= esc(session()->getFlashdata('error')) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-exclamation-triangle mt-1"></i>
                            <div>
                                <p class="font-medium mb-2">Terdapat kesalahan:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>
</body>
</html>