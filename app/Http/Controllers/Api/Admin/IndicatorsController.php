<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrivateIndicator;
use Carbon\Carbon;


class IndicatorsController extends Controller
{
    
    public function PrivateIndicators()
    {
        $indicators = PrivateIndicator::orderBy('id', 'DESC')->get();
        if ($indicators->isEmpty()) {
            return response()->json([
                'succeed' => false,
                'message' => 'No private indicators found',
                'data' => 'null'
            ], 404);
        }

        return response()->json([
            'succeed' => true,
            'message' => 'Private indicators fetched successfully',
            'data' => $indicators
        ]);
    }

    public function PrivateIndicatorsStore(Request $request)
    {
        $indicator = PrivateIndicator::insert([
            'indicator_title' => $request->indicator_title,
            'unit_measure' => $request->unit_measure,
            'indicator_nature' => $request->indicator_nature,
            'targeted_period' => $request->targeted_period,
            'created_at' => Carbon::now(),
        ]);

        if ($indicator) {
            return response()->json([
                'succeed' => true,
                'message' => 'Private indicator stored successfully',
            ], 201);
        } else {
            return response()->json([
                'succeed' => false,
                'message' => 'Failed to store private indicator'
            ], 500);
        }
    }



}
