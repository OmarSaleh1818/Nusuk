<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\According;
use App\Models\Age;
use App\Models\Contract;
use App\Models\Degree;
use App\Models\Gender;
use App\Models\Nationality;
use App\Models\Operation;
use App\Models\Opportunity;
use App\Models\Region;
use App\Models\StaffDegree;
use App\Models\StaffInformation;
use App\Models\StaffOther;
use App\Models\StaffRepresent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{

    public function OrganizationStaff()
    {
        $user_id = Auth::user()->id;
        $nationalities = Nationality::all();
        $genders = Gender::all();
        $ages = Age::all();
        $regions = Region::all();
        $contracts = Contract::all();
        $degrees = Degree::all();
        $operations = Operation::all();
        $accordings = According::all();
        $staffOthers = StaffOther::where('user_id', $user_id)->first();
        $staffRepresent = StaffRepresent::where('user_id', $user_id)->first();
        $existingData = StaffInformation::all()->groupBy(['nationality_id', 'gender_id', 'age_id', 'contract_id', 'region_id']);
        $opportunities = Opportunity::all();
        return view('organization.staff', compact('nationalities',
            'genders', 'ages', 'regions', 'contracts', 'existingData', 'degrees'
                        , 'operations', 'accordings', 'staffOthers' , 'staffRepresent', 'opportunities'));
    }

    public function StaffStore(Request $request)
    {
        $data = $request->all();
        $user_id = Auth::user()->id;

        // Debugging - Log the received data
        \Log::info('Form Data:', $data);

        StaffRepresent::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'name_notCeo' => $request->name_notCeo,
                'name_ceo' => $request->name_ceo,
                'family_notCeo' => $request->family_notCeo,
                'family_ceo' => $request->family_ceo,
                'position_notCeo' => $request->position_notCeo,
                'position_ceo' => $request->position_ceo,
                'year_notCeo' => $request->year_notCeo,
                'year_ceo' => $request->year_ceo,
                'mobile_notCeo' => $request->mobile_notCeo,
                'mobile_ceo' => $request->mobile_ceo,
                'email_notCeo' => $request->email_notCeo,
                'email_ceo' => $request->email_ceo,
                'link_notCeo' => $request->link_notCeo,
                'link_ceo' => $request->link_ceo,
                'age_notCeo' => $request->age_notCeo,
                'age_ceo' => $request->age_ceo,
                'education_notCeo' => $request->education_notCeo,
                'education_ceo' => $request->education_ceo,
            ]
        );

        foreach ($data['number'] as $nationalityId => $genders) {
            foreach ($genders as $genderId => $ages) {
                foreach ($ages as $ageId => $contracts) {
                    foreach ($contracts as $contractId => $regions) {
                        foreach ($regions as $regionId => $number) {
                            // Check if the number is not null or empty
                            if (!is_null($number) && $number !== '') {
                                // Debugging - Log the values being processed
                                \Log::info("Processing: Nationality: $nationalityId, Gender: $genderId, Age: $ageId, Contract: $contractId, Region: $regionId, Number: $number");

                                StaffInformation::updateOrCreate(
                                    [
                                        'user_id' => $user_id,
                                        'nationality_id' => $nationalityId,
                                        'gender_id' => $genderId,
                                        'age_id' => $ageId,
                                        'contract_id' => $contractId,
                                        'region_id' => $regionId
                                    ],
                                    ['number' => $number]
                                );
                            }
                        }
                    }
                }
            }
        }

        foreach ($request->staffDegree as $degreeId => $operations) {
            foreach ($operations as $operationId => $data) {
                StaffDegree::updateOrCreate(
                    [
                        'user_id' => auth()->id(),
                        'degree_id' => $degreeId,
                        'operation_id' => $operationId,
                    ],
                    [
                        'engaged' => $data['engaged'],
                        'not_engaged' => $data['not_engaged'],
                        'certified' => $data['certified'],
                        'not_certified' => $data['not_certified'],
                        'office_work' => $data['office_work'],
                        'field_work' => $data['field_work'],
                        'mixed_work' => $data['mixed_work'],
                        'total' => $data['total'],
                        'is_volunteer' => 0,
                    ]
                );
            }
        }

        StaffOther::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'benefit_male' => $request->benefit_male,
                'benefit_female' => $request->benefit_female,
                'benefit_total' => $request->benefit_total,
                'fees_male' => $request->fees_male,
                'fees_female' => $request->fees_female,
                'fees_total' => $request->fees_total,
                'free_male' => $request->free_male,
                'free_female' => $request->free_female,
                'free_total' => $request->free_total,
                'expenses_male' => $request->expenses_male,
                'expenses_female' => $request->expenses_female,
                'expenses_total' => $request->expenses_total,
                'value_male' => $request->value_male,
                'value_female' => $request->value_female,
                'value_total' => $request->value_total,
                'graduates_male' => $request->graduates_male,
                'graduates_female' => $request->graduates_female,
                'graduates_total' => $request->graduates_total,
                'fullTime_male' => $request->fullTime_male,
                'fullTime_female' => $request->fullTime_female,
                'fullTime_total' => $request->fullTime_total,
                'partTime_male' => $request->partTime_male,
                'partTime_female' => $request->partTime_female,
                'partTime_total' => $request->partTime_total,
                'consulting_male' => $request->consulting_male,
                'consulting_female' => $request->consulting_female,
                'consulting_total' => $request->consulting_total,
                'management_male' => $request->management_male,
                'management_female' => $request->management_female,
                'management_total' => $request->management_total,
                'workers_male' => $request->workers_male,
                'workers_female' => $request->workers_female,
                'workers_total' => $request->workers_total,
                'trainees_male' => $request->trainees_male,
                'trainees_female' => $request->trainees_female,
                'trainees_total' => $request->trainees_total,
            ]
        );


        return redirect()->back()->with('error', 'تم حفظ المعلومات بنجاح');
    }


}
