@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (الخدمات)
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
                    <div class="container" dir="rtl">
                        @if(Session::has('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{ session::get('error') }}</strong> .
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col text-center">
                                <h3> الخدمات </h3>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <br>
                        <form method="post" action="{{ route('services.store') }}">
                            @csrf
                            <div id="servicesSection1">
                                <div class="row">
                                    <h5>أصناف المستهدفين (بحسب الشريحة):</h5>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                            <tr>
                                                <th scope="col">الشريحة</th>
                                                <th scope="col">الفئة</th>
                                                <th scope="col">وهم خارج المملكة</th>
                                                <th scope="col">وهم داخل المملكة</th>
                                                <th scope="col">الإناث</th>
                                                <th scope="col">أصحاب الاحتياجات الخاصة</th>
                                                <th scope="col">من وافتهم المنية</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($slides as $slide)
                                                @php
                                                    $user_id = Auth::user()->id;
                                                    $servicesSlide = App\Models\ServicesSlide::where('slide_id', $slide->id)
                                                                        ->where('user_id', $user_id)
                                                                        ->first();
                                                @endphp
                                                <tr>
                                                    <th scope="row">{{ $slide->slide_name }}</th>
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="slide_id[]" value="{{ $slide->id }}" {{ $servicesSlide ? 'checked' : '' }} class="form-check-input slide-checkbox" data-slide-id="{{ $slide->id }}">
                                                        <input type="hidden" name="slide_checked[]" value="{{ $slide->id }}">
                                                    </td>
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="outside_kingdom[{{ $slide->id }}]" {{ $servicesSlide && $servicesSlide->outside_kingdom ? 'checked' : '' }} class="form-check-input toggle-checkbox-{{ $slide->id }}">
                                                    </td>
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="inside_kingdom[{{ $slide->id }}]" {{ $servicesSlide && $servicesSlide->inside_kingdom ? 'checked' : '' }} class="form-check-input toggle-checkbox-{{ $slide->id }}">
                                                    </td>
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="female[{{ $slide->id }}]" {{ $servicesSlide && $servicesSlide->female ? 'checked' : '' }} class="form-check-input toggle-checkbox-{{ $slide->id }}">
                                                    </td>
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="special_needs[{{ $slide->id }}]" {{ $servicesSlide && $servicesSlide->special_needs ? 'checked' : '' }} class="form-check-input toggle-checkbox-{{ $slide->id }}">
                                                    </td>
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="people_dead[{{ $slide->id }}]" {{ $servicesSlide && $servicesSlide->people_dead ? 'checked' : '' }} class="form-check-input toggle-checkbox-{{ $slide->id }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center" style="gap: 1rem;">
                                    <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="next">التالي</button>
                                </div>
                            </div>
                            <div id="servicesSection2" style="display: none">
                                <div class="row">
                                    @foreach($targets as $target)
                                        @php
                                            $services = App\Models\LocalServices::where('target_id', $target->id)->get();
                                        @endphp
                                        <div class="col-md-6 target-section">
                                            <div class="row mb-3">
                                                <div class="col-12 target-name">
                                                    <h5>{{ $target->target_name }}</h5>
                                                </div>
                                            </div>
                                            <div class="services-list">
                                                @foreach($services as $item)
                                                    @php
                                                        $user_id = Auth::user()->id;
                                                        $checkService = App\Models\TargetService::where('service_id', $item->id)
                                                            ->where('user_id', $user_id)
                                                            ->exists();
                                                    @endphp
                                                    <div class="row service-item mb-3">
                                                        <div class="col-12">
                                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                                <input type="checkbox" class="form-check-input" name="service_id[]" value="{{ $item->id }}" {{ $checkService ? 'checked' : '' }}>
                                                                <label class="form-check-label ml-2">{{ $item->service_name }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <br>
                                <br>
                                <div class="d-flex justify-content-center" style="gap: 1rem;">
                                    <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="next1">التالي</button>
                                    <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="previous">السابق</button>
                                </div>
                            </div>

                            <div id="servicesSection3" style="display: none">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                            <tr>
                                                <th>المراحل</th>
                                                <th>مجالات الأعمال</th>
                                                <th>عدد المؤشرات</th>
                                                <th>الخدمات الموسمية</th>
                                                <th>الخدمات المستمرة</th>
                                                <th>المبادرات</th>
                                                <th>الفعاليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($stages as $stage)
                                                @php
                                                    // Fetch all businesses for this stage
                                                    $businesses = App\Models\Business::where('stage_id', $stage->id)->get();
                                                @endphp
                                                @foreach($businesses as $businessIndex => $business)
                                                    @foreach($indicators as $indicatorIndex => $indicator)
                                                        @php
                                                            $user_id = Auth::user()->id;
                                                            $serviceImplemented = App\Models\ServiceImplemented::where('user_id', $user_id)->get();
                                                            $existing = $serviceImplemented->where('business_id', $business->id)
                                                                ->where('indicator_id', $indicator->id)
                                                                ->first();
                                                        @endphp
                                                        <tr>
                                                            @if ($businessIndex == 0 && $indicatorIndex == 0)
                                                                <td rowspan="{{ $businesses->count() * $indicators->count() }}">{{ $stage->stage_name }}</td>
                                                            @endif
                                                            @if ($indicatorIndex == 0)
                                                                <td rowspan="{{ $indicators->count() }}">{{ $business->business_name }}</td>
                                                            @endif
                                                            <td>{{ $indicator->indicator_name }}</td>
                                                            <td><input type="number" name="serviceImplemented[{{ $business->id }}][{{ $indicator->id }}][seasonal_service]"
                                                                       class="form-control text-center" value="{{ $existing->seasonal_service ?? '' }}"></td>
                                                            <td><input type="number" name="serviceImplemented[{{ $business->id }}][{{ $indicator->id }}][ongoing_service]"
                                                                       class="form-control text-center" value="{{ $existing->ongoing_service ?? '' }}"></td>
                                                            <td><input type="number" name="serviceImplemented[{{ $business->id }}][{{ $indicator->id }}][initiatives]"
                                                                       class="form-control text-center" value="{{ $existing->initiatives ?? '' }}"></td>
                                                            <td><input type="number" name="serviceImplemented[{{ $business->id }}][{{ $indicator->id }}][events]"
                                                                       class="form-control text-center" value="{{ $existing->events ?? '' }}"></td>
                                                            <input type="hidden" name="serviceImplemented[{{ $business->id }}][{{ $indicator->id }}][stage_id]" value="{{ $stage->id }}">
                                                            <input type="hidden" name="serviceImplemented[{{ $business->id }}][{{ $indicator->id }}][business_id]" value="{{ $business->id }}">
                                                            <input type="hidden" name="serviceImplemented[{{ $business->id }}][{{ $indicator->id }}][indicator_id]" value="{{ $indicator->id }}">
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center" style="gap: 1rem;">
                                    <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="next2">التالي</button>
                                    <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="previous1">السابق</button>
                                </div>
                            </div>
                            <div id="servicesSection4" style="display: none">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                            <tr>
                                                <th>الشريحة</th>
                                                <th>الخدمات الموسمية</th>
                                                <th>الخدمات المستمرة</th>
                                                <th>المبادرات</th>
                                                <th>الفعاليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>هل تم قياس مستوى الرضا؟</td>
                                                <td>
                                                    <label>
                                                        <input type="radio" class="form-check-input" name="seasonal_question" value="1" {{ $benefitSatisfaction && $benefitSatisfaction->seasonal_question == 1 ? 'checked' : '' }}>
                                                        نعم
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="form-check-input" name="seasonal_question" value="0" {{ $benefitSatisfaction && $benefitSatisfaction->seasonal_question == 0 ? 'checked' : '' }}>
                                                        لا
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="radio" class="form-check-input" name="ongoing_question" value="1" {{ $benefitSatisfaction && $benefitSatisfaction->ongoing_question == 1 ? 'checked' : '' }}>
                                                        نعم
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="form-check-input" name="ongoing_question" value="0" {{ $benefitSatisfaction && $benefitSatisfaction->ongoing_question == 0 ? 'checked' : '' }}>
                                                        لا
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="radio" class="form-check-input" name="initiatives_question" value="1" {{ $benefitSatisfaction && $benefitSatisfaction->initiatives_question == 1 ? 'checked' : '' }}>
                                                        نعم
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="form-check-input" name="initiatives_question" value="0" {{ $benefitSatisfaction && $benefitSatisfaction->initiatives_question == 0 ? 'checked' : '' }}>
                                                        لا
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="radio" class="form-check-input" name="events_question" value="1" {{ $benefitSatisfaction && $benefitSatisfaction->events_question == 1 ? 'checked' : '' }}>
                                                        نعم
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="form-check-input" name="events_question" value="0" {{ $benefitSatisfaction && $benefitSatisfaction->events_question == 0 ? 'checked' : '' }}>
                                                        لا
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>مستوى الرضا %</td>
                                                <td>
                                                    <input type="number" class="form-control text-center" name="seasonal_percentage"
                                                           value="{{ $benefitSatisfaction ? $benefitSatisfaction->seasonal_percentage : '' }}" max="100">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control text-center" name="ongoing_percentage"
                                                           value="{{ $benefitSatisfaction ? $benefitSatisfaction->ongoing_percentage : '' }}" max="100">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control text-center" name="initiatives_percentage"
                                                           value="{{ $benefitSatisfaction ? $benefitSatisfaction->initiatives_percentage : '' }}" max="100">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control text-center" name="events_percentage"
                                                           value="{{ $benefitSatisfaction ? $benefitSatisfaction->events_percentage : '' }}" max="100">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>حجم العيّنة المسحيّة</td>
                                                <td>
                                                    <input type="number" class="form-control text-center" name="seasonal_size"
                                                           value="{{ $benefitSatisfaction ? $benefitSatisfaction->seasonal_size : '' }}">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control text-center" name="ongoing_size"
                                                           value="{{ $benefitSatisfaction ? $benefitSatisfaction->ongoing_size : '' }}">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control text-center" name="initiatives_size"
                                                           value="{{ $benefitSatisfaction ? $benefitSatisfaction->initiatives_size : '' }}">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control text-center" name="events_size"
                                                           value="{{ $benefitSatisfaction ? $benefitSatisfaction->events_size : '' }}">
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
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
            document.getElementById('servicesSection1').style.display = 'none';
            document.getElementById('servicesSection2').style.display = 'block';
        });

        document.getElementById('previous').addEventListener('click', function() {
            document.getElementById('servicesSection1').style.display = 'block';
            document.getElementById('servicesSection2').style.display = 'none';
        });

        document.getElementById('next1').addEventListener('click', function() {
            document.getElementById('servicesSection2').style.display = 'none';
            document.getElementById('servicesSection3').style.display = 'block';
        });

        document.getElementById('previous1').addEventListener('click', function() {
            document.getElementById('servicesSection2').style.display = 'block';
            document.getElementById('servicesSection3').style.display = 'none';
        });

        document.getElementById('next2').addEventListener('click', function() {
            document.getElementById('servicesSection3').style.display = 'none';
            document.getElementById('servicesSection4').style.display = 'block';
        });

        document.getElementById('previous2').addEventListener('click', function() {
            document.getElementById('servicesSection3').style.display = 'block';
            document.getElementById('servicesSection4').style.display = 'none';
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Select all slide checkboxes
            document.querySelectorAll('.slide-checkbox').forEach(function (checkbox) {
                // Set initial visibility based on checked state
                toggleCheckboxes(checkbox);

                // Add event listener to toggle checkboxes on change
                checkbox.addEventListener('change', function () {
                    toggleCheckboxes(checkbox);
                });
            });

            function toggleCheckboxes(slideCheckbox) {
                var slideId = slideCheckbox.dataset.slideId;
                var checkboxes = document.querySelectorAll('.toggle-checkbox-' + slideId);

                checkboxes.forEach(function (checkbox) {
                    checkbox.style.display = slideCheckbox.checked ? 'inline-block' : 'none';
                });
            }
        });
    </script>
    <style>
        /* Hide all toggle checkboxes by default */
        .toggle-checkbox-{{ $slide->id }} {
            display: none;
        }
    </style>



@endsection
