<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partnerships;
use App\Models\PartnershipsType;
use App\Models\partnershipsStatus;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class PartnershipsController extends Controller
{
    
    public function PartnershipsView()
    {

        $user_id = Auth::user()->id;
        $partnerships = Partnerships::where('user_id', $user_id)
                                ->with('type', 'status') 
                                ->get();
        $partnership_type = PartnershipsType::all();
        $status = partnershipsStatus::all();

        if ($partnerships->isEmpty()) {
            return response()->json([
                'message' => 'No partnerships found',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'partnerships' => $partnerships,
            'partnership_types' => $partnership_type,
            'statuses' => $status,
            'message' => 'Partnerships fetched successfully',
            'status' => 200,
        ], 200);

    }

    public function PartnershipsStore(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'partnership_topic' => 'required',
            'partnership_side' => 'required',
            'partnership_type' => 'required',
            'start_date' => 'required|date|before_or_equal:end_date', 
            'end_date' => 'date|after_or_equal:start_date',   
        ]);

        try {
            // Get the authenticated user's ID
            $user_id = Auth::user()->id;

            // Create a new partnership record
            $partnership = Partnerships::create([
                'user_id' => $user_id,
                'partnership_topic' => $validated['partnership_topic'],
                'partnership_side' => $validated['partnership_side'],
                'partnership_type' => $validated['partnership_type'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'created_at' => Carbon::now(),
            ]);

            // Return a JSON response indicating success
            return response()->json([
                'message' => 'Partnership created successfully',
                'partnership' => $partnership,
                'status' => 201,
            ], 201);

        } catch (\Exception $e) {
            // Handle errors and return a JSON response indicating failure
            return response()->json([
                'message' => 'Failed to create partnership',
                'error' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }

    }

    public function PartnershipsEdit($id)
    {
        $partnership = Partnerships::where('id', $id)
                                ->with('type', 'status') 
                                ->first();
        if (!$partnership) {
            return response()->json([
                'message' => 'Partnership not found',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'partnership' => $partnership,
            'message' => 'Partnership fetched successfully',
            'status' => 200
        ]);
    }

    public function PartnershipsUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'partnership_topic' => 'required',
            'partnership_side' => 'required',
            'partnership_type' => 'required', 
            'start_date' => 'required', 
            'end_date' => 'date|after_or_equal:start_date', 
        ]);

        try {
            // Find the partnership by ID
            $partnership = Partnerships::find($id);

            // If the partnership doesn't exist, return a 404 response
            if (!$partnership) {
                return response()->json([
                    'message' => 'Partnership not found',
                    'status' => 404,
                ], 404);
            }
            $partnership->update([
                'partnership_topic' => $validated['partnership_topic'],
                'partnership_side' => $validated['partnership_side'],
                'partnership_type' => $validated['partnership_type'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'updated_at' => Carbon::now(), 
            ]);

            return response()->json([
                'message' => 'Partnership updated successfully',
                'partnership' => $partnership,
                'status' => 200,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update partnership',
                'error' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    public function PartnershipsDelete($id)
    {
         try {
            $partnership = Partnerships::find($id);

            if (!$partnership) {
                return response()->json([
                    'message' => 'Partnership not found',
                    'status' => 404,
                ], 404);
            }

            $partnership->delete();

            return response()->json([
                'message' => 'Partnership deleted successfully',
                'status' => 200,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete partnership',
                'error' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }


}
