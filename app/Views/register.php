<?= $this->extend('main') ?>

<?= $this->section('content') ?>
<section class="relative bg-gray-50 py-16">
    <div class="absolute inset-0">
        <img src="<?= base_url('assets/images/hero-bg.png') ?>" alt="Background" class="w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-white/80"></div>
    </div>

    <div class="relative max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 px-6">
        <div class="bg-white rounded-3xl p-10 shadow-2xl border border-gray-100">
            <p class="text-sm uppercase tracking-[0.4em] text-gray-400">Bergabung</p>
            <h1 class="mt-3 text-3xl font-semibold text-gray-900">Buat Akun BL Parfume</h1>
            <p class="mt-2 text-gray-500">Nikmati pengalaman belanja parfum yang dipersonalisasi, akses promo eksklusif, dan banyak lagi.</p>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 flex items-start space-x-3">
                    <i class="fas fa-circle-exclamation mt-1"></i>
                    <span><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 flex items-start space-x-3">
                    <i class="fas fa-circle-check mt-1"></i>
                    <span><?= esc(session()->getFlashdata('success')) ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 space-y-2 text-red-700">
                    <p class="font-semibold flex items-center space-x-2">
                        <i class="fas fa-triangle-exclamation"></i>
                        <span>Silakan perbaiki beberapa input berikut:</span>
                    </p>
                    <ul class="list-disc list-inside text-sm">
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('register') ?>" method="post" class="mt-8 space-y-6">
                <?= csrf_field() ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="<?= old('username') ?>"
                            required
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 py-3 px-4 text-gray-900 focus:border-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-800/20"
                            placeholder="blparfume_lover"
                        >
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?= old('email') ?>"
                            required
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 py-3 px-4 text-gray-900 focus:border-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-800/20"
                            placeholder="you@example.com"
                        >
                    </div>
                </div>

                <div>
                    <label for="fullname" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input
                        type="text"
                        id="fullname"
                        name="fullname"
                        value="<?= old('fullname') ?>"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 py-3 px-4 text-gray-900 focus:border-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-800/20"
                        placeholder="Nama lengkap sesuai identitas"
                    >
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="<?= old('phone') ?>"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 py-3 px-4 text-gray-900 focus:border-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-800/20"
                        placeholder="08xxxxxxxxxx"
                    >
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 py-3 px-4 text-gray-900 focus:border-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-800/20"
                            placeholder="Minimal 6 karakter"
                        >
                    </div>
                    <div>
                        <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password *</label>
                        <input
                            type="password"
                            id="password_confirm"
                            name="password_confirm"
                            required
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 py-3 px-4 text-gray-900 focus:border-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-800/20"
                            placeholder="Ulangi password"
                        >
                    </div>
                </div>

                <button type="submit" class="w-full rounded-2xl bg-gray-900 py-3 text-white font-semibold tracking-wide shadow-lg shadow-gray-900/20 hover:bg-black transition">
                    Daftar & Masuk
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">
                Sudah punya akun?
                <a href="<?= site_url('login') ?>" class="font-semibold text-gray-900 hover:text-gray-700">Masuk di sini</a>
            </p>
        </div>

        <div class="rounded-3xl bg-gray-900 text-white p-10 flex flex-col justify-between shadow-2xl">
            <div>
                <p class="text-sm uppercase tracking-[0.6em] text-gray-400">Eksklusif</p>
                <h2 class="mt-4 text-4xl font-semibold leading-tight">Keistimewaan Member BL Parfume</h2>
                <p class="mt-6 text-gray-300 leading-relaxed">
                    Personal shopper siap membantu Anda menemukan aroma khas, akses early-bird ke koleksi terbatas, dan prioritas layanan pelanggan.
                </p>
            </div>
            <div class="mt-10 space-y-6">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                        <i class="fas fa-star text-lg"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Program Loyalti</p>
                        <p class="text-sm text-gray-400">Kumpulkan poin setiap transaksi dan tukarkan dengan hadiah parfum eksklusif.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                        <i class="fas fa-truck text-lg"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Gratis Ongkir Premium</p>
                        <p class="text-sm text-gray-400">Antar cepat ke seluruh Indonesia dengan perlindungan paket khusus.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                        <i class="fas fa-shield-heart text-lg"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Keamanan Data</p>
                        <p class="text-sm text-gray-400">Informasi Anda terlindungi oleh enkripsi modern dan audit berkala.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
