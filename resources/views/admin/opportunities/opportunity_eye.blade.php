@extends('admin.admin_master')
@section('title')
    nusuk | نٌسكـ (عرض الفرصة القطاعية)
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
            <section class="list-opp">
                <div class="container-fluid">
                    @if(Session::has('error'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ session::get('error') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="section-header col-md-12">
                                <span>
                                     عرض/تعديل {{ $add->opportunity_name }}
                                </span>


                        </div>
                        <div class="oppo-form">
                            <form id="questions-form" method="post" action="{{ route('opportunity.update', $id) }}" class="row g-3">
                                @csrf

                                <div class="col-12">
                                    <label for="heading" class="form-label">
                                        عنوان الفرصة
                                    </label>
                                    <input type="text" name="title" class="form-control" value="{{ $opportunity->title }}" required>
                                </div>

                                <div class="col-12">
                                    <label for="about" class="form-label">
                                        نبذة عن الفرصة
                                    </label>
                                    <input type="text" name="about" class="form-control" value="{{ $opportunity->about }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="target" class="form-label">
                                        المستهدفون بالمشاركة
                                    </label>
                                    <input type="text" name="targeted_people" class="form-control" value="{{ $opportunity->targeted_people }}" required id="target">
                                </div>

                                <div class="col-md-6">
                                    <label for="Standards" class="form-label">
                                        شروط الترشح
                                    </label>
                                    <input type="text" name="conditions" class="form-control" value="{{ $opportunity->conditions }}" required id="Standards">
                                </div>

                                <div class="col-md-6">
                                    <label for="reciver" class="form-label">
                                        الجهة
                                    </label>
                                    <input type="text" name="side" class="form-control" value="{{ $opportunity->side }}" required id="reciver">
                                </div>

                                <div class="col-md-6">
                                    <label for="date" class="form-label">
                                        تاريخ النشر
                                    </label>
                                    <input type="date"  name="date_publication" class="form-control" value="{{ $opportunity->date_publication }}" required id="date">
                                </div>

                                <div class="col-md-4">
                                    <label for="deadline" class="form-label">
                                        آخر موعد للتقديم
                                    </label>
                                    <input type="date" name="deadline_apply" class="form-control" value="{{ $opportunity->deadline_apply }}" required id="deadline">
                                </div>

                                <div class="col-md">
                                    <label for="strat" class="form-label">
                                        فترة العمل :  من
                                    </label>
                                    <input type="date" name="date_from" class="form-control" value="{{ $opportunity->date_from }}" required id="strat">
                                </div>
                                <div class="col-md">
                                    <label for="end" class="form-label">
                                        الي
                                    </label>
                                    <input type="date" name="date_to" class="form-control" value="{{ $opportunity->date_to }}" required id="end">
                                </div>


                                <div class="col-md-6">
                                    <label for="target" class="form-label">
                                        حالة الفرصة
                                    </label>
                                    <input type="text" class="form-control" value="{{ $status->value }}" id="target">
                                </div>

                                <div class="col-md-6">
                                    <label for="Standards" class="form-label">
                                        عدد المنظمات المرغوبة
                                    </label>
                                    <input type="text" name="organization_number" class="form-control" value="{{ $opportunity->organization_number }}" required id="Standards">
                                </div>


                                <div class="col-12 text-center">
                                           <h4>الاختبار التأهيلي</h4>
                                </div>
                                <hr>
                                @foreach($question as $key => $item)
                                    @php
                                        $answers = App\Models\Answer::where('question_id', $item->id)->get();
                                    @endphp
                                    <input type="hidden" name="question_ids[]" value="{{ $item->id }}">
                                    <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th> نوع السؤال </th>
                                        <th> السؤال </th>
                                        <th colspan="5">
                                            <input type="text" name="question[]" class="form-control" value="{{ $item->question }}" placeholder="السؤال">
                                        </th>
                                        <th colspan="2"> هل السؤال حاسم ؟ </th>
                                        <th colspan="3"> وزن الأهمية النسبية (%) </th>

                                    </tr>


                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td rowspan="2">
                                            إجابة من متعدد
                                        </td>
                                        <td> الدرجة </td>
                                        <td> 1 </td>
                                        <td> 2 </td>
                                        <td> 3 </td>
                                        <td> 4 </td>
                                        <td> 5 </td>

                                        <td rowspan="2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_decisive[{{ $item->id }}]" value="1" @if($item->is_decisive === 1) checked @endif>
                                                <label class="form-check-label" for="multiple1">
                                                    نعم
                                                </label>
                                            </div>
                                        </td>
                                        <td rowspan="2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_decisive[{{ $item->id }}]" value="0"  @if($item->is_decisive === 0) checked @endif>
                                                <label class="form-check-label" for="multiple1">
                                                    لا
                                                </label>
                                            </div>
                                        </td>
                                        <td rowspan="2">
                                            <input type="text" name="importance[]" value="{{ $item->importance }}" class="form-control importance-input">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> الاجابة </td>
                                        @foreach($answers as $index => $answer)
                                            <td>
                                                <input type="text" name="answer[{{ $item->id }}][]" class="form-control mb-2" value="{{ $answer->answer }}" placeholder="الإجابة {{ $index+1 }}">
                                            </td>
                                        @endforeach
                                    </tr>
                                    </tbody>
                                </table>
                                @endforeach
                            @foreach($questionNumeric as $key => $item)
                                @php
                                    $answers = App\Models\NumericNumber::where('question_id', $item->id)->get();
                                @endphp
                                <input type="hidden" name="question_ids[]" value="{{ $item->id }}">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th> نوع السؤال </th>
                                        <th> السؤال </th>
                                        <th colspan="5">
                                            <input type="text" name="question[]" class="form-control" value="{{ $item->question }}" placeholder="السؤال">
                                        </th>
                                        <th colspan="2"> هل السؤال حاسم ؟ </th>
                                        <th colspan="3"> وزن الأهمية النسبية (%) </th>

                                    </tr>


                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td rowspan="2">
                                            إجابة رقمية
                                        </td>
                                        <td> الدرجة </td>
                                        <td> 1 </td>
                                        <td> 2 </td>
                                        <td> 3 </td>
                                        <td> 4 </td>
                                        <td> 5 </td>

                                        <td rowspan="2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_decisive[{{ $item->id }}]" value="1" @if($item->is_decisive === 1) checked @endif>
                                                <label class="form-check-label" for="digital">
                                                    نعم
                                                </label>
                                            </div>
                                        </td>
                                        <td rowspan="2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_decisive[{{ $item->id }}]" value="0"  @if($item->is_decisive === 0) checked @endif>
                                                <label class="form-check-label" for="digital">
                                                    لا
                                                </label>
                                            </div>
                                        </td>
                                        <td rowspan="2">
                                            <input type="text" name="importance[]" value="{{ $item->importance }}" class="form-control importance-input">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> الاجابة </td>
                                        @foreach($answers as $index => $answer)
                                        <td>
                                            <label>من</label>
                                            <input type="number" name="from_number[{{ $item->id }}][]" class="form-control" value="{{ $answer->from_number }}" placeholder="الإجابة {{ $index+1 }}">
                                            <label>إلى</label>
                                            <input type="number" name="to_number[{{ $item->id }}][]" class="form-control" value="{{ $answer->to_number }}" placeholder="الإجابة {{ $index+1 }}">
                                        </td>
                                        @endforeach
                                    </tr>

                                    </tbody>

                                </table>
                            @endforeach
                            <div class="row mb-3">
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-4 text-center">
                                    <label for="sum" class="form-label fw-bold">
                                        مجموع وزن الأهمية النسبية (%)
                                    </label>
                                    <input type="text" id="total-importance" name="total" class="form-control" value="100" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-4 text-center">
                                    <label for="per" class="form-label fw-bold">
                                        نسبة التأهل (%)
                                    </label>
                                    <input type="text" name="percentage" class="form-control" value="{{ $opportunity->percentage }}" required>
                                </div>
                            </div>

                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-dark text-white">
                                        حفظ
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const importanceInputs = document.querySelectorAll('.importance-input');
            const form = document.getElementById('questions-form');
            const totalImportance = document.getElementById('total-importance');

            function calculateTotalImportance() {
                let total = 0;
                importanceInputs.forEach(input => {
                    const value = parseFloat(input.value);
                    if (!isNaN(value)) {
                        total += value;
                    }
                });

                totalImportance.value = total;
                return total;
            }

            function validateTotalImportance(event) {
                const total = calculateTotalImportance();
                if (total !== 100) {
                    alert('مجموع وزن الأهمية يجب ان يكون 100%');
                    event.preventDefault(); // Prevent form submission
                }
            }

            importanceInputs.forEach(input => {
                input.addEventListener('input', calculateTotalImportance);
            });

            // Initial calculation
            calculateTotalImportance();

            // Add submit event listener to the form
            form.addEventListener('submit', validateTotalImportance);
        });
    </script>

@endsection
