@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (إضافة مستخدم)
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

                <!-- ====== Start Users section ======= -->
                <section class="list-opp">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="section-header col-md-12">
                                <span>
                                    إضافة مستخدم
                                </span>
                            </div>
                            <!-- <div>
                                <span>
                                    بيانات المستخدم
                                </span>
                            </div> -->
                            <div class="add-user-form">
                                <form method="post" action="{{ route('organization.store.user') }}" class="row g-3">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $id }}">

                                    <div class="col-md-6">
                                        <label for="target" class="form-label">
                                            الاسم
                                        </label>
                                        <input type="text" class="form-control"  name="contact_name" id="target" required>
                                        @error('contact_name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="col-md-6">
                                        <label for="Standards" class="form-label">
                                            البريد الالكتروني
                                        </label>
                                        <input type="email" class="form-control"  name="email" id="Standards" required>
                                        @error('email')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="col-md-6">
                                        <label for="target" class="form-label">
                                            الجوال
                                        </label>
                                        <input type="text" class="form-control" name="contact_mobile" id="target" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="Standards" class="form-label">
                                            المسمى الوظيفي
                                        </label>
                                        <input type="text" class="form-control" name="contact_job_title" id="Standards" required>
                                    </div>

                                    <div class="col-md-4 ">
                                        <label for="reciver" class="form-label">
                                            اسم المستخدم
                                        </label>
                                        <input type="text" class="form-control" name="name" id="reciver">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="date" class="form-label">
                                            كلمة المرور
                                        </label>
                                        <input type="password" class="form-control" name="password" id="date" required>
                                        @error('password')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="deadline" class="form-label">
                                            تأكيد كلمة المرور
                                        </label>
                                        <input type="password" class="form-control" name="password_confirmation" id="deadline" required>
                                        @error('password_confirmation')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 text-center my-5">
                                        <button type="submit" class="btn btn-dark px-5 text-white" style="background-color: #b49164;">
                                                حفظ
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </section>

            </div>


        </div>
    </div>


@endsection
