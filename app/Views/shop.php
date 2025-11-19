<?= $this->extend('main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-12">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Koleksi Parfum Kami</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">Temukan beragam aroma yang menarik</p>
    </div>

    <!-- Filters -->
    <div class="mb-12">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="flex items-center space-x-4">
                <span class="font-medium">Filter by:</span>
                <button class="px-4 py-2 bg-white border rounded-full hover:bg-gray-50">All</button>
                <button class="px-4 py-2 bg-white border rounded-full hover:bg-gray-50">Men</button>
                <button class="px-4 py-2 bg-white border rounded-full hover:bg-gray-50">Women</button>
                <button class="px-4 py-2 bg-white border rounded-full hover:bg-gray-50">Unisex</button>
            </div>
            <div class="relative">
                <select class="appearance-none bg-white border rounded-full pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    <option>Sort by: Featured</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Newest Arrivals</option>
                </select>
                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <!-- Product 1 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="relative overflow-hidden aspect-square">
                <img src="<?= base_url('assets/images/parfume-1.jpg') ?>" alt="Dior Sauvage" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center">
                    <button class="bg-white text-gray-800 px-6 py-2 rounded-full font-medium opacity-0 hover:opacity-100 transform translate-y-4 hover:translate-y-0 transition-all duration-300">
                        Quick View
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Dior Sauvage</h3>
                        <p class="text-gray-500">Eau de Parfum</p>
                    </div>
                    <span class="text-lg font-bold text-gray-900">$89.99</span>
                </div>
                <button class="w-full mt-4 bg-black text-white py-2 rounded-md hover:bg-gray-800 transition-colors">
                    Add to Cart
                </button>
            </div>
        </div>

        <!-- Product 2 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="relative overflow-hidden aspect-square">
                <img src="<?= base_url('assets/images/parfume-2.jpg') ?>" alt="Soft Al Sosha" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center">
                    <button class="bg-white text-gray-800 px-6 py-2 rounded-full font-medium opacity-0 hover:opacity-100 transform translate-y-4 hover:translate-y-0 transition-all duration-300">
                        Quick View
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Soft Al Sosha</h3>
                        <p class="text-gray-500">Eau de Toilette</p>
                    </div>
                    <span class="text-lg font-bold text-gray-900">$79.99</span>
                </div>
                <button class="w-full mt-4 bg-black text-white py-2 rounded-md hover:bg-gray-800 transition-colors">
                    Add to Cart
                </button>
            </div>
        </div>

        <!-- Product 3 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="relative overflow-hidden aspect-square">
                <img src="<?= base_url('assets/images/parfume-3.jpg') ?>" alt="Zahrat Hawaii" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center">
                    <button class="bg-white text-gray-800 px-6 py-2 rounded-full font-medium opacity-0 hover:opacity-100 transform translate-y-4 hover:translate-y-0 transition-all duration-300">
                        Quick View
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Zahrat Hawaii</h3>
                        <p class="text-gray-500">Eau de Parfum</p>
                    </div>
                    <span class="text-lg font-bold text-gray-900">$99.99</span>
                </div>
                <button class="w-full mt-4 bg-black text-white py-2 rounded-md hover:bg-gray-800 transition-colors">
                    Add to Cart
                </button>
            </div>
        </div>

        <!-- Add more products as needed -->
    </div>

    <!-- Pagination -->
    <div class="mt-12 flex justify-center">
        <nav class="inline-flex rounded-md shadow">
            <a href="#" class="px-4 py-2 rounded-l-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">Previous</a>
            <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-blue-50 text-blue-600">1</a>
            <a href="#" class="px-4 py-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">2</a>
            <a href="#" class="px-4 py-2 border-t border-b border-r border-gray-300 bg-white text-gray-700 hover:bg-gray-50">3</a>
            <a href="#" class="px-4 py-2 rounded-r-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">Next</a>
        </nav>
    </div>
</div>
<?= $this->endSection() ?>