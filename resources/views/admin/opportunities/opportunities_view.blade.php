@extends('admin.admin_master')
@section('title')
    nusuk | نٌسكـ (إدارة الفرص القطاعية)
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
                                <a href="{{ route('sectoral.opportunities', $item->id) }}" class="sidebar-link text-center {{ $item->id == $id ? 'active' : '' }}">
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
                <form method="POST" action="{{ route('opportunity.bulkAction') }}">
                    @csrf

                    <div class="container-fluid ">
                    <div class="row">
                        <div class="section-header col-md-12">
                                <span>
                                    {{ $opportunity->opportunity_name }}
                                </span>
                        </div>
                        @if(Session::has('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{ session::get('error') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="oppo-controls col-md-12 my-2">
                            <button type="button" class="btn btn-black bg-opacity-50 px-3 text-white" style="background-color: #b49164;">
                                <a href="{{ route('add.opportunity', $id) }}">
                                    إضافة فرصة
                                </a>
                            </button>
                            <button type="submit" name="action" value="stop" class="btn btn-secondary bg-opacity-50 px-3 text-white">
                                تجميد
                            </button>
                            <button type="submit" name="action" value="active" class="btn btn-success bg-opacity-50 px-3 text-white">
                                تفعيل
                            </button>
                            <button  type="submit" name="action" value="delete" class="btn btn-danger bg-opacity-25 px-3 text-white">
                                حذف
                            </button>
                        </div>
                        <div class="oppo-filter col-md-12 my-3">
                            <span>عرض الفرص:</span>

                            <span>
                                <input class="form-check-input" type="checkbox" value="all" id="oppo-all">
                                <label class="form-check-label" for="oppo-all">الكل</label>
                            </span>
                            <span>
                                <input class="form-check-input" type="checkbox" value="open" id="oppo-open">
                                <label class="form-check-label" for="oppo-open">باب الترشُّح مفتوح</label>
                            </span>
                            <span>
                                <input class="form-check-input" type="checkbox" value="close" id="oppo-close">
                                <label class="form-check-label" for="oppo-close">باب الترشُّح مغلق</label>
                            </span>
                            <span>
                                <input class="form-check-input" type="checkbox" value="pending" id="oppo-pend">
                                <label class="form-check-label" for="oppo-pend">الفرصة مجمدة حتى إشعار آخر</label>
                            </span>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">العنوان</th>
                        <th scope="col">الجهة</th>
                        <th scope="col">آخر موعد للتقديم</th>
                        <th scope="col">حالة الفرصة</th>
                        <th scope="col">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody id="opportunities-table">
                    @foreach($data as $opportunity)
                        @php
                            $status = App\Models\OpportunityStatus::where('id', $opportunity->status_id)->first();
                        @endphp
                        <tr data-status="{{ $status->id }}">
                            <th>
                                <input type="checkbox" class="form-check-input" name="opportunity_id[]" value="{{ $opportunity->id }}">
                            </th>
                            <td>{{ $opportunity->title }}</td>
                            <td>{{ $opportunity->side }}</td>
                            <td>{{ $opportunity->deadline_apply }}</td>
                            <td>{{ $status->value }}</td>
                            <td>
                                <button type="button" class="btn btn-black">
                                    <a class="text-white" href="{{ route('opportunity.eye', $opportunity->id) }}">عرض</a>
                                </button>
                                <button type="button" class="btn btn-black">
                                    <a class="text-white" href="{{ route('opportunity.report', $opportunity->id) }}">التقرير</a>
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allCheckbox = document.getElementById('oppo-all');
            const openCheckbox = document.getElementById('oppo-open');
            const closeCheckbox = document.getElementById('oppo-close');
            const pendingCheckbox = document.getElementById('oppo-pend');
            const rows = document.querySelectorAll('#opportunities-table tr');

            allCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    rows.forEach(row => row.style.display = '');
                    openCheckbox.checked = closeCheckbox.checked = pendingCheckbox.checked = false;
                }
            });

            openCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    rows.forEach(row => {
                        row.style.display = row.getAttribute('data-status') == '1' ? '' : 'none';
                    });
                    allCheckbox.checked = closeCheckbox.checked = pendingCheckbox.checked = false;
                }
            });

            closeCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    rows.forEach(row => {
                        row.style.display = row.getAttribute('data-status') == '2' ? '' : 'none';
                    });
                    allCheckbox.checked = openCheckbox.checked = pendingCheckbox.checked = false;
                }
            });

            pendingCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    rows.forEach(row => {
                        row.style.display = row.getAttribute('data-status') == '3' ? '' : 'none';
                    });
                    allCheckbox.checked = openCheckbox.checked = closeCheckbox.checked = false;
                }
            });
        });
    </script>
@endsection
