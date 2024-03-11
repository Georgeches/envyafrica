@extends('layout')

@section('content')
    @include('products.partials.navbar')
    <div class="container border p-4" style="position: relative; top: 100px;">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6" style="height: 100%; overflow-y: scroll;">
                <h4 class="mb-4">Cart</h4>
                @if (session('cart'))
                    @foreach (session('cart') as $item)
                        <div class="cart-item w-100 mb-3 border py-3 px-3">
                            <div class="w-100 mb-2 d-flex justify-content-between flex-wrap">
                                <div class="cart-image" style="width: 100px; height: 100px;">
                                    <img src={{ asset("storage/$item->image") }} class="w-100" alt="">
                                </div>
                                <div class="item-info w-100 px-1 pt-3 d-flex justify-content-between flex-wrap">
                                    <div class="me-4">
                                        <h4>{{$item->name}}</h4>
                                        <p class="">Remaining: <span class="text-warning">{{$item->quantity}}</span></p>
                                    </div>
                                    <h6>Ksh {{$item->price}}</h6>
                                </div>
                            </div>
                            <div class="w-100 d-flex justify-content-between">
                                <form action="/cart/delete/{{$item->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger"><i class="bi bi-trash-fill"></i></button>
                                </form>
                                <div class="d-flex align-items-center">
                                    <a href="/cart/increment/{{$item->id}}" class="btn btn-warning text-white">+</a>
                                    <p class="mb-0 mt-0 mx-3">{{$item->amount}}</p>
                                    <a href="/cart/decrement/{{$item->id}}" class="btn btn-warning text-white">-</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <h4>Summary</h4>
                <h6>Subtotal: Ksh {{$total}}</h6>
                <h6>Tax: Ksh {{$tax}}</h6>
                <h6>Total: Ksh {{$total + $tax}}</h6>
                <a href="/customerinfo" class="btn btn-warning mt-2 text-white">Checkout</a>
            </div>
        </div>
    </div>
@endsection