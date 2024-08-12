<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\NumericNumber;
use App\Models\Opportunity;
use App\Models\OpportunityData;
use App\Models\OrganizationScore;
use App\Models\Question;
use App\Models\UserAnswerMultiple;
use App\Models\UserAnswerNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnswersController extends Controller
{

    public function OrganizationAnswer(Request $request)
    {

        $user_id = Auth::user()->id;
        $opportunityData_id = $request->opportunityData_id;

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

        DB::table('user_opportunity_statuses')
            ->where('user_id', $user_id)
            ->where('opportunity_id', $opportunityData_id)
            ->update(['status' => 3]);

        return redirect()->route('organization.score', $opportunityData_id)->with('error', 'تم حفظ إجاباتك');
    }

    public function OrganizationScore($id)
    {
        $opportunities = Opportunity::all();
        $opportunity = OpportunityData::find($id);
        $add = Opportunity::where('id', $opportunity->opportunity_id)->first();
        $user_id = Auth::user()->id;
        $user_organization_id = Auth::user()->user_id;
        $score = OrganizationScore::where('opportunityData_id', $id)->where('user_id', $user_id)->first();
        $organization_score = OrganizationScore::where('user_id', $user_organization_id)->where('opportunityData_id', $id)->first();

        return view('organization.opportunities.opportunity_score', compact('opportunities','organization_score'
            , 'opportunity','id', 'add', 'score'));
    }



}
