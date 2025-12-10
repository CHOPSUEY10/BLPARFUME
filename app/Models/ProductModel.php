<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id_product';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['product_name','product_price','product_desc','product_size','product_image','stock'];
    
    // Mengambil semua produk
    public function getAllItems(){
        try{   
            return $this->findAll();
        }catch(\Exception $e){
            log_message('error', 'Query failure : '. $e->getMessage());
            return []; // Return array kosong jika gagal
        }
    }

    public function getProductsPaginated($limit, $offset, $search = '')
    {
        $builder = $this->table($this->table);
        if(!empty($search)){
            $builder->like('product_name', $search)
                    ->orLike('product_desc', $search);
        }
        return $builder->limit($limit, $offset)->get()->getResultArray();
    }

    public function countProducts($search = '')
    {
        $builder = $this->table($this->table);
        if(!empty($search)){
            $builder->like('product_name', $search)
                    ->orLike('product_desc', $search);
        }
        return $builder->countAllResults();
    }
    
    // Mengambil satu produk berdasarkan ID
    public function getItemById($id){     
        if(empty($id)){
            return false;
        }

        try{
            return $this->find($id); // Langsung return hasil find()
        }catch(\Exception $e){
            log_message('error', 'Query failure : '. $e->getMessage());
            return false;
        }
    }

    // Insert (untuk Admin nanti)
    public function insertProduct(array $data){
        if(empty($data)){
            return false; 
        }
        try{
            return $this->insert($data);
        }catch(\Exception $e){
            log_message('error', 'Query failure : '. $e->getMessage());
            return false;
        }
    }

    // Update (untuk Admin nanti)
    public function updateProduct(array $data, int $id ){
        if(empty($data) || empty($id)){
            return false; 
        }
        try{
            return $this->update($id, $data);
        }catch(\Exception $e){
            log_message('error', 'Query failure : '. $e->getMessage());
            return false;
        }
    }

    // Delete (untuk Admin nanti)
    public function removeProduct(int $id ){
        if(empty($id)){
            return false; 
        }
        try{
            return $this->delete($id);
        }catch(\Exception $e){
            log_message('error', 'Query failure : '. $e->getMessage());
            return false;
        }
    }
}