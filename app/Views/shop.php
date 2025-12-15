<?= $this->extend('main') ?>

<?= $this->section('content') ?>
<div class="mx-auto px-4 py-12 max-w-6xl">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Koleksi Parfum Kami</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">Temukan beragam aroma yang menarik sesuai kepribadian Anda.</p>
    </div>
   
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mx-auto">
        
        <?php if (!empty($products) && is_array($products)) : ?>
            <?php foreach ($products as $index => $product) : ?>
                <?php 
                    // Logika sederhana untuk gambar
                    $imgNum = ($index % 3) + 1; 
                ?>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="relative overflow-hidden aspect-square">
                        <img src="<?= base_url('assets/images/parfume-' . $imgNum . '.jpg') ?>" 
                             alt="<?= esc($product['product_name']) ?>" 
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800"><?= esc($product['product_name']) ?></h3>
                                <?php if (!empty($product['sizes']) && is_array($product['sizes'])): ?>
                                    <label for="size-select-<?= $index ?>" class="sr-only">Pilih ukuran</label>
                                    <select id="size-select-<?= $index ?>" class="select-size block w-full text-xs text-gray-700 bg-white border rounded px-2 py-1 mb-2">
                                        <?php foreach ($product['sizes'] as $s): ?>
                                            <option value="<?= esc($s['id']) ?>"><?= esc($s['size']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else: ?>
                                    <?php $sizeDisplay = is_array($product['product_size']) ? implode(', ', $product['product_size']) : $product['product_size']; ?>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide"><?= esc($sizeDisplay) ?></p>
                                <?php endif; ?>
                            </div>
                            <span class="text-lg font-bold text-gray-900">
                                Rp.<?= number_format($product['product_price'], 0, ',', '.') ?>
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            <?= esc($product['product_desc']) ?>
                        </p>
                        
                        <button 
                            class="w-full mt-2 bg-black text-white py-2 rounded-md hover:bg-gray-800 transition-colors btn-add-cart"
                            data-product-default-id="<?= $product['id_product'] ?>">
                            <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-span-full text-center py-12">
                <h3 class="text-xl font-medium text-gray-900">Belum ada produk tersedia.</h3>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addButtons = document.querySelectorAll('.btn-add-cart');
        
        // 1. Definisikan Token sebagai variabel GLOBAL dan MUTABLE (let)
        const csrfName = '<?= csrf_token() ?>';
        let csrfHash   = '<?= csrf_hash() ?>'; // Token awal

        addButtons.forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();

                // Try to find a size select within the same card; if present use its value (product id for that size)
                const card = this.closest('.p-6');
                const select = card ? card.querySelector('.select-size') : null;
                const productId = select ? select.value : this.getAttribute('data-product-default-id');

                // Loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                this.disabled = true;

                try {
                    // Request ke CartController
                    const response = await fetch('<?= site_url('cart/add') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfHash // Gunakan token saat ini
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            [csrfName]: csrfHash // Kirim token di body juga
                        })
                    });

                    const result = await response.json();

                    // 2. UPDATE TOKEN: Ini kuncinya!
                    // Ambil token baru dari server dan simpan ke variabel csrfHash
                    if (result.token) {
                        csrfHash = result.token;
                        console.log("Token updated:", csrfHash);
                    }

                    if (response.ok && result.success) {
                        alert('✅ ' + result.message);
                    } else {
                        if(response.status === 401) {
                            // Redirect jika belum login
                            window.location.href = '<?= site_url('login') ?>';
                        } else {
                            alert('❌ ' + (result.message || 'Gagal menambahkan produk.'));
                        }
                    }

                } catch (error) {
                    console.error('Error:', error);
                    alert('❌ Terjadi kesalahan koneksi.');
                } finally {
                    // Kembalikan tombol ke semula
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>