@extends('admin.admin_master')
@section('title')
    nusuk | نٌسكـ (إضافة فرصة)
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
                <div class="container-fluid">
                    <div class="row">
                        <div class="section-header col-md-12">
                                <span>
                                     إضافة الفرصة
                                </span>


                        </div>
                        <div class="oppo-form">
                            <form id="opportunity-form" method="post" action="{{ route('opportunity.store', $id) }}" class="row g-3">
                                @csrf
                                <div class="col-12">
                                    <label for="heading" class="form-label">
                                        عنوان الفرصة
                                    </label>
                                    <input type="text" name="title" class="form-control" id="heading" placeholder="فرصه1" required>
                                    @error('title')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="about" class="form-label">
                                        تصنيف الفرصة
                                    </label>
                                    <select name="opportunity_id" class="form-select" required>
                                        <option value="" selected="" disabled="">اختيار الفرصة ...</option>
                                        @foreach($opportunities as $key => $item)
                                            <option value="{{ $item->id }}">{{ $item->opportunity_name }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="about" class="form-label">
                                        نبذة عن الفرصة
                                    </label>
                                    <input type="text" name="about" class="form-control" id="about" placeholder=" تتميز الفرصه ... " required>
                                    @error('about')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="target" class="form-label">
                                        المستهدفون بالمشاركة
                                    </label>
                                    <input type="text" name="targeted_people" class="form-control" id="target" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="Standards" class="form-label">
                                        شروط الترشح
                                    </label>
                                    <input type="text" name="conditions" class="form-control" id="Standards" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="reciver" class="form-label">
                                        الجهة
                                    </label>
                                    <input type="text" name="side" class="form-control" required id="reciver">
                                    @error('side')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="date" class="form-label">
                                        تاريخ النشر
                                    </label>
                                    <input type="date" name="date_publication" class="form-control"
                                           required id="date">
                                    @error('date_publication')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="deadline" class="form-label">
                                        آخر موعد للتقديم
                                    </label>
                                    <input type="date" name="deadline_apply" class="form-control"
                                           min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required id="deadline">
                                    @error('deadline_apply')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md">
                                    <label for="strat" class="form-label">
                                        فترة العمل :  من
                                    </label>
                                    <input type="date" name="date_from" class="form-control"  id="startDateInput"
                                           min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                    @error('date_from')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md">
                                    <label for="end" class="form-label">
                                        الى
                                    </label>
                                    <input type="date" name="date_to" class="form-control" id="endDateInput"
                                           min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                    @error('date_to')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="Standards" class="form-label">
                                        عدد المنظمات المرغوبة
                                    </label>
                                    <input type="number" name="organization_number" class="form-control" required id="Standards">
                                </div>


                                <div class="col-12 text-center">
                                    <h4>الاختبار التأهيلي</h4>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" id="add-multiple" class="btn btn-dark text-white">إضافة سؤال(إجابة من متعدد)</button>
                                    </div>
                                </div>
                                <br>

                                <div id="multiple-template" style="display: none;">
                                    <div class="row multiple mb-3">
                                        <div class="col-md-8" style="border-left: 1px solid #444444">
                                            <input type="text" name="question[]" class="form-control" placeholder="السؤال">
                                            <input type="hidden" name="is_numeric[]" value="0">
                                            <br>
                                            <div class="d-flex justify-content-center" style="gap: 10px;">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <input type="text" name="answer[0][]" class="form-control" placeholder="الإجابة {{ $i }}" >
                                                    <input type="hidden" name="value[0][]" value="{{ $i }}">
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>هل السؤال حاسم ؟</label>
                                            <br>
                                            <br>
                                            <input type="radio" name="is_decisive_0" value="1" > نعم
                                            <input type="radio" name="is_decisive_0" value="0"> لا
                                        </div>
                                        <div class="col-md-2">
                                            <label>وزن الأهمية النسبية (%)</label>
                                            <br>
                                            <br>
                                            <input type="text" name="importance[]" class="form-control importance-input" >
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-dark text-white remove-btn">حذف</button>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div id="multiple"></div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" id="add-numeric" class="btn btn-dark text-white">إضافة سؤال(إجابة رقمية)</button>
                                    </div>
                                </div>
                                <br>

                                <div id="numeric-template" style="display: none;">
                                    <div class="row multiple mb-3">
                                        <div class="col-md-8" style="border-left: 1px solid #444444">
                                            <input type="text" name="question[]" class="form-control" placeholder="السؤال">
                                            <input type="hidden" name="is_numeric[]" value="1">
                                            <br>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <div class="d-flex justify-content-center" style="gap: 10px;">
                                                    <label>من</label>
                                                    <input type="number" name="from_number[0][]" class="form-control" placeholder="الإجابة {{ $i }}" >
                                                    <label>إلى</label>
                                                    <input type="number" name="to_number[0][]" class="form-control" placeholder="الإجابة {{ $i }}" >
                                                    <input type="hidden" name="value[0][]" value="{{ $i }}">
                                                </div>
                                            @endfor
                                        </div>
                                        <div class="col-md-2">
                                            <label>هل السؤال حاسم ؟</label>
                                            <br>
                                            <br>
                                            <input type="radio" name="is_decisive_0" value="1" > نعم
                                            <input type="radio" name="is_decisive_0" value="0"> لا
                                        </div>
                                        <div class="col-md-2">
                                            <label>وزن الأهمية النسبية (%)</label>
                                            <br>
                                            <br>
                                            <input type="text" name="importance[]" class="form-control importance-input" >
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-dark text-white remove-btn">حذف</button>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div id="numeric"></div>

                                <div class="row">
                                    <div class="col-md-4">

                                    </div>
                                    <div class="col-md-4">
                                        <label>النسبة التأهيلية (%)</label>
                                        <br>
                                        <br>
                                        <input type="text" name="percentage" class="form-control" required max="100">
                                    </div>
                                    <div class="col-md-4">
                                        <label>مجموع وزن الأهمية النسبية(%)</label>
                                        <br>
                                        <br>
                                        <input type="text" id="total-importance" name="total" class="form-control" readonly>
                                    </div>
                                </div>
                                <br>
                                <div class="d-flex justify-content-center" style="gap: 2rem;">
                                    <button class="btn btn-dark text-white" type="submit" id="submit-form">حفظ</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startDateInput = document.getElementById('startDateInput');
            const endDateInput = document.getElementById('endDateInput');

            startDateInput.addEventListener('change', function () {
                const startDate = startDateInput.value;
                endDateInput.min = startDate;
                if (endDateInput.value && endDateInput.value < startDate) {
                    endDateInput.value = ''; // Clear the end date if it's before the start date
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            let counter = 0;

            function updateTotalImportance() {
                let total = 0;
                $('.importance-input').each(function() {
                    let value = parseFloat($(this).val()) || 0;
                    total += value;
                });
                $('#total-importance').val(total);
            }

            function addQuestion(templateId, containerId, questionCounter) {
                var clone = $(`#${templateId} .row`).clone();
                clone.find('input[name^="answer"]').each(function(index) {
                    $(this).attr('name', `answer[${questionCounter}][${index}]`);
                    // Add required attribute to the first and fifth answer input
                    if (index === 0 || index === 4) {
                        $(this).attr('required', true);
                    } else {
                        $(this).removeAttr('required');
                    }
                });
                clone.find('input[name^="from_number"]').each(function(index) {
                    $(this).attr('name', `from_number[${questionCounter}][${index}]`);
                    // Add required attribute to the first and fifth from_number input
                    if (index === 0 || index === 4) {
                        $(this).attr('required', true);
                    } else {
                        $(this).removeAttr('required');
                    }
                });
                clone.find('input[name^="to_number"]').each(function(index) {
                    $(this).attr('name', `to_number[${questionCounter}][${index}]`);
                    // Add required attribute to the first and fifth to_number input
                    if (index === 0 || index === 4) {
                        $(this).attr('required', true);
                    } else {
                        $(this).removeAttr('required');
                    }
                });
                clone.find('input[name^="value"]').each(function(index) {
                    $(this).attr('name', `value[${questionCounter}][${index}]`);
                });
                clone.find('input[name^="is_decisive"]').each(function() {
                    $(this).attr('name', `is_decisive_${questionCounter}`);
                });
                clone.find('input[name^="question"]').each(function() {
                    $(this).attr('name', `question[${questionCounter}]`);
                });
                clone.find('input[name^="is_numeric"]').each(function() {
                    $(this).attr('name', `is_numeric[${questionCounter}]`);
                });
                clone.find('input[name^="importance"]').each(function() {
                    $(this).attr('name', `importance[${questionCounter}]`);
                });
                $(`#${containerId}`).append(clone);
            }

            $('#add-multiple').click(function() {
                addQuestion('multiple-template', 'multiple', counter);
                counter++;
            });

            $('#add-numeric').click(function() {
                addQuestion('numeric-template', 'numeric', counter);
                counter++;
            });

            $(document).on('click', '.remove-btn', function() {
                $(this).closest('.row').remove();
                updateTotalImportance();
            });

            $(document).on('input', '.importance-input', function() {
                updateTotalImportance();
            });

            $('#submit-form').click(function(event) {
                // Remove required attributes from hidden sections before submitting
                $('[style*="display: none"] [required]').each(function() {
                    $(this).removeAttr('required');
                });

                let totalImportance = parseFloat($('#total-importance').val()) || 0;
                if (totalImportance !== 100) {
                    alert('مجموع وزن الأهمية النسبية يجب أن يكون 100%');
                    event.preventDefault();
                }
            });

            // Show/hide sections and toggle required fields
            $('#next').click(function() {
                $('#section').hide();
                $('#section2').show();
                toggleRequired('section', false);
                toggleRequired('section2', true);
            });

            $('#previous').click(function() {
                $('#section2').hide();
                $('#section').show();
                toggleRequired('section2', false);
                toggleRequired('section', true);
            });

            function toggleRequired(sectionId, isRequired) {
                $(`#${sectionId} [required]`).each(function() {
                    $(this).attr('required', isRequired);
                });
            }
        });
    </script>

@endsection
