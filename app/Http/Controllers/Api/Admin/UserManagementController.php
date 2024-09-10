<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Opportunity;
use App\Models\User;
use App\Models\Apout;
use App\Models\LocalType;
use App\Models\TypeDescription;
use App\Models\LocalDescription;
use App\Models\Financial;
use App\Models\Slide;
use App\Models\ServicesSlide;
use App\Models\LocalTarget;
use App\Models\Stage;
use App\Models\Indicator;
use App\Models\ServiceImplemented;
use App\Models\BenefitSatisfaction;
use App\Models\LocalServices;
use App\Models\TargetService;
use App\Models\Nationality;
use App\Models\Gender;
use App\Models\Age;
use App\Models\Region;
use App\Models\Contract;
use App\Models\Degree;
use App\Models\Operation;
use App\Models\According;
use App\Models\StaffInformation;
use App\Models\StaffDegree;
use App\Models\StaffOther;
use App\Models\StaffRepresent;
use App\Models\Volunteer;
use App\Models\VolunteerDegree;
use App\Models\VolunteerOperation;
use App\Models\VolunteerContract;
use App\Models\VolunteerRegion;
use App\Models\VolunteerInformation;
use App\Models\ContractVolunteer;



class UserManagementController extends Controller
{
    
    public function UserManagement()
    {
        $opportunities = Opportunity::all();
        $users = User::where('user_permission', 1)->orderBy('id', 'desc')->get();
        return response()->json([
            'opportunities' => $opportunities,
            'users' => $users,
            'message' => 'Users fetched successfully'
        ], 200);
    }

    public function UserBulkAction(Request $request)
    {
         // Get selected user IDs and the action to perform
         $userIds = $request->input('user_id');
         $action = $request->input('action');
 
         // Validate if user IDs are provided
         if (!$userIds) {
             return response()->json([
                 'success' => false,
                 'message' => 'لا يوجد مستخدم محدد'
             ], 400); // 400 Bad Request
         }
 
         // Perform the requested action
         if ($action == 'stop') {
            
             User::whereIn('id', $userIds)->update(['status' => 0]);
         } elseif ($action == 'delete') {

            // User::whereIn('id', $userIds)->delete();
         } elseif ($action == 'active') {
             User::whereIn('id', $userIds)->update(['status' => 1]);
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

    public function UserEye($id)
    {
        $user = User::where('id', $id)->first();
        return response()->json([
            'user' => $user,
            'message' => 'User fetched successfully'
        ], 200);
    }

    public function AdminOrganizationBasic($id)
    {
        $basic = User::where('id', $id)->first();
        $opportunities = Opportunity::all();
        return response()->json([
            'basic' => $basic,
            'opportunities' => $opportunities,
            'message' => 'Basic fetched successfully'
        ], 200);
    }

    public function AdminOrganizationAbout($id)
    {
        $about = Apout::where('user_id', $id)->first();
        $types = LocalType::all();
        $opportunities = Opportunity::all();
        $response = [];

        foreach ($types as $type) {
            // For each type, retrieve related descriptions
            $descriptions = LocalDescription::where('type_id', $type->id)->get();

            // Prepare description data with checked status
            $descriptionData = [];
            foreach ($descriptions as $description) {
                $isChecked = TypeDescription::where('description_id', $description->id)
                                            ->where('user_id', $id)
                                            ->exists();

                $descriptionData[] = [
                    'id' => $description->id,
                    'description' => $description->description,
                    'is_checked' => $isChecked // Include the checked status
                ];
            }

            // Add the type and its descriptions to the response array
            $response[] = [
                'type_id' => $type->id,
                'type_name' => $type->type_name,
                'descriptions' => $descriptionData
            ];
        }
        if($about){
            return response()->json([
                'about data' => $about,
                'types' => $types,
                'opportunities' => $opportunities,
                'response' => $response,
                'message' => 'About data fetched successfully', 
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'About data not found',
                'status' => 404,
            ]);
        }
    }

    public function AdminOrganizationFinancial($id)
    {
        $financial = Financial::where('user_id', $id)->first();
        $opportunities = Opportunity::all();
        return response()->json([
            'financial' => $financial,
            'opportunities' => $opportunities,
            'message' => 'Financial fetched successfully'
        ], 200);
    }

    public function AdminOrganizationServices($id)
    {
        // Get the slides data
        $slides = Slide::all();
        $slideData = [];
        foreach ($slides as $slide) {
            $servicesSlide = ServicesSlide::where('slide_id', $slide->id)
                                ->where('user_id', $id)
                                ->first();
            $slideData[] = [
                'slide_name' => $slide->slide_name,
                'slide_id' => $slide->id,
                'checked' => $servicesSlide ? true : false, // Whether the slide is selected
                'outside_kingdom' => $servicesSlide ? (bool)$servicesSlide->outside_kingdom : false,
                'inside_kingdom' => $servicesSlide ? (bool)$servicesSlide->inside_kingdom : false,
                'female' => $servicesSlide ? (bool)$servicesSlide->female : false,
                'special_needs' => $servicesSlide ? (bool)$servicesSlide->special_needs : false,
                'people_dead' => $servicesSlide ? (bool)$servicesSlide->people_dead : false,
            ];
        }

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
                    ->where('user_id', $id)
                    ->exists();
                // Add service data including whether it's checked or not
                $serviceData[] = [
                    'service_name' => $service->service_name,
                    'service_id' => $service->id,
                    'checked' => $checkService ? true : false
                ];
            }
            // Add target and its associated services data to the array
            $targetData[] = [
                'target_name' => $target->target_name,
                'target_id' => $target->id,
                'services' => $serviceData
            ];
        }

         // Get all stages with their businesses
        $stages = Stage::with('businesses')->get();
        $indicators = Indicator::all();
        $serviceImplemented = ServiceImplemented::where('user_id', $id)->get();
        $response = [];
        foreach ($stages as $stage) {
            $stageData = [
                'stage_name' => $stage->stage_name,
                'businesses' => [],
            ];
            foreach ($stage->businesses as $business) {
                $businessData = [
                    'business_name' => $business->business_name,
                    'indicators'    => [],
                ];
                foreach ($indicators as $indicator) {
                    // Check if the service was implemented by the user for this business and indicator
                    $existing = $serviceImplemented->where('business_id', $business->id)
                                                ->where('indicator_id', $indicator->id)
                                                ->first();
                    $businessData['indicators'][] = [
                        'indicator_name'    => $indicator->indicator_name,
                        'seasonal_service'  => $existing->seasonal_service ?? null,
                        'ongoing_service'   => $existing->ongoing_service ?? null,
                        'initiatives'       => $existing->initiatives ?? null,
                        'events'            => $existing->events ?? null,
                        'business_id'       => $business->id,
                        'indicator_id'      => $indicator->id,
                    ];
                }
                $stageData['businesses'][] = $businessData;
            }
            $response[] = $stageData;
        }
        // Get the benefit satisfaction data
        $benefitSatisfaction = BenefitSatisfaction::where('user_id', $id)->first();
        // Get the opportunities data
        $opportunities = Opportunity::all();
        // Return the response as JSON
        return response()->json([
            'slideData' => $slideData,
            'targetData' => $targetData,
            'stagesData' => $response,
            'benefitSatisfaction' => $benefitSatisfaction,
            'opportunities' => $opportunities,
            'message' => 'Services data fetched successfully',
            'status' => 200,
        ]);
    }

