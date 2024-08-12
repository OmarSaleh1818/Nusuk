@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (تسجيل البيانات الأساسية)
@endsection
@section('main')
    <div class="content">
        <div>

        </div>
        <!-- ====== Start open-new-acc section ======= -->
        <section class="open-new-acc">
            <div class="container-fluid">
                <div class="row">
                    <div class="section-header col-md-12">
                    <span>
                        البيانات الأساسية
                    </span>
                    </div>
                    <div class="add-acc-form my-4">
                        <form method="POST" action="{{ route('register') }}" class="row g-3">
                            @csrf

                            <div class="org-data-form col-md-4 px-5">
                            <span>
                                بيانات المنظمة
                            </span>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <label for="org-name" class="form-label">
                                            اسم المنظمة
                                        </label>
                                        <input type="text" class="form-control" name="organization_name" id="org-name" required>
                                        @error('name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="org-id" class="form-label">
                                            رقم الترخيص
                                        </label>
                                        <input type="text" class="form-control" name="license_number" id="org-id" required>
                                        @error('name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="org-email" class="form-label">
                                            البريد الالكتروني
                                        </label>
                                        <input type="email" class="form-control" name="organization_email" id="org-email" required>
                                        @error('name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="org-area" class="form-label">
                                            المنطقة
                                        </label>
                                        <input type="text" class="form-control" name="organization_region" id="org-area" required>
                                        @error('name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="org-city" class="form-label">
                                            المدينة
                                        </label>
                                        <input type="text" class="form-control" name="organization_city" id="org-city" required>
                                        @error('name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <!-- --------------------------- -->
                            <div class="manager-data-form col-md-4 px-5">
                            <span>
                                بيانات مدير المنظمة
                            </span>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <label for="manager-name" class="form-label">
                                            الاسم
                                        </label>
                                        <input type="text" class="form-control" name="manager_name" id="manager-name" required>
                                        @error('name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="manager-phone" class="form-label">
                                            الجوال
                                        </label>
                                        <input type="text" class="form-control" name="manager_mobile" id="manager-phone" required>
                                        @error('name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="manager-email" class="form-label">
                                            البريد الالكتروني
                                        </label>
                                        <input type="email" class="form-control" name="manager_email" id="manager-email" required>
                                        @error('name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <!-- --------------------------- -->
                            <div class="liaison-officer-data col-md-4 px-5">
                            <span>
                                بيانات ضابط الارتباط
                            </span>
                                <div class="row mt-5">
                                    <div liaison-officer-data-item class="col-md-12">
                                        <label for="officer-name" class="form-label">
                                            الاسم
                                        </label>
                                        <input type="text" class="form-control"  name="contact_name" id="officer-name" required>
                                        @error('name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div liaison-officer-data-item class="col-md-12">
                                        <label for="officer-phone" class="form-label">
                                            الجوال
                                        </label>
                                        <input type="text" class="form-control" name="contact_mobile" id="officer-phone" required>
                                        @error('name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div liaison-officer-data-item class="col-md-12">
                                        <label for="officer-email" class="form-label">
                                            البريد الالكتروني
                                        </label>
                                        <input type="email" class="form-control" name="email" id="officer-email" required>
                                        @error('name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div liaison-officer-data-item class="col-md-12">
                                        <label for="officer-job-title" class="form-label">
                                            المسمى الوظيفي
                                        </label>
                                        <input type="text" class="form-control" name="contact_job_title" id="officer-job-title" required>
                                        @error('name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>



                            <div class="row  my-5 px-5">
                                <div class="col-md-4 ">
                                    <label for="reciver" class="form-label">
                                        اسم المستخدم
                                    </label>
                                    <input type="text" class="form-control" name="name"  id="reciver">
                                    @error('name')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="date" class="form-label">
                                        كلمة المرور
                                    </label>
                                    <input type="password" class="form-control" name="password" id="date">
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
                            </div>

                            <div class="col-12 text-center my-5">
                                <button type="submit" class="btn btn-dark px-5" style="background-color: #b49164; color: white;">
                                        حفظ
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

    </section>

    </div>


@endsection

