<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BL Parfume - Luxury Fragrances</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="/assets/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
        <nav class="bg-white shadow-xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- <span class="text-xl font-bold text-gray-800">BL PARFUME</span> -->
                        <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" width="150" height="150">
                    </div>
                    <div class="hidden md:flex items-center space-x-8">
                        
                        <a href="<?= site_url('pesanan') ?>" class="text-gray-700 hover:text-gray-900">Belanja</a>
                        <a href="<?= site_url('transaksi') ?>" class="text-gray-700 hover:text-gray-900">Tentang</a>
                        <a href="<?= site_url('pelanggan') ?>" class="text-gray-700 hover:text-gray-900">Kontak</a>
                        
                        
                        <?php if (session()->get('user_id')) : ?>
    
                        <a href="<?= site_url('logout') ?>" class="text-red-700 hover:text-gray-900s font-weight-bold">
                            Keluar
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>

        <div class="relative max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 px-6">
        <div class="bg-white/80 backdrop-blur rounded-3xl shadow-2xl p-10 border border-gray-100">
            <div class="mb-8 text-center">
                <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Selamat Datang Kembali</p>
                <h1 class="text-3xl font-semibold text-gray-900">BL Parfume Administration</h1>
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 flex items-start space-x-3">
                    <i class="fas fa-circle-exclamation mt-1"></i>
                    <span><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 flex items-start space-x-3">
                    <i class="fas fa-circle-check mt-1"></i>
                    <span><?= esc(session()->getFlashdata('success')) ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('admin/login') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="email">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-4 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 py-3 pl-12 pr-4 text-gray-900 focus:border-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-800/20"
                            placeholder="you@example.com"
                            required
                            value="<?= old('email') ?>"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="password">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-4 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 py-3 pl-12 pr-4 text-gray-900 focus:border-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-800/20"
                            placeholder="Masukkan password"
                            required
                        >
                    </div>
                </div>

                    
                <p class="mt-8 text-center text-sm text-gray-500">
                    Belum punya akun?
                    <a href="<?= site_url('admin/register') ?>" class="font-semibold text-gray-900 hover:text-gray-700">Daftar sekarang</a>
                </p>

                <div class="flex items-center justify-between text-sm">
                    <label class="inline-flex items-center space-x-2 text-gray-600">
                        <input type="checkbox" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                        <span>Ingat saya</span>
                    </label>
                    <a href="#" class="text-gray-900 font-medium hover:text-gray-700">Lupa password?</a>
                </div>

                <button type="submit" class="w-full rounded-2xl bg-gray-900 py-3 text-white font-semibold tracking-wide shadow-lg shadow-gray-900/20 hover:bg-black transition">Masuk Sekarang</button>
            </form>

            
        </div>

    
    </div>
    </body>
    </html>