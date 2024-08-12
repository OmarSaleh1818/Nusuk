@extends('admin.admin_master')
@section('title')
    nusuk | نٌسكـ (إدار الأخبار)
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
                                    إدارة الأخبار
                                </span>
                        </div>
                        <div class="oppo-controls col-md-12 my-2">
                            <button type="button" class="btn btn-success bg-opacity-50 m-1 px-3">
                                <a href="{{ route('news.add') }}">
                                    إضافة خبر جديد
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
                        <th scope="col">عنوان الخبر</th>
                        <th scope="col">الصورة</th>
                        <th scope="col">
                            حالة الخبر
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($news as $key => $item)
                        <tr>
                            <th>{{ $key+1 }}</th>
                            <td>{{ $item->news_title }}</td>
                            <td>
                                <img src="{{ asset($item->news_image) }}" height="50" width="50">
                            </td>
                            <td>
                                @if($item->status_id == 2)
                                    <a href="{{ route('news.show', $item->id) }}" class="btn btn-secondary btn-sm">مخفي</a>
                                @elseif($item->status_id == 1)
                                    <a href="{{ route('news.hide', $item->id) }}" class="btn btn-success btn-sm">منشور</a>
                                @endif
                                <a href="{{ route('news.edit', $item->id) }}" class="btn btn-info btn-sm">تعديل</a>
                                <a href="{{ route('news.delete', $item->id) }}" class="btn btn-danger btn-sm" id="delete">حذف</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </section>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function(){
            $(document).on('click', '#delete', function(e){
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete This Data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link;
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                    }
                });
            });
        });
    </script>


@endsection
