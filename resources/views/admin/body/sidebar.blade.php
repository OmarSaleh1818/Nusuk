@php
    $prefix = Request::route()->getPrefix();
    $route = Route::current()->getName();
@endphp
@if(Auth::guard('admin')->user()->status == 0)
    <li class="sidebar-item">
        <a href="" class="sidebar-link collapsed" data-bs-toggle="collapse"
           data-bs-target="#news" aria-expanded="false" aria-controls="news">
            <i class="fa-regular fa-newspaper pe-2"></i>
            <span> إدارة الاخبار</span>
        </a>
        <ul id="news" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item">
                <a href="{{ route('news') }}" class="sidebar-link text-center {{ ($route == 'news')? 'active' : '' }}"> إدارة الاخبار </a>
            </li>
        </ul>
    </li>

    <li class="sidebar-item">
        <a href="" class="sidebar-link collapsed" data-bs-toggle="collapse"
           data-bs-target="#new" aria-expanded="false" aria-controls="new">
            <i class="fa-solid fa-gear pe-2"></i>
            <span>الاعدادات</span>
        </a>
        <ul id="new" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link text-center {{ ($route == 'admin.dashboard')? 'active' : '' }}"> الصفحة الرئيسية </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('user.management') }}" class="sidebar-link text-center {{ ($route == 'user.management')? 'active' : '' }}"> إدارة المنظمات </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.management') }}" class="sidebar-link text-center {{ ($route == 'admin.management')? 'active' : '' }}"> إدارة المستخدمين </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.logout') }}" class="sidebar-link text-center">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    تسجيل الخروج
                </a>
            </li>

        </ul>
    </li>
@elseif(Auth::guard('admin')->user()->status == 1)
    <li class="sidebar-item">
        <a href="" class="sidebar-link collapsed" data-bs-toggle="collapse"
           data-bs-target="#new" aria-expanded="false" aria-controls="new">
            <i class="fa-solid fa-gear pe-2"></i>
            <span>الاعدادات</span>
        </a>
        <ul id="new" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item">
                <a href="{{ route('admin.logout') }}" class="sidebar-link text-center">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    تسجيل الخروج
                </a>
            </li>
        </ul>
    </li>
@endif

