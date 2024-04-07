@php
    $text = $product['description'];
    $imageDisplay = $_REQUEST['image'] ?? $product->image;
    $inBag = $product->alreadyInBag($product->id);
@endphp

@extends('layout')

@section('content')
    @include('products.partials.navbar')
    <div class="links pt-5 ps-lg-5 ps-3">
        <a href="/">Home / </a> <a href="/all"> Products / </a> <a href="/all?category={{$category[0]['id']}}"> {{$category[0]['name']}}/</a> <a href="/all"> {{$product->name}} / </a>
    </div>
    <div class="product-detail container-fluid pt-5">
        <div class="other-images d-none d-lg-flex">
            @foreach ($product_images as $image)
                <div class="other-image">
                    <a href="?image={{$image->image}}" style="cursor: pointer"><img src={{asset("storage/$image->image")}} alt=""></a>
                </div>
            @endforeach
        </div>
        <div class="row product-detail-row justify-content-center align-items-start">
            <div class="images w-100 d-flex flex-wrap d-md-none d-lg-none">
                <div class="col-12 product-detail-img">
                    <img class="img-fluid" src={{ asset("storage/$imageDisplay") }} alt=""/>
                </div>
                <div class="other-images-row col-12 other-images mt-3 d-flex">
                    @foreach ($product_images as $image)
                        <div class="other-image">
                            <a href="?image={{$image->image}}" style="cursor: pointer"><img src={{asset("storage/$image->image")}} alt=""></a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-6 border-0 product-detail-img d-none d-md-flex d-lg-flex justify-content-center">
                <img class="img-fluid" src={{ asset("storage/$imageDisplay") }} alt=""/>
            </div>

            <div class="col-12 col-md-6 col-lg-6 pt-5 ">
                <p class='lead fw-normal'>{{$product['name']}}</p>
                <p class='fw-light mb-3'>sh {{$product['price']}}</p>
                <div class='d-flex'>
                    <p class='fw-light' style='font-size: small;'>{{$product['description']}}</p>
                </div>
                @if ($inBag)
                    <form action="/cart/delete/{{$product->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn text-center mt-3 remove-cart d-flex justify-content-center align-items-center">REMOVE FROM BAG<i class="bi bi-cart-dash ms-2" style="font-size: 22px;"></i></button>
                    </form>
                @else
                    <a href="/cart/add/{{$product->id}}" class='btn text-center mt-3 add-cart d-flex justify-content-center align-items-center'>ADD TO BAG <i class="bi bi-cart-plus ms-3" style="font-size: 23px;"></i></a>
                @endif
            </div>
        </div>
    </div>

    <div class="container similar">
        <h4>Other Products</h4>
        <div class="d-flex align-items-center gap-1" style="overflow-x: scroll">
            @php $count = 0 @endphp
            @foreach ($remainingProducts as $p)
                @if ($count < 6)
                    <x-productSmall :product="$p"/>
                    @php $count++ @endphp
                @else
                    @break
                @endif
            @endforeach
        </div>
    </div>
@endsection
