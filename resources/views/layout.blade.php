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
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/carousel.css">
    <link rel="stylesheet" href="/css/designsSection.css">
    <link rel="stylesheet" href="/css/productsSection.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/productsPage.css">
    <link rel="stylesheet" href="/css/cartOffcanvas.css">
    <link rel="stylesheet" href="/css/productDetail.css">
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="/css/xform.css">
    <link rel="stylesheet" href="/css/checkout.css">
    <link rel="stylesheet" href="/css/payment.css">

    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src='/js/custom.js'></script>
    <title>Laras</title>
  </head>
  <body>
    @if (session('success'))
        <div class="container d-flex justify-content-center" style="position: relative">
            <div class="alert alert-success" id="success-alert" style="position: relative; z-index: 10000000000000000; top: 60px;">
              {{session('success')}}
              <button class="btn btn-link ms-3 text-dark" onclick="hideSuccessAlert()"><i class="bi bi-x-circle"></i></button>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="container d-flex justify-content-center">
            <div class="alert alert-danger" id="error-alert" style="position: relative; z-index: 10000000000000000; top: 60px;">
              {{session('error')}}
              <button class="btn btn-link ms-3 text-dark" onclick="hideErrorAlert()"><i class="bi bi-x-circle"></i></button>
            </div>
        </div>
    @endif
    @yield('content')
    <!--Bootstrap 5-->
    <script>
      function hideSuccessAlert() {
          document.getElementById('success-alert').style.display = 'none';
      }
      function hideErrorAlert() {
          document.getElementById('error-alert').style.display = 'none';
      }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>  
</body>
</html>