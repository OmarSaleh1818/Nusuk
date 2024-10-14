<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Opportunity;
use Illuminate\Validation\Rules;
use Carbon\Carbon;


class AuthAdminController extends Controller
{
    
    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Create an API token for the admin
        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'Logged in successfully',
            'admin' => $admin,
            'succeed' => true
        ], 200);
    }

    public function Dashboard()
    {
        $opportunities = Opportunity::all();
        return response()->json([
            'succeed' => true,
            'message' => 'Admin dashboard',
            'data' => $opportunities,
        ], 200);
    }

    public function AdminManagement()
    {
        $admins = Admin::all();
        return response()->json([
            'data' => $admins,
            'message' => 'Admin management',
            'status 0' => 'ادمن نسك',
            'status 1' => 'سوبر ',
            'succeed' => true
        ], 200);
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

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'job_title' => $request->job_title,
            'user_name' => $request->user_name,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'created_at' => Carbon::now('Asia/Riyadh'),
        ]);

        if($admin){
            return response()->json([
                'message' => 'Admin registered successfully',
                'admin' => $admin,
                'succeed' => true
            ], 200);
        }else{
            return response()->json([
                'message' => 'Admin not registered',
                'succeed' => false
            ], 401);
        }
    }

    public function AdminLogout()
    {
        $admin = auth()->user()->tokens()->delete();
        if($admin){
            return response()->json([
                'message' => 'Admin logged out successfully',
                'succeed' => true
            ], 200);
        }else{
            return response()->json([
                'message' => 'Admin not logged out',
                'succeed' => false
            ], 401);
        }
    }

    public function AdminPermission()
    {
        $admin = auth()->guard('api')->user(); 
        $user = auth()->user();
        if($admin->status == 0){

            return response()->json([
                'succeed' => true,
                'message' => 'Admin permission fetched successfully',
                'data' => 'admin' 
            ]);
        } elseif($admin->status == 1) {
            return response()->json([
                'succeed' => true,
                'message' => 'Admin permission fetched successfully',
                'data' => 'super' 
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to fetch admin',
            ], 404); // Return 404 status if no admin is found
        }
        if($user->user_permission == 1){
            
            return response()->json([
                'succeed' => true,
                'message' => 'User permission fetched successfully',
                'data' => 'user' 
            ]);
        } elseif($user->user_permission == 2) {
            return response()->json([
                'succeed' => true,
                'message' => 'User permission fetched successfully',
                'data' => 'user_orgnization' 
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to fetch user',
            ], 404); 
        }
    }




}
