@props(['product'])

<div class="card style-card border-0">
    <div class="card-body p-0 bg-light">
        <div class="card-body-image">
            <a href="/products/{{$product['id']}}"><img class="img-fluid" src='{{ asset("storage/$product->image") }}' alt=""/></a>
        </div>
        <div class="product-details d-flex justify-content-between align-items-start container text-start">
        <div>
            <a href="/products/{{$product['id']}}"><p class="text-dark fw-normal mb-2">{{$product['name']}}</p></a>
            <p class="fw-light mb-2">sh {{$product['price']}}</p>
        </div>
        <a href="/cart/add/{{$product->id}}"><i class="bi bi-bag-plus" style="font-size: 25px"></i></a>
        </div>
    </div>
</div>