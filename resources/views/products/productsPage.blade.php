@extends('layout')

@section('content')
@include('products.partials.navbar')
<div class="container-fluid products-page d-flex gap-1 p-0 justify-content-between">
    <div class="filter-section px-2">
        <h4 class="mb-2">Products ({{count($products)}})</h4>
        <hr>
        <ul class="filter-categories mt-4 mb-5">
            <li class="filter-category">
                <a href="/all" class="filter-category-link">All</a>
            </li>
            @foreach ($categories as $category)
                <li class="filter-category">
                    <a href="?category={{$category->slug}}" class="filter-category-link">{{$category->name}}</a>
                </li>
            @endforeach
        </ul>
        <h5 class="mt-3 mb-2">By price</h5>
        <hr>
        <ul class="filter-categories mt-4 mb-5">
            <li class="filter-category">
                <a href="?minprice=0&maxprice=500" class="filter-category-link">sh 0 - sh 500</a>
            </li>
            <li class="filter-category">
                <a href="?minprice=501&maxprice=2000" class="filter-category-link">sh 501 - sh 2000</a>
            </li>
            <li class="filter-category">
                <a href="?minprice=2001&maxprice=4000" class="filter-category-link">sh 2001 - sh 4000</a>
            </li>
            <li class="filter-category">
                <a href="?minprice=4001&maxprice=8000" class="filter-category-link">sh 4001 - sh 8000</a>
            </li>
            <li class="filter-category">
                <a href="?minprice=8001&maxprice=none" class="filter-category-link">sh 8001 - ...</a>
            </li>
        </ul>
    </div>
    <div class="container w-75 allproducts p-0">
        <div class="mb-2" style="height: fit-content;">
            <div class="d-md-none mb-2">
                <button style="width: 100px;" class="btn btn-outline-dark text-dark d-flex align-items-center justify-content-center gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter" aria-controls="offcanvasFilter">
                    <i class="las la-bars" style="font-size: 22px"></i> filter
                </button>
                <x-filterOffcanvas :products="$products" :categories="$categories"/>
            </div>
            <form action="" class="w-100 all-form d-flex justify-content-center p-0" style="position: relative">
                <input type="text" placeholder="Search..." class="form-control all-search w-100 ps-3" name="search" id="search">
                <button type="submit" class="btn btn-link search-btn text-dark" style="position: absolute; right: 12px; top: 6px;"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <div class="ready-row p-0 d-flex flex-wrap justify-content-start">
            @if (count($products) === 0)
                <p class="mx-4 my-4">No results found</p>
            @endif
            @foreach ($products as $product)
                <x-product :product="$product"/>
            @endforeach
        </div>
    </div>
</div>
@endsection