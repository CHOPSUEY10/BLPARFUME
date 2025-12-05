document.addEventListener('DOMContentLoaded', (event) => {

    
    const addItem = document.querySelectorAll('.add-item');

    addItem.forEach( btn =>{

        btn.addEventListener('click', async (event) =>{
            
            const productCard = btn.closest('.product-card');
        
            // Ambil data produk dari elemen dalam card
            const productName = productCard.querySelector('h3').textContent;
            const productDesc = productCard.querySelector('p').textContent;
            const productPrice = productCard.querySelector('.text-lg.font-bold').textContent;
                
            try{    
                const url = `${BASE_URL}/basket/api/add`
                const method = 'POST'
                const timestamp = Date.now()
                const payload = {
                    product_id :  Math.random().toString(16).slice(2),
                    product_name : productName,
                    product_desc : productDesc,
                    product_price : productPrice,
                    quantity : 1
                }


                const req = await fetch(url,{
                    method : method,
                    headers :{
                        'Content-Type' : 'application/json',
                        'X-Timestamp' : Date.now()
                    },
                    body : JSON.stringify(payload)
                });

                console.log(req.status);

                const res = await req.json();

                if(res.error){
                    console.log(res.message);
                }

                alert("Berhasil memasukkan ke keranjang");
            }catch(err){

                console.error(`error message ${err}`);

            }    

        })

    });
    
});
    

async function tokenCheck(){
    
    const token = localStorage.getItem('token');
    const token_exp = localStorage.getItem('token_expires');
    

    
    
    const url = `${BASE_URL}/admin`
    const method = 'GET'
    try{ 

        const req = await fetch(url,{
            method:method,
            headers: {
                'Authorization' : 'Bearer '+token,
                'Content-Type'  : 'application/json'
            }
        })

        console.log(req.status)
        if(!req.ok){
            showToast('Sesi telah habis. Silahkan login kembali', false)
            localStorage.removeItem('token'); 
            setTimeout(()=>{
                window.location.href = '/admin/login';
            },3000);
            return;
        }
        
        const res = await req.json();
        
        if(res.error){
            localStorage.removeItem('token'); 
            console.log(res.message);
            return
        }

        
        window.location.href = res.redirect

    }catch(err){
        
        console.error(`error message ${err}`);

    }
}




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

