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
    