<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\User\DashboardController;
use App\Http\Controllers\Api\User\AboutController;
use App\Http\Controllers\Api\User\FinancialController;
use App\Http\Controllers\Api\User\ServicesController;
use App\Http\Controllers\Api\User\StaffController;
use App\Http\Controllers\Api\User\VolunteerController;
use App\Http\Controllers\Api\User\OrganizationUsersController;
use App\Http\Controllers\Api\User\OpportunityController;
use App\Http\Controllers\Api\User\PartnershipsController;
use App\Http\Controllers\Api\User\AppreciationController;
use App\Http\Controllers\Api\User\GovernanceController;
use App\Http\Controllers\Api\User\ChallengesController;
use App\Http\Controllers\Api\User\OrganizationIndicatorsController;
use App\Http\Controllers\Api\Admin\AuthAdminController;
use App\Http\Controllers\Api\Admin\NewsController;
use App\Http\Controllers\Api\Admin\UserManagementController;
use App\Http\Controllers\Api\Admin\OpportunitiesController;
use App\Http\Controllers\Api\Admin\ApproveController;
use App\Http\Controllers\Api\Admin\QualitativeEvaluations;
use App\Http\Controllers\Api\Admin\IndicatorsController;



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
// Admin Authentication Routes
Route::post('/admin/login/owner', [AuthAdminController::class, 'Login']);
Route::post('/admin/register/store', [AuthAdminController::class, 'AdminRegisterStore']); // Accessible without authentication
Route::delete('/admin/delete/{admin_id}', [AuthAdminController::class, 'DeleteAdmin'])->name('admin.delete');

// Protected Admin Routes
Route::prefix('admin')->middleware('auth:api')->group(function () {

    Route::get('/dashboard', [AuthAdminController::class, 'Dashboard']);
    Route::get('/management', [AuthAdminController::class, 'AdminManagement']);
    Route::get('/logout', [AuthAdminController::class, 'AdminLogout']);
    Route::get('/permission', [AuthAdminController::class, 'AdminPermission']);

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

    Route::get('/organization/sectoral/challenges/{id}', [UserManagementController::class, 'SectoralChallenges']);
    Route::get('/organization/instituational/challenges/{id}', [UserManagementController::class, 'InstituationalChallenges']);
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

    /* --------------------- Qualitative Evaluations -------------------------*/
    Route::get('/qualitative/evaluations', [QualitativeEvaluations::class, 'QualitativeEvaluation']);
    Route::post('/qualitative/evaluations/store', [QualitativeEvaluations::class, 'OrganizationEvaluationStore']);
    Route::get('/qualitative/evaluations/result', [QualitativeEvaluations::class, 'QualitativeEvaluationResult']);
    /* --------------------- End Qualitative Evaluations  -------------------------*/

    /* --------------------- Private Indicators  -------------------------*/
    Route::get('/private/indicators', [IndicatorsController::class, 'PrivateIndicators']);
    Route::post('/private/indicators/store', [IndicatorsController::class, 'PrivateIndicatorsStore']);
    /* --------------------- End Private Indicators  -------------------------*/

});

/* -------------------- End Admin -------------------------*/

