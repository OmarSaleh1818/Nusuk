@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (عرض الفرصة)
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
                                <h3>عرض {{ $add->opportunity_name }}</h3>
                            </div>
                        </div>
                        <hr>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <label>عنوان الفرصة</label>
                                <input type="text" name="title" class="form-control" value="{{ $opportunity->title }}" required readonly>
                            </div>
                        </div>
                        <br>
                        <div id="opportunity">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>نبذة عن الفرصة</label>
                                    <input type="text" name="about" class="form-control" value="{{ $opportunity->about }}" readonly>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>المستهدفون بالمشاركة</label>
                                    <input type="text" name="targeted_people" class="form-control" value="{{ $opportunity->targeted_people }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>شروط الترشح</label>
                                    <input type="text" name="conditions" class="form-control" value="{{ $opportunity->conditions }}" readonly>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>الجهة</label>
                                    <input type="text" name="side" class="form-control" value="{{ $opportunity->side }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>تاريخ النشر</label>
                                    <input type="date" name="date_publication" class="form-control" value="{{ $opportunity->date_publication }}" readonly>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>اخر موعد للتقديم</label>
                                    <input type="date" name="deadline_apply" class="form-control" value="{{ $opportunity->deadline_apply }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>فترة العمل</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>من</label>
                                            <input type="date" name="date_from" class="form-control" value="{{ $opportunity->date_from }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label>إلى</label>
                                            <input type="date" name="date_to" class="form-control" value="{{ $opportunity->date_to }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <form method="post" action="{{ route('update.status') }}">
                                @csrf
                                <input type="hidden" name="opportunityData_id" value="{{ $id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>حالة الفرصة</label>
                                        <input type="text" name="status" class="form-control" value="{{ $status->value }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label>تحديث حالة المشاركة</label>

                                        @php
                                             $user_id = Auth::user()->id;
                                             $user_status = App\Models\UserOpportunityStatus::where('opportunity_id', $id)->where('user_id', $user_id)->first();
                                             $displayStatus = App\Models\OrganizationStatus::where('status_id', $user_status->status)->first();
                                             $organizationStatus = App\Models\OrganizationStatus::find(2);
                                             $organizationBeforeStart = App\Models\OrganizationStatus::find(8);
                                             $organizationAfterStart = App\Models\OrganizationStatus::find(9);
                                        @endphp
                                        @if(Auth::user()->user_permission == 1)
                                            @if($user_status && ($user_status->status == 1 || $user_status->status == 2))
                                                <select name="sharing_status" class="form-select mb-2" required>
                                                    <option value="" selected="" disabled="">اختيار الحالة</option>
                                                    <option value="{{ $organizationStatus->status_id }}" {{ $organizationStatus->status_id == $user_status->status ? 'selected' : '' }}>
                                                        {{ $organizationStatus->value }}
                                                    </option>
                                                </select>
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-dark">حفظ</button>
                                                </div>
                                            @elseif($user_status && $user_status->status == 5)
                                                <select name="sharing_status" class="form-select mb-2" required>
                                                    <option value="" selected="" disabled="">اختيار الحالة</option>
                                                    <option value="{{ $organizationBeforeStart->status_id }}" {{ $organizationBeforeStart->status_id == $user_status->status ? 'selected' : '' }}>
                                                        {{ $organizationBeforeStart->value }}
                                                    </option>
                                                </select>
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-dark">حفظ</button>
                                                </div>
                                            @elseif($user_status && $user_status->status == 6)
                                                <select name="sharing_status" class="form-select mb-2" required>
                                                    <option value="" selected="" disabled="">اختيار الحالة</option>
                                                    <option value="{{ $organizationAfterStart->status_id }}" {{ $organizationAfterStart->status_id == $user_status->status ? 'selected' : '' }}>
                                                        {{ $organizationAfterStart->value }}
                                                    </option>
                                                </select>
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-dark">حفظ</button>
                                                </div>
                                            @elseif($displayStatus)
                                                <input type="text" value="{{ $displayStatus->value }}" class="form-control" readonly>
                                            @endif
                                        @else
                                            <input type="text" value="لا يمكنك تحديث حالة المشاركة لأن ذلك من صلاحيات ظابط الارتباط" class="form-control" readonly>
                                        @endif

                                    </div>
                                </div>
                            </form>
                            <br>
                            <br>
                            <div class="d-flex justify-content-center" style="gap: 2rem;">
                                @if(Auth::user()->user_permission == 1)
                                    @if($answer_multiple || $answer_numeric)
                                        <a href="{{ route('organization.score', $opportunity->id) }}" class="btn btn-dark">نتيجة الاختبار التأهيلي</a>
                                    @else
                                        <button class="btn btn-dark" type="button" id="next">الاختبار التأهيلي</button>
                                    @endif
                                @endif
                                @if(Auth::user()->user_permission == 2)
                                        @if($user_multiple || $user_numeric)
                                            <a href="{{ route('organization.score', $opportunity->id) }}" class="btn btn-dark">نتيجة الاختبار التأهيلي</a>
                                        @endif
                                @endif
                            </div>
                        </div>
                        <div id="question" style="display: none">
                            <form method="post" action="{{ route('organization.answer') }}">
                                @csrf
                                <input type="hidden" name="opportunityData_id" value="{{ $id }}">
                                <input type="hidden" name="question_id" value="{{ $item->id }}">

                                @foreach($question as $item)
                                    @php
                                        $answers = App\Models\Answer::where('question_id', $item->id)->get();
                                        $answers = $answers->shuffle();
                                    @endphp
                                    <legend class="col-form-label col-sm-12 pt-0 mt-4">{{ $item->question }}</legend>
                                    <br>
                                    <div class="d-flex" style="gap: 15px;">
                                        @foreach($answers as $answer)
                                            @if($answer && !empty($answer->id) && !empty($answer->answer))
                                                <label>
                                                    <input type="radio" name="answer_id[{{ $item->id }}]" value="{{ $answer->id }}" required>
                                                    {{ $answer->answer }}
                                                </label>
                                                @error('answer_id')
                                                <span class="text-danger"> {{ $message }}</span>
                                                @enderror
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                                <hr>
                                @foreach($questionNumeric as $item)
                                    <div class="col-md-6 my-3">
                                        <label for="one-ans" class="form-label">
                                            {{ $item->question }}
                                        </label>
                                        <input type="number" name="answer_number[{{ $item->id }}]" class="form-control text-center" placeholder="الاجابة" required>
                                        @error('answer_number')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>

                                    <br>
                                @endforeach
                                <div class="d-flex justify-content-center" style="gap: 2rem;">
                                    <button type="submit" class="btn btn-dark">النتيجة</button>
                                    <button class="btn btn-dark" type="button" id="previous">الرجوع</button>
                                </div>
                            </form>
                        </div>


                    </div>


                </div>

            </div>


        </div>
</div>


    <script>
        document.getElementById('next').addEventListener('click', function() {
            document.getElementById('opportunity').style.display = 'none';
            document.getElementById('question').style.display = 'block';
        });

        document.getElementById('previous').addEventListener('click', function() {
            document.getElementById('opportunity').style.display = 'block';
            document.getElementById('question').style.display = 'none';
        });
    </script>

@endsection
