@props(['product'])

@php
    $inBag = $product->alreadyInBag($product->id);
@endphp

<div class="style-card p-0 border-0">
    <div class="card-body p-0 w-100">
        <div class="card-body-image p-0 w-100">
            <a href="/products/{{$product['id']}}"><img class="w-100" src='{{asset("storage/$product->image")}}' alt=""/></a>
        </div>
        <div class="product-details px-1 container text-start">
            <div>
                <a href="/products/{{$product['id']}}"><p class="text-dark fw-normal mb-1">{{$product['name']}}</p></a>
                <p class="fw-light mb-2">sh {{$product['price']}}</p>
                @if ($inBag)
                    <form action="/cart/delete/{{$product->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn cart-btn p-0 border" style=""><i class="bi bi-bag-dash" style="font-size: 22px;"></i></button>
                    </form>
                @else
                    <a href="/cart/add/{{$product->id}}" class="btn cart-btn p-0 border" style=""><i class="bi bi-bag-plus" style="font-size: 22px;"></i></a>
                @endif
            </div>
        </div>
    </div>
</div>