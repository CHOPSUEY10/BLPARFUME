<?= $this->extend('admin/__partials/layout') ?>
<?= $this->section('content') ?>

<!-- Success/Error Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <i class="fas fa-exclamation-circle mr-2"></i><?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Header Section -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Edit Produk</h2>
        <p class="text-gray-600 mt-1">Edit informasi produk: <?= esc($product['product_name']) ?></p>
    </div>
    <div class="flex space-x-3">
        <a href="<?= site_url('admin/product/view') ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>
</div>

<!-- Form Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <form action="<?= site_url('admin/product/update/' . $product['id_product']) ?>" method="post" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>
        
        <!-- Product Name -->
        <div>
            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
            <input type="text" 
                   id="product_name" 
                   name="product_name" 
                   value="<?= old('product_name', $product['product_name']) ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                   placeholder="Masukkan nama produk"
                   required>
            <?php if (isset($errors['product_name'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $errors['product_name'] ?></p>
            <?php endif; ?>
        </div>

        <!-- Product Price -->
        <div>
            <label for="product_price" class="block text-sm font-medium text-gray-700 mb-2">Harga Produk</label>
            <div class="relative">
                <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                <input type="number" 
                       id="product_price" 
                       name="product_price" 
                       value="<?= old('product_price', $product['product_price']) ?>"
                       class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                       placeholder="0"
                       min="0"
                       required>
            </div>
            <?php if (isset($errors['product_price'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $errors['product_price'] ?></p>
            <?php endif; ?>
        </div>

        <!-- Product Size -->
        <div>
            <label for="product_size" class="block text-sm font-medium text-gray-700 mb-2">Ukuran</label>
            <input type="text" 
                   id="product_size" 
                   name="product_size" 
                   value="<?= old('product_size', $product['product_size']) ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                   placeholder="Contoh: 50ml, 100ml"
                   required>
            <?php if (isset($errors['product_size'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $errors['product_size'] ?></p>
            <?php endif; ?>
        </div>

        <!-- Product Stock -->
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stok Produk</label>
            <input type="number" 
                   id="stock" 
                   name="stock" 
                   value="<?= old('stock', $product['stock'] ?? 0) ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                   placeholder="0"
                   min="0"
                   required>
            <?php if (isset($errors['stock'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $errors['stock'] ?></p>
            <?php endif; ?>
        </div>

        <!-- Current Image & Upload New -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Produk</label>
            <div class="space-y-4">
                <!-- Current Image -->
                <?php if (!empty($product['product_image'])): ?>
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                        <div class="w-32 h-32 border border-gray-300 rounded-lg overflow-hidden">
                            <img src="<?= base_url('uploads/products/' . $product['product_image']) ?>" 
                                 alt="<?= esc($product['product_name']) ?>"
                                 class="w-full h-full object-cover">
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Upload New Image -->
                <div class="flex items-center space-x-4">
                    <div class="flex-1">
                        <input type="file" 
                               id="product_image" 
                               name="product_image" 
                               accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                               onchange="previewImage(this)">
                        <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</p>
                    </div>
                    <div id="image-preview" class="w-20 h-20 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                        <i class="fas fa-image text-gray-400"></i>
                    </div>
                </div>
            </div>
            <?php if (isset($errors['product_image'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $errors['product_image'] ?></p>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <p class="text-red-500 text-sm mt-1"><?= session()->getFlashdata('error') ?></p>
            <?php endif; ?>
        </div>

        <!-- Product Description -->
        <div>
            <label for="product_desc" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk</label>
            <textarea id="product_desc" 
                      name="product_desc" 
                      rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                      placeholder="Masukkan deskripsi produk yang menarik..."
                      required><?= old('product_desc', $product['product_desc']) ?></textarea>
            <?php if (isset($errors['product_desc'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $errors['product_desc'] ?></p>
            <?php endif; ?>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="<?= site_url('admin/product/view') ?>" 
               class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-black px-6 py-2 rounded-lg font-medium transition-colors shadow-lg">
                <i class="fas fa-save mr-2"></i>Update Produk
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB.');
            input.value = '';
            preview.innerHTML = '<i class="fas fa-image text-gray-400"></i>';
            return;
        }
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung! Gunakan JPG, PNG, atau GIF.');
            input.value = '';
            preview.innerHTML = '<i class="fas fa-image text-gray-400"></i>';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover rounded-lg">
                <div class="absolute top-1 right-1 bg-green-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                    <i class="fas fa-check"></i>
                </div>
            `;
            preview.classList.add('relative');
        }
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '<i class="fas fa-image text-gray-400"></i>';
        preview.classList.remove('relative');
    }
}

// Auto-hide success/error messages after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});
</script>

<?= $this->endSection() ?>