@php
    $options = [
        [ 'value' => '', 'label'=> 'Please select a size' ],
        [ 'value'=> 'Medium', 'label'=> 'Medium' ],
        [ 'value'=> 'Large', 'label'=> 'Large' ],
        [ 'value'=> 'X Large', 'label'=> 'X Large' ],
        [ 'value'=> 'XX Large', 'label'=> 'XX Large' ],
    ];
    $text = $product['description'];
    $imageDisplay = $_REQUEST['image'] ?? $product->image;
@endphp

@extends('layout')

@section('content')
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
                <select name="size" id="">
                    @foreach($options as $option)
                        <option value="{{$option['value']}}">{{$option['label']}}</option>
                    @endforeach
                </select>
                <a href="/cart/add/{{$product->id}}" class='btn btn-dark text-center mt-3 add-cart'>ADD TO BAG</a>
            </div>
        </div>
    </div>
@endsection
