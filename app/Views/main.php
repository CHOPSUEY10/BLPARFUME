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
                    <a href="<?= site_url('login') ?>" class="inline-flex items-center px-5 py-2 rounded-xl bg-black text-white text-sm font-semibold shadow-lg shadow-black/20 hover:bg-gray-800 transition">
                        Masuk
                    </a>
                    <a href="<?= site_url('/') ?>" class="text-gray-700 hover:text-gray-900">Beranda</a>
                    <a href="<?= site_url('belanja') ?>" class="text-gray-700 hover:text-gray-900">Belanja</a>
                    <a href="<?= site_url('tentang') ?>" class="text-gray-700 hover:text-gray-900">Tentang</a>
                    <a href="<?= site_url('kontak') ?>" class="text-gray-700 hover:text-gray-900">Kontak</a>
                    
                    <a href="<?=site_url('keranjang') ?>" class="text-gray-700 hover:text-gray-900">
                    <i class="fas fa-shopping-cart"></i>
                    
                    </a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    
    <section 
    class="hero flex flex-col items-center justify-center text-white text-center bg-cover bg-center h-[700px] relative"
    style="background-image: url('<?= base_url('assets/images/hero-bg.png') ?>');">
    
    <div class="px-4 relative z-10">
        <h1 class="text-4xl md:text-6xl font-bold mb-16 mt-6">Discover Your Signature Scent</h1>

        <a href="#shop" class="bg-white text-gray-800 px-8 py-3 shadow-lg rounded-full font-semibold hover:bg-gray-100 transition duration-300">
            Belanja Sekarang
        </a>
    </div>

    <!-- Optional overlay -->
    <div class="absolute inset-0 bg-black/40 z-0"></div>
</section>


    <!-- Featured Products -->
    <section id="shop" class="py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Produk Terlaris</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Product 1 -->
                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                
                    <img src="<?= base_url('assets/images/parfume-1.jpg') ?>" alt="Product Image" width="100%" height="100%" style="z-index:-1"> 
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Dior Sauvage</h3>
                        <p class="text-gray-600 mb-4">A captivating fragrance that lasts all day</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold">Rp.200.000</span>
                            <button class=" add-item bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                                +
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product 2 -->
                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                   
                    <img src="<?= base_url('assets/images/parfume-2.jpg') ?>" alt="Product Image" width="100%" height="100%" style="z-index:-1"> 
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Soft Al Sosha</h3>
                        <p class="text-gray-600 mb-4">A delicate bouquet of fresh flowers</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold">Rp.210.000</span>
                            <button class=" add-item bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                                +
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Product 3 -->
                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                    
                    <img src="<?= base_url('assets/images/parfume-3.jpg') ?>" alt="Product Image" width="100%" height="100%" style="z-index:-1"> 
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Zahrat Hawaii</h3>
                        <p class="text-gray-600 mb-4">Rich and mysterious oriental scent</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold">Rp.230.000</span>
                            <button class="add-item  bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                                +
                            </button>
                        </div>
                    </div>
                </div>
                <script> BASE_URL="<?=base_url()?>" </script>
                <scripts src="<?= base_url("assets/js/main.js") ?>">  </scripts>
            </div>
        </div>
    </section>

    <?= $this->renderSection('content') ?>
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-4">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">BL PARFUME</h3>
                <p class="text-gray-400">Luxury fragrances for the modern individual.</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Shop</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Seluruh Produk</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Produk Terkini</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Produk Terlaris</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Customer Service</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Contact Us</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Shipping & Returns</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Connect With Us</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
            <p>&copy; <?php echo date('Y'); ?> BL Parfume. All rights reserved.</p>
        </div>
    </footer>


</body>
</html>