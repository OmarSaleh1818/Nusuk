<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\ServicesSlide;
use App\Models\Slide;
use App\Models\LocalTarget;
use App\Models\Stage;
use App\Models\Indicator;
use App\Models\ServiceImplemented;
use App\Models\BenefitSatisfaction;
use App\Models\Opportunity;
use App\Models\LocalServices;
use App\Models\TargetService;
use App\Models\Business;



class ServicesController extends Controller
{
    // Serveices By Slide
    public function OrganizationServicesBySlide()
    {
        $user_id = Auth::user()->id;
        // Get the slides data
        $slides = Slide::all();
        $slideData = [];
        foreach ($slides as $slide) {
            $servicesSlide = ServicesSlide::where('slide_id', $slide->id)
                                ->where('user_id', $user_id)
                                ->first();
            $slideData[] = [
                'id' => $servicesSlide ? $servicesSlide->id : null,
                'outside_kingdom' => $servicesSlide ? (bool)$servicesSlide->outside_kingdom : false,
                'inside_kingdom' => $servicesSlide ? (bool)$servicesSlide->inside_kingdom : false,
                'female' => $servicesSlide ? (bool)$servicesSlide->female : false,
                'special_needs' => $servicesSlide ? (bool)$servicesSlide->special_needs : false,
                'people_dead' => $servicesSlide ? (bool)$servicesSlide->people_dead : false,
            ];
        }
        
        return response()->json([
            'succeed' => true,
            'message' => 'Services Slide data fetched successfully',
            'data' => $slideData,
        ]);
    }

    public function ServicesBySlideStore(Request $request)
    {
        $user_id = Auth::user()->id;
        // ------------- Slide Data -------------
        $slide_ids = $request->input('slide_id', []);
        $outside_kingdom = $request->input('outside_kingdom', []);
        $inside_kingdom = $request->input('inside_kingdom', []);
        $female = $request->input('female', []);
        $special_needs = $request->input('special_needs', []);
        $people_dead = $request->input('people_dead', []);

        ServicesSlide::where('user_id', $user_id)->delete();

        foreach ($slide_ids as $index => $slide_id) {
            ServicesSlide::create([
                'user_id' => $user_id,
                'slide_id' => $slide_id,
                'outside_kingdom' => $outside_kingdom[$index] ?? 0,
                'inside_kingdom' => $inside_kingdom[$index] ?? 0,
                'female' => $female[$index] ?? 0,
                'special_needs' => $special_needs[$index] ?? 0,
                'people_dead' => $people_dead[$index] ?? 0
            ]);
        }
        $slideData = ServicesSlide::where('user_id', $user_id)->get();

        return response()->json([
            'succeed' => true,
            'message' => 'Services Slide data updated successfully',
            'data' => $slideData,
        ]);
        
    }

    // Serveices By Target
    public function OrganizationServicesByTarget()
    {
        $user_id = Auth::user()->id;
       
        // Get the targets data
        $targets = LocalTarget::all();
        $targetData = [];
        foreach ($targets as $target) {
            // Fetch services for each target
            $services = LocalServices::where('target_id', $target->id)->get();
            // Prepare services data for each target
            $serviceData = [];
            foreach ($services as $service) {
                // Check if the service is selected by the current user
                $checkService = TargetService::where('service_id', $service->id)
                    ->where('user_id', $user_id)
                    ->exists();
                // Add service data including whether it's checked or not
                $serviceData[] = [
                    'service_id' => $service->id,
                    'checked' => $checkService ? true : false
                ];
            }
            // Add target and its associated services data to the array
            $targetData[] = [
                'services' => $serviceData
            ];
        }

        return response()->json([
            'succeed' => true,
            'message' => 'Services Target data fetched successfully',
            'data' => $targetData,
        ]);
    
    }

    public function ServicesByTargetStore(Request $request)
    {
        $user_id = Auth::user()->id;

        // Target Data
        TargetService::where('user_id', $user_id)->delete();
        if ($request->has('service_id')) {
            foreach ($request->service_id as $service_id) {
                TargetService::create([
                    'user_id' => $user_id,
                    'service_id' => $service_id,
                ]);
            }
        }
        $targetData = TargetService::where('user_id', $user_id)->get();

        return response()->json([
            'succeed' => true,
            'message' => 'Services Target data updated successfully',
            'data' => $targetData,
        ]);
    }

