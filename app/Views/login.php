<?= $this->extend('main') ?>
<?= $this->section('content') ?>
<section class="relative bg-gray-50 py-16">
    <div class="absolute inset-0">
        <img src="<?= base_url('assets/images/hero-bg.png') ?>" alt="Fragrance" class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-white/70"></div>
    </div>

    <div class="relative max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 px-6">
        <div class="bg-white/80 backdrop-blur rounded-3xl shadow-2xl p-10 border border-gray-100">
            <div class="mb-8 text-center">
                <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Selamat Datang Kembali</p>
                <h1 class="text-3xl font-semibold text-gray-900">Masuk ke BL Parfume</h1>
                <p class="text-gray-500 mt-2">Login satu pintu untuk Customer dan Admin. Sistem akan mengarahkan Anda ke halaman yang sesuai.</p>
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 flex items-start space-x-3">
                    <i class="fas fa-circle-exclamation mt-1"></i>
                    <span><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 flex items-start space-x-3">
                    <i class="fas fa-circle-check mt-1"></i>
                    <span><?= esc(session()->getFlashdata('success')) ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('login') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="email">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-4 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 py-3 pl-12 pr-4 text-gray-900 focus:border-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-800/20"
                            placeholder="you@example.com"
                            required
                            value="<?= old('email') ?>"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="password">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-4 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 py-3 pl-12 pr-4 text-gray-900 focus:border-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-800/20"
                            placeholder="Masukkan password"
                            required
                        >
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="inline-flex items-center space-x-2 text-gray-600">
                        <input type="checkbox" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                        <span>Ingat saya</span>
                    </label>
                    <a href="#" class="text-gray-900 font-medium hover:text-gray-700">Lupa password?</a>
                </div>

                <button type="submit" class="w-full rounded-2xl bg-gray-900 py-3 text-white font-semibold tracking-wide shadow-lg shadow-gray-900/20 hover:bg-black transition">Masuk Sekarang</button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="<?= site_url('register') ?>" class="font-semibold text-gray-900 hover:text-gray-700">Daftar sekarang</a>
            </p>
        </div>

        <div class="bg-gray-900 rounded-3xl text-white p-10 flex flex-col justify-between shadow-2xl">
            <div>
                <p class="text-sm uppercase tracking-[0.5em] text-gray-400">Eksklusif</p>
                <h2 class="text-4xl font-semibold mt-4 leading-tight">Aroma Signatur <span class="text-gray-300">untuk Anda</span></h2>
                <p class="mt-6 text-gray-300 leading-relaxed">
                    Masuk untuk mengakses koleksi parfum private label, promo personal, dan rekomendasi aroma sesuai preferensi Anda.
                </p>
            </div>

            <div class="space-y-5 mt-10">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Kurasi Premium</p>
                        <p class="text-sm text-gray-400">Pilihan parfum eksklusif dengan standar kualitas tinggi.</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Reward Member</p>
                        <p class="text-sm text-gray-400">Nikmati hadiah spesial dan voucher personal.</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Keamanan Terjamin</p>
                        <p class="text-sm text-gray-400">Data pribadi Anda terlindungi dengan enkripsi tingkat tinggi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