/* -------------------- Main User -------------------------*/
    Route::post('/login', [AuthUserController::class, 'login']);
    Route::post('/register', [AuthUserController::class, 'register']);
    Route::post('/forgot-password', [AuthUserController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthUserController::class, 'resetPassword']);

    Route::get('/user/permission', [AuthUserController::class, 'userPermission']);
    Route::get('/user/name', [AuthUserController::class, 'UserName']);
    Route::get('/auth/validate-token', [AuthUserController::class, 'ValidateToken']);

    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::post('/contact-us', [ContactUsController::class, 'submit']);
    Route::get('/news/archive', [DashboardController::class, 'NewsArchive']);
    Route::get('/news/data/{id}', [DashboardController::class, 'NewsData']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthUserController::class, 'logout'])->middleware('auth:sanctum');
        Route::get('/user', [AuthUserController::class, 'user'])->middleware('auth:sanctum');


        Route::get('/organization/dashboard', [DashboardController::class, 'DashboardView']);

        /* -------------------- Basic Data -------------------------*/
        Route::get('/organization/basic', [AboutController::class, 'OrganizationBasic']);
        Route::post('/organization/basic/update', [AboutController::class, 'BasicUpdate']);
        /* -------------------- End Basic Data -------------------------*/

        /* -------------------- Specialized Data -------------------------*/
        Route::get('/organization/specialized/data', [AboutController::class, 'OrganizationSpecializedData']);
        Route::post('/organization/specialized/data/store', [AboutController::class, 'SpecializedDataStore']);
        Route::get('/organization/about', [AboutController::class, 'OrganizationAbout']);
        Route::post('/organization/about/store', [AboutController::class, 'AboutStore']);
        /* -------------------- End Specialized Data -------------------------*/

        /* -------------------- Financial Data -------------------------*/
        Route::get('/organization/financial', [FinancialController::class, 'OrganizationFinancial']);
        Route::post('/organization/financial/store', [FinancialController::class, 'FinancialStore']);
        /* -------------------- End Financial Data -------------------------*/

        /* -------------------- Services Data -------------------------*/
        Route::get('/organization/services/slide', [ServicesController::class, 'OrganizationServicesBySlide']);
        Route::post('/organization/services/slide/store', [ServicesController::class, 'ServicesBySlideStore']);

        Route::get('/organization/services/target', [ServicesController::class, 'OrganizationServicesByTarget']);
        Route::post('/organization/services/target/store', [ServicesController::class, 'ServicesByTargetStore']);

        Route::get('/organization/services/first', [ServicesController::class, 'OrganizationServicesFirst']);
        Route::get('/organization/services/second', [ServicesController::class, 'OrganizationServicesSecond']);
        Route::post('/organization/services/store', [ServicesController::class, 'ServicesStore']);

        Route::get('/organization/services/satisfaction', [ServicesController::class, 'OrganizationServicesBySatisfaction']);
        Route::post('/organization/services/satisfaction/store', [ServicesController::class, 'ServicesBySatisfactionStore']);
        /* -------------------- End Services Data -------------------------*/

        /* -------------------- staff Data -------------------------*/
        Route::get('/organization/staff/represent/ceo', [StaffController::class, 'OrganizationStaffRepresentCEO']);
        Route::get('/organization/staff/represent/notceo', [StaffController::class, 'OrganizationStaffRepresentNotCEO']);
        Route::post('/organization/staff/represent/store', [StaffController::class, 'StaffRepresentStore']);

        Route::get('/organization/staff/saudi/consulting/contract/{id}', [StaffController::class, 'OrganizationStaffConsulting']);
        Route::get('/organization/staff/saudi/fulltime/contract/{id}', [StaffController::class, 'OrganizationStaffFulltime']);
        Route::get('/organization/staff/saudi/partTime/contract/{id}', [StaffController::class, 'OrganizationStaffpartTime']);
        Route::post('/organization/staff/saudi/store', [StaffController::class, 'StaffSaudiStore']);

        Route::get('/organization/staff/qualifications/opportunities', [StaffController::class, 'OrganizationStaffOpportunities']);
        Route::get('/organization/staff/qualifications/certificates', [StaffController::class, 'OrganizationStaffCertificates']);
        Route::get('/organization/staff/qualifications/work', [StaffController::class, 'OrganizationStaffWork']);
        Route::post('/organization/staff/qualifications/store', [StaffController::class, 'StaffQualificationsStore']);

        Route::get('/organization/staff/other', [StaffController::class, 'OrganizationStaffOther']);
        Route::post('/organization/staff/other/store', [StaffController::class, 'StaffOtherStore']);

        /* -------------------- End Staff Data -------------------------*/

        /* -------------------- Volunteers Data -------------------------*/
        Route::get('/organization/volunteers/field/{id}', [VolunteerController::class, 'OrganizationVolunteersField']);
        Route::get('/organization/volunteers/office/{id}', [VolunteerController::class, 'OrganizationVolunteersOffice']);
        Route::get('/organization/volunteers/remotely/{id}', [VolunteerController::class, 'OrganizationVolunteersRemotely']);
        Route::get('/organization/volunteers/integrated/{id}', [VolunteerController::class, 'OrganizationVolunteersIntegrated']);
        Route::post('/organization/volunteer/store', [VolunteerController::class, 'VolunteerStore']);
        /* -------------------- End Volunteers Data -------------------------*/

        /* -------------------- Organization User -------------------------*/
        Route::get('/organization/user/management/{id}', [OrganizationUsersController::class, 'OrganizationUserManagement']);
        Route::post('/organization/user/bulkAction', [OrganizationUsersController::class, 'OrganizationUserBulkAction']);
        Route::get('/organization/add/user/{id}', [OrganizationUsersController::class, 'OrganizationAddUser']);
        Route::post('/organization/store/user', [OrganizationUsersController::class, 'OrganizationStoreUser']);

        Route::get('/organization/user/basic/{id}', [OrganizationUsersController::class, 'OrganizationUserBasic']);
        Route::get('/organization/user/about/{id}', [OrganizationUsersController::class, 'OrganizationUserAbout']);
        Route::get('/organization/user/financial/{id}', [OrganizationUsersController::class, 'OrganizationUserFinancial']);
        Route::get('/organization/user/services/{id}', [OrganizationUsersController::class, 'OrganizationUserServices']);
        Route::get('/organization/user/staff/{id}', [OrganizationUsersController::class, 'OrganizationUserStaff']);
        Route::get('/organization/user/volunteers/{id}', [OrganizationUsersController::class, 'OrganizationUserVolunteers']);

        /* -------------------- End Organization User -------------------------*/

        // -------------------- Organization Opportunity -------------------------*/
        Route::get('/organization/opportunity/{id}', [OpportunityController::class, 'OrganizationOpportunity']);
        Route::get('/organization/opportunity/eye/{id}', [OpportunityController::class, 'OrganizationOpportunityEye']);
        Route::post('/organization/update/status', [OpportunityController::class, 'UpdateStatus']);

        Route::post('/organization/answer/{id}', [OpportunityController::class, 'OrganizationAnswer']);
        Route::post('/organization/answer/store/{id}', [OpportunityController::class, 'OrganizationAnswerStore']);
        Route::get('/organization/score/{id}', [OpportunityController::class, 'OrganizationScore']);
        // -------------------- End Organization Opportunity -------------------------*/

        // -------------------- PartnerShips -------------------------*/
        Route::get('/organization/partnership/view', [PartnershipsController::class, 'PartnershipsView']);
        Route::post('/organization/partnership/store', [PartnershipsController::class, 'PartnershipsStore']);
        Route::get('/organization/partnership/edit/{id}', [PartnershipsController::class, 'PartnershipsEdit']);
        Route::post('/organization/partnership/update/{id}', [PartnershipsController::class, 'PartnershipsUpdate']);
        Route::get('/organization/partnership/delete/{id}', [PartnershipsController::class, 'PartnershipsDelete']);
        // -------------------- End PartnerShips -------------------------*/

        // -------------------- Appreciations -------------------------*/
        Route::get('/organization/appreciation/view', [AppreciationController::class, 'AppreciationView']);
        Route::post('/organization/appreciation/store', [AppreciationController::class, 'AppreciationStore']);
        Route::get('/organization/appreciation/edit/{id}', [AppreciationController::class, 'AppreciationEdit']);
        Route::post('/organization/appreciation/update/{id}', [AppreciationController::class, 'AppreciationUpdate']);
        Route::get('/organization/appreciation/delete/{id}', [AppreciationController::class, 'AppreciationDelete']);
        // -------------------- End Appreciations -------------------------*/

        // -------------------- Governance -------------------------*/
        Route::get('/organization/governance/view', [GovernanceController::class, 'GovernanceView']);
        Route::post('/organization/governance/store', [GovernanceController::class, 'GovernanceStore']);
        // -------------------- End Governance -------------------------*/

        // -------------------- Sectoral challenges -------------------------*/
        Route::get('/organization/sectoral/challenges/view/{id}', [ChallengesController::class, 'SectoralChallengesView']);
        Route::post('/organization/sectoral/challenges/store/{id}', [ChallengesController::class, 'SectoralChallengesStore']);
        // -------------------- End Sectoral challenges -------------------------*/

        // -------------------- Instituational challenges -------------------------*/
        Route::get('/organization/instituational/challenges/view/{id}', [ChallengesController::class, 'InstituationalChallengesView']);
        Route::post('/organization/nstituational/challenges/store/{id}', [ChallengesController::class, 'InstituationalChallengesStore']);
        // -------------------- End Instituational challenges -------------------------*/

        // -------------------------- Pivate Indicator ----------------------------------*/
        Route::get('/organization/private/indicators', [OrganizationIndicatorsController::class, 'OrganizationPrivateIndicators']);
        Route::post('/organization/private/indicators/store', [OrganizationIndicatorsController::class, 'OrganizationPrivateIndicatorsStore']);
        // ----------------------- End Pivate Indicator ----------------------------------*/
    });




/* -------------------- End Main User -------------------------*/







