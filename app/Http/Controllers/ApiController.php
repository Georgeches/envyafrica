<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getOrders(){
        $orders = Order::all();
        $data = json_decode($orders, true);
        return response()->json($data);
    }

    public function getCustomers(){
        $customers = Customer::all();
        $data = json_decode($customers, true);
        return response()->json($data);
    }

    public function getProducts(){
        $products = Product::all();
        $data = json_decode($products, true);
        return response()->json($data);
    }

    public function getUsers(){
        $users = User::all();
        $data = json_decode($users, true);
        return response()->json($data);
    }

    public function getCategories(){
        $categories = Category::all();
        $data = json_decode($categories, true);
        return response()->json($data);
    }

    public function getOrder($id){
        $order = Order::findOrFail($id);
        $data = json_decode($order, true);
        return response()->json($data);
    }

    public function getCustomer($id){
        $customer = Customer::findOrFail($id);
        $data = json_decode($customer, true);
        return response()->json($data);
    }

    public function getProduct($id){
        $product = Product::findOrFail($id);
        $data = json_decode($product, true);
        return response()->json($data);
    }

    public function getUser($id){
        $user = User::findOrFail($id);
        $data = json_decode($user, true);
        return response()->json($data);
    }

    public function getCategory($id){
        $category = Category::findOrFail($id);
        $data = json_decode($category, true);
        return response()->json($data);
    }
}