    // Serveices for beneficiaries
    public function OrganizationServicesFirst()
    {
        $user_id = Auth::user()->id;

        // Get all stages with their businesses
        $stages = Stage::take(5)->with('businesses')->get();
        $indicators = Indicator::all();
        $serviceImplemented = ServiceImplemented::where('user_id', $user_id)->get();
        
        $response = [];

        foreach ($stages as $stage) {
            foreach ($stage->businesses as $business) {
                $businessData = [
            
                    'indicators'    => []
                ];

                foreach ($indicators as $indicator) {
                    // Check if the service was implemented by the user for this business and indicator
                    $existing = $serviceImplemented->where('business_id', $business->id)
                                                ->where('indicator_id', $indicator->id)
                                                ->first();

                    $businessData['indicators'][] = [
                    
                        'seasonal_service' => $existing ? $existing->seasonal_service : null,
                        'ongoing_service'  => $existing ? $existing->ongoing_service : null,
                        'initiatives'      => $existing ? $existing->initiatives : null,
                        'events'           => $existing ? $existing->events : null,
                    ];
                }

                $response[] = $businessData;
            }
        }

        return response()->json([
            'succeed' => true,
            'message' => 'Service First data fetched successfully',
            'data'    => $response,
        ]);
    }

    public function OrganizationServicesSecond()
    {
        $user_id = Auth::user()->id;
    
        $stages = Stage::skip(5)->take(2)->with('businesses')->get();
        $indicators = Indicator::all(); // Get all indicators
        $serviceImplemented = ServiceImplemented::where('user_id', $user_id)->get();
        $response = [];

        foreach ($stages as $stage) {
            foreach ($stage->businesses as $business) {
                $indicatorData = [];
                
                foreach ($indicators as $indicator) {
                    // Check if the service was implemented by the user for this business and indicator
                    $existing = $serviceImplemented->where('business_id', $business->id)
                                                ->where('indicator_id', $indicator->id)
                                                ->first();
                    
                    $indicatorData[] = [
                        'seasonal_service'  => $existing ? $existing->seasonal_service : null,
                        'ongoing_service'   => $existing ? $existing->ongoing_service : null ,
                        'initiatives'       => $existing ? $existing->initiatives : null,
                        'events'            => $existing ? $existing->events : null,
                    ];
                }
                
                if (!empty($indicatorData)) {
                    $response[] = [
                        'indicators'    => $indicatorData,  
                    ];
                }
            }
        }

        return response()->json([
            'succeed' => true,
            'message' => 'Indicators data grouped by business fetched successfully',
            'data'    => $response,
        ]);
    }


    public function ServicesStore(Request $request)
    {
        $user_id = Auth::user()->id;

        // ------------- Service Implemented Data -------------
        $seasonal_services = $request->input('seasonal_service', []);
        $ongoing_services = $request->input('ongoing_service', []);
        $initiatives = $request->input('initiatives', []);
        $events = $request->input('events', []);
        $business_ids = $request->input('business_id', []);
        $indicator_ids = $request->input('indicator_id', []);

        foreach ($business_ids as $index => $business_id) {
            $indicator_id = $indicator_ids[$index] ?? null;

            $seasonal_service = $seasonal_services[$index] ?? null;
            $ongoing_service = $ongoing_services[$index] ?? null;
            $initiative = $initiatives[$index] ?? null;
            $event = $events[$index] ?? null;
            // Check if at least one field is not null or empty
            if (
                !is_null($seasonal_service) ||
                !is_null($ongoing_service) ||
                !is_null($initiative) ||
                !is_null($event)
            ) {
                // Insert or update the record with provided values
                ServiceImplemented::updateOrCreate(
                    [
                        'user_id' => $user_id,
                        'business_id' => $business_id,
                        'indicator_id' => $indicator_id,
                    ],
                    [
                        'seasonal_service' => $seasonal_service,
                        'ongoing_service' => $ongoing_service,
                        'initiatives' => $initiative,
                        'events' => $event,
                    ]
                );
            }
        }
        $serviceImplementedData = ServiceImplemented::where('user_id', $user_id)->get();

        
        return response()->json([
            'succeed' => true,
            'message' => 'Services data updated successfully',
            'data' => $serviceImplementedData,
        ]);
        
    }

    // Serveices for Satisfaction
    public function OrganizationServicesBySatisfaction()
    {
        $user_id = Auth::user()->id;
         // Get the benefit satisfaction data
        $benefitSatisfaction = BenefitSatisfaction::where('user_id', $user_id)->first();

         return response()->json([
            'succeed' => true,
            'message' => 'Services Satisfaction data fetched successfully',
            'data' => $benefitSatisfaction,
        ]);
    }

    public function ServicesBySatisfactionStore(Request $request)
    {
        $user_id = Auth::user()->id;
        // Benefit Satisfaction Data
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
        $benefitSatisfactionData = BenefitSatisfaction::where('user_id', $user_id)->first();
        return response()->json([
            'succeed' => true,
            'message' => 'Services Satisfaction data updated successfully',
            'data' => $benefitSatisfactionData,
        ]);
    }


}
