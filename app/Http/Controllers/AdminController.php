<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //index
    public function index(){
        if(Auth::check()){
            if(request('collection')){
                $collection = request('collection');
                if($collection == 'products'){
                    return view('admin.index',[
                        'collection' => Product::latest()->filter(request(['search']))->get(),
                        'request' => $collection
                    ]);
                }
                elseif($collection == 'users'){
                    return view('admin.index',[
                        'collection' => User::latest()->get(),
                        'request' => $collection
                    ]);
                }
                elseif($collection == 'orders'){
                    return view('admin.index',[
                        'collection' => Order::latest()->get(),
                        'request' => $collection
                    ]);
                }
                elseif($collection == 'customers'){
                    return view('admin.index',[
                        'collection' => Customer::latest()->get(),
                        'request' => $collection
                    ]);
                }
            }
            return view('admin.index', [
                'collection' => Product::latest()->filter(request(['search']))->get(),
                'request' => 'products'
            ]);
        }
        return view('user.login');
    }
}