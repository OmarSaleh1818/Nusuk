<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Opportunity;
use App\Models\OpportunityData;
use App\Models\UserOpportunityStatus;
use App\Models\OpportunityStatus;
use App\Models\Question;
use App\Models\UserAnswerMultiple;
use App\Models\UserAnswerNumeric;
use App\Models\OrganizationStatus;
use App\Models\Answer;
use App\Models\AnswerNumeric;
use App\Models\AnswerChoice;
use App\Models\NumericNumber;
use App\Models\OrganizationScore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OpportunityController extends Controller
{
    
    public function OrganizationOpportunity($id)
    {
        $opportunities = Opportunity::all();
        $opportunityData = OpportunityData::where('opportunity_id', $id)->orderBy('id', 'DESC')->get();
        $opportunity = Opportunity::find($id);
        if($opportunity){
            return response()->json([
                'opportunities' => $opportunities,
                'opportunityData' => $opportunityData,
                'opportunity' => $opportunity,
                'message' => 'Opportunity fetched successfully',
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'Opportunity not found',
                'status' => 404,
            ]);
        }
    }

    public function OrganizationOpportunityEye($id)
    {
        $user_id = Auth::user()->id;
        $user_status = UserOpportunityStatus::where('opportunity_id', $id)->where('user_id', $user_id)->first();
        
        // Initialize displayStatus to null to avoid undefined variable error
        $displayStatus = null;

        // Check if a record already exists before creating a new one
        if (!$user_status) {
            UserOpportunityStatus::create([
                'user_id' => $user_id,
                'opportunity_id' => $id,
                'status' => 1,
            ]);
        } else {
            // Set displayStatus only if $user_status is available
            $displayStatus = OrganizationStatus::where('status_id', $user_status->status)->first();
        }

        // Fetch all necessary data
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
        $organizationStatus = OrganizationStatus::all();

        $answers = [];
        foreach($question as $item){
            $answer = Answer::where('question_id', $item->id)->get();
            $answers = $answer->shuffle();
        }

        // Response data
        return response()->json([
            'opportunity_data' => $opportunity,
            'opportunity_status' => $status,
            'opportunity' => $add,
            'question' => $question,
            'question_numeric' => $questionNumeric,
            'answers' => $answers,
            'answer_numeric' => $answer_numeric,
            'answer_multiple' => $answer_multiple,
            'user_multiple' => $user_multiple,
            'user_numeric' => $user_numeric,
            'user_status' => $user_status,
            'display_status' => $displayStatus,
            'organization_status' => $organizationStatus,
            'message' => 'Opportunity fetched successfully',
            'status' => 200,
        ]);
    }

    public function UpdateStatus(Request $request)
    {
        $user_id = Auth::user()->id;
        $opportunity_id = $request->opportunityData_id;
        $status = $request->organization_status;
    
        // Use updateOrCreate to update existing record or create a new one
        $userOpportunityStatus = UserOpportunityStatus::updateOrCreate(
            [
                'user_id' => $user_id,
                'opportunity_id' => $opportunity_id
            ],
            [
                'status' => $status
            ]
        );
    
        // Return a JSON response after updating or creating the record
        return response()->json([
            'user_status' => $userOpportunityStatus,
            'message' => 'Status updated successfully',
            'status' => $userOpportunityStatus->status
        ], 200);
    }

    public function OrganizationAnswer(Request $request,$id)
    {
        $user_id = Auth::user()->id;
        $opportunityData_id = $id;
    
        // Insert selected multiple choice answers
        if ($request->has('answer_id')) {
            foreach ($request->answer_id as $question_id => $answer_id) {
                UserAnswerMultiple::create([
                    'user_id' => $user_id,
                    'opportunityData_id' => $opportunityData_id,
                    'question_id' => $question_id,
                    'answer_id' => $answer_id,
                ]);
            }
        }
    
        // Insert numeric answers
        if ($request->has('answer_number')) {
            foreach ($request->answer_number as $question_id => $answer_number) {
                UserAnswerNumeric::create([
                    'user_id' => $user_id,
                    'opportunityData_id' => $opportunityData_id,
                    'question_id' => $question_id,
                    'answer_number' => $answer_number,
                ]);
            }
        }
    
        // Calculate evaluation score
        $totalEvaluationScore = 0;
    
        // Retrieve multiple choice answers
        $multipleChoiceAnswers = UserAnswerMultiple::where('user_id', $user_id)
            ->where('opportunityData_id', $opportunityData_id)
            ->get();
    
        // Retrieve numeric answers
        $numericAnswers = UserAnswerNumeric::where('user_id', $user_id)
            ->where('opportunityData_id', $opportunityData_id)
            ->get();
    
        // Calculate evaluation score for multiple choice answers
        foreach ($multipleChoiceAnswers as $answer) {
            $question = Question::find($answer->question_id);
            $answer_multiple = Answer::find($answer->answer_id);
    
            if ($question->is_decisive && $answer_multiple->value != 5) {
                $evaluationScore = 0;
            } else {
                $answerValue = $answer_multiple->value; // Assuming Answer model has the 'value' field
                $evaluationScore = $answerValue * ($question->importance / 100);
            }
    
            $totalEvaluationScore += $evaluationScore;
        }
    
        // Calculate evaluation score for numeric answers
        foreach ($numericAnswers as $answer) {
            $question = Question::find($answer->question_id);
            $numericAnswer = $answer->answer_number;
    
            // Find the matching answer choice based on from_number and to_number range
            $answerChoices = NumericNumber::where('question_id', $question->id)
                ->where('from_number', '<=', $numericAnswer)
                ->where('to_number', '>=', $numericAnswer)
                ->get();
    
            foreach ($answerChoices as $answerChoice) {
                $evaluationScore = $answerChoice->value * ($question->importance / 100);
                $isValidAnswer = true;
    
                // Apply decisive condition
                if ($question->is_decisive && ($answerChoice->value != 5 || !$isValidAnswer)) {
                    $evaluationScore = 0;
                }
    
                $totalEvaluationScore += $evaluationScore;
            }
        }
    
        // Calculate percentage
        $totalPercentage = ($totalEvaluationScore * 100) / 5;
    
        // Insert into OrganizationScore
        OrganizationScore::updateOrCreate(
            [
                'user_id' => $user_id,
                'opportunityData_id' => $opportunityData_id
            ],
            [
                'evaluation_score' => $totalEvaluationScore,
                'total_percentage' => $totalPercentage,
                'status' => 1
            ]
        );
    
        // Update user opportunity status
        DB::table('user_opportunity_statuses')
            ->where('user_id', $user_id)
            ->where('opportunity_id', $opportunityData_id)
            ->update(['status' => 3]);
    
        // Return JSON response to frontend
        return response()->json([
            'message' => 'Answers saved successfully',
            'evaluation_score' => $totalEvaluationScore,
            'total_percentage' => $totalPercentage,
            'status' => 1
        ]);
    }

    public function OrganizationScore($id)
    {
        $opportunities = Opportunity::all();
        $opportunity_data = OpportunityData::find($id);
        $opportunity = Opportunity::where('id', $opportunity_data->opportunity_id)->first();
        $user_id = Auth::user()->id;
        $user_organization_id = Auth::user()->user_id;
        $score = OrganizationScore::where('opportunityData_id', $id)->where('user_id', $user_id)->first();
        $organization_score = OrganizationScore::where('user_id', $user_organization_id)->where('opportunityData_id', $id)->first();

        return response()->json([
            'opportunities' => $opportunities,
            'opportunity_data' => $opportunity_data,
            'opportunity' => $opportunity,
            'score' => $score,
            'organization_score' => $organization_score,
            'message' => 'Score fetched successfully',
            'status' => 200,
        ]);
    }

}
