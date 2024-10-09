<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EvaluationArea;
use App\Models\EvaluationAspect;
use App\Models\EvaluationChoices;
use App\Models\OrganizationEvaluation;

class QualitativeEvaluations extends Controller
{
    
    public function QualitativeEvaluation()
    {
        $evaluation_area = EvaluationArea::all();
        $evaluation_aspect = EvaluationAspect::all();
        $evaluation_choice = EvaluationChoices::all();

        $data = [
            'evaluation_areas' => $evaluation_area,
            'evaluation_aspects' => $evaluation_aspect,
            'evaluation_choices' => $evaluation_choice
        ];

        return response()->json([
            'succeed' => true,
            'message' => 'Qualitative evaluation data retrieved successfully',
            'data' => $data
        ]);
    }

    public function OrganizationEvaluationStore(Request $request)
    {
        
        $userId = $request->input('user_id');
        $opportunityDataId = $request->input('opportunityData_id');
        $choices = $request->input('choices');

        if (!$userId || !$opportunityDataId || !$choices) {
            return response()->json(['error' => 'Missing required fields'], 400);
        }

        foreach ($choices as $choice) {
            // Ensure that both evaluation_aspect_id and id are present for each choice
            if (isset($choice['evaluation_aspect_id']) && isset($choice['id'])) {
                OrganizationEvaluation::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'opportunityData_id' => $opportunityDataId,
                        'evaluation_aspect_id' => $choice['evaluation_aspect_id'],
                    ],
                    [
                        'evaluation_choice_id' => $choice['id'],
                    ]
                );
            }
        }

        return response()->json(['message' => 'Choices stored successfully'], 200);

    }

    public function QualitativeEvaluationResult(Request $request)
    {
        $opportunityDataId = $request->input('opportunityData_id');
        $userId = $request->input('user_id');

        if (!$opportunityDataId || !$userId) {
            return response()->json(['error' => 'Missing required fields'], 400);
        }

        $evaluations = OrganizationEvaluation::where('opportunityData_id', $opportunityDataId)
            ->where('user_id', $userId)
            ->with(['aspect', 'choice']) 
            ->get();

        if ($evaluations->isEmpty()) {
            return response()->json([
                'succeed' => false,
                'message' => 'No evaluation data found for the given opportunity and user',
                'data' => []
            ], 404);
        }

        $totalValue = 0;  
        $totalAspects = 0;  

        foreach ($evaluations as $evaluation) {
            if ($evaluation->choice->value > 0) {
                
                $totalValue += $evaluation->choice->value;
                
                $totalAspects++;
            }
        }

        // Multiply the total aspects count by 5
        $totalAspectsMultiplied = $totalAspects * 5;

        // Calculate the final evaluation result
        $evaluationResult = 0;
        if ($totalAspectsMultiplied > 0) {
            $evaluationResult = ($totalValue / $totalAspectsMultiplied) * 100;
        }

        // Format and return the data
        $data = $evaluations->map(function ($evaluation) {
            return [
                'opportunityData_id' => $evaluation->opportunityData_id,
                'evaluation_aspect_id' => $evaluation->evaluation_aspect_id,
                'evaluation_aspect' => $evaluation->aspect->name, 
                'evaluation_choice_id' => $evaluation->evaluation_choice_id,
                'evaluation_choice' => $evaluation->choice->name,
                'evaluation_choice_value' => $evaluation->choice->value
            ];
        });

        return response()->json([
            'succeed' => true,
            'message' => 'The data and result fetched successfully',
            'evaluation_result' => $evaluationResult,
            'data' => $data
        ], 200);
    }



}
