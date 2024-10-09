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
        if($financial){
            return response()->json([
            'succeed' => true,
            'message' => 'Financial data fetched successfully',
            'data' => $financial,
        ]);
        }else{
            return response()->json([
                'message' => 'Financial data not found',
                'succeed' => false,
            ]);     
        }
        
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
            'succeed' => true,
            'message' => 'Financial data updated successfully',
            'data' => $financial,
        ]);
    }

}
