@extends('admin.admin_master')
@section('title')
    nusuk | نٌسكـ (الصفحة الرئيسية)
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
            <div class="row">
                <div class="col text-center">
                    <h3> إحصائيات </h3>
                </div>
            </div>
            <div class="row mt-3">
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th scope="col">البيان</th>
                        <th scope="col">الفرص المتاحة</th>
                        <th scope="col">الفرص المجمدة</th>
                        <th scope="col">الفرص المغلقة</th>
                        <th scope="col">عدد المنظمات المشاركة</th>
                        <th scope="col">عدد المنظمات المتأهلة</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($opportunityData as $item)
                        <tr>
                            <td>
                                {{ $item['opportunity_name'] }}
                            </td>
                            <td>
                                <input type="text" value="{{ $item['countAvailable'] }}" class="form-control text-center count-available" readonly>
                            </td>
                            <td>
                                <input type="text" value="{{ $item['countFrozen'] }}" class="form-control text-center count-frozen" readonly>
                            </td>
                            <td>
                                <input type="text" value="{{ $item['countNotAvailable'] }}" class="form-control text-center count-not-available" readonly>
                             </td>
                            <td>
                                <input type="text" value="{{ $item['countParticipatingOrg'] }}" class="form-control text-center count-participating-org" readonly>
                            </td>
                            <td>
                                <input type="text" value="{{ $item['countQualifiedOrg'] }}" class="form-control text-center count-qualified-org" readonly>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr class="refuse">
                        <td>المجموع</td>
                        <td><input type="number" class="form-control text-center total-for-available" readonly></td>
                        <td><input type="number" class="form-control text-center total-for-frozen" readonly></td>
                        <td><input type="number" class="form-control text-center total-for-not-available" readonly></td>
                        <td><input type="number" class="form-control text-center total-for-participating-org" readonly></td>
                        <td><input type="number" class="form-control text-center total-for-qualified-org" readonly></td>
                    </tr>
                    </tfoot>
                </table>

            </div>

        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function calculateTotals() {
                let totalAvailable = 0;
                let totalFrozen = 0;
                let totalNotAvailable = 0;
                let totalParticipatingOrg = 0;
                let totalQualifiedOrg = 0;

                document.querySelectorAll('.count-available').forEach(input => totalAvailable += parseInt(input.value) || 0);
                document.querySelectorAll('.count-frozen').forEach(input => totalFrozen += parseInt(input.value) || 0);
                document.querySelectorAll('.count-not-available').forEach(input => totalNotAvailable += parseInt(input.value) || 0);
                document.querySelectorAll('.count-participating-org').forEach(input => totalParticipatingOrg += parseInt(input.value) || 0);
                document.querySelectorAll('.count-qualified-org').forEach(input => totalQualifiedOrg += parseInt(input.value) || 0);

                document.querySelector('.total-for-available').value = totalAvailable;
                document.querySelector('.total-for-frozen').value = totalFrozen;
                document.querySelector('.total-for-not-available').value = totalNotAvailable;
                document.querySelector('.total-for-participating-org').value = totalParticipatingOrg;
                document.querySelector('.total-for-qualified-org').value = totalQualifiedOrg;
            }

            calculateTotals();

            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('input', calculateTotals);
            });
        });
    </script>
@endsection
