<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(){
        $cartDetails = $this->getCartDetails();
        return view('paymentPage', [
            'subtotal' => $cartDetails['subtotal'],
            'total' => $cartDetails['total'],
            'tax' => $cartDetails['tax'],
            'shipping' => $cartDetails['shipping']
        ]);
    }

    public function new(){
        $cartDetails = $this->getCartDetails();
        $customer = session()->get('customer');
        $items = session()->get('cart', []);
        $min = 10000;
        $max = 999999;
        $randomNumber = rand($min, $max);
        $randomString = Str::random(2);
        $order = [
            'shipping_price' => $cartDetails['shipping'], 
            'notes' => '',
            'amount' => $cartDetails['subtotal'],
            'number' => strtoupper($randomString).strval($randomNumber),
            'status' => 'pending',
            'customer_id' => $customer['id'],
        ];

        $newOrder = Order::create($order);

        if($newOrder){
            foreach($items as $item){
                $orderItem = [
                    'product_id' => $item['id'],
                    'order_id' => $newOrder->id,
                    'price' => $item['price'],
                    'quantity' => $item['amount'],
                ];

                $newOrderItem = OrderItem::create($orderItem);
                if($newOrderItem){
                    $product = Product::findOrFail($item['id']);
                    $product->quantity -= $item['amount'];
                    $product->save();
                }
                else{
                    return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
                }
            }
            session()->put('cart', []);
            Mail::to($customer['email'])
                ->send(OrderReceivedMail($order));
            return redirect('/')->with('success', 'Order has been sent successfully');
        }
        else{
            return redirect()->back()->with('error', 'Could not save order. Please try again later');
        }
    }

    public function getCartDetails(){
        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach($cart as $item){
            $subtotal+=$item['price']*$item['amount'];
        }

        return [
            'subtotal' => $subtotal,
            'tax' => 0.16*$subtotal,
            'total' => $subtotal + 0.16*$subtotal + 500,
            'shipping' => 500,
        ];
    }
}
