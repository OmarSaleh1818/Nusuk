@php
    $route = Route::current()->getName();
@endphp

<li class="sidebar-item">
    <a href="" class="sidebar-link collapsed" data-bs-toggle="collapse"
       data-bs-target="#new" aria-expanded="false" aria-controls="new">
        <i class="fa-regular fa-newspaper pe-2" aria-hidden="true"></i>
        <span>ملف المنظمة</span>
    </a>
    <ul id="new" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
        <li class="sidebar-item">
            @if(Auth::user()->user_permission == 1)
                <a href="{{ route('organization.basic') }}" class="sidebar-link text-center {{ ($route == 'organization.basic')? 'active' : '' }}">البيانات الأساسية </a>
            @else
                <a href="{{ route('organization.user.basic', Auth::user()->user_id) }}" class="sidebar-link text-center {{ ($route == 'organization.user.basic')? 'active' : '' }}">البيانات الأساسية </a>
            @endif
        </li>
        <li class="sidebar-item">
            @if(Auth::user()->user_permission == 1)
                <a href="{{ route('organization.about') }}" class="sidebar-link text-center {{ ($route == 'organization.about')? 'active' : '' }}">البيانات التخصصية </a>
            @else
                <a href="{{ route('organization.user.about', Auth::user()->user_id) }}" class="sidebar-link text-center {{ ($route == 'organization.user.about')? 'active' : '' }}">البيانات التخصصية </a>
            @endif
        </li>
        <li class="sidebar-item">
            @if(Auth::user()->user_permission == 1)
                <a href="{{ route('organization.financial') }}" class="sidebar-link text-center {{ ($route == 'organization.financial')? 'active' : '' }}">بيانات الواقع المالي </a>
            @else
                <a href="{{ route('organization.user.financial', Auth::user()->user_id) }}" class="sidebar-link text-center {{ ($route == 'organization.user.financial')? 'active' : '' }}">بيانات الواقع المالي </a>
            @endif
        </li>
        <li class="sidebar-item">
            @if(Auth::user()->user_permission == 1)
                <a href="{{ route('organization.services') }}" class="sidebar-link text-center {{ ($route == 'organization.services')? 'active' : '' }}">الخدمات </a>
            @else
                <a href="{{ route('organization.user.services', Auth::user()->user_id) }}" class="sidebar-link text-center {{ ($route == 'organization.user.services')? 'active' : '' }}">الخدمات </a>
            @endif
        </li>
        <li class="sidebar-item">
            @if(Auth::user()->user_permission == 1)
                <a href="{{ route('organization.staff') }}" class="sidebar-link text-center {{ ($route == 'organization.staff')? 'active' : '' }}">بيانات العاملين </a>
            @else
                <a href="{{ route('organization.user.staff', Auth::user()->user_id) }}" class="sidebar-link text-center {{ ($route == 'organization.user.staff')? 'active' : '' }}">بيانات العاملين </a>
            @endif
        </li>
        <li class="sidebar-item">
            @if(Auth::user()->user_permission == 1)
                <a href="{{ route('organization.volunteers') }}" class="sidebar-link text-center {{ ($route == 'organization.volunteers')? 'active' : '' }}">بيانات المتطوعين </a>
            @else
                <a href="{{ route('organization.user.volunteers', Auth::user()->user_id) }}" class="sidebar-link text-center {{ ($route == 'organization.volunteers')? 'active' : '' }}">بيانات المتطوعين </a>
            @endif
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link text-center">الشراكات </a>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link text-center">الاعترافات التقديرية </a>
        </li>
    </ul>
</li>

<li class="sidebar-item">
    <a href="" class="sidebar-link collapsed" data-bs-toggle="collapse"
       data-bs-target="#setting" aria-expanded="false" aria-controls="setting">
        <i class="fa-solid fa-gear pe-2"></i>
        <span>الاعدادات</span>
    </a>
    <ul id="setting" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
        <li class="sidebar-item">
            <a href="{{ route('dashboard') }}" class="sidebar-link text-center {{ ($route == 'dashboard')? 'active' : '' }}">الصفحة الرئيسية </a>
        </li>
        @if(Auth::user()->user_permission == 1)
            <li class="sidebar-item">
                <a href="{{ route('organization.user.management', Auth::user()->id) }}" class="sidebar-link text-center">إدارة المستخدمين </a>
            </li>
        @endif
        <li class="sidebar-item">
            <a href="{{ route('user.logout') }}" class="sidebar-link text-center">
                <i class="fa-solid fa-right-from-bracket"></i>
                تسجيل الخروج
            </a>
        </li>
    </ul>
</li>

