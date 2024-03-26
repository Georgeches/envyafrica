<section class="container-fluid p-0 ready-products mt-5 pt-5">
<div class="text-center">
    <h3 class="" style="font-weight: 500">What's New</h3>
    <p>Shop Latest Styles <a href="/all" class="btn btn-link text-decoration-none view-all">View all <i class="bi bi-arrow-right"></i></a></p>
</div>

<div class="ready-row w-100 p-0">
    @php $count = 0 @endphp
    @foreach ($products as $product)
        @if ($count < 4)
            <x-product :product="$product" />
            @php $count++ @endphp
        @else
            @break
        @endif
    @endforeach
</div>

</section>