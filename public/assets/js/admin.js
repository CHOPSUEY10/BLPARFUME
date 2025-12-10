// Admin Dashboard JavaScript Functions

// View Order Details
function viewOrder(orderId) {
    // Show loading
    Swal.fire({
        title: 'Loading...',
        text: 'Mengambil detail pesanan',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Fetch order details
    fetch(`/admin/api/order/details/${orderId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const order = data.data;
            Swal.fire({
                title: `Detail Pesanan #ORD-${String(order.order_id).padStart(3, '0')}`,
                html: `
                    <div class="text-left space-y-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <strong>Customer:</strong><br>
                                ${order.customer_name || 'N/A'}<br>
                                <small class="text-gray-500">${order.customer_email || 'N/A'}</small>
                            </div>
                            <div>
                                <strong>Total:</strong><br>
                                <span class="text-lg font-bold text-green-600">Rp ${new Intl.NumberFormat('id-ID').format(order.total_price)}</span>
                            </div>
                        </div>
                        <div>
                            <strong>Alamat:</strong><br>
                            ${order.customer_address || 'Tidak ada alamat'}
                        </div>
                        <div>
                            <strong>Telepon:</strong><br>
                            ${order.customer_phone || 'Tidak ada nomor telepon'}
                        </div>
                        <div>
                            <strong>Status:</strong><br>
                            <span class="px-2 py-1 rounded-full text-xs ${getStatusClass(order.status)}">${getStatusText(order.status)}</span>
                        </div>
                        <div>
                            <strong>Tanggal:</strong><br>
                            ${new Date(order.tanggal_transaksi).toLocaleDateString('id-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            })}
                        </div>
                    </div>
                `,
                width: 600,
                showCancelButton: true,
                confirmButtonText: 'Update Status',
                cancelButtonText: 'Tutup',
                confirmButtonColor: '#3B82F6'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatus(orderId);
                }
            });
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Gagal mengambil detail pesanan', 'error');
    });
}

// Update Order Status
function updateStatus(orderId) {
    Swal.fire({
        title: 'Update Status Pesanan',
        input: 'select',
        inputOptions: {
            'pending': 'Pending',
            'paid': 'Paid/Selesai',
            'cancelled': 'Dibatalkan'
        },
        inputPlaceholder: 'Pilih status baru',
        showCancelButton: true,
        confirmButtonText: 'Update',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) {
                return 'Pilih status terlebih dahulu!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Send update request
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const formData = new FormData();
            formData.append('order_id', orderId);
            formData.append('status', result.value);
            formData.append('csrf_test_name', csrfToken);
            
            fetch('/admin/api/order/update-status', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Gagal mengupdate status', 'error');
            });
        }
    });
}

// View Transaction Details
function viewTransaction(transactionId) {
    viewOrder(transactionId); // Same as order details
}

// Edit Product
function editProduct(productId) {
    Swal.fire({
        title: 'Edit Produk',
        text: 'Fitur edit produk akan segera tersedia',
        icon: 'info'
    });
}

// Delete Product
function deleteProduct(productId, productName) {
    Swal.fire({
        title: 'Hapus Produk?',
        text: `Apakah Anda yakin ingin menghapus "${productName}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send delete request - try POST first
            // Send delete request
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const csrfHeader = document.querySelector('meta[name="csrf-header"]')?.getAttribute('content') || 'X-CSRF-TOKEN';
            
            fetch(`/admin/product/delete/${productId}`, {
                method: 'POST', // Using POST as typical for CI4 delete with Method Spoofing if needed, but simple POST works
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    [csrfHeader]: csrfToken
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', `Gagal menghapus produk: ${error.message}`, 'error');
            });
        }
    });
}

// Helper Functions
function getStatusClass(status) {
    switch(status) {
        case 'paid':
            return 'bg-green-100 text-green-800';
        case 'pending':
            return 'bg-yellow-100 text-yellow-800';
        case 'cancelled':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-blue-100 text-blue-800';
    }
}

function getStatusText(status) {
    switch(status) {
        case 'paid':
            return 'Selesai';
        case 'pending':
            return 'Pending';
        case 'cancelled':
            return 'Dibatalkan';
        default:
            return 'Baru';
    }
}

// Show Create Order Modal
function showCreateOrderModal() {
    Swal.fire({
        title: 'Tambah Pesanan Baru',
        html: `
            <div class="text-left space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Customer Email</label>
                    <input type="email" id="customer_email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500" placeholder="customer@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Harga</label>
                    <input type="number" id="total_price" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500" placeholder="0" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="order_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
        `,
        width: 500,
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#F59E0B',
        preConfirm: () => {
            const email = document.getElementById('customer_email').value;
            const price = document.getElementById('total_price').value;
            const status = document.getElementById('order_status').value;
            
            if (!email || !price) {
                Swal.showValidationMessage('Semua field harus diisi!');
                return false;
            }
            
            return { email, price, status };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Send create order request
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const formData = new FormData();
            formData.append('email', result.value.email);
            formData.append('total_price', result.value.price);
            formData.append('status', result.value.status);
            formData.append('csrf_test_name', csrfToken);
            
            fetch('/admin/api/order/create', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Gagal menambahkan pesanan', 'error');
            });
        }
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add any initialization code here
    console.log('Admin dashboard loaded');
});