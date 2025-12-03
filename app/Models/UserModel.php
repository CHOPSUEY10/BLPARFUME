<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_user', 'nama', 'alamat', 'email','no_telp','password'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    

    public function getUserIdByEmail($email){
        if(empty($email)){
            return false;
        }

        try{

            return $this->where('email', $email)->first();
        }catch(\Exception $e){
            log_message('Error','Error Message :'.$e);
            return false;
        }
    }

    public function insertNewUser($newdata){

        if(empty($newdata)){
            return false;
        }


        $data = [
            'id_user' => $newdata['id_user'],
            'nama' => $newdata['fullname'],
            'alamat' => $newdata['address'],
            'no_telp' => $newdata['phone'],
            'email' => $newdata['email'],
            'password' => $newdata['password'],
        ];

        try{
            return $this->insert($data);
        }catch(\Exception $e){
            log_message('error','Error Message :'. $e->getMessage());
            return false;
        }
    }

    public function updateUserData($id,$data){

        if(empty($newdata)){
            return false;
        }

        try{
            return $this->update($id,$data);
        }catch(\Exception $e){
            log_message('Error','Error Message :'.$e);
            return false;
        }




    }
}