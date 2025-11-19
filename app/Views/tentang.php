<?= $this->extend('main') ?>

<?= $this->section('content') ?>
<section class="bg-white py-16 px-4">
    <div class="max-w-5xl mx-auto text-center mb-12">
        <p class="text-sm uppercase tracking-widest text-gray-500 mb-4">Tentang BL Parfume</p>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Meracik Keanggunan Sejak 2018</h2>
        <p class="text-lg text-gray-600">
            BL Parfume adalah rumah parfum independen yang fokus menghadirkan wewangian mewah
            terinspirasi dari memori perjalanan dan lanskap aromatik Nusantara. Setiap botol
            dibuat dalam batch terbatas dengan standar bahan baku premium dan proses evaluasi profesional.
        </p>
    </div>
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="rounded-xl border border-gray-100 p-8 shadow-sm">
            <h3 class="text-xl font-semibold mb-3">Filosofi Bisnis</h3>
            <p class="text-gray-600">
                Menggabungkan seni perfumery klasik dengan inovasi modern agar setiap aroma terasa
                personal, tahan lama, dan mudah dikenakan di iklim tropis.
            </p>
        </div>
        <div class="rounded-xl border border-gray-100 p-8 shadow-sm">
            <h3 class="text-xl font-semibold mb-3">Layanan</h3>
            <p class="text-gray-600">
                Distribusi ritel &amp; online, layanan private label untuk brand lokal, serta konsultasi
                signature scent bagi hotel dan corporate gifting.
            </p>
        </div>
        <div class="rounded-xl border border-gray-100 p-8 shadow-sm">
            <h3 class="text-xl font-semibold mb-3">Nilai Inti</h3>
            <ul class="space-y-2 text-gray-600">
                <li>• Transparansi bahan baku</li>
                <li>• Craftsmanship dan riset aroma</li>
                <li>• Kolaborasi dengan artisan lokal</li>
            </ul>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-16 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
        <div>
            <p class="text-4xl font-bold text-gray-900">150+</p>
            <p class="text-gray-500">Retail Partner</p>
        </div>
        <div>
            <p class="text-4xl font-bold text-gray-900">12</p>
            <p class="text-gray-500">Koleksi Signature</p>
        </div>
        <div>
            <p class="text-4xl font-bold text-gray-900">25K</p>
            <p class="text-gray-500">Pelanggan Aktif</p>
        </div>
        <div>
            <p class="text-4xl font-bold text-gray-900">98%</p>
            <p class="text-gray-500">Repeat Order Rate</p>
        </div>
    </div>
</section>

<section class="bg-white py-16 px-4">
    <div class="max-w-4xl mx-auto">
        <h3 class="text-2xl font-semibold text-gray-900 mb-6">Informasi Bisnis</h3>
        <div class="bg-gray-100 rounded-2xl p-8 flex flex-col md:flex-row gap-8 items-center">
            <div class="flex-1">
                <p class="text-gray-600 mb-4">
                    Tim kemitraan kami siap membantu kebutuhan reseller, bulk order event, hingga
                    pengembangan lini parfum khusus. Kirimkan proposal Anda atau jadwalkan sesi konsultasi virtual.
                </p>
                <ul class="text-gray-700 space-y-2">
                    <li><strong>Alamat Gerai:</strong> Jl. Melati No. 45, Bandung</li>
                    <li><strong>Jam Operasional:</strong> Senin - Sabtu, 09.00 - 18.00 WIB</li>
                    <li><strong>Email:</strong> partnership@blparfume.id</li>
                    <li><strong>WhatsApp:</strong> +62 831-8347-9614</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
