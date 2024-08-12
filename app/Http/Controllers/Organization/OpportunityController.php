<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Models\OpportunityData;
use App\Models\OpportunityStatus;
use App\Models\OrganizationStatus;
use App\Models\Question;
use App\Models\SharingStatus;
use App\Models\UserAnswerMultiple;
use App\Models\UserAnswerNumeric;
use App\Models\UserOpportunityStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OpportunityController extends Controller
{

    public function OrganizationOpportunity($id)
    {
        $opportunities = Opportunity::all();
        $data = OpportunityData::where('opportunity_id', $id)->orderBy('id', 'DESC')->get();
        $opportunity = Opportunity::find($id);
        return view('organization.opportunities.opportunity_view', compact('opportunities','opportunity','id','data'));
    }

    public function OrganizationOpportunityEye($id)
    {
        $user_id = Auth::user()->id;
        $user_status = UserOpportunityStatus::where('opportunity_id', $id)->where('user_id', $user_id)->first();
        // Check if a record already exists before creating a new one
        if (!$user_status) {
            UserOpportunityStatus::create([
                'user_id' => $user_id,
                'opportunity_id' => $id,
                'status' => 1,
            ]);
        }
        $opportunities = Opportunity::all();
        $opportunity = OpportunityData::find($id);
        $status = OpportunityStatus::where('id', $opportunity->status_id)->first();
        $add = Opportunity::where('id', $opportunity->opportunity_id)->first();
        $question = Question::where('opportunityData_id', $id)->where('is_numeric', 0)->get();
        $questionNumeric = Question::where('opportunityData_id', $id)->where('is_numeric', 1)->get();
        $answer_multiple = UserAnswerMultiple::where('user_id', $user_id)->where('opportunityData_id', $id)->exists();
        $answer_numeric = UserAnswerNumeric::where('user_id', $user_id)->where('opportunityData_id', $id)->exists();
        $user_organization_id = Auth::user()->user_id;
        $user_multiple = UserAnswerMultiple::where('user_id', $user_organization_id)->where('opportunityData_id', $id)->exists();
        $user_numeric = UserAnswerNumeric::where('user_id', $user_organization_id)->where('opportunityData_id', $id)->exists();

        return view('organization.opportunities.opportunity_eye', compact('opportunities','answer_multiple', 'answer_numeric',
            'opportunity', 'add', 'question', 'questionNumeric', 'id', 'user_organization_id', 'status', 'user_status', 'user_multiple', 'user_numeric'));
    }

    public function UpdateStatus(Request $request)
    {
        $user_id = Auth::user()->id;
        $opportunity_id = $request->opportunityData_id;
        $status = $request->sharing_status;

        // Use updateOrCreate to update existing record or create a new one
        UserOpportunityStatus::updateOrCreate(
            [
                'user_id' => $user_id,
                'opportunity_id' => $opportunity_id
            ],
            [
                'status' => $status
            ]
        );

        return redirect()->back()->with('error', 'تم تغيير حالتك');
    }


}
