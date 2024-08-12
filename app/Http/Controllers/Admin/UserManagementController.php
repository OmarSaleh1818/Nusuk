<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\According;
use App\Models\Age;
use App\Models\Apout;
use App\Models\BenefitSatisfaction;
use App\Models\Contract;
use App\Models\ContractVolunteer;
use App\Models\Degree;
use App\Models\Financial;
use App\Models\Gender;
use App\Models\Indicator;
use App\Models\LocalTarget;
use App\Models\LocalType;
use App\Models\Nationality;
use App\Models\Operation;
use App\Models\Opportunity;
use App\Models\Region;
use App\Models\ServiceImplemented;
use App\Models\ServicesSlide;
use App\Models\Slide;
use App\Models\StaffDegree;
use App\Models\StaffInformation;
use App\Models\StaffOther;
use App\Models\StaffRepresent;
use App\Models\Stage;
use App\Models\TargetService;
use App\Models\TypeDescription;
use App\Models\User;
use App\Models\VolunteerDegree;
use App\Models\VolunteerInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{

    public function UserManagement()
    {
        $opportunities = Opportunity::all();

        $users = User::where('user_permission', 1)->orderBy('id', 'desc')->get();
        return view('admin.user.user_management', compact('users','opportunities'));
    }

    public function UserBulkAction(Request $request)
    {
        $userIds = $request->input('user_id');
        $action = $request->input('action');

        if (!$userIds) {
            return redirect()->back()->with('error', 'لا يوجد مستخدم محدد');
        }

        if ($action == 'stop') {

            User::whereIn('id', $userIds)->update(['status' => 0]);
        } elseif ($action == 'delete') {

//            User::whereIn('id', $userIds)->delete();
        } elseif ($action == 'active') {

            User::whereIn('id', $userIds)->update(['status' => 1]);
        }
        Session()->flash('error', 'تم تنفيذ طلبك');
        return redirect()->route('user.management');
    }

    public function UserEye($id)
    {
        $opportunities = Opportunity::all();
        $user = User::where('id', $id)->first();
        return view('admin.user.user_eye', compact('id', 'opportunities', 'user'));
    }

    public function AdminOrganizationBasic($id)
    {
        $basic = User::where('id', $id)->first();
        $opportunities = Opportunity::all();
        return view('admin.user.basic_eye', compact('basic', 'opportunities'));
    }

    public function AdminOrganizationAbout($id)
    {
        $about = Apout::where('user_id', $id)->first();
        $types = LocalType::all();
        $typeDescription = TypeDescription::where('user_id', $id)->get();
        $opportunities = Opportunity::all();
        return view('admin.user.about_eye', compact('about', 'types', 'typeDescription', 'opportunities'));
    }

    public function AdminOrganizationFinancial($id)
    {
        $financial = Financial::where('user_id', $id)->first();
        $opportunities = Opportunity::all();
        return view('admin.user.financial_eye', compact('financial', 'opportunities'));
    }

    public function AdminOrganizationServices($id)
    {
        $slides = Slide::all();
        $targets = LocalTarget::all();
        $stages = Stage::all();
        $indicators = Indicator::all();
        $serviceImplemented = ServiceImplemented::where('user_id', $id)->get();
        $benefitSatisfaction = BenefitSatisfaction::where('user_id', $id)->first();
        $servicesSlide = ServicesSlide::where('user_id', $id)->get();
        $targetService = TargetService::where('user_id', $id)->get();
        $opportunities = Opportunity::all();
        return view('admin.user.services_eye', compact('slides', 'targets','opportunities',
            'stages', 'benefitSatisfaction', 'indicators', 'serviceImplemented', 'servicesSlide', 'targetService'));
    }

    public function AdminOrganizationStaff($id)
    {
        $user_id = $id;
        $nationalities = Nationality::all();
        $genders = Gender::all();
        $ages = Age::all();
        $regions = Region::all();
        $contracts = Contract::all();
        $degrees = Degree::all();
        $operations = Operation::all();
        $accordings = According::all();
        $staffRepresent = StaffRepresent::where('user_id', $user_id)->first();
        $staffOthers = StaffOther::where('user_id', $id)->first();
        $staffDegree = StaffDegree::where('user_id', $user_id)->get();
        $staffInformation = StaffInformation::where('user_id', $user_id)->get();
        $opportunities = Opportunity::all();
        $existingData = StaffInformation::all()->groupBy(['nationality_id', 'gender_id', 'age_id', 'contract_id', 'region_id']);
        return view('admin.user.staff_eye', compact('nationalities', 'user_id',
            'genders', 'ages', 'regions', 'contracts', 'existingData', 'degrees', 'opportunities', 'staffRepresent'
            , 'operations', 'accordings', 'staffOthers', 'staffDegree', 'staffInformation'));
    }

    public function AdminOrganizationVolunteers($id)
    {
        $nationalities = Nationality::all();
        $genders = Gender::all();
        $ages = Age::all();
        $regions = Region::all();
        $contracts = ContractVolunteer::all();
        $volunteerInformation = VolunteerInformation::where('user_id', $id)->get();
        $opportunities = Opportunity::all();
        $accordings = According::all();
        $existingData = VolunteerInformation::all()->groupBy(['nationality_id', 'gender_id', 'age_id', 'according_id', 'contract_id', 'region_id']);
        return view('admin.user.volunteer_eye', compact('nationalities', 'volunteerInformation',
            'genders', 'ages', 'regions', 'contracts', 'existingData', 'opportunities', 'accordings'));
    }


}
