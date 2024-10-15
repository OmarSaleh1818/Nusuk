<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SupAspect;
use App\Models\OrganizationGap;
use App\Models\Gap;

class ChallengesController extends Controller
{
    
    public function SectoralChallengesView()
    {
        $user_id = Auth::user()->id;
        $supAspect = SupAspect::all(); // Get all sides
        $gaps = Gap::all(); // Get all available choices

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


}
