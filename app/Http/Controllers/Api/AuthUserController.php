<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Mail\ResetPasswordCodeMail;

class AuthUserController extends Controller
{

    public function login(Request $request)
    {
        try {

            $loginUserData = $request->validate([
                'email'=>'required|string|email',
                'password'=>'required|min:8'
            ]);
            $user = User::where('email',$loginUserData['email'])->where('status', 1)->first();
            if(!$user || !Hash::check($loginUserData['password'],$user->password)){
                return response()->json([
                    'message' => 'Invalid Credentials'
                ],401);
            }
            $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'message' => 'Logged in successfully',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during login',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            // Check if the email already exists
            $existingUser = User::where('email', $request->input('email'))->first();

            if ($existingUser) {
                return response()->json([
                    'succeed' => false,
                    'message' => 'Email already exists. Please use a different email address.',
                ], 409); // Conflict status code
            }

            // Create a new user with the data from the request
            $user = User::create([
                'organization_name' => $request->input('organization_name'),
                'license_number' => $request->input('license_number'),
                'organization_email' => $request->input('organization_email'),
                'organization_region' => $request->input('organization_region'),
                'organization_city' => $request->input('organization_city'),
                'manager_name' => $request->input('manager_name'),
                'manager_mobile' => $request->input('manager_mobile'),
                'manager_email' => $request->input('manager_email'),
                'contact_name' => $request->input('contact_name'),
                'contact_mobile' => $request->input('contact_mobile'),
                'email' => $request->input('email'),
                'contact_job_title' => $request->input('contact_job_title'),
                'name' => $request->input('name'),
                'password' => Hash::make($request->input('password')),
            ]);
            $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
            return response()->json([
                'succeed' => true,
                'message' => 'User Created Successfully',
                'data'=>$user,
                'token'=> $token
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during registration',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }



    public function logout(Request $request)
    {
        try {
            $user = auth()->user()->tokens()->delete();
            if($user){
                return response()->json([
                    'succeed' => true,
                    'message' => 'Logged out successfully'
                ]);
            }else{
                return response()->json([
                    'succeed' => false,
                    'message' => 'Failed to logout'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during logout',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }

    }

    public function user(Request $request)
    {
        try {

            $user = auth()->user();
            if($user){
                return response()->json([
                    'succeed' => true,
                    'message' => 'User fetched successfully',
                    'user' => $user
                ]);
            }else{
                return response()->json([
                    'succeed' => false,
                    'message' => 'Failed to fetch user'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during user',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    // Forgot Password
    public function forgotPassword(Request $request)
    {
        try {
// Validate the email input
$request->validate(['email' => 'required|email']);

// Generate a 6-digit code
$code = rand(100000, 999999);

// Store the code in the password_reset_codes table
DB::table('password_reset_codes')->updateOrInsert(
    ['email' => $request->email],
    [
        'code' => $code,
        'created_at' => Carbon::now()
    ]
);

$data = [
    'email' => $request->email,
    'code' => $code,
];

// Send the code via email
Mail::to($request->email)->send(new ResetPasswordCodeMail($code));

return response()->json([
    'succeed' => true,
    'message' => 'Verification code sent to your email.',
    'data' => $data
], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during forgotPassword',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    // Reset Password
    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'code' => 'required|numeric|digits:6',
                'password' => 'required|string|confirmed',
            ]);

            // Check if the code exists and is valid (within 15 minutes)
            $resetCode = DB::table('password_reset_codes')
                            ->where('email', $request->email)
                            ->where('code', $request->code)
                            ->where('created_at', '>=', Carbon::now()->subMinutes(15))
                            ->first();

            if (!$resetCode) {
                return response()->json([
                    'message' => 'Invalid or expired code.'
                ], 422);
            }

            // Reset the password
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->update(['password' => bcrypt($request->password)]);
                DB::table('password_reset_codes')->where('email', $request->email)->delete(); // delete used code
                return response()->json([
                    'succeed' => true,
                    'message' => 'Password reset successfully.'
                ], 200);
            }

            return response()->json([
                'succeed' => false,
                'message' => 'User not found.'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during resetPassword',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    public function userPermission()
    {
        try {
            $admin = auth()->guard('api')->user();
            $user = auth()->guard('sanctum')->user();

            // Check if admin is authenticated
            if ($admin) {
                if ($admin->status == 0) {
                    return response()->json([
                        'succeed' => true,
                        'message' => 'Admin permission fetched successfully',
                        'data' => 'admin'
                    ]);
                } elseif ($admin->status == 1) {
                    return response()->json([
                        'succeed' => true,
                        'message' => 'Super permission fetched successfully',
                        'data' => 'super'
                    ]);
                }  elseif ($admin->status == 2) {
                    return response()->json([
                        'succeed' => true,
                        'message' => 'Super User permission fetched successfully',
                        'data' => 'user_super'
                    ]);
                } else {
                    return response()->json([
                        'message' => 'Failed to fetch admin',
                    ], 404); // Return 404 if the admin is not found
                }
            }

            // Check if user is authenticated
            if ($user) {
                if ($user->user_permission == 1) {
                    return response()->json([
                        'succeed' => true,
                        'message' => 'Organization permission fetched successfully',
                        'data' => 'organization'
                    ]);
                } elseif ($user->user_permission == 2) {
                    return response()->json([
                        'succeed' => true,
                        'message' => 'User permission fetched successfully',
                        'data' => 'user_organization'
                    ]);
                } else {
                    return response()->json([
                        'succeed' => false,
                        'message' => 'Failed to fetch user',
                    ], 404);
                }
            }

            // Return 404 if neither admin nor user is authenticated
            return response()->json([
                'message' => 'No user or admin authenticated',
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during userPermission',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    public function ValidateToken(Request $request)
    {
        try {

 // Retrieve the token from the Authorization header
 $token = $request->bearerToken();

 if (!$token) {
     return response()->json([
         'succeed' => false,
         'message' => 'No token provided'
     ], 401);
 }

 // Find the token in the personal_access_tokens table
 $tokenData = PersonalAccessToken::findToken($token);

 if (!$tokenData) {
     return response()->json([
         'succeed' => false,
         'message' => 'Invalid token'
     ], 401);
 }

 // Check if token has been revoked (via logout, etc.)
 if ($tokenData->revoked) {
     return response()->json([
         'succeed' => false,
         'message' => 'Token has been revoked',
     ], 401);
 }
 // Since Sanctum tokens don't expire by default, simply return success
 return response()->json([
     'succeed' => true,
     'message' => 'Token is valid',
     'data' => $token
 ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during ValidateToken',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }

    public function UserName(){
        try {

            $admin = auth()->guard('api')->user();
            $user = auth()->guard('sanctum')->user();

            if ($admin) {
                return response()->json([
                    'succeed' => true,
                    'message' => 'User Name fetched successfully',
                    'data' => [
                        'email' => $admin->email,
                        'name' => $admin->name
                    ]
                ]);
            }


            if ($user) {
                return response()->json([
                    'succeed' => true,
                    'message' => 'User Name fetched successfully',
                    'data' => [
                        'email' => $user->email,
                        'name' => $user->name
                    ]
                ]);
            }

            return response()->json([
                'message' => 'No user or admin authenticated',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during UserName',
                'error' => $e->getMessage(),
                'succeed' => false
            ], 500);
        }
    }


}
