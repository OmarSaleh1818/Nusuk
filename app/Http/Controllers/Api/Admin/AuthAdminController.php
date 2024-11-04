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

    try {


        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to find the admin by email
        $admin = Admin::where('email', $request->email)->first();

        // Check if admin exists and password is correct
        if (!$admin) {
            return response()->json(['error' => 'Email not found'], 404);
        }

        if (!Hash::check($request->password, $admin->password)) {
            return response()->json(['error' => 'Invalid password'], 401);
        }

        // Generate an API token for the admin
        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'Logged in successfully',
            'admin' => $admin,
            'succeed' => true
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred during Login',
            'error' => $e->getMessage(),
            'succeed' => false
        ], 500);
    }
}


    public function Dashboard()
    {
        try {
            $opportunities = Opportunity::all();
            return response()->json([
                'succeed' => true,
                'message' => 'Admin dashboard',
                'data' => $opportunities,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during Dashboard',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }

    }

    public function AdminManagement()
    {
        try {

            $admins = Admin::all();
            return response()->json([
                'data' => $admins,
                'message' => 'Admin management',
                'status 0' => 'ادمن نسك',
                'status 1' => 'سوبر ',
                'succeed' => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during AdminManagement',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    public function AdminRegisterStore(Request $request)
    {


        try {
            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'user_name' => $request->user_name,
                'mobile_number' => $request->mobile_number,
                'job_title' => $request->job_title,

                'password' => Hash::make($request->password),
                'status' => $request->status ?? 1,
                'created_at' => Carbon::now('Asia/Riyadh'),
            ]);

            // Generate an API token for the admin
            $token = $admin->createToken('admin-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'message' => 'Admin registered successfully',
                'admin' => $admin,
                'succeed' => true
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during registration',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }


    public function AdminLogout()
    {

        try {

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
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during AdminLogout',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    public function AdminPermission()
    {


        try {
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

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during AdminPermission',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }



    }






    public function DeleteAdmin($admin_id)
{
    try {
         // Find the admin by ID
        $admin = Admin::find($admin_id);

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin not found'
            ], 404);
        }

        // Delete the admin
        $admin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin deleted successfully'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred during DeleteAdmin',
            'error' => $e->getMessage(),
            'succeed' => false
        ], 500);
    }


}



}
