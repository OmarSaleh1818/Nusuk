<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Apout;
use App\Models\Opportunity;
use App\Models\LocalType;
use App\Models\LocalDescription;
use App\Models\TypeDescription;



class AboutController extends Controller
{
    
    public function OrganizationBasic()
    {
        $user_id = Auth::user()->id;
        $basic = User::where('id', $user_id)->first();
        $opportunities = Opportunity::all();
        if($basic){
            return response()->json([
                'basic data' => $basic,
                'opportunities' => $opportunities,
                'message' => 'Basic data fetched successfully',
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Basic data not found',
                'status' => 404,
            ]);
        }
    }

    public function BasicUpdate(Request $request)
    {
        $user_id = Auth::user()->id;
        $basic = User::where('id', $user_id)->first();
        if($basic){
            $basic->update($request->all());
            return response()->json([
                'basic data' => $basic,
                'message' => 'Basic data updated successfully',
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Basic data not found',
                'status' => 404,
            ]);
        }
    }

    public function OrganizationAbout()
    {
        $user_id = Auth::user()->id;
        $about = Apout::where('user_id', $user_id)->first();
        $types = LocalType::all();
        $opportunities = Opportunity::all();
        $response = [];

        foreach ($types as $type) {
            // For each type, retrieve related descriptions
            $descriptions = LocalDescription::where('type_id', $type->id)->get();

            // Prepare description data with checked status
            $descriptionData = [];
            foreach ($descriptions as $description) {
                $isChecked = TypeDescription::where('description_id', $description->id)
                                            ->where('user_id', $user_id)
                                            ->exists();

                $descriptionData[] = [
                    'id' => $description->id,
                    'description' => $description->description,
                    'is_checked' => $isChecked // Include the checked status
                ];
            }

            // Add the type and its descriptions to the response array
            $response[] = [
                'type_id' => $type->id,
                'type_name' => $type->type_name,
                'descriptions' => $descriptionData
            ];
        }
        if($about){
            return response()->json([
                'about data' => $about,
                'types' => $types,
                'opportunities' => $opportunities,
                'response' => $response,
                'message' => 'About data fetched successfully', 
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'About data not found',
                'status' => 404,
            ]);
        }
    }

    public function AboutStore(Request $request)
    {
        $user_id = Auth::user()->id;
        // Validate the request
        $request->validate([
            'brief' => 'required',
            'goals' => 'required',
            'vision' => 'required',
            'message' => 'required',
        ]);

        // Update or create the about section
        $about = Apout::updateOrCreate(
            ['user_id' => $user_id],
            [
                'brief' => $request->brief,
                'goals' => $request->goals,
                'vision' => $request->vision,
                'message' => $request->message,
            ]
        );

        // Handle the TypeDescription associations (delete existing and insert new)
        TypeDescription::where('user_id', $user_id)->delete();

        if ($request->has('description_id')) {
            foreach ($request->description_id as $description_id) {
                TypeDescription::create([
                    'user_id' => $user_id,
                    'description_id' => $description_id,
                ]);
            }
        }

        if($about){
            return response()->json([
                'about data' => $about, 
                'message' => 'About data updated successfully',
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'About data not found',
                'status' => 404,
            ]);     
        }
    }
    
    
    


}
