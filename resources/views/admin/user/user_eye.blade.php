@extends('admin.admin_master')
@section('title')
    nusuk | نٌسكـ (إدارة المنظمات)
@endsection
@section('content')
    <aside id="sidebar">
        <div class="h-100">
            <div class="sidebar-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/image/logo/logo.png') }}" height="80px" width="150px">
                    <!-- Ahmedhamdi -->
                </a>
            </div>

            <ul class="sidebar-nav">
                <li class="sidebar-header">
                    اهلا {{ Auth::guard('admin')->user()->name }}
                </li>
                <li class="sidebar-item">
                    <a href="" class="sidebar-link collapsed" data-bs-toggle="collapse"
                       data-bs-target="#opportunities" aria-expanded="false" aria-controls="opportunities">
                        <i class="fa-solid fa-table pe-2"></i>
                        <span>إدارة الفرص القطاعية</span>
                    </a>
                    <ul id="opportunities" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        @foreach($opportunities as $key => $item)
                            @php
                                $count = App\Models\OpportunityData::where('opportunity_id', $item->id)->count();
                            @endphp
                            <li class="sidebar-item">
                                <a href="{{ route('sectoral.opportunities', $item->id) }}" class="sidebar-link text-center">
                                    {{ $item->opportunity_name }}  ({{$count}})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @include('admin.body.sidebar')
            </ul>
        </div>
    </aside>
    <div class="main">
        <!-- ====== Start Navbar ======= -->
        <nav class="navbar navbar-expand px-3 border-bottom">
            <!-- == sidebar button toggle == -->
            <button id="sidebar-toggler-btn" class="btn-sidebar" type="button">
                <!-- <span class="navbar-toggler-icon"></span> -->
                <i class="fa-solid fa-arrow-right-arrow-left"></i>
            </button>
        </nav>
        <!-- ====== End Navbar ======= -->
        <div class="content">

            <!-- ====== Start oppor section ======= -->
            <section class="org-view">
                <!-- ====== Start nusuk data section ======= -->
                <div class="row">
                    <div class="col-md-12 my-5">
                            <span>
                                عرض بيانات منظمة {{ $user->organization_name }}
                            </span>
                    </div>
                </div>
                <div class="org-view-file row">

                    <div class="col-md-12 text-center p-3">
                        <span>ملف المنظمة</span>
                    </div>
                    <div class="col-md-3 p-3">
                        <div class="org-view-file-item">
                            <a href="{{ route('admin.organization.basic', $id) }}">البيانات الأساسية</a>
                        </div>
                    </div>

                    <div class="col-md-3 p-3">
                        <div class="org-view-file-item">
                            <a href="{{ route('admin.organization.about', $id) }}">
                                البيانات التخصصية
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 p-3">
                        <div class="org-view-file-item">
                            <a href="{{ route('admin.organization.financial', $id) }}">
                                بيانات الواقع المالي
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 p-3">
                        <div class="org-view-file-item">
                            <a href="{{ route('admin.organization.services', $id) }}">
                                الخدمات
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 p-3">
                        <div class="org-view-file-item">
                            <a href="{{ route('admin.organization.staff', $id) }}">بيانات العاملين </a>
                        </div>
                    </div>
                    <div class="col-md-3 p-3">
                        <div class="org-view-file-item">
                            <a href="{{ route('admin.organization.volunteers', $id) }}">بيانات المتطوعين </a>
                        </div>
                    </div>
                    <div class="col-md-3 p-3">
                        <div class="org-view-file-item">
                            <a>الشراكات </a>
                        </div>
                    </div>
                    <div class="col-md-3 p-3">
                        <div class="org-view-file-item">
                            <a>الاعترافات التقديرية </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
