<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationScore;
use App\Models\UserAnswerMultiple;
use App\Models\UserAnswerNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApproveController extends Controller
{

    public function AdminApprove($id)
    {

        DB::table('organization_scores')
            ->where('id', $id)
            ->update(['status' => 2]);

        return redirect()->back()->with('error', 'تمت الموافقة بنجاح');
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

        return redirect()->back()->with('error', 'تم طلب إعادة التقييم بنجاح');
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


        return redirect()->back()->with('error', 'تم الموافقة بنجاح');
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

        return redirect()->back()->with('error', 'تم  استبعاد المنظمة');
    }

}
