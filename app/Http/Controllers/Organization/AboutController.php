<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\LocalDescription;
use App\Models\LocalType;
use App\Models\Apout;
use App\Models\Opportunity;
use App\Models\TypeDescription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AboutController extends Controller
{

    public function OrganizationBasic()
    {
        $user_id = Auth::user()->id;
        $basic = User::where('id', $user_id)->first();
        $opportunities = Opportunity::all();
        return view('organization.basic', compact('basic', 'opportunities'));
    }

    public function BasicUpdate(Request $request)
    {
        $user_id = $request->user_id;

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user_id,
            'password' => 'nullable|same:password_confirmation',
        ]);

        $user = User::find($user_id);

        $updateData = [
            'organization_name' => $request->organization_name,
            'license_number' => $request->license_number,
            'organization_email' => $request->organization_email,
            'organization_region' => $request->organization_region,
            'organization_city' => $request->organization_city,
            'manager_name' => $request->manager_name,
            'manager_mobile' => $request->manager_mobile,
            'manager_email' => $request->manager_email,
            'contact_name' => $request->contact_name,
            'contact_mobile' => $request->contact_mobile,
            'email' => $request->email,
            'contact_job_title' => $request->contact_job_title,
            'name' => $request->name,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->back()->with('error', 'تم حفظ المعلومات بنجاح');
    }


    public function OrganizationAbout()
    {
        $user_id = Auth::user()->id;
        $about = Apout::where('user_id', $user_id)->first();
        $types = LocalType::all();
        $opportunities = Opportunity::all();
        return view('organization.about', compact('types', 'about', 'opportunities'));
    }

    public function AboutStore(Request $request)
    {
        $user_id = Auth::user()->id;

        $request->validate([
            'brief' => 'required',
            'goals' => 'required',
            'vision' => 'required',
            'message' => 'required',
        ]);

        $about = Apout::updateOrCreate(
            ['user_id' => $user_id],
            [
                'brief' => $request->brief,
                'goals' => $request->goals,
                'vision' => $request->vision,
                'message' => $request->message,
            ]
        );

        // Handle the LocalDescription associations
        TypeDescription::where('user_id', $user_id)->delete();

        if ($request->has('description_id')) {
            foreach ($request->description_id as $description_id) {
                TypeDescription::create([
                    'user_id' => $user_id,
                    'description_id' => $description_id,
                ]);
            }
        }

        return redirect()->route('organization.about')->with('error', 'تم حفظ المعلومات بنجاح');
    }



}
