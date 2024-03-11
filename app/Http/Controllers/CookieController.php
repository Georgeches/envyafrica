<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookieController extends Controller
{
    public function addToCart(Request $request){
        $cartCookie = request()->cookie('cartCookie') ? unserialize(request()->cookie('cartCookie')) : [];
        dd($cartCookie);
        $cartItems = array_push($cartCookie, $request->product_id);
        $updatedCookie = cookie('cartCookie', serialize($cartItems), 60*24*5);
        return back()->with('success', 'Added to cart!')->withCookie($updatedCookie);
    }
}
