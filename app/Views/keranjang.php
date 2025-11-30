<?= $this->extend('main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Keranjang Belanja</h1>
    
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Cart Items -->
        <div class="lg:w-2/3">
            <!-- Cart Header -->
            <div class="hidden md:grid grid-cols-12 gap-4 bg-gray-100 p-4 rounded-t-lg">
                <div class="col-span-5 font-medium text-gray-600">Produk</div>
                <div class="col-span-2 font-medium text-gray-600 text-center">Harga</div>
                <div class="col-span-2 font-medium text-gray-600 text-center">Jumlah</div>
                <div class="col-span-2 font-medium text-gray-600 text-center">Subtotal</div>
                <div class="col-span-1"></div>
            </div>

            <!-- Cart Item 1 -->
            <div class="border-b border-gray-200 py-6">
                <div class="flex flex-col md:grid md:grid-cols-12 gap-4 items-center">
                    <div class="col-span-5 flex items-center space-x-4">
                        <img src="<?= base_url('assets/images/parfume-1.jpg') ?>" alt="Dior Sauvage" class="w-20 h-20 object-cover rounded">
                        <div>
                            <h3 class="font-medium text-gray-800">Dior Sauvage</h3>
                            <!-- <p class="text-sm text-gray-500">Eau de Parfum</p> -->
                        </div>
                    </div>
                    <div class="col-span-2 text-center">
                        <span class="text-gray-800">Rp.200.000</span>
                    </div>
                    <div class="col-span-2">
                        <div class="flex items-center justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border rounded-full hover:bg-gray-100">-</button>
                            <span class="w-10 text-center">1</span>
                            <button class="w-8 h-8 flex items-center justify-center border rounded-full hover:bg-gray-100">+</button>
                        </div>
                    </div>
                    <div class="col-span-2 text-center font-medium">
                        Rp.200.000
                    </div>
                    <div class="col-span-1 flex justify-end">
                        <button class="text-gray-400 hover:text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Cart Item 2 -->
            <div class="border-b border-gray-200 py-6">
                <div class="flex flex-col md:grid md:grid-cols-12 gap-4 items-center">
                    <div class="col-span-5 flex items-center space-x-4">
                        <img src="<?= base_url('assets/images/parfume-2.jpg') ?>" alt="Soft Al Sosha" class="w-20 h-20 object-cover rounded">
                        <div>
                            <h3 class="font-medium text-gray-800">Soft Al Sosha</h3>
                            <!-- <p class="text-sm text-gray-500">Eau de Toilette</p> -->
                        </div>
                    </div>
                    <div class="col-span-2 text-center">
                        <span class="text-gray-800">Rp.210.000</span>
                    </div>
                    <div class="col-span-2">
                        <div class="flex items-center justify-center space-x-2">
                            <button class="w-8 h-8 flex items-center justify-center border rounded-full hover:bg-gray-100">-</button>
                            <span class="w-10 text-center">1</span>
                            <button class="w-8 h-8 flex items-center justify-center border rounded-full hover:bg-gray-100">+</button>
                        </div>
                    </div>
                    <div class="col-span-2 text-center font-medium">
                        Rp.210.000
                    </div>
                    <div class="col-span-1 flex justify-end">
                        <button class="text-gray-400 hover:text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Continue Shopping Button -->
            <div class="mt-8">
                <a href="<?= site_url('belanja') ?>" class="flex items-center text-blue-600 hover:text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Lanjutkan Belanja
                </a>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:w-1/3">
            <div class="bg-gray-50 p-6 rounded-lg">
                <h2 class="text-xl font-semibold mb-6">Ringkasan Pesanan</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span>$169.98</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ongkos Kirim</span>
                        <span class="text-green-600">Gratis</span>
                    </div>
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex justify-between font-semibold text-lg">
                            <span>Total</span>
                            <span>$169.98</span>
                        </div>
                    </div>
                </div>

                <!-- Checkout Button -->
                <button class="w-full mt-6 bg-black text-white py-3 rounded-lg hover:bg-gray-800 transition-colors flex items-center justify-center space-x-2">
                    <a href="https://wa.me/+6283183479614">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.293-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.964-.941 1.162-.173.198-.349.223-.646.074-.299-.149-1.263-.465-2.403-1.485-.888-.795-1.484-1.761-1.66-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.611-.912-2.207-.242-.579-.487-.5-.669-.508-.172-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-8.535 7.543h-.016l1.337-.372c-.213-.608-.427-1.216-.647-1.818 1.045.326 2.114.482 3.166.506.007.2.016.398.016.598a12.7 12.7 0 0 1-3.872-1.11c.2.603.407 1.203.612 1.797l.404 1.001z"/>
                    </svg>
                </button>

                <!-- Payment Methods -->
                
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>