    public function AdminOrganizationStaff($id)
    {
        $nationalities = Nationality::all();
        $genders = Gender::all();
        $ages = Age::all();
        $regions = Region::all();
        $contracts = Contract::all();
        $degrees = Degree::all();
        $operations = Operation::all();
        $accordings = According::all();
        $staffOthers = StaffOther::where('user_id', $id)->first();
        $staffRepresent = StaffRepresent::where('user_id', $id)->first();
        $existingData = StaffInformation::where('user_id', $id)->groupBy(['nationality_id', 'gender_id', 'age_id', 'contract_id', 'region_id']);
        $opportunities = Opportunity::all();
    
        $staffDegreeData = [];

        foreach ($degrees as $degree) {
            foreach ($operations as $operation) {
                // Get the existing data for the current degree and operation
                $staffDegree = StaffDegree::where('user_id', $id)
                    ->where('degree_id', $degree->id)
                    ->where('operation_id', $operation->id)
                    ->first();

                // Structure the data for the API response
                $staffDegreeData[] = [
                    'degree_name' => $degree->degree_name,
                    'operation_name' => $operation->operation_name,
                    'engaged' => $staffDegree->engaged ?? null,
                    'not_engaged' => $staffDegree->not_engaged ?? null,
                    'certified' => $staffDegree->certified ?? null,
                    'not_certified' => $staffDegree->not_certified ?? null,
                    'office_work' => $staffDegree->office_work ?? null,
                    'field_work' => $staffDegree->field_work ?? null,
                    'mixed_work' => $staffDegree->mixed_work ?? null,
                    'total' => $staffDegree->total ?? null,
                    'degree_id' => $degree->id,
                    'operation_id' => $operation->id
                ];
            }
        }
        if($id){
            return response()->json([
                'nationalities' => $nationalities,
                'genders' => $genders,
                'ages' => $ages,
                'regions' => $regions,
                'contracts' => $contracts,
                'degrees' => $degrees,
                'operations' => $operations,
                'accordings' => $accordings,
                'staffOthers' => $staffOthers,
                'staffRepresent' => $staffRepresent,
                'existingData' => $existingData,
                'opportunities' => $opportunities,
                'staffDegreeData' => $staffDegreeData,
                'message' => 'Data fetched successfully',
                'status' => 200
            ]);
        }else{
            return response()->json([
                'message' => 'Data not found',
                'status' => 404,
            ]);
        }
    }

    public function AdminOrganizationVolunteers($id)
    {
        $nationalities = Nationality::all();
        $genders = Gender::all();
        $ages = Age::all();
        $regions = Region::all();
        $contracts = ContractVolunteer::all();
        $accordings = According::all();
    
        // Fetch existing volunteer information grouped by necessary fields
        $existingData = VolunteerInformation::where('user_id', $id)
            ->get()
            ->groupBy(['nationality_id', 'gender_id', 'age_id', 'contract_id', 'region_id', 'according_id']);
    
        return response()->json([
            'nationalities' => $nationalities,
            'genders' => $genders,
            'ages' => $ages,
            'regions' => $regions,
            'contracts' => $contracts,
            'accordings' => $accordings,
            'existingData' => $existingData,
            'message' => 'Volunteers fetched successfully',
            'status' => 200
        ]);
    }

    


}
