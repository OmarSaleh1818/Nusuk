<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\NumericNumber;
use App\Models\Opportunity;
use App\Models\OpportunityData;
use App\Models\OpportunityStatus;
use App\Models\OrganizationScore;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpportunitiesController extends Controller
{

    public function SectoralOpportunities($id)
    {
        $opportunities = Opportunity::all();
        $data = OpportunityData::where('opportunity_id', $id)->orderBy('id', 'DESC')->get();
        $opportunity = Opportunity::find($id);
        return view('admin.opportunities.opportunities_view', compact('opportunities', 'opportunity', 'id', 'data'));
    }

    public function AddOpportunity($id)
    {
        $opportunities = Opportunity::all();
        $add = Opportunity::where('id', $id)->first();
        $opportunity = OpportunityData::find($id);
        return view('admin.opportunities.add_opportunity', compact('opportunity',
            'opportunities', 'add', 'id'));
    }

    public function OpportunityStore(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'about' => 'required',
            'side' => 'required',
            'date_publication' => 'required',
            'deadline_apply' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'question' => 'required',
        ]);

        $data_id = OpportunityData::insertGetId([
            'opportunity_id' => $request->opportunity_id,
            'title' => $request->title,
            'about' => $request->about,
            'targeted_people' => $request->targeted_people,
            'conditions' => $request->conditions,
            'side' => $request->side,
            'date_publication' => $request->date_publication,
            'deadline_apply' => $request->deadline_apply,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'organization_number' => $request->organization_number,
            'percentage' => $request->percentage,
            'created_at' => Carbon::now('Asia/Riyadh'),
        ]);

        // Insert questions and answers
        $questions = $request->input('question');
        $is_numeric = $request->input('is_numeric');
        $answers = $request->input('answer');
        $values = $request->input('value');
        $from_number = $request->input('from_number');
        $to_number = $request->input('to_number');
        $importance = $request->input('importance');
        $is_decisive = [];

        foreach ($questions as $index => $questionText) {
            if (is_null($questionText)) {
                continue; // Skip null questions
            }
            $is_decisive_key = "is_decisive_{$index}";
            $is_decisive_value = $request->input($is_decisive_key);
            $is_decisive[$index] = $is_decisive_value;

            // Ensure importance is not null
            $importanceValue = $importance[$index] ?? 0;
            $numeric = $is_numeric[$index] ?? 0;

            $question_id = Question::insertGetId([
                'opportunityData_id' => $data_id,
                'question' => $questionText,
                'importance' => $importanceValue,
                'is_decisive' => $is_decisive[$index],
                'is_numeric' => $numeric,
            ]);

            if ($numeric) {
                // Handle numeric questions
                if (isset($from_number[$index]) && is_array($from_number[$index]) && isset($to_number[$index]) && is_array($to_number[$index])) {
                    // Allow null values in numeric inputs
                    $limitedFrom = array_slice($from_number[$index], 0, 5);
                    $limitedTo = array_slice($to_number[$index], 0, 5);
                    $limitedValues = array_slice($values[$index], 0, 5);

                    foreach ($limitedFrom as $key => $FromNumber) {
                        NumericNumber::insert([
                            'question_id' => $question_id,
                            'from_number' => $FromNumber,
                            'to_number' => $limitedTo[$key] ?? null,
                            'value' => $limitedValues[$key] ?? null,
                        ]);
                    }
                }
            } else {
                // Handle non-numeric questions
                if (isset($answers[$index]) && is_array($answers[$index])) {
                    // Limit to 5 answers
                    $limitedAnswers = array_slice($answers[$index], 0, 5);
                    $limitedValues = array_slice($values[$index], 0, 5);

                    foreach ($limitedAnswers as $key => $answerText) {
                        Answer::insert([
                            'question_id' => $question_id,
                            'answer' => $answerText,
                            'value' => $limitedValues[$key] ?? null,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('sectoral.opportunities', $id)->with('error', 'تم إضافة الفرصة بنجاح');

    }

    public function OpportunityEye($id)
    {
        $opportunities = Opportunity::all();
        $opportunity = OpportunityData::find($id);
        $add = Opportunity::where('id', $opportunity->opportunity_id)->first();
        $question = Question::where('opportunityData_id', $id)->where('is_numeric', 0)->get();
        $questionNumeric = Question::where('opportunityData_id', $id)->where('is_numeric', 1)->get();
        $status = OpportunityStatus::where('id', $opportunity->status_id)->first();
        return view('admin.opportunities.opportunity_eye', compact('opportunities', 'add',
            'id', 'opportunity', 'question', 'questionNumeric', 'status'));
    }

    public function OpportunityUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'about' => 'required',
            'side' => 'required',
            'date_publication' => 'required',
            'deadline_apply' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'question' => 'required',
        ]);

        OpportunityData::find($id)->update([
            'title' => $request->title,
            'about' => $request->about,
            'targeted_people' => $request->targeted_people,
            'conditions' => $request->conditions,
            'side' => $request->side,
            'date_publication' => $request->date_publication,
            'deadline_apply' => $request->deadline_apply,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'organization_number' => $request->organization_number,
            'percentage' => $request->percentage,
            'updated_at' => Carbon::now('Asia/Riyadh'),
        ]);

        $questionIds = $request->input('question_ids');
        $questions = $request->input('question');
        $importances = $request->input('importance');
        $isDecisives = $request->input('is_decisive');
        $answers = $request->input('answer');
        $from_numbers = $request->input('from_number');
        $to_numbers = $request->input('to_number');

        foreach ($questionIds as $index => $id) {
            $question = Question::find($id);
            $question->question = $questions[$index];
            $question->importance = $importances[$index];
            $question->is_decisive = isset($isDecisives[$id]) ? $isDecisives[$id] : null;
            $question->save();

            // Update answers
            if (isset($answers[$id])) {
                foreach ($answers[$id] as $answerIndex => $answerText) {
                    $answer = Answer::where('question_id', $id)->skip($answerIndex)->first();
                    if ($answer) {
                        $answer->answer = $answerText;
                        $answer->save();
                    }
                }
            }

            // Update numeric ranges
            if (isset($from_numbers[$id]) && isset($to_numbers[$id])) {
                foreach ($from_numbers[$id] as $rangeIndex => $fromNumber) {
                    $toNumber = $to_numbers[$id][$rangeIndex] ?? null;
                    $numericRange = NumericNumber::where('question_id', $id)->skip($rangeIndex)->first();
                    if ($numericRange) {
                        $numericRange->from_number = $fromNumber;
                        $numericRange->to_number = $toNumber;
                        $numericRange->save();
                    } else {
                        // If no existing range, create a new one
                        NumericNumber::create([
                            'question_id' => $id,
                            'from_number' => $fromNumber,
                            'to_number' => $toNumber,
                            'value' => $rangeIndex + 1, // Assuming the value should be sequential
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('error', 'تم تعديل الفرصة بنجاح');
    }

    public function OpportunityBulkAction(Request $request)
    {
        $opportunityIds = $request->input('opportunity_id');
        $action = $request->input('action');

        if (!$opportunityIds) {
            return redirect()->back()->with('error', 'لا توجد فرصة محددة');
        }

        if ($action == 'stop') {

            OpportunityData::whereIn('id', $opportunityIds)->update(['status_id' => 3]);
        } elseif ($action == 'delete') {

            OpportunityData::whereIn('id', $opportunityIds)->delete();
        } elseif ($action == 'active') {

            OpportunityData::whereIn('id', $opportunityIds)->update(['status_id' => 1]);
        }

        return redirect()->back()->with('error', 'تم تنفيذ طلبك');
    }

    public function OpportunityReport($id)
    {
        $opportunities = Opportunity::all();
        $opportunity = OpportunityData::find($id);
        $status = OpportunityStatus::where('id', $opportunity->status_id)->first();
        $users = User::where('user_permission', 1)->count();
        $allUsers = User::where('user_permission', 1)->pluck('id')->toArray();
        $usersInOpportunity = OrganizationScore::where('opportunityData_id', $id)
            ->pluck('user_id')
            ->toArray();
        $usersNotInOpportunity = array_diff($allUsers, $usersInOpportunity);
        $usersNotInCount = count($usersNotInOpportunity);
        $usersInCount = OrganizationScore::where('opportunityData_id', $id)
            ->distinct('user_id')
            ->count('user_id');

        $userQualificationCount = DB::table('organization_scores')
            ->join('opportunity_data', 'organization_scores.opportunityData_id', '=', 'opportunity_data.id')
            ->where('organization_scores.opportunityData_id', $id)
            ->whereColumn('organization_scores.total_percentage', '>=', 'opportunity_data.percentage')
            ->count('organization_scores.user_id');

        $userQualificationData = DB::table('organization_scores')
            ->join('opportunity_data', 'organization_scores.opportunityData_id', '=', 'opportunity_data.id')
            ->where('organization_scores.opportunityData_id', $id)
            ->whereColumn('organization_scores.total_percentage', '>=', 'opportunity_data.percentage')
            ->pluck('organization_scores.user_id');

        $users_Qualification = User::whereIn('id', $userQualificationData->toArray())->get();

        $userNotQualificationCount = DB::table('organization_scores')
            ->join('opportunity_data', 'organization_scores.opportunityData_id', '=', 'opportunity_data.id')
            ->where('organization_scores.opportunityData_id', $id)
            ->whereColumn('organization_scores.total_percentage', '<', 'opportunity_data.percentage')
            ->count('organization_scores.user_id');

        $userNotQualificationData = DB::table('organization_scores')
            ->join('opportunity_data', 'organization_scores.opportunityData_id', '=', 'opportunity_data.id')
            ->where('organization_scores.opportunityData_id', $id)
            ->whereColumn('organization_scores.total_percentage', '<', 'opportunity_data.percentage')
            ->pluck('organization_scores.user_id');

        $users_NotQualification = User::whereIn('id', $userNotQualificationData->toArray())->get();

        return view('admin.opportunities.opportunity_report', compact('opportunity', 'users_Qualification', 'users_NotQualification',
            'status', 'users', 'usersNotInCount', 'usersInCount', 'userQualificationCount', 'opportunities', 'userNotQualificationCount'));
    }





}
