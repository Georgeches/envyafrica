@php
    $cart = session()->get('cart', []);
    $itemsCount = 0;
    if(isset($cart)){
        $itemsCount = count($cart);
    }
@endphp

<nav class="navbar fixed-top navbar-expand-lg navbar-light">
    <div class="container-fluid nav-top">
        <button id="navbar-toggler" class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand brand-first fw-bold" id="navbar-brand" href="/">LARAS</a>
        <button id="search-icon"  class="btn btn-link search-btn search-icon text-dark"><i class="bi bi-search"></i></button>
        <div class="collapse navbar-collapse d-md-flex justify-content-md-center" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">Home</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Designs
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="#">Pambo picaso</a></li>
                <li><a class="dropdown-item" href="#">Mermaid gowns</a></li>
                <li><a class="dropdown-item" href="#">Peplum dresses</a></li>
                <li><a class="dropdown-item" href="#">Pleated skirts</a></li>
                <li><a class="dropdown-item" href="#">Cocktail dresses</a></li>
            </ul>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
            </li>
            <li class="nav-item">
            <a class="cart-icon d-flex" href="/cart">
                <i class="bi bi-cart4"></i>
                <span class="cart-span">{{$itemsCount}}</span>
            </a>
            </li>
        </ul>
        </div>

        <div class="search-form" id="search-form">
        <form action="/all">
            <input type="text" placeholder="Search" name="search" spellcheck="false" class="" />
            <button type="submit" class="btn btn-link search-btn text-dark"><i class="bi bi-search"></i></button>
        </form>

        <button class="btn btn-link close-search text-dark fw-bold d-lg-none" id="close-search">
            <i class="bi bi-x-lg"></i>
        </button>
        </div>
    </div>
</nav>