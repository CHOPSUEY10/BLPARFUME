<?= $this->extend('admin/__partials/layout') ?>
<?= $this->section('content') ?>

<!-- Header Section -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Kotak Masuk</h2>
        <p class="text-gray-600 mt-1">Kelola pesan dari pelanggan</p>
    </div>
</div>

<!-- Messages List -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengirim</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pesan</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $msg): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d M Y H:i', strtotime($msg['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900"><?= esc($msg['name']) ?></p>
                                <p class="text-xs text-gray-500"><?= esc($msg['email']) ?></p>
                                <p class="text-xs text-gray-500"><?= esc($msg['phone']) ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700 line-clamp-2"><?= esc($msg['message']) ?></p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button onclick="viewMessage('<?= esc($msg['name']) ?>', '<?= esc($msg['email']) ?>', '<?= esc($msg['phone']) ?>', `<?= esc($msg['message']) ?>`)" 
                                        class="text-blue-600 hover:text-blue-800 mr-3 text-sm font-medium">
                                    Lihat
                                </button>
                                <button onclick="deleteMessage(<?= $msg['id'] ?>)" 
                                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                            <p>Belum ada pesan masuk</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function viewMessage(name, email, phone, message) {
    Swal.fire({
        title: `Pesan dari ${name}`,
        html: `
            <div class="text-left space-y-3">
                <div class="border-b pb-2">
                    <p><strong>Email:</strong> ${email}</p>
                    <p><strong>Telepon:</strong> ${phone || '-'}</p>
                </div>
                <div class="mt-4">
                    <p class="whitespace-pre-wrap">${message}</p>
                </div>
            </div>
        `,
        confirmButtonText: 'Tutup',
        confirmButtonColor: '#1F2937'
    });
}

function deleteMessage(id) {
    Swal.fire({
        title: 'Hapus Pesan?',
        text: "Pesan yang dihapus tidak dapat dikembalikan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // CSRF Handling
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfHeader = document.querySelector('meta[name="csrf-header"]')?.getAttribute('content') || 'X-CSRF-TOKEN';

            fetch(`<?= site_url('admin/message/delete/') ?>${id}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    [csrfHeader]: csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Terhapus!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Terjadi kesalahan sistem', 'error');
            });
        }
    });
}
</script>

<?= $this->endSection() ?>
