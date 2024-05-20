@props(['product'])

@php
    $inBag = $product->alreadyInBag($product->id);
@endphp

<div class="style-card-small p-0 border-0">
    <div class="card-body p-0">
        <div class="card-body-image p-0">
            <a href="/products/{{$product['id']}}"><img class="w-100" src='storage/{{$product->image}}' alt=""/></a>
        </div>
        <div class="product-details px-1 container text-start">
            <div class="">
                <a href="/products/{{$product['id']}}"><p class="text-dark fw-normal m-0" style="height: fit-content; max-height: 50px; overflow-y:hidden">{{$product['name']}}</p></a>
                <div class="d-flex justify-content-between align-items-center w-100 p-0">
                    <p class="fw-normal m-0 p-0" style="color: rgb(255,41,140);">Ksh {{$product['price']}}</p>
                    @if ($inBag)
                        <form action="/cart/delete/{{$product->id}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn cart-btn p-0" style=""><i class="bi bi-bag-dash" style="font-size: 20px;"></i></button>
                        </form>
                    @else
                        <a href="/cart/add/{{$product->id}}" class="btn cart-btn p-0" style=""><i class="bi bi-bag-plus" style="font-size: 20px;"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>