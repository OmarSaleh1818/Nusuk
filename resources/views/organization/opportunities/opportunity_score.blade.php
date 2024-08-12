@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (نتيجة الاختبار التأهيلي)
@endsection
@section('main')

    <div class="wrapper">
        <!-- ================ Sidebar =============== -->
        <aside id="sidebar">
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
                                    <a href="{{ route('organization.opportunity', $item->id) }}" class="sidebar-link text-center {{ $item->id == $add->id ? 'active' : '' }}">
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

                <!-- ====== Start oppor section ======= -->
                <div class="row">
                    <div class="col-md-12 order-md-1">
                        @if(Session::has('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{ session::get('error') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col text-center">
                                <h3>نتيجة الاختبار التأهيلي</h3>
                            </div>
                        </div>
                        <hr>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <label>عنوان الفرصة</label>
                                <input type="text" name="title" value="{{ $opportunity->title }}" class="form-control" readonly>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <label style="margin-left: 20px">النتيجة</label>
                                <label style="margin-left: 10px">العلامة التقييمية</label>
                                @if(Auth::user()->user_permission == 1)
                                    <input type="text" name="" readonly class="form-control" value="{{ $score->evaluation_score }}" style="margin-left: 15px">
                                @else
                                    <input type="text" name="" readonly class="form-control" value="{{ $organization_score->evaluation_score }}" style="margin-left: 15px">
                                @endif
                                <label style="margin-left: 10px">النسبة المئوية</label>
                                @if(Auth::user()->user_permission == 1)
                                    <input type="text" name="" readonly class="form-control" value="{{ $score->total_percentage }} %">
                                @else
                                    <input type="text" name="" readonly class="form-control" value="{{ $organization_score->total_percentage }} %">
                                @endif
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <label style="margin-left: 20px">التأهل للفرصة</label>
                                @if(Auth::user()->user_permission == 1)
                                    @if($score->total_percentage >= $opportunity->percentage)
                                        <input type="text" name="" class="form-control" value="منظمتكم متأهلة" readonly>
                                    @else
                                        <input type="text" name="" class="form-control" value="للأسف منظمتك غير متأهلة" readonly>
                                    @endif
                                @else
                                    @if($organization_score->total_percentage >= $opportunity->percentage)
                                        <input type="text" name="" class="form-control" value="منظمتكم متأهلة" readonly>
                                    @else
                                        <input type="text" name="" class="form-control" value="للأسف منظمتك غير متأهلة" readonly>
                                    @endif
                                @endif

                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <label style="margin-left: 20px">الأسباب</label>
                                @if(Auth::user()->user_permission == 1)
                                    @if($score->total_percentage >= $opportunity->percentage)
                                        <textarea  class="form-control"  readonly>
                                            •	تلبية متطلبات الحد الأدنى من العلامة التقييمية
                                            •	النجاح في تخطّي جميع المعايير الحاسمة
                                        </textarea>
                                    @else
                                        <textarea  class="form-control"  readonly>
                                           •	عدم تلبية المعايير الحاسمة للقرار
                                           •	عدم تجميع الحد الأدنى من الحصيلة النقطية اللازم
                                        </textarea>
                                    @endif
                                @else
                                    @if($organization_score->total_percentage >= $opportunity->percentage)
                                        <textarea  class="form-control"  readonly>
                                            •	تلبية متطلبات الحد الأدنى من العلامة التقييمية
                                            •	النجاح في تخطّي جميع المعايير الحاسمة
                                        </textarea>
                                    @else
                                        <textarea  class="form-control"  readonly>
                                           •	عدم تلبية المعايير الحاسمة للقرار
                                           •	عدم تجميع الحد الأدنى من الحصيلة النقطية اللازم
                                        </textarea>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <p>ملاحظة: كون المنظمة مؤهلة لا يعني بالضرورة ارتباطها بالفرصة قبل مراجعة التقرير الجمعي الذي يضم جميع المنظمات المتقدّمة، فقد يكتفي متّخذ القرار بعدد محدد من المنظمات غير الربحية المشاركة، واستبعاد بعض من المنظمات المؤهلة كما يلزم.</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>



@endsection
