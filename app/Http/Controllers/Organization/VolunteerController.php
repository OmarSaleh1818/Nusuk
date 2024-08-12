<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\According;
use App\Models\Age;
use App\Models\ContractVolunteer;
use App\Models\Degree;
use App\Models\Gender;
use App\Models\Nationality;
use App\Models\Operation;
use App\Models\Opportunity;
use App\Models\Region;
use App\Models\StaffDegree;
use App\Models\VolunteerDegree;
use App\Models\VolunteerInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{

    public function OrganizationVolunteers()
    {
        $nationalities = Nationality::all();
        $genders = Gender::all();
        $ages = Age::all();
        $regions = Region::all();
        $contracts = ContractVolunteer::all();
        $opportunities = Opportunity::all();
        $degrees = Degree::all();
        $operations = Operation::all();
        $accordings = According::all();
        $existingData = VolunteerInformation::all()->groupBy(['nationality_id', 'gender_id', 'age_id', 'contract_id', 'region_id']);
        return view('organization.volunteers', compact('nationalities', 'accordings', 'opportunities',
            'genders', 'ages', 'regions', 'contracts', 'existingData', 'degrees', 'operations'));
    }

    public function VolunteerStore(Request $request)
    {

        $data = $request->all();
        $user_id = Auth::user()->id;

        // Prepare an array to hold the insert and update data
        $insertData = [];

        foreach ($data['number'] as $nationalityId => $genders) {
            foreach ($genders as $genderId => $ages) {
                foreach ($ages as $ageId => $accordings) {
                    foreach ($accordings as $accordingId => $contracts) {
                        foreach ($contracts as $contractId => $regions) {
                            foreach ($regions as $regionId => $number) {
                                // Only add data if number is not null or empty
                                if (!is_null($number) && $number !== '') {
                                    $insertData[] = [
                                        'user_id' => $user_id,
                                        'nationality_id' => $nationalityId,
                                        'gender_id' => $genderId,
                                        'age_id' => $ageId,
                                        'according_id' => $accordingId,
                                        'contract_id' => $contractId,
                                        'region_id' => $regionId,
                                        'number' => $number
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }

        // Perform batch insert or update
        DB::transaction(function () use ($insertData) {
            foreach ($insertData as $data) {
                VolunteerInformation::updateOrCreate(
                    [
                        'user_id' => $data['user_id'],
                        'nationality_id' => $data['nationality_id'],
                        'gender_id' => $data['gender_id'],
                        'age_id' => $data['age_id'],
                        'according_id' => $data['according_id'],
                        'contract_id' => $data['contract_id'],
                        'region_id' => $data['region_id'],
                    ],
                    ['number' => $data['number']]
                );
            }
        });

        return redirect()->back()->with('error', 'تم حفظ المعلومات بنجاح');

    }


}
