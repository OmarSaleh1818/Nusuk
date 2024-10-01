<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VolunteerInformation;
use App\Models\Nationality;
use App\Models\Gender;
use App\Models\Age;
use App\Models\Region;
use App\Models\ContractVolunteer;
use App\Models\According;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class VolunteerController extends Controller
{

    public function OrganizationVolunteersSaudi($id)
    {
        $user_id = Auth::id();
        $saudiData = VolunteerInformation::where('user_id', $user_id)
            ->where('nationality_id', $id) 
            ->get()
            ->groupBy(['nationality_id', 'gender_id', 'age_id', 'contract_id', 'region_id', 'according_id']);

        if ($saudiData->isEmpty()) {
            return response()->json([
                'message' => 'No data found for the given nationality',
                'status' => 404
            ]);
        }

        return response()->json([
            'succeed' => true,
            'message' => 'Saudi Volunteers fetched successfully',
            'data' => $saudiData,
        ]);
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
        try {
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

            $volunteer = VolunteerInformation::where('user_id', $user_id)->get();
            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Volunteer data saved successfully.',
                'volunteer' => $volunteer,
            ], 200);

        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save volunteer data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
}
