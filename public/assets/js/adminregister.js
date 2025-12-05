document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById("admin-registerform");
    if (!form) {
        console.error("Form admin-registerform tidak ditemukan!");
        return;
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();  // INI yang benar

        try {
            const password = document.getElementById("password").value
            const password_confirm = document.getElementById("password_confirm").value

            if(password !== password_confirm){
                showToast("Konfirmasi password anda tidak cocok")
                return
            }

            const body = {
                email: document.getElementById("email").value,
                password: password,
                password_confirm : password_confirm,
                name: document.getElementById("name").value,
                address: document.getElementById("address").value,
                phone: document.getElementById("phone").value,
            };

            const url = `${BASE_URL}/register`;

            const req = await fetch(url, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    [CSRF_NAME]: CSRF_HASH,          // kirim token sebagai header (optional)
                    'X-CSRF-TOKEN': CSRF_HASH        // ini yang dibaca CI4
                },
                body: JSON.stringify(body)
            });

            const res = await req.json();
            if (!res.access_token) {
                showToast('Token tidak ditemukan di respons server.');
                return;
            }

            showToast(res.message, true);

            localStorage.setItem('token', res.access_token);
            localStorage.setItem(
                'token_expires',
                (Date.now() + (res.expires_in || 3600) * 1000).toString()
            );

            window.location.href = `${BASE_URL}/pesanan`; // atau dashboard admin
        }
        catch(err) {
            console.error(`fetch fail ${err}`);
            showToast('Gagal menghubungi server');
        }
    });

});

function showToast(msg, success = false) {
    let t = document.getElementById("toast-notif");
    if (!t) {
        t = document.createElement("div");
        t.id = "toast-notif";
        t.className = "toast";
        document.body.appendChild(t);
    }

    t.innerText = msg;

    t.classList.remove("success");
    if (success) t.classList.add("success");

    t.classList.add("show");
    setTimeout(() => t.classList.remove("show"), 2000);
}

