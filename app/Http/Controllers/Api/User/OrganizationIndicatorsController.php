<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrganizationPrivateIndicator;
use App\Models\PrivateIndicator;
use Carbon\Carbon;


class OrganizationIndicatorsController extends Controller
{
    
    public function OrganizationPrivateIndicators()
    {
        $user_id = Auth::user()->id;

        $indicator = OrganizationPrivateIndicator::where('user_id', $user_id)->get();

        if ($indicator->isNotEmpty()) {
            return response()->json([
                'succeed' => true,
                'message' => 'Private indicators fetched successfully',
                'data' => $indicator
            ]);
        } else {
            return response()->json([
                'succeed' => false,
                'message' => 'No private indicators found for this organization',
                'data' => null
            ]);
        }
    }

    public function OrganizationPrivateIndicatorsStore(Request $request)
    {
        $user_id = Auth::user()->id;
        // Insert the private indicator
        $privateIndicator = PrivateIndicator::create([
            'indicator_title' => $request->indicator_title,
            'unit_measure' => $request->unit_measure,
            'indicator_nature' => $request->indicator_nature,
            'targeted_period' => $request->targeted_period,
            'created_at' => Carbon::now(),
        ]);
        // Determine the operator from the indicator_nature
        $operator = $privateIndicator->indicator_nature;
        $unitMeasureNumber = $request->unit_measure_number;
        $targetedPeriod = $privateIndicator->targeted_period;

        // Calculate the actual_result based on the operator
        $actualResult = 0;
        
        if ($operator == '+') {
            $actualResult = $unitMeasureNumber + $targetedPeriod; 
        } elseif ($operator == '-') {
            $actualResult = $unitMeasureNumber - $targetedPeriod; 
        }
        // You can extend this logic for other operations

        // Insert into the organization_private_indicators table
        $organizationIndicator = OrganizationPrivateIndicator::create([
            'user_id' => $user_id,
            'opportunityData_id' => $request->opportunityData_id,
            'private_indicator_id' => $privateIndicator->id,
            'unit_measure_number' => $unitMeasureNumber,
            'actual_result' => $actualResult, // Save the calculated result
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Return the response
        if ($privateIndicator && $organizationIndicator) {
            return response()->json([
                'succeed' => true,
                'message' => 'Private indicator and organization data stored successfully',
                'actual_result' => $actualResult, 
            ], 201);
        } else {
            return response()->json([
                'succeed' => false,
                'message' => 'Failed to store private indicator or organization data'
            ], 500);
        }

    }
    

}
