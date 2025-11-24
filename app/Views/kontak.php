<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<section class="bg-gray-50 py-16 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <p class="text-sm uppercase tracking-[0.3em] text-gray-500 mb-4">Hubungi Kami</p>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Kami Hadir untuk Membantu Anda</h1>
        <p class="text-lg text-gray-600">
            Tim customer experience BL Parfume siap menjawab pertanyaan mengenai produk, pemesanan bulk,
            kerja sama bisnis, maupun konsultasi aroma pribadi.
        </p>
    </div>
</section>

<section class="bg-white py-12 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="rounded-2xl border border-gray-100 p-6 shadow-sm">
            <p class="text-gray-500 text-xs uppercase tracking-widest">Gerai Utama</p>
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Tanjungpinang</h3>
            <p class="text-gray-600">Jl. Merdeka No. 9<br>Tanjungpinang, Kep. Riau</p>
        </div>
        <div class="rounded-2xl border border-gray-100 p-6 shadow-sm">
            <p class="text-gray-500 text-xs uppercase tracking-widest">Jam Operasional</p>
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Senin - Sabtu</h3>
            <p class="text-gray-600">09.00 - 18.00 WIB<br>Reservasi by appointment</p>
        </div>
        <div class="rounded-2xl border border-gray-100 p-6 shadow-sm">
            <p class="text-gray-500 text-xs uppercase tracking-widest">Email</p>
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Customer Care</h3>
            <p class="text-gray-600">hello@blparfume.id<br>partnership@blparfume.id</p>
        </div>
        <div class="rounded-2xl border border-gray-100 p-6 shadow-sm">
            <p class="text-gray-500 text-xs uppercase tracking-widest">WhatsApp</p>
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Fast Response</h3>
            <p class="text-gray-600">+62 831-8347-9614<br>@blparfume</p>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-16 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <p class="text-sm uppercase tracking-[0.4em] text-gray-500 mb-4">Formulir</p>
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Kirim Pertanyaan</h2>
            <form class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="nama">Nama Lengkap</label>
                    <input id="nama" type="text" placeholder="Mis. Bintang Lestari"
                        class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-800">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
                        <input id="email" type="email" placeholder="nama@email.com"
                            class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-800">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="telepon">No. Telepon</label>
                        <input id="telepon" type="tel" placeholder="08xx xxxx xxxx"
                            class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-800">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="pesan">Pesan</label>
                    <textarea id="pesan" rows="4" placeholder="Tulis kebutuhan atau pertanyaan Anda"
                        class="w-full rounded-2xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-800"></textarea>
                </div>
                <button type="button"
                    class="w-full bg-gray-900 text-white py-3 rounded-full font-semibold tracking-wide hover:bg-gray-800 transition">
                    Kirim Sekarang
                </button>
            </form>
        </div>

        <div class="flex flex-col gap-8">
            <div class="p-8 bg-white rounded-3xl shadow-lg">
                <p class="text-sm uppercase tracking-[0.3em] text-gray-500 mb-3">Customer Care</p>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Konsultasi Aroma &amp; Pemesanan</h3>
                <p class="text-gray-600 mb-6">
                    Konsultan parfum kami siap memberi rekomendasi sesuai preferensi aroma, kebutuhan acara,
                    hingga paket gifting. Respon maksimum 1x24 jam kerja.
                </p>
                <ul class="space-y-3 text-gray-700">
                    <li><span class="font-medium">Live Chat:</span> 09.00 - 21.00 WIB</li>
                    <li><span class="font-medium">Instagram DM:</span> @blparfume</li>
                    <li><span class="font-medium">Marketplace:</span> Tokopedia &amp; Shopee Official Store</li>
                </ul>
            </div>
            <div class="rounded-3xl overflow-hidden shadow-lg border border-gray-100">
                <iframe title="Lokasi BL Parfume" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7957.410692740988!2d104.444!3d0.907!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d989df2b1c7c7f%3A0x9cc59cc49f8c2358!2sTanjungpinang!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
