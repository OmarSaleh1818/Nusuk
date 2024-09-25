<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Season;
use App\Models\Governance;
use Carbon\Carbon;

class GovernanceController extends Controller
{
    
    public function GovernanceView()
    {
        $user_id = Auth::user()->id;
        $seasons = Season::all();
        // Filter governance by season_id matching the id in the seasons table
        $governance = Governance::where('user_id', $user_id)
                                ->whereHas('season', function($query) {
                                    $query->whereColumn('governances.season_id', 'seasons.id');
                                })
                                ->with('season') // Load the related season data
                                ->get();

        if ($governance->isEmpty()) {
            return response()->json([
                'message' => 'No Governance found',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'governance' => $governance,
            'seasons' => $seasons,
            'message' => 'Governance fetched successfully',
            'status' => 200,
        ], 200);
    }

    public function GovernanceStore(Request $request)
    {
        $user_id = Auth::user()->id;

        $governance = Governance::updateOrCreate(
            [
                'user_id' => $user_id,        
                'season_id' => $request->season_id 
            ],
            [
                'compliance_commitment' => $request->compliance_commitment,
                'transparency_Disclosure' => $request->transparency_Disclosure,
                'financial_safety' => $request->financial_safety,
                'created_at' => Carbon::now(),
            ]
        );

        return response()->json([
            'message' => 'Governance created successfully',
            'governance' => $governance,
            'status' => 201,
        ], 201);
    }


}
