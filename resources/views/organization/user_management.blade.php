@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (إدارة المستخدمين)
@endsection
@section('main')

    <div class="wrapper">
        <!-- ================ Sidebar =============== -->
        <aside id="sidebar">
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

                <!-- ====== Start Users section ======= -->
                <section class="list-opp">
                    <form method="POST" action="{{ route('organization.user.bulkAction') }}">
                        @csrf
                        <div class="container-fluid ">
                            @if(Session::has('error'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>{{ session::get('error') }}</strong> .
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="row">
                                <div class="section-header col-md-12">
                                    <span>
                                        إدارة المستخدمين
                                    </span>
                                </div>
                                <div class="oppo-controls col-md-12 my-2">
                                    <button type="button" class="btn btn-success btn-sm">
                                        <a class="text-white" href="{{ route('organization.add.user', Auth::user()->id)}}">
                                            إضافة مستخدم
                                        </a>
                                    </button>
                                    <button type="submit" name="action" value="active" class="btn btn-success btn-sm text-white">
                                        تفعيل
                                    </button>
                                    <button type="submit" name="action" value="stop" class="btn btn-secondary btn-sm text-white">
                                        إيقاف
                                    </button>
                                    <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm text-white">
                                        حذف
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
                                    رقم الجوال
                                </th>
                                <th scope="col">
                                    المسمى الوظيفي
                                </th>
                                <th scope="col">
                                    الحالة
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($organization_users as $item)
                                <tr>
                                    <th scope="row">
                                        <input type="checkbox" class="form-check-input" name="user_id[]" value="{{ $item->id }}">
                                    </th>
                                    <td>
                                        {{ $item->name }}
                                    </td>
                                    <td>
                                        {{ $item->email }}
                                    </td>
                                    <td>
                                        {{ $item->contact_mobile }}
                                    </td>
                                    <td>
                                        {{ $item->contact_job_title }}
                                    </td>
                                    <td>
                                        @if($item->status != 1)
                                            <button type="button" class="btn btn-secondary">موقوف</button>
                                        @else
                                            <button type="button" class="btn btn-success">مفعل</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                </section>

            </div>


        </div>
    </div>


@endsection
