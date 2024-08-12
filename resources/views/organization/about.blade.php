@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (البيانات التخصصية)
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
                        <div class="row mt-4">
                            <div class="col text-center">
                                <h3> البيانات التخصصية </h3>
                            </div>
                        </div>
                        <hr>
                        <br>
                        @if(Session::has('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{ session::get('error') }}</strong> .
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="post" action="{{ route('about.store') }}">
                            @csrf
                            @if($about)
                                <input type="hidden" name="id" value="{{ $about->id }}">
                            @endif
                            <!-- Textarea Section -->
                            <div id="textareaSection">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">عن المنظمة</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="brief" rows="3">{{ $about ? $about->brief : '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">الأهداف</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="goals" rows="3">{{ $about ? $about->goals : '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">الرؤية</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="vision" rows="3">{{ $about ? $about->vision : '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">الرسالة</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="message" rows="3">{{ $about ? $about->message : '' }}</textarea>
                                </div>
                                <br>
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="next">التالي</button>
                                </div>
                            </div>

                            <!-- Foreach Section -->
                            <div id="foreachSection" style="display:none;">
                                @foreach($types as $type)
                                    @php
                                        $descriptions = App\Models\LocalDescription::where('type_id', $type->id)->get();
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h5>{{ $type->type_name }}</h5>
                                                <div class="controls">
                                                    @foreach($descriptions as $item)
                                                        @php
                                                            $user_id = Auth::user()->id;
                                                            $checkDescription = App\Models\TypeDescription::where('description_id', $item->id)
                                                                ->where('user_id', $user_id)
                                                                ->exists();
                                                        @endphp
                                                        <div class="form-check" style="display: inline-block; margin-right: 10px;">
                                                            <label>
                                                                <input type="checkbox" class="form-check-input" name="description_id[]" value="{{ $item->id }}" {{ $checkDescription ? 'checked' : '' }}>
                                                                {{ $item->description }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                @endforeach
                                <div class="d-flex justify-content-center" style="gap: 1rem;">
                                    <button class="btn btn-dark text-white" style="background-color: #b49164;" type="submit">حفظ</button>
                                    <button type="button" class="btn btn-dark text-white" style="background-color: #b49164;" id="previous">السابق</button>
                                </div>
                                <br>
                                <br>
                            </div>
                        </form>
                    </div>
                </section>

            </div>


        </div>
    </div>

    <script>
        document.getElementById('next').addEventListener('click', function() {
            document.getElementById('textareaSection').style.display = 'none';
            document.getElementById('foreachSection').style.display = 'block';
        });

        document.getElementById('previous').addEventListener('click', function() {
            document.getElementById('textareaSection').style.display = 'block';
            document.getElementById('foreachSection').style.display = 'none';
        });
    </script>

@endsection
