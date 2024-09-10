<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffInformation;
use App\Models\StaffOther;
use App\Models\StaffRepresent;
use App\Models\Nationality;
use App\Models\Gender;
use App\Models\Age;
use App\Models\Region;
use App\Models\Contract;
use App\Models\Degree;
use App\Models\StaffDegree;
use App\Models\Operation;
use App\Models\According;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $existingData = StaffInformation::where('user_id', $user_id)->groupBy(['nationality_id', 'gender_id', 'age_id', 'contract_id', 'region_id']);
        $opportunities = Opportunity::all();
    
        $staffDegreeData = [];

        foreach ($degrees as $degree) {
            foreach ($operations as $operation) {
                // Get the existing data for the current degree and operation
                $staffDegree = StaffDegree::where('user_id', $user_id)
                    ->where('degree_id', $degree->id)
                    ->where('operation_id', $operation->id)
                    ->first();

                // Structure the data for the API response
                $staffDegreeData[] = [
                    'degree_name' => $degree->degree_name,
                    'operation_name' => $operation->operation_name,
                    'engaged' => $staffDegree->engaged ?? null,
                    'not_engaged' => $staffDegree->not_engaged ?? null,
                    'certified' => $staffDegree->certified ?? null,
                    'not_certified' => $staffDegree->not_certified ?? null,
                    'office_work' => $staffDegree->office_work ?? null,
                    'field_work' => $staffDegree->field_work ?? null,
                    'mixed_work' => $staffDegree->mixed_work ?? null,
                    'total' => $staffDegree->total ?? null,
                    'degree_id' => $degree->id,
                    'operation_id' => $operation->id
                ];
            }
        }
        return response()->json([
            'nationalities' => $nationalities,
            'genders' => $genders,
            'ages' => $ages,
            'regions' => $regions,
            'contracts' => $contracts,
            'degrees' => $degrees,
            'operations' => $operations,
            'accordings' => $accordings,
            'staffOthers' => $staffOthers,
            'staffRepresent' => $staffRepresent,
            'existingData' => $existingData,
            'opportunities' => $opportunities,
            'staffDegreeData' => $staffDegreeData,
            'message' => 'Data fetched successfully',
            'status' => 200
        ]);
    }

    public function StaffStore(Request $request)
    {
        $user_id = Auth::user()->id;

        // ------------- StaffRepresent Data -------------
        StaffRepresent::updateOrCreate(
            ['user_id' => $user_id],
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
        $staffRepresent = StaffRepresent::where('user_id', $user_id)->first();  

        // ------------- StaffInformation Data -------------
        $data = $request->all();
        // Loop through the provided data and insert/update in the database
        foreach ($data['number'] as $nationalityId => $genders) {
            if (!is_array($genders)) {
                continue; // Skip if not an array
            }
            foreach ($genders as $genderId => $ages) {
                if (!is_array($ages)) {
                    continue;
                }
                foreach ($ages as $ageId => $contracts) {
                    if (!is_array($contracts)) {
                        continue;
                    }
                    foreach ($contracts as $contractId => $regions) {
                        if (!is_array($regions)) {
                            continue;
                        }
                        foreach ($regions as $regionId => $number) {
                            // Process only if $number is not null or empty
                            if (!is_null($number) && $number !== '') {
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
        $staffInformation = StaffInformation::where('user_id', $user_id)->get();

        // ------------- StaffDegree Data -------------
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
        $staffDegree = StaffDegree::where('user_id', $user_id)->get();

        // ------------- StaffOther Data -------------
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
        $staffOther = StaffOther::where('user_id', $user_id)->first();

        return response()->json([
            'staffRepresent' => $staffRepresent,
            'staffInformation' => $staffInformation,
            'staffDegree' => $staffDegree,
            'staffOther' => $staffOther,
            'message' => 'Data stored successfully',
            'status' => 200
        ]);
    }




}
