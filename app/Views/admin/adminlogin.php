<?= view('admin/__partials/head.php')?>
<body class="bg-gray-50">
    <?= view('admin/__partials/navbar.php')?>
    
        <div class="relative max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-1 gap-10 px-12">
        <div class="bg-white/60 backdrop-blur rounded-3xl shadow-2xl p-16 border border-gray-100">
            <div class="mb-8 text-center">
                <h3 class="text-4xl font-semibold text-yellow-600">BL Parfume Administration</h1>
            </div>

            

            <form id="admin-loginform" class="space-y-6">
             
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

                    
                <p class="mt-8 text-center text-sm text-gray-500">
                    <a href="<?= site_url('admin/register') ?>" class="font-semibold text-gray-900 hover:text-gray-700">Daftar Akun</a>
                </p>

                <div class="flex items-center justify-between text-sm">
                    <label class="inline-flex items-center space-x-2 text-gray-600">
                        <input type="checkbox" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                        <span>Ingat saya</span>
                    </label>
                    <a href="#" class="text-gray-900 font-medium hover:text-gray-700">Lupa password?</a>
                </div>

                <button type="submit" class="w-full rounded-2xl bg-gray-900 py-2 text-white font-semibold tracking-wide shadow-lg shadow-gray-900/20 hover:bg-black transition">Masuk</button>
            </form>

            
            </div>

    
        </div>
            <script> 
            const BASE_URL = "<?= base_url()?>admin" 
            const CSRF_NAME = "<?= csrf_token() ?>";
            const CSRF_HASH = "<?= csrf_hash() ?>";
            </script>
            <script src="<?= base_url("assets/js/adminlogin.js")?>"></script>
        </body>
    </html>