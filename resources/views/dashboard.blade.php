@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (ملف المنظمة)
@endsection
@section('main')

    <div class="wrapper">
        <!-- ================ Sidebar =============== -->
        <aside id="sidebar" class="collapsed">
            <div class="h-100">
                <ul class="sidebar-nav">
                    <li class="sidebar-item">
                        <a href="" class="sidebar-link collapsed" data-bs-toggle="collapse"
                           data-bs-target="#opportunities" aria-expanded="false" aria-controls="opportunities">
                            <i class="fa-solid fa-table pe-2"></i>
                            <span> الفرص القطاعية</span>
                        </a>
                        <ul id="opportunities" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            @foreach($opportunities as $key => $item)
                                @php
                                    $count = App\Models\OpportunityData::where('opportunity_id', $item->id)->count();
                                @endphp
                                <li class="sidebar-item">
                                    <a href="{{ route('organization.opportunity', $item->id) }}" class="sidebar-link text-center">
                                        {{ $item->opportunity_name }}  ({{$count}})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    @include('frontend.body.sidebar')

                </ul>
            </div>
        </aside>
        <!-- ================ End Sidebar =============== -->
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
                    <div class="container">
                        @if(Session::has('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{ session::get('error') }}</strong> .
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="hello row">
                            <div class="col-md-12 my-4">

                            </div>
                        </div>
                        <div class="org-view-file row">
                            <div class="col-md-12 text-center p-3">
                                <span>ملف المنظمة</span>
                            </div>
                            <div class="col-md-3 p-3">
                                <div class="org-view-file-item">
                                    @if(Auth::user()->user_permission == 1)
                                        <a href="{{ route('organization.basic') }}">البيانات الأساسية</a>
                                    @else
                                        <a href="{{ route('organization.user.basic', Auth::user()->user_id) }}">البيانات الأساسية</a>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3 p-3">
                                <div class="org-view-file-item">
                                    @if(Auth::user()->user_permission == 1)
                                        <a href="{{ route('organization.about') }}">
                                            البيانات التخصصية
                                        </a>
                                    @else
                                        <a href="{{ route('organization.user.about', Auth::user()->user_id) }}">
                                            البيانات التخصصية
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <div class="org-view-file-item">
                                    @if(Auth::user()->user_permission == 1)
                                    <a href="{{ route('organization.financial') }}">
                                        بيانات الواقع المالي
                                    </a>
                                    @else
                                        <a href="{{ route('organization.user.financial', Auth::user()->user_id) }}">
                                            بيانات الواقع المالي
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <div class="org-view-file-item">
                                    @if(Auth::user()->user_permission == 1)
                                        <a href="{{ route('organization.services') }}">
                                            الخدمات
                                        </a>
                                    @else
                                        <a href="{{ route('organization.user.services', Auth::user()->user_id) }}">
                                            الخدمات
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <div class="org-view-file-item">
                                    @if(Auth::user()->user_permission == 1)
                                        <a href="{{ route('organization.staff') }}">بيانات العاملين </a>
                                    @else
                                        <a href="{{ route('organization.user.staff', Auth::user()->user_id) }}">بيانات العاملين </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 p-3">
                                <div class="org-view-file-item">
                                    @if(Auth::user()->user_permission == 1)
                                        <a href="{{ route('organization.volunteers') }}">بيانات المتطوعين </a>
                                    @else
                                        <a href="{{ route('organization.user.volunteers', Auth::user()->user_id) }}">بيانات المتطوعين </a>
                                    @endif
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

                        <div class="org-view-file row my-3">
                            <div class="col-md-12 text-center p-3">
                                <span>الفرص القطاعية </span>
                            </div>
                            <div class="row">
                                @foreach($opportunities as $item)
                                    @php
                                        $count = App\Models\OpportunityData::where('opportunity_id', $item->id)->count();
                                    @endphp
                                    <div class="col-md-4 p-3">
                                        <div class="org-view-file-item">
                                            <a href="{{ route('organization.opportunity', $item->id) }}">
                                                {{ $item->opportunity_name }} ({{ $count }})
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

            </div>


        </div>
    </div>

@endsection
