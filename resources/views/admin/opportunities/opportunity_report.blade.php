@extends('admin.admin_master')
@section('title')
    nusuk | نٌسكـ (التقرير)
@endsection
@section('content')
    <aside id="sidebar" class="collapsed">
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
                                <a href="{{ route('sectoral.opportunities', $item->id) }}" class="sidebar-link text-center {{ $item->id == $opportunity->opportunity_id ? 'active' : '' }}">
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
            <section class="opp-report">
                <div class="container-fluid">
                    @if(Session::has('error'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ session::get('error') }}</strong> .
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="section-header col-md-12">

                            تقرير الفرص

                        </div>
                        <div class="oppo-form my-5">
                            <form class="row g-3">
                                <div class="col-md-4">
                                    <label for="heading" class="form-label">
                                        عنوان الفرصة
                                    </label>
                                    <input type="text" class="form-control" id="heading" value="{{ $opportunity->title }}" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label for="status" class="form-label">
                                        حالة الفرصة
                                    </label>
                                    <input type="text" class="form-control" id="status" value="{{ $status->value }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="time" class="form-label">
                                        التاريخ
                                    </label>
                                    <input type="datetime-local" class="form-control" id="time" value="{{ $opportunity->created_at }}" readonly>
                                </div>

                            </form>
                        </div>
                        <hr>
                        <div class="opp-statistics row my-3">
                            <h5>‌أ) واقع النافذة الزمنية للتقديم للفرصة</h5>
                            <div class="col-md-8">

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">تاريخ بداية النافذة الزمنية للتقديم</th>
                                        <th scope="col">تاريخ نهاية النافذة الزمنية للتقديم</th>
                                        <th scope="col">حجم النافذة الزمنية للتقديم (بالأيام)</th>
                                        <th scope="col">عدد الأيام المنقضية</th>
                                        <th scope="col">عدد الأيام المتبقية قبل إغلاق الفرصة</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" name="date_from" id="date_from" class="form-control" value="{{ $opportunity->date_from }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="date_to" id="date_to" class="form-control" value="{{ $opportunity->date_to }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="days" id="days" class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="elapsed_days" id="elapsed_days" class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="remaining_days" id="remaining_days" class="form-control" readonly>
                                        </td>
                                    </tr>
                                    </tbody>

                                    <tfoot>
                                        <td colspan="3">
                                            <label>النسبة المئوية من الإجمالي</label>
                                        </td>
                                        <td>
                                            <input type="text" name="elapsed_percentage" id="elapsed_percentage" class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="remaining_percentage" id="remaining_percentage" class="form-control" readonly>

                                        </td>
                                    </tfoot>

                                </table>
                            </div>

                            <div class="col-md-4 static-image">
                                <canvas id="myChart1" height="150vh"></canvas>
                            </div>
                        </div>

                        <hr>
                        <div class="opp-statistics row my-3">
                            <h5>‌ب) واقع المنظمات المؤهلة</h5>
                            <div class="col-md-8">

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col"> عدد المنظمات المشتركة في المنصة </th>
                                        <th scope="col"> عدد المنظمات العازفة عن التقديم </th>
                                        <th scope="col"> عدد المنظمات المتقدمة </th>
                                        <th scope="col"> عدد المنظمات المؤهلة </th>
                                        <th scope="col"> عدد المنظمات غير المؤهلة </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" name="users" class="form-control" value="{{ $users }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="usersNotInCount" class="form-control" value="{{ $usersNotInCount }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="usersInCount" value="{{ $usersInCount }}" class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="userQualificationCount" value="{{ $userQualificationCount}}"  class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="userNotQualificationCount" value="{{ $userNotQualificationCount }}" class="form-control" readonly>
                                        </td>
                                    </tr>
                                    </tbody>

                                    <tfoot>
                                    <td>
                                        النسبة المئوية من الإجمالي
                                    </td>
                                    <td>
                                        <input type="text" name="notInCount" class="form-control" id="notInCount" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="inCount" id="inCount" class="form-control" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="qualificationCount" id="qualificationCount"  class="form-control" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="notQualificationCount" id="notQualificationCount" class="form-control" readonly>
                                    </td>
                                    </tfoot>

                                </table>
                            </div>

                            <div class="col-md-4 ">
                                <div class="row">
                                    <div class="col-md-6 static-chart">
                                        <canvas id="myChart3"></canvas>
                                    </div>
                                    <div class="col-md-6 static-chart">
                                        <canvas id="myChart2"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="opp-statistics row my-3">
                            <h5>‌ج) ‌واقع استقطاب المنظمات غير الربحية نحو الفرصة</h5>
                            <div class="col-md-8">

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col"> عدد المنظمات المرغوبة (إن وجد) </th>
                                        <th scope="col"> عدد المنظمات المؤهلة </th>
                                        <th scope="col"> عدد المنظمات المتبقية التي ينبغي العمل على استقطابها </th>
                                        <th scope="col"> عدد المنظمات المؤهلة التي ينبغي استبعادها </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td> {{ $opportunity->organization_number }}</td>
                                        <td> {{ $userQualificationCount }}</td>
                                        <td>
                                            @php
                                                $difference = $opportunity->organization_number - $userQualificationCount;
                                            @endphp
                                            {{ $difference < 0 ? 0 : $difference }}
                                        </td>
                                        <td>
                                            @php
                                                $loremValue = $userQualificationCount > $opportunity->organization_number ? $userQualificationCount : '0';
                                            @endphp
                                            {{ $loremValue }}
                                        </td>
                                    </tr>

                                    </tbody>

                                </table>
                            </div>


                        </div>
                        <hr>
                        <div class="opp-statistics row my-3">
                            <h5>د) قائمة المنظمات غير الربحية المؤهلة للفرصة</h5>
                            <div class="col-md-12">

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th rowspan="2" > م </th>
                                        <th rowspan="2"> اسم المنظمة </th>
                                        <th rowspan="2"> المحافظة التي يتواجد فيها المقر الرئيس </th>
                                        <th colspan="3"> بيانات ضابط الارتباط </th>
                                        <th colspan="2"> المحصلة النقطية</th>
                                        <th rowspan="2"> موافقة مسؤول المنصة على النتيجة من الناحية التقنية (المرحلة الأولى)</th>
                                        <th rowspan="2"> موافقة مسؤول الفرصة على النتيجة من الناحية الفنية (المرحلة الثانية)</th>
                                    </tr>

                                    <tr>
                                        <th> الاسم </th>
                                        <th> الجوال </th>
                                        <th> البريد الالكتروني </th>
                                        <th>وفق وزن الأهمية النسبية (من 5.00)</th>
                                        <th>النسبة المئوية</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users_Qualification as $key => $item)
                                        @php
                                            $score = App\Models\OrganizationScore::where('user_id', $item->id)->where('opportunityData_id', $opportunity->id)->first();
                                        @endphp
                                        <tbody>
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->organization_name }}</td>
                                            <td>{{ $item->organization_region }}</td>
                                            <td>{{ $item->contact_name }}</td>
                                            <td>{{ $item->contact_mobile }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $score->evaluation_score }}</td>
                                            <td>{{ $score->total_percentage }} %</td>
                                            <td>
                                                @if(Auth::guard('admin')->user()->status == 0)
                                                    @if($score->status == 1)
                                                        <div class="d-flex justify-content-center" style="gap: 10px">
                                                            <a href="{{ route('admin.approve', $score->id) }}" class="btn btn-success btn-sm" id="delete"> موافق </a>
                                                            <a href="{{ route('admin.reevaluation' , $score->id) }}" class="btn btn-secondary btn-sm" id="delete"> إعادة التقييم </a>
                                                        </div>
                                                    @elseif($score->status == 3)
                                                        <button class="btn btn-success btn-sm"> تم طلب إعادة التقييم </button>
                                                    @else
                                                        <button class="btn btn-success btn-sm"> تمت الموافقة </button>
                                                    @endif
                                                @else
                                                    @if($score->status == 1)
                                                        في انتظار موافقة الادمن
                                                    @elseif($score->status == 3)
                                                        <button class="btn btn-success btn-sm"> تم طلب إعادة التقييم </button>
                                                    @else
                                                        <button class="btn btn-success btn-sm"> تمت الموافقة </button>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if(Auth::guard('admin')->user()->status == 1)
                                                    @if($score->status == 1)
                                                       في انتظار موافقة الادمن
                                                    @elseif($score->status == 2)
                                                        <a href="{{ route('super.approve' , $score->id) }}" class="btn btn-success btn-sm" id="delete"> موافق </a>
                                                        <a href="{{ route('super.notApprove', $score->id) }}" class="btn btn-secondary btn-sm" id="delete"> استبعاد </a>
                                                    @elseif($score->status == 4)
                                                        <button class="btn btn-success btn-sm"> تمت الموافقة </button>
                                                    @elseif($score->status == 5)
                                                        <button class="btn btn-danger btn-sm"> تم اسبتعاد المنظمة  </button>
                                                    @endif
                                                @else
                                                    @if($score->status == 4)
                                                        <button class="btn btn-success btn-sm"> تمت الموافقة </button>
                                                    @elseif($score->status == 5)
                                                        <button class="btn btn-danger btn-sm"> تم اسبتعاد المنظمة  </button>
                                                    @else
                                                        في الانتظار
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>


                        </div>

                        <hr>

                        <div class="opp-statistics row my-3">
                            <h5>هـ) قائمة المنظمات غير الربحية غير المؤهلة للفرصة </h5>
                            <div class="col-md-12">

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th rowspan="2" > م </th>
                                        <th rowspan="2"> اسم المنظمة </th>
                                        <th rowspan="2"> المحافظة التي يتواجد فيها المقر الرئيس </th>
                                        <th colspan="3"> بيانات ضابط الارتباط </th>
                                        <th colspan="2"> المحصلة النقطية</th>
                                        <th rowspan="2"> موافقة مسؤول المنصة على النتيجة من الناحية التقنية (المرحلة الأولى)</th>
                                        <th rowspan="2"> موافقة مسؤول الفرصة على النتيجة من الناحية الفنية (المرحلة الثانية)</th>
                                    </tr>

                                    <tr>
                                        <th> الاسم </th>
                                        <th> الجوال </th>
                                        <th> البريد الالكتروني </th>
                                        <th>وفق وزن الأهمية النسبية (من 5.00)</th>
                                        <th>النسبة المئوية</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users_NotQualification as $key => $item)
                                        @php
                                            $score = App\Models\OrganizationScore::where('user_id', $item->id)->where('opportunityData_id', $opportunity->id)->first();
                                        @endphp
                                        <tbody>
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->organization_name }}</td>
                                            <td>{{ $item->organization_region }}</td>
                                            <td>{{ $item->contact_name }}</td>
                                            <td>{{ $item->contact_mobile }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $score->evaluation_score }}</td>
                                            <td>{{ $score->total_percentage }} %</td>
                                            <td>
                                                @if(Auth::guard('admin')->user()->status == 0)
                                                    @if($score->status == 1)
                                                        <div class="d-flex justify-content-center" style="gap: 10px">
                                                            <a href="{{ route('admin.approve', $score->id) }}" class="btn btn-success btn-sm" id="delete"> موافق </a>
                                                            <a href="{{ route('admin.reevaluation' , $score->id) }}" class="btn btn-secondary btn-sm" id="delete"> إعادة التقييم </a>
                                                        </div>
                                                    @elseif($score->status == 3)
                                                        <button class="btn btn-success btn-sm"> تم طلب إعادة التقييم </button>
                                                    @else
                                                        <button class="btn btn-success btn-sm"> تمت الموافقة </button>
                                                    @endif
                                                @else
                                                    @if($score->status == 1)
                                                        في انتظار موافقة الادمن
                                                    @elseif($score->status == 3)
                                                        <button class="btn btn-success btn-sm"> تم طلب إعادة التقييم </button>
                                                    @else
                                                        <button class="btn btn-success btn-sm"> تمت الموافقة </button>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if(Auth::guard('admin')->user()->status == 1)
                                                    @if($score->status == 1)
                                                        في انتظار موافقة الادمن
                                                    @elseif($score->status == 2)
                                                        <a href="{{ route('super.approve' , $score->id) }}" class="btn btn-success btn-sm" id="delete"> استثناء </a>
                                                        <a href="{{ route('super.notApprove', $score->id) }}" class="btn btn-secondary btn-sm" id="delete"> استبعاد </a>
                                                    @elseif($score->status == 4)
                                                        <button class="btn btn-success btn-sm"> تمت الموافقة </button>
                                                    @elseif($score->status == 5)
                                                        <button class="btn btn-danger btn-sm"> تم اسبتعاد المنظمة  </button>
                                                    @endif
                                                @else
                                                    @if($score->status == 4)
                                                        <button class="btn btn-success btn-sm"> تمت الموافقة </button>
                                                    @elseif($score->status == 5)
                                                        <button class="btn btn-danger btn-sm"> تم اسبتعاد المنظمة  </button>
                                                    @else
                                                        في الانتظار
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>


                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the date values from the input fields
            const dateFrom = new Date(document.getElementById('date_from').value);
            const dateTo = new Date(document.getElementById('date_to').value);
            const today = new Date();

            // Calculate the difference in time
            const diffTime = dateTo - dateFrom;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            // Calculate elapsed days, ensuring it's within the range
            const elapsedDays = Math.min(Math.max(0, Math.ceil((today - dateFrom) / (1000 * 60 * 60 * 24))), diffDays);

            // Calculate remaining days, ensuring it's within the range
            const remainingDays = Math.min(Math.max(0, Math.ceil((dateTo - today) / (1000 * 60 * 60 * 24))), diffDays - elapsedDays);

            // Calculate percentages
            const elapsedPercentage = (elapsedDays / diffDays) * 100;
            const remainingPercentage = (remainingDays / diffDays) * 100;

            // Update the input fields with the calculated values
            document.getElementById('days').value = diffDays;
            document.getElementById('elapsed_days').value = elapsedDays;
            document.getElementById('remaining_days').value = remainingDays;
            document.getElementById('elapsed_percentage').value = elapsedPercentage.toFixed(2) + '%';
            document.getElementById('remaining_percentage').value = remainingPercentage.toFixed(2) + '%';

            // Create the first chart
            const ctx = document.getElementById('myChart1').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['الايام المتبقية قبل اغلاق الفرصة', 'الايام المنقضية'],
                    datasets: [{
                        label: '# of Days',
                        data: [remainingDays, elapsedDays],
                        borderWidth: 1,
                        backgroundColor: ['#3277a8', '#e85c0c']
                    }]
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

        $(document).ready(function() {
            // Fetch the values from the input fields in the tbody
            var users = parseInt($('input[name="users"]').val());
            var usersNotInCount = parseInt($('input[name="usersNotInCount"]').val());
            var usersInCount = parseInt($('input[name="usersInCount"]').val());
            var userQualificationCount = parseInt($('input[name="userQualificationCount"]').val());
            var userNotQualificationCount = parseInt($('input[name="userNotQualificationCount"]').val());

            // Calculate the percentages
            var notInCountPercentage = ((usersNotInCount / users) * 100).toFixed(2);
            var inCountPercentage = ((usersInCount / users) * 100).toFixed(2);
            var qualificationCountPercentage = ((userQualificationCount / users) * 100).toFixed(2);
            var notQualificationCountPercentage = ((userNotQualificationCount / users) * 100).toFixed(2);

            // Update the hidden input fields with the number and percentage concatenated
            $('#notInCount').val(notInCountPercentage + '%');
            $('#inCount').val(inCountPercentage + '%');
            $('#qualificationCount').val(qualificationCountPercentage + '%');
            $('#notQualificationCount').val(notQualificationCountPercentage + '%');

            // Create the second chart
            const ctx2 = document.getElementById('myChart2').getContext('2d');
            new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: [
                        `العازفة عن التقديم (${notInCountPercentage}%)`,
                        `المتقدمة (${inCountPercentage}%)`
                    ],
                    datasets: [{
                        label: '# of Users',
                        data: [usersNotInCount, usersInCount],
                        borderWidth: 1,
                        backgroundColor: ['#3277a8', '#d1e619']
                    }]
                }
            });

            // Create the third chart
            const ctx3 = document.getElementById('myChart3').getContext('2d');
            new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: [
                        `منظمات مؤهلة (${qualificationCountPercentage}%)`,
                        `منظمات غير مؤهلة (${notQualificationCountPercentage}%)`
                    ],
                    datasets: [{
                        label: '# of Organizations',
                        data: [userQualificationCount, userNotQualificationCount],
                        borderWidth: 1,
                        backgroundColor: ['#e85c0c', '#595553']
                    }]
                }
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function(){
            $(document).on('click', '#delete', function(e){
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'هل انت متأكد?',
                    text: "هل انت متأكد من طلبك ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link;
                        Swal.fire(
                            'تم!',
                            'تم تنفيظ طلبك بنجاح.',
                        );
                    }
                });
            });
        });
    </script>

@endsection
