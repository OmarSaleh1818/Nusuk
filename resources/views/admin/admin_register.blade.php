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
                            <form method="post" action="{{ route('admin.register.store') }}" class="row g-3">
                                @csrf

                                <div class="col-md-6">
                                    <label for="target" class="form-label">
                                        الاسم
                                    </label>
                                    <input type="text" class="form-control" name="name" required/>
                                    @error('name')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="Standards" class="form-label">
                                        البريد الالكتروني
                                    </label>
                                    <input type="email" name="email" class="form-control" id="Standards" required>
                                    @error('email')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror

                                </div>

                                <div class="col-md-6">
                                    <label for="target" class="form-label">
                                        الجوال
                                    </label>
                                    <input type="text" name="mobile_number" class="form-control" id="target" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="Standards" class="form-label">
                                        المسمى الوظيفي
                                    </label>
                                    <input type="text" name="job_title" class="form-control" id="Standards" required>
                                </div>

                                <div class="col-md-4 ">
                                    <label for="reciver" class="form-label">
                                        اسم المستخدم
                                    </label>
                                    <input type="text" name="user_name" class="form-control" id="reciver" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="date" class="form-label">
                                        كلمة المرور
                                    </label>
                                    <input type="password" name="password" class="form-control" id="date" required>
                                    @error('password')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="deadline" class="form-label">
                                        تأكيد كلمة المرور
                                    </label>
                                    <input type="password" name="password_confirmation" class="form-control" id="deadline" required>
                                    @error('password_confirmation')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                        <span>
                                            نوع الحساب
                                        </span>
                                </div>

                                <div class="form-check col-md-2">
                                    <input class="form-check-input" type="radio" name="status" value="0" id="acc-type">
                                    <label class="form-check-label" for="acc-type">
                                        أدمن نسك
                                    </label>
                                </div>
                                <div class="form-check col-md-2">
                                    <input class="form-check-input" type="radio" name="status" value="1" id="acc-type" checked>
                                    <label class="form-check-label" for="acc-type">
                                        سوبر
                                    </label>
                                </div>

                                <div class="col-12 text-center my-5">
                                    <button type="submit" class="btn btn-dark px-5 text-white">
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

@endsection
