@extends('admin.admin_master')
@section('title')
    nusuk | نٌسكـ (عرض  بيانات العاملين)
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
            <div class="container" dir="rtl">
                <div class="row">
                    <div class="col text-center">
                        <h3> العاملون </h3>
                    </div>
                </div>
                <hr>
                <br>
                <br>
                <div id="staffSection">
                    <div class="row">
                        <h6>أبرز ممثلي المنظمة :</h6>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered text-center">
                                <thead>
                                <tr>
                                    <th>البيان</th>
                                    <th>
                                        <h6>أعلى مسؤول غير تنفيذي</h6>
                                        <label style="font-size: 12px">(مثل رئيس مجلس الأمناء/ الإدارة)</label>
                                    </th>
                                    <th>
                                        <h6>أعلى مسؤول تنفيذي</h6>
                                        <label style="font-size: 12px">(مثل الأمين العام/ المدير العام/ المدير التنفيذي)</label>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>الاسم الأول</td>
                                    <td>
                                        <input type="text" name="name_notCeo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->name_notCeo : '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="name_ceo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->name_ceo : '' }}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>اسم العائلة</td>
                                    <td>
                                        <input type="text" name="family_notCeo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->family_notCeo : '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="family_ceo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->family_ceo : '' }}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>المنصب الوظيفي</td>
                                    <td>
                                        <input type="text" name="position_notCeo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->position_notCeo : '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="position_ceo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->position_ceo : '' }}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>السنة المالية للالتحاق بالمنصب</td>
                                    <td>
                                        <input type="text" name="year_notCeo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->year_notCeo : '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="year_ceo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->year_ceo : '' }}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>الجوال:</td>
                                    <td>
                                        <input type="text" name="mobile_notCeo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->mobile_notCeo : '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="mobile_ceo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->mobile_ceo : '' }}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>البريد الإلكتروني:</td>
                                    <td>
                                        <input type="text" name="email_notCeo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->email_notCeo : '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="email_ceo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->email_ceo : '' }}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>الارتباط:</td>
                                    <td>
                                        <input type="text" name="link_notCeo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->link_notCeo : '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="link_ceo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->link_ceo : '' }}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>الفئة العمرية:</td>
                                    <td>
                                        <input type="text" name="age_notCeo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->age_notCeo : '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="age_ceo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->age_ceo : '' }}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>المؤهل التعليمي الأعلى:</td>
                                    <td>
                                        <input type="text" name="education_notCeo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->education_notCeo : '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="education_ceo" class="form-control text-center" value="{{ $staffRepresent ? $staffRepresent->education_ceo : '' }}" readonly>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center" style="gap: 1rem;">
                        <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="next">التالي</button>
                    </div>
                </div>
                <div id="staffSection1" style="display: none">
                    <div class="row">
                        <h6>إجمالي عدد العاملين – بحسب المعلومات الديمغرافية:</h6>
                    </div>
                    <br>
                    <table class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th rowspan="2">الجنسية</th>
                            <th rowspan="2">الجنس</th>
                            <th rowspan="2">الفئة العمرية</th>
                            @foreach($contracts as $contract)
                                <th colspan="{{ count($regions) }}">{{ $contract->contract_name }}</th>
                            @endforeach
                            <th rowspan="2">المجموع</th>
                        </tr>
                        <tr>
                            @foreach($contracts as $contract)
                                @foreach($regions as $region)
                                    <th>{{ $region->region_name }}</th>
                                @endforeach
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @if($staffInformation)
                            @foreach($nationalities as $nationality)
                                @foreach($genders as $gender)
                                    @foreach($ages as $age)
                                        <tr>
                                            @if($loop->parent->first && $loop->first)
                                                <td rowspan="{{ count($genders) * count($ages) }}">{{ $nationality->nationality_name }}</td>
                                            @endif
                                            @if($loop->first)
                                                <td rowspan="{{ count($ages) }}">{{ $gender->gender_name }}</td>
                                            @endif
                                            <td>{{ $age->age_group }}</td>
                                            @foreach($contracts as $contract)
                                                @foreach($regions as $region)
                                                    @php
                                                        $existing = $staffInformation->where('nationality_id', $nationality->id)->where('gender_id', $gender->id)
                                                                    ->where('age_id', $age->id)->where('region_id', $region->id)->where('contract_id', $contract->id)
                                                                    ->first();
                                                    @endphp
                                                    <td>
                                                        <input type="number" name="number[{{ $nationality->id }}][{{ $gender->id }}][{{ $age->id }}][{{ $contract->id }}][{{ $region->id }}]"
                                                               class="form-control text-center contract-region-input" data-contract="{{ $contract->id }}" readonly data-region="{{ $region->id }}" oninput="calculateTotals()" value="{{ $existing->number ?? '' }}">
                                                    </td>
                                                @endforeach
                                            @endforeach
                                            <td>
                                                <input type="number" name="total_for_age[{{ $nationality->id }}][{{ $gender->id }}][{{ $age->id }}]" class="form-control text-center total-for-age" readonly>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3">المجموع</td>
                            @foreach($contracts as $contract)
                                @foreach($regions as $region)
                                    <td>
                                        <input type="number" class="form-control text-center total-for-contract-region" data-contract="{{ $contract->id }}" data-region="{{ $region->id }}" readonly>
                                    </td>
                                @endforeach
                            @endforeach
                            <td>
                                <input type="number" class="form-control text-center total-for-all" readonly>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="d-flex justify-content-center" style="gap: 1rem;">
                        <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="next0">التالي</button>
                        <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="previous0">السابق</button>
                    </div>
                </div>
                <div id="staffSection2" style="display: none">
                    <div class="row">
                        <h6>إجمالي عدد العاملين – بحسب المؤهلات:</h6>
                    </div>
                    <br>
                    <table class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th rowspan="2">الدرجة العلمية</th>
                            <th rowspan="2">نوع العمليات</th>
                            <th colspan="2">بحسب إدماجهم في فرص التأهيل والتدريب خلال السنة المالية</th>
                            <th colspan="2">بحسب شهادات الاعتماد المهنية الاحترافية العالمية</th>
                            <th colspan="3">بحسب طبيعة العمل</th>
                            <th rowspan="2">المجموع</th>
                        </tr>
                        <tr>
                            <th>المنخرطين</th>
                            <th>غير المنخرطين</th>
                            <th>الحاملين للاعتمادات</th>
                            <th>غير الحاملين للاعتمادات</th>
                            <th>العمل المكتبي فقط</th>
                            <th>العمل الميداني فقط</th>
                            <th>العمل المدمج</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($staffDegree)
                            @foreach($degrees as $degree)
                                @foreach($operations as $index => $operation)
                                    @php
                                        $operationCount = $operations->count();
                                        $existing = $staffDegree->where('degree_id', $degree->id)
                                            ->where('operation_id', $operation->id)->where('is_volunteer', 0)
                                            ->first();
                                    @endphp
                                    <tr>
                                        @if($index == 0)
                                            <td rowspan="{{ $operationCount }}">{{ $degree->degree_name }}</td>
                                        @endif
                                        <td>{{ $operation->operation_name }}</td>
                                        <td>
                                            <input type="number" name="staffDegree[{{ $degree->id }}][{{ $operation->id }}][engaged]"
                                                   class="form-control text-center" value="{{ $existing->engaged ?? '' }}" readonly oninput="calculateRowTotal(this)">
                                        </td>
                                        <td>
                                            <input type="number" name="staffDegree[{{ $degree->id }}][{{ $operation->id }}][not_engaged]"
                                                   class="form-control text-center" value="{{ $existing->not_engaged ?? '' }}" readonly oninput="calculateRowTotal(this)">
                                        </td>
                                        <td>
                                            <input type="number" name="staffDegree[{{ $degree->id }}][{{ $operation->id }}][certified]"
                                                   class="form-control text-center" value="{{ $existing->certified ?? '' }}" readonly oninput="calculateRowTotal(this)">
                                        </td>
                                        <td>
                                            <input type="number" name="staffDegree[{{ $degree->id }}][{{ $operation->id }}][not_certified]"
                                                   class="form-control text-center" value="{{ $existing->not_certified ?? '' }}" readonly oninput="calculateRowTotal(this)">
                                        </td>
                                        <td>
                                            <input type="number" name="staffDegree[{{ $degree->id }}][{{ $operation->id }}][office_work]"
                                                   class="form-control text-center" value="{{ $existing->office_work ?? '' }}" readonly oninput="calculateRowTotal(this)">
                                        </td>
                                        <td>
                                            <input type="number" name="staffDegree[{{ $degree->id }}][{{ $operation->id }}][field_work]"
                                                   class="form-control text-center" value="{{ $existing->field_work ?? '' }}" readonly oninput="calculateRowTotal(this)">
                                        </td>
                                        <td>
                                            <input type="number" name="staffDegree[{{ $degree->id }}][{{ $operation->id }}][mixed_work]"
                                                   class="form-control text-center" value="{{ $existing->mixed_work ?? '' }}" readonly oninput="calculateRowTotal(this)">
                                        </td>
                                        <td>
                                            <input type="number" name="staffDegree[{{ $degree->id }}][{{ $operation->id }}][total]"
                                                   class="form-control text-center"  value="{{ $existing->total ?? '' }}" readonly>
                                        </td>
                                        <input type="hidden" name="staffDegree[{{ $degree->id }}][{{ $operation->id }}][degree_id]" value="{{ $degree->id }}">
                                        <input type="hidden" name="staffDegree[{{ $degree->id }}][{{ $operation->id }}][operation_id]" value="{{ $operation->id }}">
                                    </tr>
                                @endforeach
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center" style="gap: 1rem;">
                        <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="next1">التالي</button>
                        <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="previous">السابق</button>
                    </div>
                </div>
                <div id="staffSection3" style="display: none">
                    <div class="row">
                        <h6>التدريب (خلال السنة المالية):</h6>
                    </div>
                    <br>
                    <table class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th rowspan="2">البيان</th>
                            <th colspan="2">الجنس</th>
                            <th rowspan="2">المجموع</th>
                        </tr>
                        <tr>
                            <th>ذكر</th>
                            <th>أنثى</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                عدد العاملين المستفيدين من الفرص التدريبية
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="benefit_male" oninput="calculateTotal('benefit')"
                                       value="{{ $staffOthers ? $staffOthers->benefit_male : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="benefit_female" oninput="calculateTotal('benefit')"
                                       value="{{ $staffOthers ? $staffOthers->benefit_female : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="benefit_total" readonly
                                       value="{{ $staffOthers ? $staffOthers->benefit_total : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                عدد البرامج التأهيلية والتدريبية ذات الرسوم التي تم إلحاق العاملين بها
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="fees_male" oninput="calculateTotal('fees')"
                                       value="{{ $staffOthers ? $staffOthers->fees_male : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="fees_female" oninput="calculateTotal('fees')"
                                       value="{{ $staffOthers ? $staffOthers->fees_female : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="fees_total" readonly
                                       value="{{ $staffOthers ? $staffOthers->fees_total : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                عدد البرامج التأهيلية والتدريبية المجانية التي تم إلحاق العاملين بها
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="free_male" oninput="calculateTotal('free')"
                                       value="{{ $staffOthers ? $staffOthers->free_male : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="free_female" oninput="calculateTotal('free')"
                                       value="{{ $staffOthers ? $staffOthers->free_female : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="free_total" readonly
                                       value="{{ $staffOthers ? $staffOthers->free_total : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                مصروفات التأهيل والتدريب السنوية للعاملين (بالريال)
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="expenses_male" oninput="calculateTotal('expenses')"
                                       value="{{ $staffOthers ? $staffOthers->expenses_male : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="expenses_female" oninput="calculateTotal('expenses')"
                                       value="{{ $staffOthers ? $staffOthers->expenses_female : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="expenses_total" readonly
                                       value="{{ $staffOthers ? $staffOthers->expenses_total : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                القيمة الاقتصادية للتأهيل والتدريب المجاني الذي استفاد منه العاملون (بالريال)
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="value_male" oninput="calculateTotal('value')"
                                       value="{{ $staffOthers ? $staffOthers->value_male : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="value_female" oninput="calculateTotal('value')"
                                       value="{{ $staffOthers ? $staffOthers->value_female : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="value_total" readonly
                                       value="{{ $staffOthers ? $staffOthers->value_total : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                إجمالي عدد العاملين المتدربين من خلال مسار تمهير لبرنامج طاقات
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="trainees_male" oninput="calculateTotal('trainees')"
                                       value="{{ $staffOthers ? $staffOthers->trainees_male : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="trainees_female" oninput="calculateTotal('trainees')"
                                       value="{{ $staffOthers ? $staffOthers->trainees_female : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="trainees_total" readonly
                                       value="{{ $staffOthers ? $staffOthers->trainees_total : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                عدد خريجي (دبلوم إدارة المنظمات غير الربحية) الذي أطلقه المركز الوطني لتنمية القطاع غير الربحي بالتعاون مع معهد الإدارة العامة
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="graduates_male" oninput="calculateTotal('graduates')"
                                       value="{{ $staffOthers ? $staffOthers->graduates_male : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="graduates_female" oninput="calculateTotal('graduates')"
                                       value="{{ $staffOthers ? $staffOthers->graduates_female : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="graduates_total" readonly
                                       value="{{ $staffOthers ? $staffOthers->graduates_total : '' }}">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <div class="row">
                        <h6>الأجور:</h6>
                    </div>
                    <br>
                    <table class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th rowspan="2">البيان</th>
                            <th colspan="2">الجنس</th>
                            <th rowspan="2">المجموع</th>
                        </tr>
                        <tr>
                            <th>ذكر</th>
                            <th>أنثى</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                إجمالي أجور العاملين بدوام كلي، وهذا يشمل الرواتب الأساسية، والتعويضات، والمزايا الوظيفية، والحوافز (بالريال)
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="fullTime_male" oninput="calculateTotal('fullTime')"
                                       value="{{ $staffOthers ? $staffOthers->fullTime_male : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="fullTime_female" oninput="calculateTotal('fullTime')"
                                       value="{{ $staffOthers ? $staffOthers->fullTime_female : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="fullTime_total" readonly
                                       value="{{ $staffOthers ? $staffOthers->fullTime_total : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                إجمالي أجور العاملين بدوام جزئي (بالريال)
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="partTime_male" oninput="calculateTotal('partTime')"
                                       value="{{ $staffOthers ? $staffOthers->partTime_male : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="partTime_female" oninput="calculateTotal('partTime')"
                                       value="{{ $staffOthers ? $staffOthers->partTime_female : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="partTime_total" readonly
                                       value="{{ $staffOthers ? $staffOthers->partTime_total : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                إجمالي أجور العاملين بعقود استشارية (بالريال)
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="consulting_male" oninput="calculateTotal('consulting')"
                                       value="{{ $staffOthers ? $staffOthers->consulting_male : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="consulting_female" oninput="calculateTotal('consulting')"
                                       value="{{ $staffOthers ? $staffOthers->consulting_female : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="consulting_total" readonly
                                       value="{{ $staffOthers ? $staffOthers->consulting_total : '' }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                إجمالي مكافآت مجلس الأمناء أو الإدارة (بالريال)
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="management_male" oninput="calculateTotal('management')"
                                       value="{{ $staffOthers ? $staffOthers->management_male : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="management_female" oninput="calculateTotal('management')"
                                       value="{{ $staffOthers ? $staffOthers->management_female : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="management_total" readonly
                                       value="{{ $staffOthers ? $staffOthers->management_total : '' }}">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <div class="row">
                        <h6>انتهاء الخدمة:</h6>
                    </div>
                    <br>
                    <table class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th rowspan="2">البيان</th>
                            <th colspan="2">الجنس</th>
                            <th rowspan="2">المجموع</th>
                        </tr>
                        <tr>
                            <th>ذكر</th>
                            <th>أنثى</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                عدد العاملين الذين انتهت خدماتهم خلال السنة المالية (سواءً بالاستقالة أو عدم تجديد التعاقد أو الوفاة أو غير ذلك من الدوافع والأسباب)
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="workers_male" oninput="calculateTotal('workers')"
                                       value="{{ $staffOthers ? $staffOthers->workers_male : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="workers_female" oninput="calculateTotal('workers')"
                                       value="{{ $staffOthers ? $staffOthers->workers_female : '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center text-center" name="workers_total" readonly
                                       value="{{ $staffOthers ? $staffOthers->workers_total : '' }}">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <div class="d-flex justify-content-center" style="gap: 1rem;">
                        <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="previous1">السابق</button>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <script>
        document.getElementById('next').addEventListener('click', function() {
            document.getElementById('staffSection').style.display = 'none';
            document.getElementById('staffSection1').style.display = 'block';
        });

        document.getElementById('previous0').addEventListener('click', function() {
            document.getElementById('staffSection').style.display = 'block';
            document.getElementById('staffSection1').style.display = 'none';
        });

        document.getElementById('next0').addEventListener('click', function() {
            document.getElementById('staffSection1').style.display = 'none';
            document.getElementById('staffSection2').style.display = 'block';
        });

        document.getElementById('previous').addEventListener('click', function() {
            document.getElementById('staffSection1').style.display = 'block';
            document.getElementById('staffSection2').style.display = 'none';
        });

        document.getElementById('next1').addEventListener('click', function() {
            document.getElementById('staffSection2').style.display = 'none';
            document.getElementById('staffSection3').style.display = 'block';
        });

        document.getElementById('previous1').addEventListener('click', function() {
            document.getElementById('staffSection2').style.display = 'block';
            document.getElementById('staffSection3').style.display = 'none';
        });
    </script>
    <script>
        function calculateTotals() {
            let nationalities = @json($nationalities);
            let genders = @json($genders);
            let ages = @json($ages);
            let contracts = @json($contracts);
            let regions = @json($regions);

            // Calculate totals for each age group
            nationalities.forEach(nationality => {
                genders.forEach(gender => {
                    ages.forEach(age => {
                        let ageTotal = 0;
                        contracts.forEach(contract => {
                            regions.forEach(region => {
                                let input = document.querySelector(`input[name="number[${nationality.id}][${gender.id}][${age.id}][${contract.id}][${region.id}]"]`);
                                ageTotal += parseFloat(input.value) || 0;
                            });
                        });
                        document.querySelector(`input[name="total_for_age[${nationality.id}][${gender.id}][${age.id}]"]`).value = ageTotal;
                    });
                });
            });

            // Calculate totals for each contract and region
            let contractRegionTotals = {};
            document.querySelectorAll('.contract-region-input').forEach(input => {
                let contractId = input.getAttribute('data-contract');
                let regionId = input.getAttribute('data-region');
                let key = `${contractId}-${regionId}`;
                contractRegionTotals[key] = (contractRegionTotals[key] || 0) + (parseFloat(input.value) || 0);
            });
            document.querySelectorAll('.total-for-contract-region').forEach(input => {
                let contractId = input.getAttribute('data-contract');
                let regionId = input.getAttribute('data-region');
                let key = `${contractId}-${regionId}`;
                input.value = contractRegionTotals[key] || 0;
            });

            // Calculate grand total
            let grandTotal = 0;
            document.querySelectorAll('.total-for-contract-region').forEach(input => {
                grandTotal += parseFloat(input.value) || 0;
            });
            document.querySelector('.total-for-all').value = grandTotal;
        }

        document.addEventListener('DOMContentLoaded', calculateTotals);
    </script>
    <script>
        function calculateRowTotal(input) {
            const row = input.closest('tr');
            const inputs = row.querySelectorAll('input[type="number"]:not([name*="[total]"])');
            let total = 0;

            inputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });

            const totalInput = row.querySelector('input[name*="[total]"]');
            totalInput.value = total;
        }

        window.onload = function() {
            const rows = document.querySelectorAll('tr[data-row]');
            rows.forEach(row => {
                const inputs = row.querySelectorAll('input[type="number"]');
                inputs.forEach(input => calculateRowTotal(input));
            });
        }
    </script>
    <script>
        function calculateTotal(type) {
            const maleInput = document.querySelector(`input[name="${type}_male"]`);
            const femaleInput = document.querySelector(`input[name="${type}_female"]`);
            const totalInput = document.querySelector(`input[name="${type}_total"]`);

            const maleValue = parseFloat(maleInput.value) || 0;
            const femaleValue = parseFloat(femaleInput.value) || 0;
            const totalValue = maleValue + femaleValue;

            totalInput.value = totalValue;
        }

        window.onload = function() {
            calculateTotal('workers');
            calculateTotal('trainees');
        }
    </script>

@endsection
