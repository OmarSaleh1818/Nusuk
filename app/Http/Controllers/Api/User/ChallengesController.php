<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SupAspect;
use App\Models\OrganizationGap;
use App\Models\Gap;
use App\Models\Challenge;
use App\Models\InstitutionalChallenge;
use App\Models\OrganizationChallenge;

class ChallengesController extends Controller
{
    
    // Get Sevtoral Challenges
    public function SectoralChallengesView()
    {
        $user_id = Auth::user()->id;
        $supAspect = SupAspect::all(); 
        $gaps = Gap::all(); 

        $organizationGap = OrganizationGap::where('user_id', $user_id)
        ->get();
        $data =[];

        foreach($organizationGap as $item)
        {
            $data[] = [
                'sub_aspect_id' => $item->sub_aspect_id,
                'gap_id' => $item->gap_id,
            ];
        }

        if ($organizationGap->isNotEmpty()) {
            return response()->json([
                'succeed' => true,
                'message' => 'Sectoral challenges fetched successfully',
                'data' => $data
                
            ]);
        } else {
            return response()->json([
                'succeed' => true,
                'message' => 'No sectoral challenges found for this organization',
                'data' => [
                    'organizationGaps' => 'null'
                ]
            ]);
        }
    }

    // sttore Sectoral Challenges
    public function SectoralChallengesStore(Request $request)
    {
        $user_id = Auth::user()->id;

        $gaps = $request->input('gaps'); 

        foreach ($gaps as $aspectId => $gapId) {
            // Update or create the user's choice for this side
            OrganizationGap::updateOrCreate(
                ['user_id' => $user_id, 'sub_aspect_id' => $aspectId],
                ['gap_id' => $gapId]
            );
        }

        return response()->json(['message' => 'Choices saved successfully']);
    }

    // get Institutional Challenges
    public function InstituationalChallengesView()
    {
        $user_id = Auth::user()->id;
        $institutionalChallenge = InstitutionalChallenge::all(); 
        $Challenge = Challenge::all(); 

        $organizationChallenge = OrganizationChallenge::where('user_id', $user_id)
        ->get();
        $data =[];

        foreach($organizationChallenge as $item)
        {
            $data[] = [
                'institutional_challenge_id' => $item->institutional_challenge_id,
                'challenge_id' => $item->challenge_id,
            ];
        }

        if ($organizationChallenge->isNotEmpty()) {
            return response()->json([
                'succeed' => true,
                'message' => 'Institutional challenges fetched successfully',
                'data' => $data
                
            ]);
        } else {
            return response()->json([
                'succeed' => true,
                'message' => 'No Institutional challenges found for this organization',
                'data' => [
                    'organizationChallenge' => 'null'
                ]
            ]);
        }
    }

    //  Store Institutional Challenges
    public function InstituationalChallengesStore(Request $request)
    {
        $user_id = Auth::user()->id;

        $challenges = $request->input('challenges'); 

        foreach ($challenges as $institutionalId => $challengeId) {
            OrganizationChallenge::updateOrCreate(
                ['user_id' => $user_id, 'institutional_challenge_id' => $institutionalId],
                ['challenge_id' => $challengeId]
            );
        }

        return response()->json([
            'message' => 'Institutional Challenges saved successfully
            ']);
    }


}
