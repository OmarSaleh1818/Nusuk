<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
use App\Models\Apout;
use App\Models\LocalType;
use App\Models\TypeDescription;
use App\Models\LocalDescription;
use App\Models\Financial;
use App\Models\Slide;
use App\Models\LocalTarget;
use App\Models\LocalServices;
use App\Models\Stage;
use App\Models\Indicator;
use App\Models\ServiceImplemented;
use App\Models\BenefitSatisfaction;
use App\Models\ServicesSlide;
use App\Models\TargetService;
use App\Models\Nationality;
use App\Models\Gender;
use App\Models\Age;
use App\Models\Region;
use App\Models\Contract;
use App\Models\Degree;
use App\Models\Operation;
use App\Models\According;
use App\Models\StaffOther;
use App\Models\StaffRepresent;
use App\Models\StaffInformation;
use App\Models\StaffDegree;
use App\Models\VolunteerInformation;
use App\Models\ContractVolunteer;



class OrganizationUsersController extends Controller
{
    
    public function OrganizationUserManagement($id)
    {
        $organization_users = User::where('user_id', $id)->get();
        return response()->json([
            'succeed' => true,
            'message' => 'Data fetched successfully',
            'data' => $organization_users,
        ]);
    }

    public function OrganizationUserBulkAction(Request $request)
    {
        $userIds = $request->input('user_id');
        $action = $request->input('action');

        if (!$userIds) {
            return response()->json([
                'message' => 'لا يوجد مستخدم محدد',
                'status' => 400
            ], 400);
        }

        switch ($action) {
            case 'stop':
                User::whereIn('id', $userIds)->update(['status' => 0]);
                break;
            case 'delete':
                // User::whereIn('id', $userIds)->delete();
                break;
            case 'active':
                User::whereIn('id', $userIds)->update(['status' => 1]);
                break;
            default:
                return response()->json([
                    'message' => 'إجراء غير صالح',
                    'status' => 400
                ], 400);
        }

        return response()->json([
            'message' => 'تم تنفيذ طلبك',
            'status' => 200
        ]);
    }

    public function OrganizationAddUser($id)
    {
        return response()->json([
            'id' => $id,
            'message' => 'Data fetched successfully',
            'status' => 200
        ]);
    }

    public function OrganizationStoreUser(Request $request)
    {
       
        $request->validate([
            'contact_name' => 'required',
            'email' => 'required',
            'contact_job_title' => 'required',
            'contact_mobile' => 'required',
            'name' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],[
            'contact_name.required' => 'اسم المطلوب',
            'email.required' => 'الايميل المطلوب',
            'contact_job_title.required' => 'المسمى الوظيفي المطلوب',
            'password.required' => 'كلمة المرور المطلوب',
            'password_confirmation.required' => 'تأكيد كلمة المرور مطلوب',
        ]);

        $user = User::insert([
            'user_id' => $request->user_id,
            'contact_name' => $request->contact_name,
            'email' => $request->email,
            'contact_mobile' => $request->contact_mobile,
            'name' => $request->name,
            'contact_job_title' => $request->contact_job_title,
            'user_permission' => 2,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
        ]);

        // Return a success response
        return response()->json([
            'succeed' => true,
            'message' => 'تم إضافة مستخدم بنجاح',
            'data' => $user,
        ], 201);
    }

    public function OrganizationUserBasic($id)
    {
        $basic = User::where('id', $id)->first();

        if (!$basic) {
            return response()->json([
                'message' => 'User not found',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'succeed' =>true,
            'message' => 'Basic data fetched Succeefully',
            'data' => $basic,
            'status' => 200
        ], 200);
    }

    public function OrganizationUserAbout($id)
    {
        $about = Apout::where('user_id', $id)->first();
        $types = LocalType::all();
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
                'succeed' => true,
                'message' => 'About data fetched successfully', 
                'data' => [
                    'about data' => $about,
                    'response' => $response,
                ],
            ]);
        }else{
            return response()->json([
                'message' => 'About data not found',
                'status' => 404,
            ]);
        }
    }

    public function OrganizationUserFinancial($id)
    {
        $financial = Financial::where('user_id', $id)->first();
        
        if ($financial) {
            return response()->json([
                'succeed' => true,
                'message' => 'Financial data fetched successfully',
                'data' => $financial,
            ]);
        } else {
            return response()->json([
                'message' => 'Financial data not found',
                'status' => 404
            ]);
        }
    }

    public function OrganizationUserServices($id)
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
        // Return the response as JSON
        return response()->json([
            'succeed' => true,
            'message' => 'Services data fetched successfully',
            'data' => [
                'slideData' => $slideData,
                'targetData' => $targetData,
                'stagesData' => $response,
                'benefitSatisfaction' => $benefitSatisfaction,
            ],
        ]);
    }

    public function OrganizationUserStaff($id)
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
        $existingData = StaffInformation::where('user_id', $id)
                        ->get()
                        ->groupBy(['nationality_id', 'gender_id', 'age_id', 'contract_id', 'region_id']);
    
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
                'succeed' => true,
                'message' => 'Data fetched successfully',
                'data' => [
                    'staffOthers' => $staffOthers,
                    'staffRepresent' => $staffRepresent,
                    'existingData' => $existingData,
                    'staffDegreeData' => $staffDegreeData,
                ],
            ]);
        }else{
            return response()->json([
                'message' => 'Data not found',
                'status' => 404,
            ]);
        }
    }

    public function OrganizationUserVolunteers($id)
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
            'succeed' => true,
            'message' => 'Volunteers fetched successfully',
            'data' => [
                'nationalities' => $nationalities,
                'genders' => $genders,
                'ages' => $ages,
                'regions' => $regions,
                'contracts' => $contracts,
                'accordings' => $accordings,
                'existingData' => $existingData,
            ],
        ]);
    }


}
