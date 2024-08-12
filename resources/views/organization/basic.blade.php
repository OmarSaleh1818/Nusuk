@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (اليانات الأساسية)
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
                <section class="list-opp">
                    <div class="container" dir="rtl">
                        <div class="row mt-4">
                            <div class="col text-center">
                                <h2 style="color: #b49164;"> البيانات الأساسية </h2>
                            </div>
                        </div>
                        <hr>
                        <br>
                        @if(Session::has('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{ session::get('error') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row" >
                            <div class="col-md-4" style="border-left: 1px solid #444444">
                                <h5> بيانات المنظمة </h5>
                            </div>
                            <div class="col-md-4" style="border-left: 1px solid #444444">
                                <h5> بيانات مدير المنظمة  </h5>
                            </div>
                            <div class="col-md-4">
                                <h5> بيانات مسؤول التواصل  </h5>
                            </div>
                        </div>
                        <br>
                        <form method="post" action="{{ route('basic.update') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $basic->id }}">
                            <div class="row">
                                <div class="col-md-4" style="border-left: 1px solid #444444">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">اسم المنظمة  </label>
                                        <input type="text" class="form-control" name="organization_name" required
                                               value="{{ $basic->organization_name }}" >
                                    </div>
                                </div>
                                <div class="col-md-4" style="border-left: 1px solid #444444">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">الاسم</label>
                                        <input type="text" class="form-control" name="manager_name" required
                                               value="{{ $basic->manager_name }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">الاسم</label>
                                        <input type="text" class="form-control" name="contact_name" required
                                               value="{{ $basic->contact_name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" style="border-left: 1px solid #444444">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">رقم الترخيص</label>
                                        <input type="text" class="form-control" name="license_number" required
                                               value="{{ $basic->license_number }}">
                                    </div>
                                </div>
                                <div class="col-md-4" style="border-left: 1px solid #444444">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">الجوال</label>
                                        <input type="text" class="form-control" name="manager_mobile" required
                                               value="{{ $basic->manager_mobile }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">الجوال</label>
                                        <input type="text" class="form-control" name="contact_mobile" required
                                               value="{{ $basic->contact_mobile }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" style="border-left: 1px solid #444444">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">البريد الالكتروني</label>
                                        <input type="text" class="form-control" name="organization_email" required
                                               value="{{ $basic->organization_email }}">
                                    </div>
                                </div>
                                <div class="col-md-4" style="border-left: 1px solid #444444">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">البريد الالكتروني</label>
                                        <input type="text" class="form-control" name="manager_email" required
                                               value="{{ $basic->manager_email }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">البريد الالكتروني</label>
                                        <input type="text" class="form-control" name="email" required
                                               value="{{ $basic->email }}">
                                        @error('email')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" style="border-left: 1px solid #444444">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">المنطقة</label>
                                        <input type="text" class="form-control" name="organization_region" required
                                               value="{{ $basic->organization_region }}">
                                    </div>
                                </div>
                                <div class="col-md-4" style="border-left: 1px solid #444444">

                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">المسمى الوظيفي</label>
                                        <input type="text" class="form-control" name="contact_job_title" required
                                               value="{{ $basic->contact_job_title }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" style="border-left: 1px solid #444444">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">المدينة</label>
                                        <input type="text" class="form-control" name="organization_city" required
                                               value="{{ $basic->organization_city }}">
                                    </div>
                                </div>
                                <div class="col-md-4" style="border-left: 1px solid #444444">

                                </div>
                                <div class="col-md-4">

                                </div>
                            </div>
                            <div class="row my-5 px-5">
                                <div class="col-md-4">
                                    <label for="reciver" class="form-label">اسم المستخدم</label>
                                    <input type="text" class="form-control" name="name" value="{{ $basic->name }}" id="reciver" required>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="date" class="form-label">كلمة المرور</label>
                                    <input type="password" class="form-control" name="password" id="date">
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="deadline" class="form-label">تأكيد كلمة المرور</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="deadline">
                                    @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 text-center my-5">
                            <button type="submit" class="btn btn-dark px-5 text-white" style="background-color: #b49164;">
                                حفظ
                            </button>
                        </div>
                        </form>
                    </div>
                </section>

            </div>


        </div>
    </div>

@endsection
