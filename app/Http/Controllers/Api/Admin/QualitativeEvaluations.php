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



}
