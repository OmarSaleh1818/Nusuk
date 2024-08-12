@extends('admin.admin_master')
@section('title')
    nusuk | نٌسكـ (عرض  بيانات المتطوعين)
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
            <div class="row">
                <div class="col text-center">
                    <h3> المتطوعين </h3>
                </div>
            </div>
            <hr>
            <br>
            <div id="staffSection1">
                <div class="row">
                    <h5>الإجمالي الفعلي لعدد الفرص التطوعية والمتطوعين وساعات التطوّع والقيمة الاقتصادية للتطوع:</h5>
                </div>
                <br>
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th rowspan="2">الجنسية</th>
                        <th rowspan="2">الجنس</th>
                        <th rowspan="2">الفئة العمرية</th>
                        <th rowspan="2">البيان</th>
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
                    @if($volunteerInformation)
                        @foreach($nationalities as $nationality)
                            @foreach($genders as $gender)
                                @foreach($ages as $age)
                                    @foreach($accordings as $according)
                                        <tr>
                                            @if($loop->parent->parent->first && $loop->parent->first && $loop->first)
                                                <td rowspan="{{ count($genders) * count($ages) * count($accordings) }}">{{ $nationality->nationality_name }}</td>
                                            @endif
                                            @if($loop->parent->first && $loop->first)
                                                <td rowspan="{{ count($ages) * count($accordings) }}">{{ $gender->gender_name }}</td>
                                            @endif
                                            @if($loop->first)
                                                <td rowspan="{{ count($accordings) }}">{{ $age->age_group }}</td>
                                            @endif
                                            <td>{{ $according->according_name }}</td>
                                            @foreach($contracts as $contract)
                                                @foreach($regions as $region)
                                                    @php
                                                        $existing = $volunteerInformation->where('nationality_id', $nationality->id)
                                                                    ->where('gender_id', $gender->id)
                                                                    ->where('age_id', $age->id)
                                                                    ->where('region_id', $region->id)
                                                                    ->where('contract_id', $contract->id)
                                                                    ->where('according_id', $according->id)
                                                                    ->first();
                                                    @endphp
                                                    <td>
                                                        <input type="text" name="number[{{ $nationality->id }}][{{ $gender->id }}][{{ $age->id }}][{{ $according->id }}][{{ $contract->id }}][{{ $region->id }}]"
                                                               class="form-control text-center contract-region-input"
                                                               data-nationality="{{ $nationality->id }}"
                                                               data-gender="{{ $gender->id }}"
                                                               data-age="{{ $age->id }}"
                                                               data-according="{{ $according->id }}"
                                                               data-contract="{{ $contract->id }}"
                                                               data-region="{{ $region->id }}"
                                                               oninput="calculateTotals()"
                                                               value="{{ $existing->number ?? '' }}" readonly>
                                                    </td>
                                                @endforeach
                                            @endforeach
                                            <td>
                                                <input type="text" name="total_for_according[{{ $nationality->id }}][{{ $gender->id }}][{{ $age->id }}][{{ $according->id }}]" class="form-control text-center total-for-according" readonly>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4">المجموع</td>
                        @foreach($contracts as $contract)
                            @foreach($regions as $region)
                                <td>
                                    <input type="text" class="form-control total-for-contract-region" data-contract="{{ $contract->id }}" data-region="{{ $region->id }}" readonly>
                                </td>
                            @endforeach
                        @endforeach
                        <td>
                            <input type="text" class="form-control total-for-all" readonly>
                        </td>
                    </tr>
                    </tfoot>
                </table>
                <div class="d-flex justify-content-center" style="gap: 1rem;">

                </div>
            </div>

        </div>


    </div>


    <script>
        function calculateTotals() {
            let inputs = document.querySelectorAll('.contract-region-input');
            let totalForAccording = {};
            let contractRegionTotals = {};
            let grandTotal = 0;

            inputs.forEach(input => {
                let nationalityId = input.getAttribute('data-nationality');
                let genderId = input.getAttribute('data-gender');
                let ageId = input.getAttribute('data-age');
                let accordingId = input.getAttribute('data-according');
                let contractId = input.getAttribute('data-contract');
                let regionId = input.getAttribute('data-region');
                let key = `${nationalityId}-${genderId}-${ageId}-${accordingId}`;
                let contractRegionKey = `${contractId}-${regionId}`;

                totalForAccording[key] = (totalForAccording[key] || 0) + (parseFloat(input.value) || 0);
                contractRegionTotals[contractRegionKey] = (contractRegionTotals[contractRegionKey] || 0) + (parseFloat(input.value) || 0);
                grandTotal += parseFloat(input.value) || 0;
            });

            for (let key in totalForAccording) {
                let [nationalityId, genderId, ageId, accordingId] = key.split('-');
                document.querySelector(`input[name="total_for_according[${nationalityId}][${genderId}][${ageId}][${accordingId}]"]`).value = totalForAccording[key];
            }

            for (let key in contractRegionTotals) {
                let [contractId, regionId] = key.split('-');
                document.querySelector(`.total-for-contract-region[data-contract="${contractId}"][data-region="${regionId}"]`).value = contractRegionTotals[key];
            }

            document.querySelector('.total-for-all').value = grandTotal;
        }

        document.addEventListener('DOMContentLoaded', calculateTotals);
    </script>
@endsection
