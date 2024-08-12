@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (اليانات الأساسية)
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

                <!-- ====== Start oppor section ======= -->
                <section class="list-opp">
                    <div class="container" dir="rtl">
                        <div class="row">
                            <div class="col text-center">
                                <h3> البيانات الأساسية </h3>
                            </div>
                        </div>
                        <hr>
                        <br>
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
                        <div class="row">
                            <div class="col-md-4" style="border-left: 1px solid #444444">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">اسم المنظمة  </label>
                                    <input type="text" class="form-control" name="organization_name" required
                                           value="{{ $basic->organization_name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4" style="border-left: 1px solid #444444">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">الاسم</label>
                                    <input type="text" class="form-control" name="manager_name" required
                                           value="{{ $basic->manager_name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">الاسم</label>
                                    <input type="text" class="form-control" name="contact_name" required
                                           value="{{ $basic->contact_name }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="border-left: 1px solid #444444">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">رقم الترخيص</label>
                                    <input type="text" class="form-control" name="license_number" required
                                           value="{{ $basic->license_number }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4" style="border-left: 1px solid #444444">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">الجوال</label>
                                    <input type="text" class="form-control" name="manager_mobile" required
                                           value="{{ $basic->manager_mobile }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">الجوال</label>
                                    <input type="text" class="form-control" name="contact_mobile" required
                                           value="{{ $basic->contact_mobile }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="border-left: 1px solid #444444">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">البريد الالكتروني</label>
                                    <input type="text" class="form-control" name="organization_email" required
                                           value="{{ $basic->organization_email }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4" style="border-left: 1px solid #444444">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">البريد الالكتروني</label>
                                    <input type="text" class="form-control" name="manager_email" required
                                           value="{{ $basic->manager_email }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">البريد الالكتروني</label>
                                    <input type="text" class="form-control" name="email" required
                                           value="{{ $basic->email }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="border-left: 1px solid #444444">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">المنطقة</label>
                                    <input type="text" class="form-control" name="organization_region" required
                                           value="{{ $basic->organization_region }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4" style="border-left: 1px solid #444444">

                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">المسمى الوظيفي</label>
                                    <input type="text" class="form-control" name="contact_job_title" required
                                           value="{{ $basic->contact_job_title }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="border-left: 1px solid #444444">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">المدينة</label>
                                    <input type="text" class="form-control" name="organization_city" required
                                           value="{{ $basic->organization_city }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4" style="border-left: 1px solid #444444">

                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                        <br>
                        <br>

                    </div>

                </section>

            </div>


        </div>
    </div>

@endsection
