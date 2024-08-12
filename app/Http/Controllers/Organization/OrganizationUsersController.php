<?php

namespace App\Http\Controllers\Organization;

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
use App\Models\OrganizationUser;
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class OrganizationUsersController extends Controller
{

    public function OrganizationUserManagement($id)
    {
        $organization_users = User::where('user_id', $id)->get();
        $opportunities = Opportunity::all();
        return view('organization.user_management', compact('organization_users', 'opportunities'));
    }

    public function OrganizationUserBulkAction(Request $request)
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
        return redirect()->route('organization.user.management', Auth::user()->id);
    }
    public function OrganizationAddUser($id)
    {
        $opportunities = Opportunity::all();
        return view('organization.add_user',compact('id', 'opportunities'));
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

        User::insert([
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

        return redirect()->route('organization.user.management',$request->user_id)->with('error', 'تم إضافة مستخدم بنجاح');
    }

    public function UserLogout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('index')->with('error', 'تم تسجيل خروجك بنجاح');
    }
    public function Index()
    {
        return view('organization_user.user_login');
    }

    public function OrganizationUserBasic($id)
    {
        $basic = User::where('id', $id)->first();
        $opportunities = Opportunity::all();
        return view('organization_user.basicUser_eye', compact('basic', 'opportunities'));
    }

    public function OrganizationUserAbout($id)
    {
        $about = Apout::where('user_id', $id)->first();
        $types = LocalType::all();
        $typeDescription = TypeDescription::where('user_id', $id)->get();
        $opportunities = Opportunity::all();
        return view('organization_user.aboutUser_eye', compact('about', 'types', 'typeDescription', 'opportunities'));
    }

    public function OrganizationUserFinancial($id)
    {
        $financial = Financial::where('user_id', $id)->first();
        $opportunities = Opportunity::all();
        return view('organization_user.financialUser_eye', compact('financial', 'opportunities'));
    }

    public function OrganizationUserServices($id)
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
        return view('organization_user.servicesUser_eye', compact('slides', 'targets', 'opportunities',
            'stages', 'benefitSatisfaction', 'indicators', 'serviceImplemented', 'servicesSlide', 'targetService'));
    }

    public function OrganizationUserStaff($id)
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
        return view('organization_user.staffUser_eye', compact('nationalities', 'user_id',
            'genders', 'ages', 'regions', 'contracts', 'existingData', 'degrees', 'opportunities', 'staffRepresent'
            , 'operations', 'accordings', 'staffOthers', 'staffDegree', 'staffInformation'));
    }

    public function OrganizationUserVolunteers($id)
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
        return view('organization_user.volunteerUser_eye', compact('nationalities', 'volunteerInformation',
            'genders', 'ages', 'regions', 'contracts', 'existingData', 'opportunities', 'accordings'));

    }

}
