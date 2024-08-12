<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ======= Meta ======= -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ======= Fontawesome Links if there is a problem in fontawesome kit ======= -->
    <!-- <link rel="stylesheet" href="assets/fonts/icon/fontawesome-free-6.5.2-web/css/fontawesome.css">
    <link rel="stylesheet" href="assets/fonts/icon/fontawesome-free-6.5.2-web/css/brands.css">
    <link rel="stylesheet" href="assets/fonts/icon/fontawesome-free-6.5.2-web/css/solid.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- ======= Bootstrap Links ======= -->
    <link rel="stylesheet" href="{{ asset('assets/liberaries/bootstrap-5.3.3-dist/css/bootstrap.rtl.min.css') }}">
    <!-- ======= Style Links ======= -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- ======= Favicon   ======= -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/image/logo/logo_nusuk.png') }}">
    <title>
        @yield('title')
    </title>

</head>
<body dir="rtl">

<div class="wrapper">
    <!-- ================ Sidebar =============== -->

    <!-- ================ End Sidebar =============== -->

    @yield('content')
</div>


<!-- ====== Start Footer ======= -->
<div class="footer">
    <div class="container-fluid">
        <div class="row p-0">
            <div class="col-md-4 footer-section">
                <span> جميع الحقوق محفوظة لمؤسسة نسك 2024</span>
            </div>
            <div class="col-md-4 footer-section">
                    <span>
                        <a class="footer-link pe-2">سياسة الخصوصية
                        </a>
                        <a class="footer-link pe-2">
                            اتـصــــل بــنــــــــا
                        </a>
                    </span>
            </div>
            <div class="col-md-4 footer-section">
                <span> تصميم وبرمجة الذكاء الثالث </span>
            </div>
        </div>
    </div>
</div>





<!-- ====== Fontawesome  script ====== -->
<script src="https://kit.fontawesome.com/194ed55864.js" crossorigin="anonymous"></script>
<!-- ====== Bootstrap  script ====== -->
<script src="{{ asset('assets/liberaries/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') }}"></script>
<!-- ====== Main  script ====== -->
<script src="{{ asset('scripts/main.js') }}"></script>
</body>
</html>
