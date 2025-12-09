<?= $this->extend('main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Keranjang Belanja</h1>
    
    <?php 
        $items = $summary['items'] ?? [];
        $total = $summary['total'] ?? 0;
        $count = $summary['count'] ?? 0;

        // PERBAIKAN: Selalu definisikan $waText di sini
        $waText = "Halo Admin BL Parfume, saya ingin memesan:%0a%0a";

        if (!empty($items)) {
            foreach($items as $i) {
                $waText .= "▪️ " . $i['product_name'] . " (" . $i['quantity'] . "x) - " . $i['product_size'] . "%0a";
            }
            $waText .= "%0a💰 *Total: Rp" . number_format($total, 0, ',', '.') . "*";
            $waText .= "%0a%0aMohon info pembayaran selanjutnya. Terima kasih.";
        } else {
             $waText = "Halo Admin BL Parfume, keranjang saya kosong. Ingin menanyakan ketersediaan produk.";
        }
    ?>

    <?php if(empty($items)): ?>
        <div class="text-center py-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
            <div class="text-gray-300 mb-4">
                <i class="fas fa-shopping-basket text-6xl"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Keranjang Anda kosong</h3>
            <p class="text-gray-500 mb-6">Yuk isi dengan parfum favoritmu!</p>
            <a href="<?= site_url('belanja') ?>" class="inline-flex items-center bg-black text-white px-8 py-3 rounded-full font-semibold hover:bg-gray-800 transition shadow-lg">
                <i class="fas fa-arrow-left mr-2"></i> Mulai Belanja
            </a>
        </div>

    <?php else: ?>
        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="lg:w-2/3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="hidden md:grid grid-cols-12 gap-4 bg-gray-50 p-4 text-sm font-bold text-gray-600 border-b">
                        <div class="col-span-6">Produk</div>
                        <div class="col-span-2 text-center">Harga</div>
                        <div class="col-span-2 text-center">Jml</div>
                        <div class="col-span-2 text-center">Subtotal</div>
                    </div>

                    <?php foreach($items as $item): ?>
                        <?php 
                            $imgNum = ($item['product_id'] % 3) + 1; 
                        ?>
                        <div class="flex flex-col md:grid md:grid-cols-12 gap-4 p-6 items-center border-b border-gray-100 last:border-0 hover:bg-gray-50 transition">
                            <div class="col-span-6 flex items-center w-full space-x-4">
                                <button class="text-gray-400 hover:text-red-500 transition btn-delete p-2" 
                                        data-product-id="<?= $item['product_id'] ?>" 
                                        title="Hapus Produk">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                                <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border border-gray-200">
                                    <img src="<?= base_url('assets/images/parfume-' . $imgNum . '.jpg') ?>" 
                                         alt="<?= esc($item['product_name']) ?>" 
                                         class="w-full h-full object-cover">
                                </div>
                                
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg"><?= esc($item['product_name']) ?></h4>
                                    <span class="inline-block px-2 py-1 bg-gray-100 text-xs rounded text-gray-500 mt-1">
                                        Size: <?= esc($item['product_size']) ?>
                                    </span>
                                </div>
                            </div>

                            <div class="col-span-2 text-center w-full md:w-auto">
                                <span class="md:hidden text-gray-500 text-sm mr-2">Harga:</span>
                                <span class="text-gray-700">Rp<?= number_format($item['product_price'], 0, ',', '.') ?></span>
                            </div>

                            <div class="col-span-2 text-center w-full md:w-auto flex justify-center items-center gap-3">
                                <span class="md:hidden text-gray-500 text-sm mr-2">Jml:</span>
                                <button class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center font-bold text-gray-700 transition btn-update"
                                        data-product-id="<?= $item['product_id'] ?>" 
                                        data-action="decrease"
                                        <?= $item['quantity'] <= 1 ? 'disabled style="opacity:0.5; cursor:not-allowed;"' : '' ?>>
                                    -
                                </button>
                                <span class="w-8 text-center font-bold text-lg"><?= esc($item['quantity']) ?></span>
                                <button class="w-8 h-8 rounded-full bg-black hover:bg-gray-800 flex items-center justify-center font-bold text-white transition btn-update"
                                        data-product-id="<?= $item['product_id'] ?>" 
                                        data-action="increase">
                                    +
                                </button>
                            </div>

                            <div class="col-span-2 text-center w-full md:w-auto font-bold text-gray-900">
                                <span class="md:hidden text-gray-500 text-sm mr-2 font-normal">Subtotal:</span>
                                Rp<?= number_format($item['subtotal'], 0, ',', '.') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="p-4 bg-gray-50">
                        <a href="<?= site_url('belanja') ?>" class="text-sm text-gray-600 hover:text-black font-medium flex items-center">
                            <i class="fas fa-long-arrow-alt-left mr-2"></i> Tambah parfum lainnya
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/3">
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Total Item</span>
                            <span class="font-medium"><?= $count ?> pcs</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Ongkos Kirim</span>
                            <span class="text-green-600 font-bold">Gratis</span>
                        </div>
                        <div class="border-t border-dashed border-gray-200 pt-4 mt-4">
                            <div class="flex justify-between items-end">
                                <span class="text-gray-900 font-bold">Total Bayar</span>
                                <span class="text-2xl font-bold text-gray-900">Rp<?= number_format($total, 0, ',', '.') ?></span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 text-right">Termasuk pajak</p>
                        </div>
                    </div>

                    <button onclick="checkoutProcess()" 
                       class="flex items-center justify-center w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl shadow-lg transition transform hover:-translate-y-1 mt-6 cursor-pointer">
                        <svg class="w-6 h-6 mr-2 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        <span>Checkout via WhatsApp</span>
                    </button>
                    
                    <p class="text-xs text-center text-gray-400 mt-4">
                        <i class="fas fa-lock mr-1"></i> Transaksi Anda aman & terenkripsi
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    // Token CSRF Global
    const csrfName = '<?= csrf_token() ?>';
    let csrfHash   = '<?= csrf_hash() ?>'; 

    document.addEventListener('DOMContentLoaded', function() {
        
        async function updateCart(url, payload) {
            // ... (kode updateCart yang sudah ada) ...
        }

        document.querySelectorAll('.btn-update').forEach(btn => {
            // ... (kode btn-update yang sudah ada) ...
        });

        document.querySelectorAll('.btn-delete').forEach(btn => {
            // ... (kode btn-delete yang sudah ada) ...
        });
    });

    // FUNGSI CHECKOUT
    async function checkoutProcess() {
        const btn = document.querySelector('button[onclick="checkoutProcess()"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
        btn.disabled = true;

        // Mendefinisikan variabel di sini agar bisa digunakan di fetch
        const waText = `<?= $waText ?>`; 

        try {
            // 1. Simpan Order ke Database
            const response = await fetch('<?= site_url('cart/checkout') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfHash
                },
                body: JSON.stringify({ [csrfName]: csrfHash })
            });

            const result = await response.json();
            if(result.token) csrfHash = result.token;

            if (result.success) {
                // 2. Buka WhatsApp
                const phone = "6283148796357";
                
                // Tambahkan ID Order ke pesan WA
                const finalWaText = `${waText}%0a%0a*Order ID: #${result.order_id}*`;
                const url = `https://wa.me/${phone}?text=${finalWaText}`;
                
                window.open(url, '_blank');
                
                // Redirect ke Halaman Riwayat
                window.location.href = '<?= site_url('riwayat') ?>';
            } else {
                alert('Gagal checkout: ' + result.message);
                btn.innerHTML = originalText;
                btn.disabled = false;
            }

        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan koneksi');
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }
</script>
<?= $this->endSection() ?>