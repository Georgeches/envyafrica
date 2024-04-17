@props(['product'])

<div class="style-card-small p-0 border-0">
    <div class="card-body p-0">
        <div class="card-body-image p-0">
            <a href="/products/{{$product['id']}}"><img class="w-100" src='storage/{{$product->image}}' alt=""/></a>
        </div>
        <div class="product-details px-1 container text-start">
            <div>
                <a href="/products/{{$product['id']}}"><p class="text-dark fw-normal mb-1">{{$product['name']}}</p></a>
                <p class="fw-light mb-2">sh {{$product['price']}}</p>
            </div>
        </div>
    </div>
</div>