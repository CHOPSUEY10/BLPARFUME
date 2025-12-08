<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BL Parfume - Luxury Fragrances</title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                     <a href="<?= site_url('/') ?>">
                        <img src="<?= base_url('assets/images/logo.png') ?>" alt="BL Parfume" class="h-12 w-auto">
                     </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="<?= site_url('/') ?>" class="text-gray-600 hover:text-black transition font-medium">Beranda</a>
                    <a href="<?= site_url('belanja') ?>" class="text-gray-600 hover:text-black transition font-medium">Belanja</a>
                    
                    <?php if (session()->get('user_id')) : ?>
                        <a href="<?= site_url('riwayat') ?>" class="text-gray-600 hover:text-black transition font-medium">Riwayat</a>
                    <?php endif; ?>

                    <a href="<?= site_url('tentang') ?>" class="text-gray-600 hover:text-black transition font-medium">Tentang</a>
                    <a href="<?= site_url('kontak') ?>" class="text-gray-600 hover:text-black transition font-medium">Kontak</a>
                    
                    <?php if (session()->get('user_id')) : ?>
                        <div class="flex items-center space-x-4 ml-4 border-l pl-6 border-gray-200">
                            <a href="<?= site_url('keranjang') ?>" class="text-gray-800 hover:text-green-600 transition relative">
                                <i class="fas fa-shopping-bag text-xl"></i>
                            </a>
                            <a href="<?= site_url('logout') ?>" class="text-red-500 hover:text-red-700 font-medium text-sm">
                                Keluar
                            </a>
                        </div>
                    <?php else : ?>
                        <a href="<?= site_url('login') ?>" class="bg-black text-white px-6 py-2 rounded-full font-medium hover:bg-gray-800 transition shadow-md">
                            Masuk
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        <?php if (uri_string() == '' || uri_string() == '/'): ?>
        <section 
            class="hero flex flex-col items-center justify-center text-white text-center bg-cover bg-center h-[600px] relative"
            style="background-image: url('<?= base_url('assets/images/hero-bg.png') ?>');">
            
            <div class="px-4 relative z-10">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 mt-6 leading-tight drop-shadow-md">
                    Discover Your <br> Signature Scent
                </h1>
                <p class="text-lg mb-10 text-gray-100 max-w-2xl mx-auto drop-shadow-sm">
                    Temukan aroma yang mendefinisikan kepribadian Anda dengan koleksi parfum eksklusif kami.
                </p>

                <a href="<?= site_url('belanja') ?>" class="bg-white text-gray-900 px-8 py-3 shadow-xl rounded-full font-semibold hover:bg-gray-100 transition duration-300 transform hover:-translate-y-1 inline-block">
                    Belanja Sekarang
                </a>
            </div>

            <div class="absolute inset-0 bg-black/40 z-0"></div>
        </section>

        <section id="shop" class="py-16 px-4 bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <span class="text-gray-500 uppercase tracking-widest text-sm font-semibold">Pilihan Terbaik</span>
                    <h2 class="text-3xl font-bold mt-2">Produk Terlaris</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden">
                        <div class="relative overflow-hidden aspect-square bg-gray-100">
                            <img src="<?= base_url('assets/images/parfume-1.jpg') ?>" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        </div> 
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-semibold mb-1 text-gray-900">Dior Sauvage</h3>
                            <p class="text-gray-500 text-sm mb-4">Aroma citrus segar & maskulin</p>
                            <span class="text-lg font-bold text-gray-900 block mb-4">Rp200.000</span>
                            <a href="<?= site_url('belanja') ?>" class="inline-block w-full border border-black text-black py-2 rounded-lg font-medium hover:bg-black hover:text-white transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    
                    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden">
                        <div class="relative overflow-hidden aspect-square bg-gray-100">
                            <img src="<?= base_url('assets/images/parfume-2.jpg') ?>" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        </div> 
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-semibold mb-1 text-gray-900">Soft Al Sosha</h3>
                            <p class="text-gray-500 text-sm mb-4">Kelembutan bunga mawar & musk</p>
                            <span class="text-lg font-bold text-gray-900 block mb-4">Rp210.000</span>
                            <a href="<?= site_url('belanja') ?>" class="inline-block w-full border border-black text-black py-2 rounded-lg font-medium hover:bg-black hover:text-white transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    
                    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden">
                        <div class="relative overflow-hidden aspect-square bg-gray-100">
                            <img src="<?= base_url('assets/images/parfume-3.jpg') ?>" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        </div> 
                        <div class="p-6 text-center">
                            <h3 class="text-lg font-semibold mb-1 text-gray-900">Zahrat Hawaii</h3>
                            <p class="text-gray-500 text-sm mb-4">Eksotis buah tropis & nanas</p>
                            <span class="text-lg font-bold text-gray-900 block mb-4">Rp230.000</span>
                            <a href="<?= site_url('belanja') ?>" class="inline-block w-full border border-black text-black py-2 rounded-lg font-medium hover:bg-black hover:text-white transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-12">
                    <a href="<?= site_url('belanja') ?>" class="text-gray-900 font-semibold border-b-2 border-black hover:text-gray-600 transition pb-1">
                        Lihat Semua Koleksi <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>

    <footer class="bg-gray-900 text-white pt-16 pb-8 px-4 mt-auto">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-1">
                <h3 class="text-2xl font-bold mb-6 tracking-wider">BL PARFUME</h3>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">
                    Menghadirkan aroma kemewahan yang terjangkau. Dirracik dengan bahan premium untuk menemani setiap momen spesial Anda.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-white hover:text-gray-900 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-white hover:text-gray-900 transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/6283148796357" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-green-500 hover:text-white transition"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            
            <div>
                <h4 class="font-semibold text-white mb-6 uppercase text-sm tracking-widest">Menu</h4>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li><a href="<?= site_url('/') ?>" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="<?= site_url('belanja') ?>" class="hover:text-white transition">Belanja</a></li>
                    <li><a href="<?= site_url('tentang') ?>" class="hover:text-white transition">Tentang Kami</a></li>
                    <li><a href="<?= site_url('riwayat') ?>" class="hover:text-white transition">Cek Pesanan</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold text-white mb-6 uppercase text-sm tracking-widest">Bantuan</h4>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li><a href="<?= site_url('kontak') ?>" class="hover:text-white transition">Hubungi Kami</a></li>
                    <li><a href="#" class="hover:text-white transition">Cara Pemesanan</a></li>
                    <li><a href="#" class="hover:text-white transition">Pengiriman</a></li>
                    <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-white mb-6 uppercase text-sm tracking-widest">Kontak</h4>
                <ul class="space-y-4 text-gray-400 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                        <span>Jl. Merdeka No. 9,<br>Tanjungpinang, Kep. Riau</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3"></i>
                        <span>hello@blparfume.id</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fab fa-whatsapp mr-3"></i>
                        <span>+62 831-4879-6357</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 text-center">
            <p class="text-xs text-gray-500">&copy; <?php echo date('Y'); ?> BL Parfume. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const BASE_URL = "<?= base_url() ?>";
    </script>
</body>
</html>