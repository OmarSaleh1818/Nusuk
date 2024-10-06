<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Opportunity;
use App\Models\OpportunityData;
use App\Models\Question;
use App\Models\NumericNumber;
use App\Models\Answer;
use Carbon\Carbon;
use App\Models\OpportunityStatus;
use App\Models\OrganizationScore;
use App\Models\User;
use Illuminate\Support\Facades\DB;



class OpportunitiesController extends Controller
{

    public function SectoralOpportunities($id)
    {
        $opportunity_data = OpportunityData::where('opportunity_id', $id)->with('status')->orderBy('id', 'DESC')->get();
        $opportunity = Opportunity::find($id);
        
        return response()->json([
            'succeed' => true,
            'message' => 'Opportunity Data fetched successfully',
            'data' => [
                'opportunity' => $opportunity,
                'opportunity_data' => $opportunity_data,
            ],
        ]);
    }

    public function OpportunityBulkAction(Request $request)
    {
        // Get selected opportunity IDs and the action to perform
        $opportunityIds = $request->input('opportunity_id');
        $action = $request->input('action');
    
        if (!$opportunityIds) {
           return response()->json([
            'success' => false,
            'message' => 'لا يوجد فرصة محددة'
           ], 400); // 400 Bad Request
        }
        if ($action == 'stop') {

            OpportunityData::whereIn('id', $opportunityIds)->update(['status_id' => 3]);
        } elseif ($action == 'delete') {

            OpportunityData::whereIn('id', $opportunityIds)->delete();
        } elseif ($action == 'active') {

            OpportunityData::whereIn('id', $opportunityIds)->update(['status_id' => 1]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'إجراء غير صالح'
            ], 400); // 400 Bad Request
        }

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'تم تنفيذ طلبك'
        ], 200); // 200 OK
    }

    public function AddOpportunity()
    {
        $opportunities = Opportunity::all();
        return response()->json([
            'opportunities' => $opportunities,
            'message' => 'Opportunity Data fetched successfully',
        ], 200); // 200 OK
    }

    public function OpportunityStore(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'about' => 'required',
            'side' => 'required',
            'date_publication' => 'required',
            'deadline_apply' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'question' => 'required|array',
            'is_numeric' => 'required|array',
            'importance' => 'required|array',
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
    
        $questions = $request->input('question');
        $is_numeric = $request->input('is_numeric');
        $answers = $request->input('answer');
        $values = $request->input('value');
        $from_number = $request->input('from_number');
        $to_number = $request->input('to_number');
        $importance = $request->input('importance');
    
        foreach ($questions as $index => $questionText) {
            if (is_null($questionText)) {
                continue; // Skip null questions
            }
        
            // Get `is_decisive` value for the specific question
            $is_decisive_key = "is_decisive_{$index}";
            $is_decisive_value = $request->input($is_decisive_key) ?? 0; // Default to 0 if not provided
        
            $importanceValue = $importance[$index] ?? 0;
            $numeric = $is_numeric[$index] ?? 0;
        
            // Insert question and get the question ID
            $question_id = Question::insertGetId([
                'opportunityData_id' => $data_id,
                'question' => $questionText,
                'importance' => $importanceValue,
                'is_decisive' => $is_decisive_value,
                'is_numeric' => $numeric,
            ]);
        
            // Handle numeric questions
            if ($numeric == 1) {
                // Insert numeric ranges and values for the question
                if (isset($from_number[$index]) && isset($to_number[$index]) && isset($values[$index])) {
                    foreach ($from_number[$index] as $key => $fromVal) {
                        $toVal = $to_number[$index][$key] ?? null;
                        $value = $values[$index][$key] ?? null;
        
                        NumericNumber::insert([
                            'question_id' => $question_id,
                            'from_number' => $fromVal,
                            'to_number' => $toVal,
                            'value' => $value,
                        ]);
                    }
                }
            } else {
                // Handle non-numeric (multiple-choice) questions
                if (isset($answers[$index]) && is_array($answers[$index])) {
                    foreach ($answers[$index] as $key => $answerText) {
                        $answerValue = $values[$index][$key] ?? null;
        
                        Answer::insert([
                            'question_id' => $question_id,
                            'answer' => $answerText,
                            'value' => $answerValue,
                        ]);
                    }
                }
            }
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Opportunity and questions added successfully.',
            'data_id' => $data_id
        ], 201);
    }

    public function OpportunityEye($id)
    {
        $opportunity_data = OpportunityData::find($id);
        $opportunity = Opportunity::where('id', $opportunity_data->opportunity_id)->first();
        // Fetch non-numeric questions
        $question = Question::where('opportunityData_id', $id)->where('is_numeric', 0)->get();
        // Fetch numeric questions
        $questionNumeric = Question::where('opportunityData_id', $id)->where('is_numeric', 1)->get();
        $status = OpportunityStatus::where('id', $opportunity_data->status_id)->first();
        // Initialize arrays to store answers and numeric values
        $answers = [];
        $numericNumbers = [];
        
        // Loop through non-numeric questions and fetch their answers
        if ($question) {
            foreach ($question as $item) {
                $answers[$item->id] = Answer::where('question_id', $item->id)->get();
            }
        }
        
        // Loop through numeric questions and fetch their numeric ranges and values
        if ($questionNumeric) {
            foreach ($questionNumeric as $item) {
                $numericNumbers[$item->id] = NumericNumber::where('question_id', $item->id)->get();
            }
        }
        
        return response()->json([
            'succeed' => true,
            'message' => 'Opportunity and questions fetched successfully.',
            'data' => [
                'opportunity' => $opportunity,
                'opportunity_data' => $opportunity_data,
                'question' => $question,
                'questionNumeric' => $questionNumeric,
                'status' => $status,
                'answers' => $answers,       
                'numericAnswer' => $numericNumbers, 
            ],
        ], 200); // 200 OK
    }

    public function OpportunityUpdate(Request $request, $id)
    {

         // Update the OpportunityData
         $opportunityData = OpportunityData::find($id);
         if (!$opportunityData) {
             return response()->json(['error' => 'Opportunity not found'], 404);
         }
         // Validate the request input
        $validatedData = $request->validate([
            'title' => 'required',
            'about' => 'required',
            'side' => 'required',
            'date_publication' => 'required',
            'deadline_apply' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'question' => 'required|array',
            'importance' => 'required|array',
        ]);

        $opportunityData->update([
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

        // Process questions
        $questionIds = $request->input('question_ids');
        $questions = $request->input('question');
        $importances = $request->input('importance');
        $isDecisives = $request->input('is_decisive', []);
        $answers = $request->input('answer', []);
        $from_numbers = $request->input('from_number', []);
        $to_numbers = $request->input('to_number', []);

        foreach ($questionIds as $index => $questionId) {
            $question = Question::find($questionId);
            if ($question) {
                // Update the question
                $question->update([
                    'question' => $questions[$index],
                    'importance' => $importances[$index],
                    'is_decisive' => $isDecisives[$questionId] ?? 0,
                ]);

                // Update answers (if applicable)
                if (isset($answers[$questionId])) {
                    foreach ($answers[$questionId] as $answerIndex => $answerText) {
                        $answer = Answer::where('question_id', $questionId)->skip($answerIndex)->first();
                        if ($answer) {
                            $answer->update([
                                'answer' => $answerText
                            ]);
                        }
                    }
                }

                // Update numeric ranges (if applicable)
                if (isset($from_numbers[$questionId]) && isset($to_numbers[$questionId])) {
                    foreach ($from_numbers[$questionId] as $rangeIndex => $fromNumber) {
                        $toNumber = $to_numbers[$questionId][$rangeIndex] ?? null;
                        $numericRange = NumericNumber::where('question_id', $questionId)->skip($rangeIndex)->first();
                        if ($numericRange) {
                            $numericRange->update([
                                'from_number' => $fromNumber,
                                'to_number' => $toNumber,
                            ]);
                        } else {
                            // Create new numeric range if it doesn't exist
                            NumericNumber::create([
                                'question_id' => $questionId,
                                'from_number' => $fromNumber,
                                'to_number' => $toNumber,
                                'value' => $rangeIndex + 1, // Assuming the value is sequential
                            ]);
                        }
                    }
                }
            }
        }

        return response()->json([
            'success' => true, 
            'message' => 'Opportunity and questions updated successfully'
        ]);
    }

    public function OpportunityReport($id)
    {
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

        return response()->json([
            'succeed' => true,
            'message' => 'Opportunity Report fetched successfully',
            'data' => [
                'opportunity' => $opportunity,
                'status' => $status,
                'users' => $users,
                'usersNotInCount' => $usersNotInCount,
                'usersInCount' => $usersInCount,
                'userQualificationCount' => $userQualificationCount,
                'userQualificationData' => $userQualificationData,
                'users_Qualification' => $users_Qualification,
                'userNotQualificationCount' => $userNotQualificationCount,
                'userNotQualificationData' => $userNotQualificationData,
                'users_NotQualification' => $users_NotQualification,
            ],
        ]);
    }
    
    


}
