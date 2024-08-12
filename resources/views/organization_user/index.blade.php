<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> ملف المنظمة</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<header style="height: 80px">
    <a href="{{ url('/organization/dashboard') }}" class="btn btn-primary">الصفحة الرئيسية</a>
</header>

<div class="container" dir="rtl">
    @if(Session::has('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{ session::get('error') }}</strong> .
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="col text-center">
            <h3> ملف المنظمة </h3>
        </div>
    </div>
    <hr>
    <br>
    <br>
    <div class="justify-content-center" style="gap: 1.5rem;">
        <h4>Name : {{ Auth::guard('organization')->user()->name }}</h4>
        <br>
        <h4>Email : {{ Auth::guard('organization')->user()->email }}</h4>
        <br>

        <br>
        <a href="{{ route('organization.logout') }}" class="btn btn-danger">تسجيل الخروج</a>
    </div>
    <br>
    <br>
    <div class="d-flex justify-content-center" style="gap: 1.5rem;">
        <a href="{{ route('organization.user.basic', Auth::guard('organization')->user()->user_id) }}" class="btn btn-dark">البيانات الأساسية</a>

        <a href="{{ route('organization.user.about', Auth::guard('organization')->user()->user_id) }}) }}" class="btn btn-dark">البيانات التخصصية</a>

        <a href="{{ route('organization.user.financial', Auth::guard('organization')->user()->user_id) }}" class="btn btn-dark">بيانات الواقع المالي</a>
    </div>
    <br>
    <div class="d-flex justify-content-center" style="gap: 3rem;">
        <a href="{{ route('organization.user.services', Auth::guard('organization')->user()->user_id) }}" class="btn btn-dark">الخدمات</a>

        <a href="{{ route('organization.user.staff', Auth::guard('organization')->user()->user_id) }}" class="btn btn-dark">بيانات العاملين</a>

        <a href="{{ route('organization.user.volunteers', Auth::guard('organization')->user()->user_id) }}" class="btn btn-dark">بيانات المتطوعين</a>
    </div>
</div>



</body>
</html>


