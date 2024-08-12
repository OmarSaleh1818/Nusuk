@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (تسجيل الدخول)
@endsection
@section('main')

    <div class="sign">
        <div class="container">
            @if(Session::has('error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>{{ session::get('error') }}</strong> .
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-5 form-box">
                    <div class="form-header">
                        <span>
                            تسجيل الدخول
                        </span>
                    </div>
                    <div class="form-body">
                        <form method="post" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="user-name" class="form-label">
                                    البريد الالكتروني
                                </label>
                                <input type="email" name="email" class="form-control" id="user-name">
                                @error('email')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="login-pass" class="form-label">
                                    كلمة المرور
                                </label>
                                <input type="password" id="login-pass" name="password" class="form-control" aria-describedby="passwordHelpBlock">
                                @error('password')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                            <!-- <div class="checkbox">
                              <label><input form-control type="checkbox"> Remember me</label>
                            </div> -->
                            <div class="form-btn">

                                <button type="submit" class="btn btn-dark">
                                    دخول
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

