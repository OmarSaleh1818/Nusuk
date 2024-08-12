@extends('frontend.main_master')
@section('title')
    nusuk | نٌسكـ (الفرص القطاعية)
@endsection
@section('main')

    <div class="sign">
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
                                        <a href="{{ route('organization.opportunity', $item->id) }}" class="sidebar-link text-center {{ $item->id == $id ? 'active' : '' }}">
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
                        <div class="container-fluid">
                            <div class="row">
                                <div class="section-header col-md-12">
                                    <span>{{ $opportunity->opportunity_name }}</span>
                                </div>
                                <div class="oppo-controls col-md-12 my-2"></div>
                                <div class="oppo-filter col-md-12 my-2">
                                    <span>عرض الفرص:</span>

                                    <span>
                                        <input class="form-check-input" type="checkbox" value="all" id="oppo-all">
                                        <label class="form-check-label" for="oppo-all">الكل</label>
                                    </span>
                                    <span>
                                        <input class="form-check-input" type="checkbox" value="year" id="oppo-year">
                                        <label class="form-check-label" for="oppo-year">السنة الحالية</label>
                                    </span>
                                    <span>
                                        <input class="form-check-input" type="checkbox" value="open" id="oppo-open">
                                        <label class="form-check-label" for="oppo-open">المتاحة للمشاركة</label>
                                    </span>
                                    <span>
                                        <input class="form-check-input" type="checkbox" value="close" id="oppo-close">
                                        <label class="form-check-label" for="oppo-close">المشتركين فيها حاليًا</label>
                                    </span>
                                    <span>
                                        <input class="form-check-input" type="checkbox" value="pending" id="oppo-pend">
                                        <label class="form-check-label" for="oppo-pend">المشتركين فيها سابقًا</label>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">العنوان</th>
                                <th scope="col">الجهة</th>
                                <th scope="col">آخر موعد للتقديم</th>
                                <th scope="col">حالة الفرصة</th>
                                <th scope="col">حالة المشاركة</th>
                                <th scope="col">الإجراءات</th>
                            </tr>
                            </thead>
                            <tbody id="opportunities-table">
                            @if(Auth::user()->user_permission == 1)
                                @foreach($data as $opportunity)
                                    @php
                                        $user_id = Auth::user()->id;
                                        $status = App\Models\OpportunityStatus::where('id', $opportunity->status_id)->first();
                                        $user_status = App\Models\UserOpportunityStatus::where('user_id', $user_id)->where('opportunity_id', $opportunity->id)->first();
                                        $sharing = App\Models\SharingStatus::find(1);
                                        if ($user_status) {
                                            $sharing_status = App\Models\SharingStatus::where('id', $user_status->status)->first();
                                        }
                                    @endphp
                                    <tr class="{{ !$user_status ? 'refuse' : '' }} opportunity-row"
                                        data-sharing-status="{{ $sharing_status->value ?? $sharing->value }}"
                                        data-user-status="{{ $user_status->status ?? 'none' }}"
                                        data-deadline="{{ \Carbon\Carbon::parse($opportunity->deadline_apply)->format('Y') }}">
                                        <td>{{ $opportunity->title }}</td>
                                        <td style="text-align: center">{{ $opportunity->side }}</td>
                                        <td style="text-align: center">{{ $opportunity->deadline_apply }}</td>
                                        <td style="text-align: center">{{ $status->value }}</td>
                                        <td style="text-align: center">
                                            {{ $user_status ? $sharing_status->value : $sharing->value }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn user">
                                                <a class="text-white" href="{{ route('organization.opportunity.eye', $opportunity->id) }}">
                                                    عرض
                                                </a>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @elseif(Auth::user()->user_permission == 2)
                                @foreach($data as $opportunity)
                                    @php
                                        $user_id = Auth::user()->user_id;
                                        $status = App\Models\OpportunityStatus::where('id', $opportunity->status_id)->first();
                                        $user_status = App\Models\UserOpportunityStatus::where('user_id', $user_id)->where('opportunity_id', $opportunity->id)->first();
                                        $sharing = App\Models\SharingStatus::find(1);
                                        if ($user_status) {
                                            $sharing_status = App\Models\SharingStatus::where('id', $user_status->status)->first();
                                        }
                                    @endphp
                                    <tr class="{{ !$user_status ? 'refuse' : '' }} opportunity-row"
                                        data-sharing-status="{{ $sharing_status->value ?? $sharing->value }}"
                                        data-user-status="{{ $user_status->status ?? 'none' }}"
                                        data-deadline="{{ \Carbon\Carbon::parse($opportunity->deadline_apply)->format('Y') }}">
                                        <td>{{ $opportunity->title }}</td>
                                        <td style="text-align: center">{{ $opportunity->side }}</td>
                                        <td style="text-align: center">{{ $opportunity->deadline_apply }}</td>
                                        <td style="text-align: center">{{ $status->value }}</td>
                                        <td style="text-align: center">
                                            {{ $user_status ? $sharing_status->value : $sharing->value }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn user">
                                                <a class="text-white" href="{{ route('organization.opportunity.eye', $opportunity->id) }}">
                                                    عرض
                                                </a>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                    </section>

                </div>


            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allCheckbox = document.getElementById('oppo-all');
            const openCheckbox = document.getElementById('oppo-open');
            const closeCheckbox = document.getElementById('oppo-close');
            const pendingCheckbox = document.getElementById('oppo-pend');
            const yearCheckbox = document.getElementById('oppo-year');
            const rows = document.querySelectorAll('.opportunity-row');

            const currentYear = new Date().getFullYear();

            allCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    rows.forEach(row => row.style.display = '');
                    openCheckbox.checked = closeCheckbox.checked = pendingCheckbox.checked = yearCheckbox.checked = false;
                }
            });

            openCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    rows.forEach(row => {
                        row.style.display = row.getAttribute('data-user-status') === 'none' ? '' : 'none';
                    });
                    allCheckbox.checked = closeCheckbox.checked = pendingCheckbox.checked = yearCheckbox.checked = false;
                }
            });

            closeCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    rows.forEach(row => {
                        row.style.display = row.getAttribute('data-user-status') === '6' ? '' : 'none';
                    });
                    allCheckbox.checked = openCheckbox.checked = pendingCheckbox.checked = yearCheckbox.checked = false;
                }
            });

            pendingCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    rows.forEach(row => {
                        row.style.display = row.getAttribute('data-user-status') === '7' ? '' : 'none';
                    });
                    allCheckbox.checked = openCheckbox.checked = closeCheckbox.checked = yearCheckbox.checked = false;
                }
            });

            yearCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    rows.forEach(row => {
                        row.style.display = row.getAttribute('data-deadline') == currentYear ? '' : 'none';
                    });
                    allCheckbox.checked = openCheckbox.checked = closeCheckbox.checked = pendingCheckbox.checked = false;
                }
            });
        });
    </script>

@endsection
