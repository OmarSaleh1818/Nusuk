@extends('admin.admin_master')
@section('title')
    nusuk | نٌسكـ (إدارة المنظمات)
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
                <form method="POST" action="{{ route('user.bulkAction') }}">
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
                                    إدارة المنظمات
                                </span>
                        </div>
                        <div class="oppo-controls col-md-12 my-2">
                            <button type="submit" name="action" value="active" class="btn btn-success bg-opacity-50 m-1 px-3 text-white">
                                تفعيل
                            </button>
                            <button type="submit" name="action" value="stop" class="btn btn-secondary bg-opacity-50 m-1 px-3 text-white">
                                إيقاف
                            </button>
                            <button type="submit" name="action" value="delete" class="btn btn-danger bg-opacity-25 m-1 px-3 text-white">
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
                            اسم المنظمة
                        </th>
                        <th scope="col">
                            الاسم
                        </th>
                        <th scope="col">
                            الجوال
                        </th>
                        <th scope="col">
                            اسم المستخدم
                        </th>
                        <th scope="col">
                            الحالة
                        </th>
                        <th>

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key => $item)
                        <tr>
                            <th><input type="checkbox" class="form-check-input" name="user_id[]" value="{{ $item->id }}"></th>
                            <td>{{ $item->organization_name }}</td>
                            <td>
                                {{ $item->manager_name }}
                            </td>
                            <td>
                                {{ $item->contact_mobile }}
                            </td>
                            <td>
                                {{ $item->name }}
                            </td>
                            <td>
                                @if($item->status != 1)
                                    <button type="button" class="btn btn-secondary">موقوف</button>
                                @else
                                    <button type="button" class="btn btn-success">مفعل</button>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn user">
                                    <a class="text-white" href="{{ route('user.eye', $item->id) }}">
                                        عرض
                                    </a>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </form>
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
