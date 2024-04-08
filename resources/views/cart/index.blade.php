@extends('layout')

@php
    $customer = session()->get('customer');
    $link = '';
    if(isset($customer)){
        $link='/checkout';
    }
    else{
        $link='/customerinfo';
    }

    $cartItems = session('cart');
    
    function getImage($item){
        $image = $item['image'];
        return asset("storage/$image");
    }
@endphp

@section('content')
    @include('products.partials.navbar')
    <div class="container border p-4 cart-page" style="position: relative; top: 150px;">
        <div class="card cart-card">
            <div class="row">
                <div class="col-md-8 col-cart">
                    <div class="title">
                        <div class="row">
                            <div class="col"><h4><b>Shopping Cart</b></h4></div>
                            <div class="col align-self-center text-right text-muted">{{count($cartItems)}} Item(s)</div>
                        </div>
                    </div>

                    @if (count($cartItems) === 0)
                        <p class="lead">No items in cart</p>
                        <a class="btn checkout-btn m-0" href="/all" style="font-size: 16px">Start Shopping</a>
                    @endif
                    
                    @foreach ($cartItems as $item)
                        <div class="row border-top">
                            <div class="row main align-items-center">
                                <div class="col-2"><img class="img-fluid" src='{{ getImage($item) }}'></div>
                                <div class="col">
                                    <div class="row text-muted">{{$item['name']}}</div>
                                    <div class="row">{{$item['price']}}</div>
                                </div>
                                <div class="col">
                                    <a href="/cart/decrement/{{$item['id']}}">-</a><a href="#" class="border">{{$item['amount']}}</a><a href="/cart/increment/{{$item['id']}}">+</a>
                                </div>
                                <div class="col d-flex align-items-center">Ksh. {{$item['amount'] * $item['price']}}
                                    <form action="/cart/delete/{{$item['id']}}" method="POST" class="ms-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="close">&#10005;</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="back-to-shop"><a href="#">&leftarrow;</a><a href="/all" class="text-muted">Back to shop</a></div>
                </div>
                @if (count($cartItems) > 0)
                <div class="col-md-4 summary">
                    <div><h5><b>Summary</b></h5></div>
                    <hr>
                    <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                        <div class="col">TOTAL PRICE</div>
                        <div class="col text-right">Ksh. {{$subtotal}}</div>
                    </div>
                    <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                        <div class="col">SHIPPING</div>
                        <div class="col text-right">Ksh. 300</div>
                    </div>
                    <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                        <div class="col">TAX</div>
                        <div class="col text-right">Ksh. {{$tax}}</div>
                    </div>
                    <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                        <div class="col"><u>TOTAL</u></div>
                        <div class="col text-right">Ksh. {{$total}}</div>
                    </div>
                    
                    <a href={{$link}} class="btn checkout-btn">CHECKOUT</a>
                </div>
                @endif
            </div> 
        </div>
    </div>
@endsection