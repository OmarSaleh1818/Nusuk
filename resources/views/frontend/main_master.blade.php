<!DOCTYPE html>
<html lang="en">
<head>

    <base href="./index.html" target="_self">
    <!-- ======= Meta ======= -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ======= Fontawesome Links if there is a problem in fontawesome kit ======= -->
    <!-- <link rel="stylesheet" href="./assets/fonts/icon/fontawesome-free-6.5.2-web/css/fontawesome.css">
    <link rel="stylesheet" href="./assets/fonts/icon/fontawesome-free-6.5.2-web/css/brands.css">
    <link rel="stylesheet" href="./assets/fonts/icon/fontawesome-free-6.5.2-web/css/solid.css"> -->

    <!-- ======= Bootstrap Links ======= -->
    <link rel="stylesheet" href="{{ asset('assets/liberaries/bootstrap-5.3.3-dist/css/bootstrap.rtl.min.css') }}">
    <!-- ======= Style Links ======= -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- ======= Favicon   ======= -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/image/logo/logo_nusuk.png') }}">
    <title>@yield('title')</title>

</head>

<body dir="rtl">

<!-- ====== Start about navbar ======= -->

    @include('frontend.body.header')

<!-- ====== Start login-body ======= -->


@yield('main')


<!-- ====== Start Footer ======= -->

@include('frontend.body.footer')



<!-- ====== Fontawesome  script ====== -->
<script src="https://kit.fontawesome.com/194ed55864.js" crossorigin="anonymous"></script>
<!-- ====== Bootstrap  script ====== -->
<script src="{{ asset('assets/liberaries/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') }}"></script>
<!-- ====== Main  script ====== -->
<script src="{{ asset('scripts/main.js') }}"></script>

</body>
