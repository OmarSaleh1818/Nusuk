@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (استعادة كلمة المرور)
@endsection
@section('main')

    <div class="sign">
        <div class="container">
            <div class="row">
                <div class="col-md-5 form-box">
                    <div class="form-header">
                        <span>
                            استعادة كلمة المرور
                        </span>
                    </div>
                    <div class="form-body">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <label for="user-name" class="form-label">
                                    ادخل البريد الاكتروني
                                </label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>

                            <!-- <div class="checkbox">
                              <label><input form-control type="checkbox"> Remember me</label>
                            </div> -->
                            <div class="form-btn">
                                <button type="submit" class="btn btn-dark">
                                    إرسال
                                </button>
                            </div>
                            <div class="form-footer">
                                <a href="{{ url('/login') }}">
                                    تسجيل الدخول
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


