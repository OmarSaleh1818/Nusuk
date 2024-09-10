<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrganizationScore;
use Illuminate\Support\Facades\DB;
use App\Models\UserAnswerMultiple;
use App\Models\UserAnswerNumeric;
use App\Models\UserOpportunityStatus;

class ApproveController extends Controller
{
    
    public function AdminApprove($id)
    {
        $score = OrganizationScore::find($id);
        DB::table('organization_scores')
            ->where('id', $id)
            ->update(['status' => 2]);

        return response()->json([
            'score' => $score,
            'message' => 'تمت الموافقة بنجاح',
            'status' => 200
        ]);
    }

    public function AdminReevaluation($id)
    {
        $score = OrganizationScore::find($id);
        UserAnswerMultiple::where('user_id', $score->user_id)->where('opportunityData_id', $score->opportunityData_id)
            ->delete();
        UserAnswerNumeric::where('user_id', $score->user_id)->where('opportunityData_id', $score->opportunityData_id)
            ->delete();

        DB::table('organization_scores')
            ->where('id', $id)
            ->update(['status' => 3]);

        DB::table('user_opportunity_statuses')
            ->where('user_id', $score->user_id)
            ->where('opportunity_id', $score->opportunityData_id)
            ->update(['status' => 11]);

        return response()->json([
            'score' => $score,
            'message' => 'تم طلب إعادة التقييم بنجاح',
            'status' => 200
        ]);
    }

    public function SuperApprove($id)
    {
        $score = OrganizationScore::find($id);

        DB::table('user_opportunity_statuses')
            ->where('user_id', $score->user_id)
            ->where('opportunity_id', $score->opportunityData_id)
            ->update(['status' => 5]);

        DB::table('organization_scores')
            ->where('id', $id)
            ->update(['status' => 4, 'total_percentage' => 100]);

        return response()->json([
            'score' => $score,
            'message' => 'تم الموافقة بنجاح',
            'status' => 200
        ]);
    }

    public function SuperNotApprove($id)
    {
        $score = OrganizationScore::find($id);

        DB::table('user_opportunity_statuses')
            ->where('user_id', $score->user_id)
            ->where('opportunity_id', $score->opportunityData_id)
            ->update(['status' => 12]);

        DB::table('organization_scores')
            ->where('id', $id)
            ->update(['status' => 5]);

        return response()->json([
            'score' => $score,
            'message' => 'تم  استبعاد المنظمة',
            'status' => 200
        ]);
    }

        
    




}
