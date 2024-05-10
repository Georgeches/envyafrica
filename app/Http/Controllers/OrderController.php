<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\OrderReceivedMail;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;

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

    public function new(Request $request){
        $cartDetails = $this->getCartDetails();
        $customers = Customer::all();
        $payMethod = $request->payMethod;

        //create customer
        $customerDetails = session()->get('customer');
        foreach($customers as $customer){
            if($customer->email === $customerDetails['email']){
                $customerDetails['id'] = $customer->id;
                break;
            }
        }

        if(!isset($customerDetails['id'])){
            $customer = [
                'firstname' => $customerDetails['firstname'],
                'secondname' => $customerDetails['secondname'],
                'email' => $customerDetails['email'],
                'address' => $customerDetails['addressone'].', '.$customerDetails['addresstwo'].', '.$customerDetails['city'],
                'phone' => $customerDetails['phonecountry'].$customerDetails['phone'],
                'city' => $customerDetails['city'],
                'country' => $customerDetails['country'],
            ];
            $newCustomer = Customer::create($customer);
            $customerDetails['id'] = $newCustomer['id'];
        }

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
            'customer_id' => $customerDetails['id'],
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
                    $product = Product::find($item['id']);
                    if($product){
                        $product->quantity -= $item['amount'];
                        $product->save();
                    }
                }
                else{
                    return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
                }
            }
            session()->put('cart', []);

            $newMail = (new OrderReceivedMail($newOrder, $customerDetails))
                ->to($customerDetails['email']);
            Mail::send($newMail);

            if($payMethod === 'mpesa'){
                $mpesaPhone = $request->validate([
                    'phone'=>'required|min:10|max:10',
                ]);

                $paymentData = [
                    'amount' => $cartDetails['total'],
                    'phone' => $mpesaPhone['phone'],
                    'order_number' => $newOrder->number,
                    'order_id' => $newOrder->id
                ];
    
                $paymentController = app()->make(\App\Http\Controllers\PaymentController::class);
                $paymentController->initiateSTK($paymentData);
            }
            else if($payMethod === 'pesapal'){
                $payDetails = [
                    'amount' => $cartDetails['total'],
                    'order_id' => $newOrder->id,
                    'first_name' => $customerDetails['firstname'],
                    'last_name' => $customerDetails['secondname'],
                    'email' => $customerDetails['email'],
                    'phone' => $customerDetails['phone']
                ];

                $cardController = app()->make(\App\Http\Controllers\CardController::class);
                $cardController->make_payment($payDetails);
            }

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
            'total' => $subtotal + 0.16*$subtotal + 300,
            'shipping' => 300,
        ];
    }
}
