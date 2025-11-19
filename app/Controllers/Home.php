<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('main');
    }

    public function shop()
    {

        return view('shop');

    }

    public function keranjang(){
        return view('keranjang');
    }
}
