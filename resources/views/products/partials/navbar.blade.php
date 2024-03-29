@php
    $cart = session()->get('cart', []);
    $itemsCount = 0;
    if(isset($cart)){
        $itemsCount = count($cart);
    }
@endphp

<div class="container-fluid p-0 large-nav w-100">
    <div class="navbar px-5 fixed-top navbar-expand-lg navbar-light">
        <a href="/"><p class="brand">EnvyAfrica</p></a>

        <div class="nav-search">
            <form action="/all" style="position: relative">
                <input type="text" placeholder="Search" name="search" spellcheck="false" class="nav-input ps-3" />
                <button type="submit" class="btn btn-link search-btn text-dark" style="position: absolute; right: 12px; top: 6px;"><i class="bi bi-search"></i></button>
            </form>
        </div>

        <div class="nav-contact d-flex align-items-center">
            <div class="cart h-100 me-3" style="position: relative">
                <a class="btn btn-link text-dark" href="/cart">
                    <i class="las la-shopping-cart text-white" style="font-size: 36px"></i>
                </a>
                <span class="cart-span">{{$itemsCount}}</span>
            </div>
            <div class="contact-image h-100">
                <img src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcRJnMWQ5uxXdnvjZjlofCHi34qngB_2Y0tHPoFYtpRcSpXvmMAK" alt="contact"/>
            </div>
            <div class="ms-2 h-100">
                <p class="m-0 text-white" style="font-size: 14px;">Contact Us</p>
                <p class="m-0 text-white" style="font-size: 13px;">0712345678</p>
            </div>
        </div>
    </div>
    <div class="nav2">
        <ul class="d-flex mt-2 justify-content-center align-items-center gap-5 text-dark">
            <li class="nav2-item"><p>Lace front wigs</p></li>
            <li class="nav2-item"><p>Combination Wigs</p></li>
            <li class="nav2-item"><p>Synthetic Hair</p></li>
            <li class="nav2-item"><p>Monofilament Wigs</p></li>
            <li class="nav2-item"><p>Hair extensions</p></li>
        </ul>
    </div>
</div>

<div class="container-fluid medium-nav p-0">
    <div class="navbar px-3 fixed-top navbar-expand-lg navbar-light">
        <a href="/"><p class="brand m-0">EnvyAfrica</p></a>

        <div class="nav-search">
            <form action="/all" style="position: relative">
                <input type="text" placeholder="Search" name="search" spellcheck="false" class="nav-input ps-3" />
                <button type="submit" class="btn btn-link search-btn text-dark" style="position: absolute; right: 12px; top: 6px;"><i class="bi bi-search"></i></button>
            </form>
        </div>

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