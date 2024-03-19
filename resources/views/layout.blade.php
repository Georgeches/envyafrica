<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--Bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- line-awesome icons -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/designsSection.css') }}">
    <link rel="stylesheet" href="{{ asset('css/productsSection.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/productsPage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cartOffcanvas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/productDetail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/xform.css') }}">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <title>Laras</title>
  </head>
  <body>
    @if (session('success'))
        <div class="container d-flex justify-content-center">
            <div class="alert alert-success" style="position: relative; z-index: 10000000000000000; top: 60px;">
              {{session('success')}}
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="container d-flex justify-content-center">
            <div class="alert alert-danger" style="position: relative; z-index: 10000000000000000; top: 60px;">
              {{session('error')}}
            </div>
        </div>
    @endif
    @yield('content')
    <!--Bootstrap 5-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>  
</body>
</html>