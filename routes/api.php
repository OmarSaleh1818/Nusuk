<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\Api\User\DashboardController;
use App\Http\Controllers\Api\User\AboutController;
use App\Http\Controllers\Api\User\FinancialController;
use App\Http\Controllers\Api\User\ServicesController;
use App\Http\Controllers\Api\User\StaffController;
use App\Http\Controllers\Api\User\VolunteerController;
use App\Http\Controllers\Api\User\OpportunityController;
use App\Http\Controllers\Api\Admin\AuthAdminController;
use App\Http\Controllers\Api\Admin\NewsController;
use App\Http\Controllers\Api\Admin\UserManagementController;
use App\Http\Controllers\Api\Admin\OpportunitiesController;
use App\Http\Controllers\Api\Admin\ApproveController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* -------------------- Admin -------------------------*/
Route::post('/admin/login/owner', [AuthAdminController::class, 'Login']);
Route::prefix('admin')->middleware('auth:admin')->group(function () {

    Route::get('/dashboard', [AuthAdminController::class, 'Dashboard']);
    Route::get('/management', [AuthAdminController::class, 'AdminManagement']);
    Route::post('/register/store', [AuthAdminController::class, 'AdminRegisterStore']);
    Route::get('/logout', [AuthAdminController::class, 'AdminLogout']);

    /* -------------------- News -------------------------*/
        Route::get('/news/view', [NewsController::class, 'NewsView']);
        Route::get('/news/add', [NewsController::class, 'NewsAdd']);
        Route::post('/news/store', [NewsController::class, 'NewsStore']);
        Route::get('/news/hide/{id}', [NewsController::class, 'NewsHide']);
        Route::get('/news/show/{id}', [NewsController::class, 'NewsShow']);
        Route::get('/news/edit/{id}', [NewsController::class, 'NewsEdit']);
        Route::post('/news/update/{id}', [NewsController::class, 'NewsUpdate']);
        Route::get('/news/delete/{id}', [NewsController::class, 'NewsDelete']);
    /* -------------------- End News -------------------------*/

    /* -------------------- User Management -------------------------*/
        Route::get('/user/management', [UserManagementController::class, 'UserManagement']);
        Route::post('/user/bulkAction', [UserManagementController::class, 'UserBulkAction']);
        Route::get('/user/eye/{id}', [UserManagementController::class, 'UserEye']);

        Route::get('/organization/basic/{id}', [UserManagementController::class, 'AdminOrganizationBasic']);
        Route::get('/organization/about/{id}', [UserManagementController::class, 'AdminOrganizationAbout']);
        Route::get('/organization/financial/{id}', [UserManagementController::class, 'AdminOrganizationFinancial']);
        Route::get('/organization/services/{id}', [UserManagementController::class, 'AdminOrganizationServices']);
        Route::get('/organization/staff/{id}', [UserManagementController::class, 'AdminOrganizationStaff']);
        Route::get('/organization/volunteers/{id}', [UserManagementController::class, 'AdminOrganizationVolunteers']);
    /* -------------------- End User Management -------------------------*/

    /* -------------------- Opportunities -------------------------*/
        Route::get('/opportunities/view/{id}', [OpportunitiesController::class, 'SectoralOpportunities']);
        Route::post('/opportunity/bulkAction', [OpportunitiesController::class, 'OpportunityBulkAction']);
        Route::get('/opportunity/add', [OpportunitiesController::class, 'AddOpportunity']);
        Route::post('/opportunity/store/{id}', [OpportunitiesController::class, 'OpportunityStore']);
        Route::get('/opportunity/eye/{id}', [OpportunitiesController::class, 'OpportunityEye']);
        Route::post('/opportunity/update/{id}', [OpportunitiesController::class, 'OpportunityUpdate']);

        Route::get('/opportunity/report/{id}', [OpportunitiesController::class, 'OpportunityReport']);
    /* -------------------- End Opportunities -------------------------*/

    /* -------------------- Approval Section -------------------------*/
        Route::get('/opportunity/approve/{id}', [ApproveController::class, 'AdminApprove']);
        Route::get('/opportunity/reevaluation/{id}', [ApproveController::class, 'AdminReevaluation']);
        Route::get('/super/opportunity/approve/{id}', [ApproveController::class, 'SuperApprove']);
        Route::get('/super/opportunity/not/approve/{id}', [ApproveController::class, 'SuperNotApprove']);
    /* -------------------- End Approval Section -------------------------*/

});
/* -------------------- End Admin -------------------------*/

/* -------------------- Main User -------------------------*/
    Route::post('/login', [AuthUserController::class, 'login']);
    Route::post('/register', [AuthUserController::class, 'register']);
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/news/archive', [DashboardController::class, 'NewsArchive']);
    Route::get('/news/data/{id}', [DashboardController::class, 'NewsData']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthUserController::class, 'logout'])->middleware('auth:sanctum');
        Route::get('/user', [AuthUserController::class, 'user'])->middleware('auth:sanctum');

        Route::get('/organization/dashboard', [DashboardController::class, 'DashboardView']);

        Route::get('/organization/basic', [AboutController::class, 'OrganizationBasic']);
        Route::post('/organization/basic/update', [AboutController::class, 'BasicUpdate']);

        Route::get('/organization/about', [AboutController::class, 'OrganizationAbout']);
        Route::post('/organization/about/store', [AboutController::class, 'AboutStore']);

        Route::get('/organization/financial', [FinancialController::class, 'OrganizationFinancial']);
        Route::post('/organization/financial/store', [FinancialController::class, 'FinancialStore']);

        Route::get('/organization/services', [ServicesController::class, 'OrganizationServices']);
        Route::post('/organization/services/store', [ServicesController::class, 'ServicesStore']);

        Route::get('/organization/staff', [StaffController::class, 'OrganizationStaff']);
        Route::post('/organization/staff/store', [StaffController::class, 'StaffStore']);

        Route::get('/organization/volunteers', [VolunteerController::class, 'OrganizationVolunteers']);
        Route::post('/organization/volunteer/store', [VolunteerController::class, 'VolunteerStore']);


        // -------------------- Organization Opportunity -------------------------
        Route::get('/organization/opportunity/{id}', [OpportunityController::class, 'OrganizationOpportunity']);
        Route::get('/organization/opportunity/eye/{id}', [OpportunityController::class, 'OrganizationOpportunityEye']);
        Route::post('/organization/update/status', [OpportunityController::class, 'UpdateStatus']);

        Route::post('/organization/answer/{id}', [OpportunityController::class, 'OrganizationAnswer']);
        Route::post('/organization/answer/store/{id}', [OpportunityController::class, 'OrganizationAnswerStore']);
        Route::get('/organization/score/{id}', [OpportunityController::class, 'OrganizationScore']);
        
        // -------------------- End Organization Opportunity -------------------------
    });




/* -------------------- End Main User -------------------------*/   







