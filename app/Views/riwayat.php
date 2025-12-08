<?= $this->extend('main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Riwayat Pesanan</h1>
        <p class="text-gray-500 mb-8">Daftar transaksi pembelian parfum Anda.</p>
        
        <?php if(empty($orders)): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="mb-4 text-gray-200">
                    <i class="fas fa-receipt text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada riwayat pesanan</h3>
                <p class="text-gray-500 mb-6">Anda belum melakukan transaksi apapun.</p>
                <a href="<?= site_url('belanja') ?>" class="inline-block bg-black text-white px-6 py-2 rounded-full font-medium hover:bg-gray-800 transition">
                    Belanja Sekarang
                </a>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold">No. Order</th>
                                <th class="px-6 py-4 font-semibold">Tanggal</th>
                                <th class="px-6 py-4 font-semibold">Total Harga</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach($orders as $order): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    #ORDER-<?= $order['order_id'] ?>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <?= date('d M Y, H:i', strtotime($order['tanggal_transaksi'])) ?> WIB
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    Rp<?= number_format($order['total_price'], 0, ',', '.') ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($order['status'] == 'pending'): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Menunggu Konfirmasi
                                        </span>
                                    <?php elseif($order['status'] == 'paid'): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Selesai / Lunas
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <?= $order['status'] ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="https://wa.me/6283148796357?text=Halo%20Admin,%20saya%20mau%20konfirmasi%20order%20%23ORDER-<?= $order['order_id'] ?>" 
                                       target="_blank"
                                       class="text-green-600 hover:text-green-800 font-medium text-sm">
                                        Hubungi Admin
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>