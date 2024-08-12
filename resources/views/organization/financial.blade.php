@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (بيانات الواقع المالي)
@endsection
@section('main')
    <div class="wrapper">
        <!-- ================ Sidebar =============== -->
        <aside id="sidebar" class="collapsed">
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
                                    <a href="{{ route('organization.opportunity', $item->id) }}" class="sidebar-link text-center">
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
                <section class="list-opp">
                    <div dir="rtl">
                        @if(Session::has('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{ session::get('error') }}</strong> .
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="post" action="{{ route('financial.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col text-center">
                                    <h3> بيانات الواقع المالي </h3>
                                </div>
                            </div>
                            <hr>
                            <br>
                            <br>
                            <div id="financialSection1">
                                <div class="row" >
                                    <div class="col-md-8" style="border-left: 1px solid #444444">
                                        <h5 style="color: #b49164;">إجمالي الإيرادات السنوية (بالريال) </h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 style="color: #b49164;">إجمالي النفقات والمصاريف السنوية (بالريال) </h5>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label ">المنح المتحصلة من القطاع العام</label>
                                            <input type="number" class="form-control text-center" name="public_sector"
                                                   value="{{ $financial ? $financial->public_sector : '' }}" id="public_sector">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="border-left: 1px solid #444444">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">مداخيل برنامج التخصيص والإسناد</label>
                                            <input type="number" class="form-control text-center" name="personalization_assignment"
                                                   value="{{ $financial ? $financial->personalization_assignment : '' }}" id="personalization_assignment">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الإنفاق الاجتماعي الموجه لقطاع خدمة ضيوف الرحمن</label>
                                            <input type="number" class="form-control text-center" name="services_sector"
                                                   value="{{ $financial ? $financial->services_sector : '' }}" id="services_sector">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">المنح المتحصلة من القطاع غير الربحي</label>
                                            <input type="number" class="form-control text-center" name="nonprofit_sector"
                                                   value="{{ $financial ? $financial->nonprofit_sector : '' }}" id="nonprofit_sector">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="border-left: 1px solid #444444">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">عوائد محفظة الاستثمار "التجاري والنقدي" الخاصة بالمنظمة</label>
                                            <input type="number" class="form-control text-center" name="commercial_monetary"
                                                   value="{{ $financial ? $financial->commercial_monetary : '' }}" id="commercial_monetary">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الإنفاق الاجتماعي الموجه للقطاعات الأخرى</label>
                                            <input type="number" class="form-control text-center" name="others_sector"
                                                   value="{{ $financial ? $financial->others_sector : '' }}" id="others_sector">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">المنح المتحصلة من القطاع الخاص</label>
                                            <input type="number" class="form-control text-center" name="private_sector"
                                                   value="{{ $financial ? $financial->private_sector : '' }}" id="private_sector">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="border-left: 1px solid #444444">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">عوائد محفظة الاستثمار "الاجتماعي" الخاصة بالمنظمة</label>
                                            <input type="number" class="form-control text-center" name="social"
                                                   value="{{ $financial ? $financial->social : '' }}" id="social">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">المصاريف العمومية والإدارية</label>
                                            <input type="number" class="form-control text-center" name="general_expenses"
                                                   value="{{ $financial ? $financial->general_expenses : '' }}" id="general_expenses">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">التبرعات المتحصلة من الأفراد</label>
                                            <input type="number" class="form-control text-center" name="donations"
                                                   value="{{ $financial ? $financial->donations : '' }}" id="donations">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="border-left: 1px solid #444444">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">ريْع المحفظة الوقفية الخاصة بالمنظمة</label>
                                            <input type="number" class="form-control text-center" name="endowment_wallet"
                                                   value="{{ $financial ? $financial->endowment_wallet : '' }}" id="endowment_wallet">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">مصاريف التسويق</label>
                                            <input type="number" class="form-control text-center" name="marketing_expenses"
                                                   value="{{ $financial ? $financial->marketing_expenses : '' }}" id="marketing_expenses">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">مداخيل التشغيل الذاتي للمنظمة</label>
                                            <input type="number" class="form-control text-center" name="self_employment"
                                                   value="{{ $financial ? $financial->self_employment : '' }}" id="self_employment">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="border-left: 1px solid #444444">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">القروض المستلمة</label>
                                            <input type="number" class="form-control text-center" name="loans_received"
                                                   value="{{ $financial ? $financial->loans_received : '' }}" id="loans_received">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">المصاريف الموجهة لمحافظ الاستثمار والأوقاف الخاصة بالمنظمة</label>
                                            <input type="number" class="form-control text-center" name="directed_expenses"
                                                   value="{{ $financial ? $financial->directed_expenses : '' }}" id="directed_expenses">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">

                                    </div>
                                    <div class="col-md-4" style="border-left: 1px solid #444444">

                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">مصاريف الاقتراض وسداد الديون</label>
                                            <input type="number" class="form-control text-center" name="borrowing_paying"
                                                   value="{{ $financial ? $financial->borrowing_paying : '' }}" id="borrowing_paying">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="next">التالي</button>
                                </div>
                            </div>
                            <div id="financialSection2" style="display:none;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 style="color: #b49164;">إجمالي الإنفاق الاجتماعي الموجه لقطاع خدمة ضيوف الرحمن (بالريال) – بحسب مجالات العمل</h5>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">التشويق والاستقطاب</label>
                                            <input type="number" class="form-control text-center" name="suspense_polarization"
                                                   value="{{ $financial ? $financial->suspense_polarization : '' }}" id="suspense_polarization">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">العناية بذوي الاحتياجات الخاصة (مثل كبار السن)</label>
                                            <input type="number" class="form-control text-center" name="special_needs"
                                                   value="{{ $financial ? $financial->special_needs : '' }}" id="special_needs">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الأنشطة في الأماكن العامة والسياحية</label>
                                            <input type="number" class="form-control text-center" name="public_places"
                                                   value="{{ $financial ? $financial->public_places : '' }}" id="public_places">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الترجمة</label>
                                            <input type="number" class="form-control text-center" name="translation"
                                                   value="{{ $financial ? $financial->translation : '' }}" id="translation">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">التوعية والتثقيف الاستباقي</label>
                                            <input type="number" class="form-control text-center" name="awareness_education"
                                                   value="{{ $financial ? $financial->awareness_education : '' }}" id="awareness_education">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">استقطاب المتطوعين</label>
                                            <input type="number" class="form-control text-center" name="attracting_volunteers"
                                                   value="{{ $financial ? $financial->attracting_volunteers : '' }}" id="attracting_volunteers">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">تنمية المشاريع الإنتاجية متناهية الصغر</label>
                                            <input type="number" class="form-control text-center" name="project_development"
                                                   value="{{ $financial ? $financial->project_development : '' }}" id="project_development">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">التطبيقات الذكية للضيوف</label>
                                            <input type="number" class="form-control text-center" name="smart_applications"
                                                   value="{{ $financial ? $financial->smart_applications : '' }}" id="smart_applications">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الاستقبال</label>
                                            <input type="number" class="form-control text-center" name="reception"
                                                   value="{{ $financial ? $financial->reception : '' }}" id="reception">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الرعاية الصحية</label>
                                            <input type="number" class="form-control text-center" name="health_care"
                                                   value="{{ $financial ? $financial->health_care : '' }}" id="health_care">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">تنمية القرى وصيانة المرافق وحماية البيئة</label>
                                            <input type="number" class="form-control text-center" name="village_development"
                                                   value="{{ $financial ? $financial->village_development : '' }}" id="village_development">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">مرافق التفاعل الاجتماعي المجهزة والمخدومة</label>
                                            <input type="number" class="form-control text-center" name="interaction_facilities"
                                                   value="{{ $financial ? $financial->interaction_facilities : '' }}" id="interaction_facilities">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">التوديع وتوزيع التذكارات</label>
                                            <input type="number" class="form-control text-center" name="farewell_distribution"
                                                   value="{{ $financial ? $financial->farewell_distribution : '' }}" id="farewell_distribution">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الأمن والسلامة العامة</label>
                                            <input type="number" class="form-control text-center" name="security_safety"
                                                   value="{{ $financial ? $financial->security_safety : '' }}" id="security_safety">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">المساهمة الإعلامية وإطلاق الفعاليات الهادفة</label>
                                            <input type="number" class="form-control text-center" name="media_contribution"
                                                   value="{{ $financial ? $financial->media_contribution : '' }}" id="media_contribution">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الريادة والابتكار</label>
                                            <input type="number" class="form-control text-center" name="leadership_innovation"
                                                   value="{{ $financial ? $financial->leadership_innovation : '' }}" id="leadership_innovation">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">النقل</label>
                                            <input type="number" class="form-control text-center" name="transport"
                                                   value="{{ $financial ? $financial->transport : '' }}" id="transport">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">المساعدات النقدية غير المباشرة</label>
                                            <input type="number" class="form-control text-center" name="cash_assistance"
                                                   value="{{ $financial ? $financial->cash_assistance : '' }}" id="cash_assistance">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الدعوة والإرشاد وتوعية الجاليات</label>
                                            <input type="number" class="form-control text-center" name="advocacy_guidance"
                                                   value="{{ $financial ? $financial->advocacy_guidance : '' }}" id="advocacy_guidance">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الدراسات والأبحاث</label>
                                            <input type="number" class="form-control text-center" name="studies_research"
                                                   value="{{ $financial ? $financial->studies_research : '' }}" id="studies_research">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الحجوزات والتسهيلات والتوجيهات</label>
                                            <input type="number" class="form-control text-center" name="reservations_facilities"
                                                   value="{{ $financial ? $financial->reservations_facilities : '' }}" id="reservations_facilities">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">المساعدات العينية</label>
                                            <input type="number" class="form-control text-center" name="eye_assistance"
                                                   value="{{ $financial ? $financial->eye_assistance : '' }}" id="eye_assistance">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">العناية بالأطفال</label>
                                            <input type="number" class="form-control text-center" name="child_care"
                                                   value="{{ $financial ? $financial->child_care : '' }}" id="child_care">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">التأهيل والتدريب القطاعي</label>
                                            <input type="number" class="form-control text-center" name="qualification_training"
                                                   value="{{ $financial ? $financial->qualification_training : '' }}" id="qualification_training">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">خدمات ضيوف الرحمن الأساسية</label>
                                            <input type="number" class="form-control text-center" name="basic_services"
                                                   value="{{ $financial ? $financial->basic_services : '' }}" id="basic_services">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الإطعام والسقاية، وحفظ الطعام</label>
                                            <input type="number" class="form-control text-center" name="feeding_watering"
                                                   value="{{ $financial ? $financial->feeding_watering : '' }}" id="feeding_watering">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center" style="gap: 1rem;">
                                    <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="next1">التالي</button>
                                    <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="previous">السابق</button>
                                </div>
                            </div>
                            <div id="financialSection3" style="display: none">
                                <div class="row">
                                    <div class="co-md-12">
                                        <h5 style="color: #b49164;">إجمالي الإنفاق الاجتماعي الموجه لقطاع خدمة ضيوف الرحمن (بالريال) – بحسب إطار تنفيذ العمل</h5>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">تقديم الخدمات الموسمية والمستمرة على مدار العام</label>
                                            <input type="number" class="form-control text-center" name="seasonal_services"
                                                   value="{{ $financial ? $financial->seasonal_services : '' }}" id="seasonal_services">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">تأسيس المبادرات (ذوات تاريخ البداية والنهاية) وتشغيلها</label>
                                            <input type="number" class="form-control text-center" name="establishing_initiatives"
                                                   value="{{ $financial ? $financial->establishing_initiatives : '' }}" id="establishing_initiatives">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">تنظيم الفعاليات وتشغيلها</label>
                                            <input type="number" class="form-control text-center" name="organizing_events"
                                                   value="{{ $financial ? $financial->organizing_events : '' }}" id="organizing_events">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 style="color: #b49164;">إجمالي الإنفاق الاجتماعي الموجه لقطاع خدمة ضيوف الرحمن (بالريال) – بحسب الجهة المنتفعة استراتيجيا من الأثر المتحقق</h5>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">وزارة الحج والعمرة</label>
                                            <input type="number" class="form-control text-center" name="ministry_hajj"
                                                   value="{{ $financial ? $financial->ministry_hajj : '' }}" id="ministry_hajj">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">وزارة الشؤون البلدية والقروية</label>
                                            <input type="number" class="form-control text-center" name="ministry_municipal_affairs"
                                                   value="{{ $financial ? $financial->ministry_municipal_affairs : '' }}" id="ministry_municipal_affairs">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">وزارة النقل والخدمات اللوجستية، والهيئة العامة للطيران المدني، والهيئة العامة للنقل، والهيئة العامة للموانئ</label>
                                            <input type="number" class="form-control text-center" name="ministry_transportation"
                                                   value="{{ $financial ? $financial->ministry_transportation : '' }}" id="ministry_transportation">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">وزارة الموارد البشرية والتنمية الاجتماعية</label>
                                            <input type="number" class="form-control text-center" name="ministry_hr"
                                                   value="{{ $financial ? $financial->ministry_hr : '' }}" id="ministry_hr">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">وزارة السياحة، والهيئة السعودية للسياحة</label>
                                            <input type="number" class="form-control text-center" name="ministry_tourism"
                                                   value="{{ $financial ? $financial->ministry_tourism : '' }}" id="ministry_tourism">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">هيئة تطوير منطقة مكة المكرمة، وهيئة تطوير منطقة المدينة المنورة</label>
                                            <input type="number" class="form-control text-center" name="Development_authority"
                                                   value="{{ $financial ? $financial->Development_authority : '' }}" id="Development_authority">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">وزارة الداخلية</label>
                                            <input type="number" class="form-control text-center" name="ministry_interior"
                                                   value="{{ $financial ? $financial->ministry_interior : '' }}" id="ministry_interior">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">وزارة الإعلام</label>
                                            <input type="number" class="form-control text-center" name="ministry_media"
                                                   value="{{ $financial ? $financial->ministry_media : '' }}" id="ministry_media">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الرئاسة العامة لشؤون المسجد الحرام والمسجد النبوي</label>
                                            <input type="number" class="form-control text-center" name="general_presidency"
                                                   value="{{ $financial ? $financial->general_presidency : '' }}" id="general_presidency">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">وزارة الخارجية</label>
                                            <input type="number" class="form-control text-center" name="ministry_external"
                                                   value="{{ $financial ? $financial->ministry_external : '' }}" id="ministry_external">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">وزارة الصحة</label>
                                            <input type="number" class="form-control text-center" name="ministry_health"
                                                   value="{{ $financial ? $financial->ministry_health : '' }}" id="ministry_health">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">الهيئة الملكية لمدينة مكة المكرمة والمشاعر المقدسة</label>
                                            <input type="number" class="form-control text-center" name="royal_commission"
                                                   value="{{ $financial ? $financial->royal_commission : '' }}" id="royal_commission">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center" style="gap: 1rem;">
                                    <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="next2">التالي</button>
                                    <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="previous1">السابق</button>
                                </div>
                            </div>
                            <div id="financialSection4" style="display: none">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 style="color: #b49164;">إجمالي الممتلكات (بالريال):</h5>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">القيمة الدفترية للأصول الثابتة المملوكة من قبل المنظمة</label>
                                            <input type="number" class="form-control text-center" name="fixed_assets"
                                                   value="{{ $financial ? $financial->fixed_assets : '' }}" id="fixed_assets">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">القيمة الدفترية للمحفظة الاستثمارية الخاصة بالمنظمة</label>
                                            <input type="number" class="form-control text-center" name="investment_wallet"
                                                   value="{{ $financial ? $financial->investment_wallet : '' }}" id="investment_wallet">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">القيمة الدفترية للمحفظة الوقفية الخاصة بالمنظمة</label>
                                            <input type="number" class="form-control text-center" name="book_endowment_wallet"
                                                   value="{{ $financial ? $financial->book_endowment_wallet : '' }}" id="book_endowment_wallet">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 style="color: #b49164;">إجمالي المحفظة الاستثمارية (بالريال):</h5>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">القيمة الدفترية للاستثمار الموجه لصندوق جمعيات ضيوف الرحمن الوقفي</label>
                                            <input type="number" class="form-control text-center" name="association_fund"
                                                   value="{{ $financial ? $financial->association_fund : '' }}" id="association_fund">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">القيمة الدفترية للاستثمار المباشر في الأسهم والأوراق المالية</label>
                                            <input type="number" class="form-control text-center" name="stocks_securities"
                                                   value="{{ $financial ? $financial->stocks_securities : '' }}" id="stocks_securities">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">القيمة الدفترية للاستثمارات الأخرى</label>
                                            <input type="number" class="form-control text-center" name="other_investments"
                                                   value="{{ $financial ? $financial->other_investments : '' }}" id="other_investments">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">القيمة الدفترية للاستثمارات الاجتماعية</label>
                                            <input type="number" class="form-control text-center" name="social_investments"
                                                   value="{{ $financial ? $financial->social_investments : '' }}" id="social_investments">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">القيمة الدفترية للاستثمار الموجه لشركات إدارة المحافظ الاستثمارية والأصول، وصناديق الاستثمار المشتركة الأخرى</label>
                                            <input type="number" class="form-control text-center" name="investment_portfolio_management"
                                                   value="{{ $financial ? $financial->investment_portfolio_management : '' }}" id="investment_portfolio_management">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 style="color: #b49164;">إجمالي الأجور السنوية المدفوعة للعاملين (بالريال السعودي)، شاملا الرواتب الأساسية، وجميع البدلات (مثل بدل السكن والمواصلات)، وجميع المزايا الوظيفية (مثل التأمينات الاجتماعية والصحية)، والحوافز (أي المكافآت):</h5>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">مجموع الأجور السنوية المدفوعة للمدير التنفيذي أو الأمين العام</label>
                                            <input type="number" class="form-control text-center" name="paid_CEO"
                                                   value="{{ $financial ? $financial->paid_CEO : '' }}" id="paid_CEO">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">مجموع الأجور السنوية المدفوعة لبقية العاملين دون المدير التنفيذي/الأمين العام</label>
                                            <input type="number" class="form-control text-center" name="paid_employee"
                                                   value="{{ $financial ? $financial->paid_employee : '' }}" id="paid_employee">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center" style="gap: 1rem;">
                                    <button class="btn btn-dark text-white" style="background-color: #b49164;" type="submit">حفظ</button>
                                    <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="previous2">السابق</button>
                                </div>
                            </div>
                        </form>
                    </div>


                </section>

            </div>


        </div>
    </div>

    <script>
        document.getElementById('next').addEventListener('click', function() {
            document.getElementById('financialSection1').style.display = 'none';
            document.getElementById('financialSection2').style.display = 'block';
        });

        document.getElementById('previous').addEventListener('click', function() {
            document.getElementById('financialSection1').style.display = 'block';
            document.getElementById('financialSection2').style.display = 'none';
        });

        document.getElementById('next1').addEventListener('click', function() {
            document.getElementById('financialSection2').style.display = 'none';
            document.getElementById('financialSection3').style.display = 'block';
        });

        document.getElementById('previous1').addEventListener('click', function() {
            document.getElementById('financialSection2').style.display = 'block';
            document.getElementById('financialSection3').style.display = 'none';
        });

        document.getElementById('next2').addEventListener('click', function() {
            document.getElementById('financialSection3').style.display = 'none';
            document.getElementById('financialSection4').style.display = 'block';
        });

        document.getElementById('previous2').addEventListener('click', function() {
            document.getElementById('financialSection3').style.display = 'block';
            document.getElementById('financialSection4').style.display = 'none';
        });
    </script>


@endsection
