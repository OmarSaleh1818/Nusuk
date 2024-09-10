<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Opportunity;
use App\Models\Financial;
use Illuminate\Support\Facades\Auth;

class FinancialController extends Controller
{
    
    public function OrganizationFinancial()
    {
        $user_id = Auth::user()->id;
        $financial = Financial::where('user_id', $user_id)->first();
        $opportunities = Opportunity::all();
        return response()->json([
            'financial data' => $financial,
            'opportunities' => $opportunities,
            'message' => 'Financial data fetched successfully',
            'status' => 200,
        ]);
    }

    public function FinancialStore(Request $request)
    {
        $user_id = Auth::user()->id;
        $financial = Financial::where('user_id', $user_id)->first();
        if($financial){
            $financial->update($request->all());
        }else{
            $financial = Financial::create(['user_id' => $user_id] + $request->all());
        }
        return response()->json([
            'financial data' => $financial,
            'message' => 'Financial data updated successfully',
            'status' => 200,
        ]);
    }

}
