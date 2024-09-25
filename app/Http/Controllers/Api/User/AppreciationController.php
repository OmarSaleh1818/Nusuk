<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appreciations;
use App\Models\partnershipsStatus;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AppreciationController extends Controller
{
    
    public function AppreciationView()
    {
        $user_id = Auth::user()->id;
        $appreciation = Appreciations::where('user_id', $user_id)
                                ->with('status') 
                                ->get();
        $status = partnershipsStatus::all();

        if ($appreciation->isEmpty()) {
            return response()->json([
                'message' => 'No Appreciations found',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'appreciation' => $appreciation,
            'statuses' => $status,
            'message' => 'Appreciations fetched successfully',
            'status' => 200,
        ], 200);
    }

    public function AppreciationStore(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'appreciation_type' => 'required',
            'appreciation_topic' => 'required',
            'appreciation_side' => 'required',
            'appreciation_date' => 'required|date|before_or_equal:end_date', 
            'end_date' => 'date|after_or_equal:start_date',   
        ]);

        try {
            // Get the authenticated user's ID
            $user_id = Auth::user()->id;

            // Create a new partnership record
            $appreciation = Appreciations::create([
                'user_id' => $user_id,
                'appreciation_type' => $validated['appreciation_type'],
                'appreciation_topic' => $validated['appreciation_topic'],
                'appreciation_side' => $validated['appreciation_side'],
                'appreciation_date' => $validated['appreciation_date'],
                'end_date' => $validated['end_date'],
                'appreciation_status' => $request->appreciation_status,
                'created_at' => Carbon::now(),
            ]);

            // Return a JSON response indicating success
            return response()->json([
                'message' => 'Appreciation created successfully',
                'appreciations' => $appreciation,
                'status' => 201,
            ], 201);

        } catch (\Exception $e) {
            // Handle errors and return a JSON response indicating failure
            return response()->json([
                'message' => 'Failed to create appreciation',
                'error' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    public function AppreciationEdit($id)
    {
        $appreciation = Appreciations::where('id', $id)
                                ->with('status') 
                                ->first();
        if (!$appreciation) {
            return response()->json([
                'message' => 'Appreciation not found',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'appreciation' => $appreciation,
            'message' => 'Appreciation fetched successfully',
            'status' => 200
        ]);
    }

    public function AppreciationUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'appreciation_type' => 'required',
            'appreciation_topic' => 'required',
            'appreciation_side' => 'required', 
            'appreciation_date' => 'required', 
            'end_date' => 'date|after_or_equal:start_date', 
        ]);

        try {
            // Find the Appreciations by ID
            $appreciation = Appreciations::find($id);

            // If the Appreciations doesn't exist, return a 404 response
            if (!$appreciation) {
                return response()->json([
                    'message' => 'Appreciation not found',
                    'status' => 404,
                ], 404);
            }
            $appreciation->update([
                'appreciation_type' => $validated['appreciation_type'],
                'appreciation_topic' => $validated['appreciation_topic'],
                'appreciation_side' => $validated['appreciation_side'],
                'appreciation_date' => $validated['appreciation_date'],
                'end_date' => $validated['end_date'],
                'updated_at' => Carbon::now(), 
            ]);

            return response()->json([
                'message' => 'Appreciation updated successfully',
                'appreciation' => $appreciation,
                'status' => 200,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update appreciation',
                'error' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    public function AppreciationDelete($id)
    {
        try {
            $appreciation = Appreciations::find($id);

            if (!$appreciation) {
                return response()->json([
                    'message' => 'Appreciations not found',
                    'status' => 404,
                ], 404);
            }

            $appreciation->delete();

            return response()->json([
                'message' => 'Appreciation deleted successfully',
                'status' => 200,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete appreciation',
                'error' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }


}
