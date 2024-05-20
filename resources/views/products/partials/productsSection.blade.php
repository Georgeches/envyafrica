<section class="container-fluid p-0 ready-products mt-5 pt-5" style="min-height: fit-content;">
<div class="text-center">
    <h3 class="" style="font-weight: 500">What's New</h3>
    <p>Shop Latest Styles <a href="/all" class="btn btn-link text-decoration-none view-all">View all <i class="bi bi-arrow-right"></i></a></p>
</div>

<div class="w-100 p-0 swiper container">
    <div class="ready-row swiper-wrapper">
        @foreach ($products as $product)
            <x-product :product="$product" />
        @endforeach
    </div>

    <div class="swiper-button-prev" style="color: rgb(255,41,140);"></div>
    <div class="swiper-button-next" style="color: rgb(255,41,140);"></div>
</div>

</section>