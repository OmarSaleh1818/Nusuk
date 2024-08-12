@extends('admin.admin_master')
@section('title')
    nusuk | نٌسكـ (تعديل خبر)
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
            <section class="new-news">
                <div class="container-fluid">
                    @if(Session::has('error'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ session::get('error') }}</strong> .
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="section-header col-md-12">
                                <span>
تعديل خبر
                                </span>
                        </div>

                        <div class="add-news-form">
                            <form method="post" action="{{ route('news.update', $news->id) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="col-md-12">
                                    <label for="target" class="form-label">
                                        عنوان الخبر
                                    </label>
                                    <input type="text" class="form-control" name="news_title" value="{{ $news->news_title }}" required>
                                </div>

                                <div class="col-md-12">
                                    <label for="Standards" class="form-label">
                                        المحتوى المختصر
                                    </label>
                                    <input type="text" class="form-control" name="short_description" value="{{ $news->short_description }}" required>

                                </div>

                                <label for="">
                                    المحتوى الكامل
                                </label>
                                <div class="form-floating">
                                    <textarea rows="10" class="form-control" required name="long_description" placeholder="Leave a comment here" id="floatingTextarea2">
                                         {{ $news->long_description }}
                                    </textarea>
                                </div>

                                <div class="col-md-12">
                                    <label for="Standards" class="form-label">
                                        تغيير الصور
                                    </label>
                                    <input type="file" accept="image/png, image/jpeg" name="news_image" id="image" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label for="example-text-input" class="col-sm-3 col-form-label"></label>
                                    <img id="showImage" class="rounded avatar-lg"
                                         src="{{ (!empty($news->news_image))? url( $news->news_image):url('images/no_image.jpg') }}" alt="Card image cap" height="80" width="80">
                                </div>

                                <div class="col-12 text-center mt-5">
                                    <button type="submit" class="btn btn-dark px-5">
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


    <script type="text/javascript">

        $(document).ready(function() {
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });

    </script>
@endsection
