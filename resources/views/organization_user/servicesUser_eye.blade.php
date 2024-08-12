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
                        <div class="row">
                            <div class="col text-center">
                                <h3> الخدمات </h3>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <br>
                        <div id="servicesSection1">
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
                                        @if($servicesSlide)
                                            @foreach($slides as $slide)
                                                @php
                                                    $checkSlide = $servicesSlide->where('slide_id', $slide->id)
                                                                        ->first();
                                                @endphp
                                                <tr>
                                                    <th scope="row">{{ $slide->slide_name }}</th>
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="slide_id[]" disabled value="{{ $slide->id }}" {{ $checkSlide ? 'checked' : '' }}>
                                                        <input type="hidden" name="slide_checked[]" disabled value="{{ $slide->id }}">
                                                    </td>
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="outside_kingdom[{{ $slide->id }}]" disabled {{ $checkSlide && $checkSlide->outside_kingdom ? 'checked' : '' }}>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="inside_kingdom[{{ $slide->id }}]" disabled {{ $checkSlide && $checkSlide->inside_kingdom ? 'checked' : '' }}>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="female[{{ $slide->id }}]" disabled {{ $checkSlide && $checkSlide->female ? 'checked' : '' }}>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="special_needs[{{ $slide->id }}]" disabled {{ $checkSlide && $checkSlide->special_needs ? 'checked' : '' }}>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <input type="checkbox" name="people_dead[{{ $slide->id }}]" disabled {{ $checkSlide && $checkSlide->people_dead ? 'checked' : '' }}>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
                                            @if($targetService)
                                                @foreach($services as $item)
                                                    @php
                                                        $checkService = $targetService->where('service_id', $item->id)->first();
                                                    @endphp
                                                    <div class="row service-item mb-3">
                                                        <div class="col-12">
                                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                                <input type="checkbox" class="form-check-input" name="service_id[]" disabled value="{{ $item->id }}" {{ $checkService ? 'checked' : '' }}>
                                                                <label class="form-check-label ml-2">{{ $item->service_name }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
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
                                        @if($serviceImplemented)
                                            @foreach($stages as $stage)
                                                @php
                                                    // Fetch all businesses for this stage
                                                    $businesses = App\Models\Business::where('stage_id', $stage->id)->get();
                                                @endphp
                                                @foreach($businesses as $businessIndex => $business)
                                                    @foreach($indicators as $indicatorIndex => $indicator)
                                                        @php
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
                                                                       class="form-control" value="{{ $existing->seasonal_service ?? '' }}" readonly></td>
                                                            <td><input type="number" name="serviceImplemented[{{ $business->id }}][{{ $indicator->id }}][ongoing_service]"
                                                                       class="form-control" value="{{ $existing->ongoing_service ?? '' }}" readonly></td>
                                                            <td><input type="number" name="serviceImplemented[{{ $business->id }}][{{ $indicator->id }}][initiatives]"
                                                                       class="form-control" value="{{ $existing->initiatives ?? '' }}" readonly></td>
                                                            <td><input type="number" name="serviceImplemented[{{ $business->id }}][{{ $indicator->id }}][events]"
                                                                       class="form-control" value="{{ $existing->events ?? '' }}" readonly></td>
                                                            <input type="hidden" name="serviceImplemented[{{ $business->id }}][{{ $indicator->id }}][stage_id]" value="{{ $stage->id }}">
                                                            <input type="hidden" name="serviceImplemented[{{ $business->id }}][{{ $indicator->id }}][business_id]" value="{{ $business->id }}">
                                                            <input type="hidden" name="serviceImplemented[{{ $business->id }}][{{ $indicator->id }}][indicator_id]" value="{{ $indicator->id }}">
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        @endif
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
                                                    <input type="radio" name="seasonal_question" disabled value="1" {{ $benefitSatisfaction && $benefitSatisfaction->seasonal_question == 1 ? 'checked' : '' }}>
                                                    نعم
                                                </label>
                                                <label>
                                                    <input type="radio" name="seasonal_question" disabled value="0" {{ $benefitSatisfaction && $benefitSatisfaction->seasonal_question == 0 ? 'checked' : '' }}>
                                                    لا
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="radio" name="ongoing_question" disabled value="1" {{ $benefitSatisfaction && $benefitSatisfaction->ongoing_question == 1 ? 'checked' : '' }}>
                                                    نعم
                                                </label>
                                                <label>
                                                    <input type="radio" name="ongoing_question" disabled value="0" {{ $benefitSatisfaction && $benefitSatisfaction->ongoing_question == 0 ? 'checked' : '' }}>
                                                    لا
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="radio" name="initiatives_question" disabled value="1" {{ $benefitSatisfaction && $benefitSatisfaction->initiatives_question == 1 ? 'checked' : '' }}>
                                                    نعم
                                                </label>
                                                <label>
                                                    <input type="radio" name="initiatives_question" disabled value="0" {{ $benefitSatisfaction && $benefitSatisfaction->initiatives_question == 0 ? 'checked' : '' }}>
                                                    لا
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="radio" name="events_question" disabled value="1" {{ $benefitSatisfaction && $benefitSatisfaction->events_question == 1 ? 'checked' : '' }}>
                                                    نعم
                                                </label>
                                                <label>
                                                    <input type="radio" name="events_question" disabled value="0" {{ $benefitSatisfaction && $benefitSatisfaction->events_question == 0 ? 'checked' : '' }}>
                                                    لا
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>مستوى الرضا %</td>
                                            <td>
                                                <input type="number" class="form-control" name="seasonal_percentage" readonly
                                                       value="{{ $benefitSatisfaction ? $benefitSatisfaction->seasonal_percentage : '' }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="ongoing_percentage" readonly
                                                       value="{{ $benefitSatisfaction ? $benefitSatisfaction->ongoing_percentage : '' }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="initiatives_percentage" readonly
                                                       value="{{ $benefitSatisfaction ? $benefitSatisfaction->initiatives_percentage : '' }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="events_percentage" readonly
                                                       value="{{ $benefitSatisfaction ? $benefitSatisfaction->events_percentage : '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>حجم العيّنة المسحيّة</td>
                                            <td>
                                                <input type="number" class="form-control" name="seasonal_size" readonly
                                                       value="{{ $benefitSatisfaction ? $benefitSatisfaction->seasonal_size : '' }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="ongoing_size" readonly
                                                       value="{{ $benefitSatisfaction ? $benefitSatisfaction->ongoing_size : '' }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="initiatives_size" readonly
                                                       value="{{ $benefitSatisfaction ? $benefitSatisfaction->initiatives_size : '' }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="events_size" readonly
                                                       value="{{ $benefitSatisfaction ? $benefitSatisfaction->events_size : '' }}">
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center" style="gap: 1rem;">
                                <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="previous2">السابق</button>
                            </div>
                        </div>
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
