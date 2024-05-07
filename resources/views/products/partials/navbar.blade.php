@php
    $cart = session()->get('cart', []);
    $itemsCount = 0;
    if(isset($cart)){
        $itemsCount = count($cart);
    }
@endphp

<div class="container-fluid p-0 large-nav w-100 border">
    <div class="navbar px-5 fixed-top navbar-expand-lg navbar-light">
        <a href="/"><p class="brand">EnvyAfrica</p></a>

        <div class="nav-contact d-flex align-items-center">
            <div class="cart h-100 me-3" style="position: relative">
                <a class="btn btn-link text-dark" href="/cart">
                    <i class="las la-shopping-cart text-white" style="font-size: 36px"></i>
                </a>
                <span class="cart-span">{{$itemsCount}}</span>
            </div>
            <div class="contact-image h-100">
                <i class="las la-headset text-white" style="font-size: 36px"></i>
            </div>
            <div class="ms-2 h-100">
                <p class="m-0 text-white" style="font-size: 14px;">Contact Us</p>
                <p class="m-0 text-white" style="font-size: 13px;">0712345678</p>
            </div>
        </div>
    </div>
    <div class="nav2">
        <ul class="d-flex mt-2 justify-content-center align-items-center gap-5 text-dark">
            <li class="nav2-item fw-bold"><p><a href="/all">Shop</a></p></li>
            <li class="nav2-item"><p><a href="/all?category=lace-front-wigs">Lace front wigs</a></p></li>
            <li class="nav2-item"><p><a href="/all?category=human-hair-wigs">Human hair wigs</a></p></li>
            <li class="nav2-item"><p><a href="/all?category=human-hair-wigs">Hand tied wigs</a></p></li>
            <li class="nav2-item"><p><a href="/all?category=monofilament-wigs">Monofilament wigs</a></p></li>
        </ul>
    </div>
</div>

<div class="container-fluid medium-nav p-0">
    <div class="navbar px-3 fixed-top navbar-expand-lg navbar-light">
        <a href="/"><p class="brand m-0">EnvyAfrica</p></a>

        <div class="d-flex">
            <div class="cart h-100 me-3" style="position: relative">
                <a class="btn btn-link text-dark" href="/cart">
                    <i class="las la-shopping-cart text-white" style="font-size: 36px"></i>
                </a>
                <span class="cart-span">{{$itemsCount}}</span>
            </div>
            <button class="btn btn-link text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                <i class="las la-bars" style="font-size: 25px"></i>
            </button>
        </div>
    </div>
</div>

<div class="container-fluid small-nav p-0">
    <div class="navbar px-3 fixed-top navbar-expand-lg navbar-light">
        <button class="btn btn-link text-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <i class="las la-bars text-white" style="font-size: 30px"></i>
        </button>

        <x-offcanvas />

        <a href="/"><p class="brand m-0">EnvyAfrica</p></a>

        <a class="btn btn-link text-dark" href="/cart">
            <i class="las la-shopping-cart text-white" style="font-size: 32px"></i>
        </a>
    </div>
    <div class="nav-search border">
        <form action="/all" style="position: relative">
            <input type="text" placeholder="Search" name="search" spellcheck="false" class="nav-input ps-3" />
            <button type="submit" class="btn btn-link search-btn text-dark" style="position: absolute; right: 12px; top: 6px;"><i class="bi bi-search"></i></button>
        </form>
    </div>
</div>