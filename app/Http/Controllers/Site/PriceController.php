<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class PriceController extends Controller
{
    public function pricetable(){
        return view('Site.pricetable');
    }

    public function checkout(){
        return view('Site.checkout');
    }

    public function shoppingcart(){
        return view('Site.shoppingcart');
    }
}
