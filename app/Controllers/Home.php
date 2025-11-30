<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {  
    
        // $logged_in = session()->get('user_id');

        // if(!$logged_in){
        //     return redirect()->to('login');
        // }

        $data = [
            'meta' => ['title' => 'Bl Parfume'],
        ];

        return view('main', $data);
    }

    public function shop()
    {

        return view('shop');

    }

    public function keranjang(){
        return view('keranjang');
    }

    public function tentang()
    {
        return view('tentang');
    }

    public function kontak(){
        return view('kontak');
    }
}
