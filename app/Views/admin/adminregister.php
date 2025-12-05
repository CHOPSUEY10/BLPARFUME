<?= view('admin/__partials/head.php')?>
<body class="bg-gray-50">
    <?= view('admin/__partials/navbar.php')?>
    <!-- Navigation -->
       

        <div class="relative max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-1 gap-10 px-12">
        <div class="bg-white/60 backdrop-blur rounded-3xl shadow-2xl p-16 border border-gray-100">
            <div class="mb-8 text-center">
                <h3 class="text-4xl font-semibold text-yellow-600">Admin Registration</h1>
            </div>

            



            <form id="admin-registerform" class="mt-8 space-y-6">
                <?= csrf_field() ?>
                <div>
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
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?= old('name') ?>"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 py-3 px-4 text-gray-900 focus:border-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-800/20"
                        placeholder="Nama lengkap sesuai identitas"
                    >
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <input
                        type="text"
                        id="address"
                        name="address"
                        value="<?= old('address') ?>"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 py-3 px-4 text-gray-900 focus:border-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-800/20"
                        placeholder="Alamat lengkap sesuai domisili"
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
        </div>           
        <script> 
            const BASE_URL = "<?= base_url()?>admin" 
            const CSRF_NAME = "<?= csrf_token() ?>";
            const CSRF_HASH = "<?= csrf_hash() ?>";
        </script>
        <script src="<?= base_url("assets/js/adminregister.js")?>"></script>
    </body>
</html>         
