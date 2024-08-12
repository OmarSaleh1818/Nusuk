<nav class="navbar navbar-expand-lg py-2" style="background-color: #23282D;">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('assets/image/logo/logo.png') }}" height="55px" width="110px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">
                        الصفحة الرئيسية
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('news.archive') }}">
                        الأخبار
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">
                        تواصل معنا
                    </a>
                </li>
            </ul>
            @php
                $user = Auth::user();
            @endphp
            @if($user)
                <div class="d-flex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ url('/dashboard') }}">
                                  أهلا {{ Auth::user()->name }}
                            </a>
                        </li>
                    </ul>
                </div>
            @else
                <div class="d-flex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="btn btn-secondary"
                               aria-current="page"
                               href="{{ route('login') }}"
                               style="background-color: #b49164; color: white;">
                                <i class="fa fa-user-circle-o" aria-hidden="true" style="color: white; margin-left: 8px"></i>
                                تسجيل الدخول
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}" style="color: white">
                                حساب جديد
                            </a>
                        </li>
                    </ul>
                </div>
            @endif

        </div>
    </div>
</nav>
