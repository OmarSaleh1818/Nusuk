<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\BenefitSatisfaction;
use App\Models\Indicator;
use App\Models\LocalTarget;
use App\Models\Opportunity;
use App\Models\ServiceImplemented;
use App\Models\ServicesSlide;
use App\Models\Slide;
use App\Models\Stage;
use App\Models\TargetService;
use Fixture\PHP74\Regression\Issue1402\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{

    public function OrganizationServices()
    {
        $user_id = Auth::user()->id;
        $slides = Slide::all();
        $targets = LocalTarget::all();
        $stages = Stage::all();
        $indicators = Indicator::all();
        $serviceImplemented = ServiceImplemented::where('user_id', $user_id)->get();
        $benefitSatisfaction = BenefitSatisfaction::where('user_id', $user_id)->first();
        $opportunities = Opportunity::all();
        return view('organization.services', compact('slides', 'targets',
            'stages', 'benefitSatisfaction', 'indicators', 'serviceImplemented', 'opportunities'));
    }

    public function ServicesStore(Request $request)
    {
        $user_id = Auth::user()->id;
        $slide_ids = $request->input('slide_id', []);
        $outside_kingdom = $request->input('outside_kingdom', []);
        $inside_kingdom = $request->input('inside_kingdom', []);
        $female = $request->input('female', []);
        $special_needs = $request->input('special_needs', []);
        $people_dead = $request->input('people_dead', []);

// Delete all checkboxes for the user
        ServicesSlide::where('user_id', $user_id)->delete();
// Insert checkboxes based on the form submission
        foreach ($slide_ids as $slide_id) {
            $isChecked = in_array($slide_id, $request->input('slide_checked', []));

            ServicesSlide::create([
                'user_id' => $user_id,
                'slide_id' => $slide_id,
                'outside_kingdom' => $isChecked && isset($outside_kingdom[$slide_id]),
                'inside_kingdom' => $isChecked && isset($inside_kingdom[$slide_id]),
                'female' => $isChecked && isset($female[$slide_id]),
                'special_needs' => $isChecked && isset($special_needs[$slide_id]),
                'people_dead' => $isChecked && isset($people_dead[$slide_id])
            ]);
        }

        TargetService::where('user_id', $user_id)->delete();
        if ($request->has('service_id')) {
            foreach ($request->service_id as $service_id) {
                TargetService::create([
                    'user_id' => $user_id,
                    'service_id' => $service_id,
                ]);
            }
        }

        foreach ($request->serviceImplemented as $businessId => $indicators) {
            foreach ($indicators as $indicatorId => $data) {
                // Check if at least one field is not null or empty
                if (
                    !is_null($data['seasonal_service']) ||
                    !is_null($data['ongoing_service']) ||
                    !is_null($data['initiatives']) ||
                    !is_null($data['events'])
                ) {
                    // Insert or update the record with provided values
                    ServiceImplemented::updateOrCreate(
                        [
                            'user_id' => auth()->id(),
                            'business_id' => $businessId,
                            'indicator_id' => $indicatorId,
                        ],
                        [
                            'seasonal_service' => $data['seasonal_service'] ?? null,
                            'ongoing_service' => $data['ongoing_service'] ?? null,
                            'initiatives' => $data['initiatives'] ?? null,
                            'events' => $data['events'] ?? null,
                        ]
                    );
                }
            }
        }


        BenefitSatisfaction::updateOrCreate(
            ['user_id' => $user_id],
            [
                'seasonal_question' => $request->seasonal_question,
                'ongoing_question' => $request->ongoing_question,
                'initiatives_question' => $request->initiatives_question,
                'events_question' => $request->events_question,

                'seasonal_percentage' => $request->input('seasonal_percentage'),
                'ongoing_percentage' => $request->input('ongoing_percentage'),
                'initiatives_percentage' => $request->input('initiatives_percentage'),
                'events_percentage' => $request->input('events_percentage'),

                'seasonal_size' => $request->input('seasonal_size'),
                'ongoing_size' => $request->input('ongoing_size'),
                'initiatives_size' => $request->input('initiatives_size'),
                'events_size' => $request->input('events_size'),
            ]
        );
        return redirect()->back()->with('error', 'تم حفظ المعلومات بنجاح');
    }


}
