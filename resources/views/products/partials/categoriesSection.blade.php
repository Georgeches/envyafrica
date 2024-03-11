<section class="container ready-products mt-4">
<div class="header d-flex justify-content-between">
    <h3 class="fw-light">Bestselling Products</h3>
    <a href="/all" class="btn btn-link text-decoration-none text-muted">View all <i class="bi bi-arrow-right"></i></a>
</div>

<div class="ready-row">
    @foreach ($products as $product)
        <x-product :product="$product" />
    @endforeach
</div>
<a href="/all" class=" mt-3 btn btn-link text-decoration-none text-muted">View all <i class="bi bi-arrow-right"></i></a>
</section>