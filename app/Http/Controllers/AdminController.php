<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Opportunity;
use App\Models\OpportunityData;
use App\Models\OrganizationScore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class AdminController extends Controller
{

    public function Index()
    {
        return view('admin.admin_login');
    } // end method

    public function Dashboard()
    {
        $opportunities = Opportunity::all();
        $opportunityData = [];

        foreach ($opportunities as $item) {
            $countAvailable = OpportunityData::where('opportunity_id', $item->id)->where('status_id', 1)->count();
            $countFrozen = OpportunityData::where('opportunity_id', $item->id)->where('status_id', 3)->count();
            $countNotAvailable = OpportunityData::where('opportunity_id', $item->id)->where('status_id', 2)->count();

            $countParticipatingOrg = OrganizationScore::where('opportunityData_id', $item->id)->count();
            $countQualifiedOrg = OrganizationScore::where('opportunityData_id', $item->id)
                ->where('total_percentage', '>', function($query) use ($item) {
                    $query->select('percentage')
                        ->from('opportunity_data')
                        ->where('opportunity_id', $item->id)
                        ->limit(1);
                })->count();

            $opportunityData[] = [
                'opportunity_name' => $item->opportunity_name,
                'countAvailable' => $countAvailable,
                'countFrozen' => $countFrozen,
                'countNotAvailable' => $countNotAvailable,
                'countParticipatingOrg' => $countParticipatingOrg,
                'countQualifiedOrg' => $countQualifiedOrg
            ];
        }
        return view('admin.index', compact('opportunities', 'opportunityData'));
    } // end method

    public function Login(Request $request)
    {
        $check = $request->all();
        if (Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
            return redirect()->route('admin.dashboard')->with('error', 'تم تسجيل دخولك بنجاح');
        } else {
            return back()->with('error', 'تسجيل دخول خاطئ');
        }
    }// end method

    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login_form')->with('error', 'تم تسجيل خروجك بنجاح');
    }// end method

    public function AdminRegister()
    {
        $opportunities = Opportunity::all();
        return view('admin.admin_register', compact('opportunities'));
    }

    public function AdminRegisterStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'mobile_number' => 'required',
            'job_title' => 'required',
            'user_name' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],[
            'name.required' => 'اسم المستخدم مطلوب',
            'email.required' => 'الايميل مطلوب',
            'password.required' => 'كلمة المرور مطلوب',
            'password_confirmation.required' => 'تأكيد كلمة المرور مطلوب',
        ]);

        Admin::insert([
            'name' => $request->name,
            'email' => $request->email,
            'user_name' => $request->user_name,
            'mobile_number' => $request->mobile_number,
            'job_title' => $request->job_title,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.management')->with('error', 'تم إنشاء الحساب بنجاح');
    }

    public function AdminManagement()
    {
        $managements = Admin::all();
        $opportunities = Opportunity::all();
        return view('admin.admin_management', compact('managements', 'opportunities'));
    }

}
