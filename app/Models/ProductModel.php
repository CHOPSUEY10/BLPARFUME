<?php

namespace App\Models;

use CodeIgniter\Model;

class BasketModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id_product';
    protected $useAutoIncrement =  true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['product_name','product_price','product_desc','product_size'];
    
    public function getAllItems(){
        try{   
            return $this->findAll();
        }catch(\Exception $e){
            log_message('error', 'Query failure : '. $e->getMessage());
            return false;
        }
    }
    
    public function getItemById($id){     
        if(empty($id)){
            
            log_message('error', 'Product id does not exist : '. $e->getMessage());
            return false;
        }

        try{
            $this->find($id);
        }catch(\Exception $e){
            log_message('error', 'Query failure : '. $e->getMessage());
            return false;
        }

    }

    public function insertProduct(array $data){

        if(empty($data)){
           log_message('error', 'Product id does not exist : '. $e->getMessage());
            return false; 
        }

        try{
            return $this->insert($data);
        }catch(\Exception $e){
            log_message('error', 'Query failure : '. $e->getMessage());
            return false;
        }
    }

     public function removeProduct(array $data, int $id ){

        if(empty($id)){
           log_message('error', 'Product id does not exist : '. $e->getMessage());
            return false; 
        }

        try{
            return $this->delete($id);
        }catch(\Exception $e){
            log_message('error', 'Query failure : '. $e->getMessage());
            return false;
        }
    }

    public function updateProduct(array $data, int $id ){

        if(empty($data) || empty($id)){
           log_message('error', 'Product id or Product Data does not exist : '. $e->getMessage());
            return false; 
        }

        try{
            return $this->update($id,$data);
        }catch(\Exception $e){
            log_message('error', 'Query failure : '. $e->getMessage());
            return false;
        }
    }



   
}