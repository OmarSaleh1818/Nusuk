@extends('admin.admin_master')
@section('title')
    nusuk | نٌسكـ (إدارة المستخدمين)
@endsection
@section('content')
    <aside id="sidebar">
        <div class="h-100">
            <div class="sidebar-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/image/logo/logo.png') }}" height="80px" width="150px">
                    <!-- Ahmed hamdi -->
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
            <section class="list-opp">
                <div class="container-fluid ">
                    <div class="row">
                        <div class="section-header col-md-12">
                                <span>
                                    إدارة المستخدمين
                                </span>
                        </div>
                        <div class="oppo-controls col-md-12 my-2">
                            <button type="button" class="btn btn-success bg-opacity-50 m-1 px-4">
                                <a class="text-white" href="{{ route('admin.register') }}">
                                    إضافة مستخدم
                                </a>
                            </button>
                        </div>

                    </div>
                </div>

                <table class="table table-Light table-striped">
                    <thead>
                    <tr>
                        <th scope="col">
                            #
                        </th>
                        <th scope="col">
                            الاسم
                        </th>
                        <th scope="col">
                            البريد الالكتروني
                        </th>
                        <th scope="col">
                            الجوال
                        </th>
                        <th scope="col">
                            اسم المستخدم
                        </th>
                        <th scope="col">
                            المسمى الوظيفي
                        </th>
                        <th scope="col">
                            نوع الحساب
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($managements as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                {{ $item->email }}
                            </td>
                            <td>
                                {{ $item->mobile_number }}
                            </td>
                            <td>
                                {{ $item->user_name }}
                            </td>
                            <td>
                                {{ $item->job_title }}
                            </td>
                            <td>
                                @if($item->status != 1)
                                    <button type="button" class="btn btn-info">
                                            ادمن نسك
                                    </button>
                                @else
                                    <button type="button" class="btn btn-info"> سوبر</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </section>
        </div>
    </div>

@endsection
