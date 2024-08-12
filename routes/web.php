<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organization\AboutController;
use App\Http\Controllers\Organization\FinancialController;
use App\Http\Controllers\Organization\ServicesController;
use App\Http\Controllers\Organization\StaffController;
use App\Http\Controllers\Organization\VolunteerController;
use App\Http\Controllers\Organization\OrganizationUsersController;
use App\Http\Controllers\Organization\OpportunityController;
use App\Http\Controllers\Organization\AnswersController;

use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\OpportunitiesController;
use App\Http\Controllers\Admin\ApproveController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* -------------------- Admin Route ------------------- */
Route::get('/admin/login', [AdminController::class, 'Index'])->name('login_form');
Route::post('/admin/login/owner', [AdminController::class, 'Login'])->name('admin.login');

Route::prefix('admin')->middleware('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'Dashboard'])
        ->name('admin.dashboard');
    Route::get('/management', [AdminController::class, 'AdminManagement'])->name('admin.management');

    Route::get('/admin/register', [AdminController::class, 'AdminRegister'])->name('admin.register');
    Route::post('/admin/register/store', [AdminController::class, 'AdminRegisterStore'])->name('admin.register.store');

    Route::get('/logout', [AdminController::class, 'AdminLogout'])
        ->name('admin.logout');

/* ------------------ News --------------------*/
    Route::get('/news/view', [NewsController::class, 'NewsView'])->name('news');
    Route::get('/news/add', [NewsController::class, 'NewsAdd'])->name('news.add');
    Route::post('/news/store', [NewsController::class, 'NewsStore'])->name('news.store');
    Route::get('/news/hide/{id}', [NewsController::class, 'NewsHide'])->name('news.hide');
    Route::get('/news/show/{id}', [NewsController::class, 'NewsShow'])->name('news.show');
    Route::get('/news/edit/{id}', [NewsController::class, 'NewsEdit'])->name('news.edit');
    Route::post('/news/update/{id}', [NewsController::class, 'NewsUpdate'])->name('news.update');
    Route::get('/news/delete/{id}', [NewsController::class, 'NewsDelete'])->name('news.delete');
/* ------------------ End News --------------------*/

/* ------------------ User Management  ------------------ */
    Route::get('/user/management', [UserManagementController::class, 'UserManagement'])->name('user.management');
    Route::post('/user/bulkAction', [UserManagementController::class, 'UserBulkAction'])->name('user.bulkAction');
    Route::get('/user/eye/{id}', [UserManagementController::class, 'UserEye'])->name('user.eye');

    Route::get('/organization/basic/{id}', [UserManagementController::class, 'AdminOrganizationBasic'])->name('admin.organization.basic');
    Route::get('/organization/about/{id}', [UserManagementController::class, 'AdminOrganizationAbout'])->name('admin.organization.about');
    Route::get('/organization/financial/{id}', [UserManagementController::class, 'AdminOrganizationFinancial'])->name('admin.organization.financial');
    Route::get('/organization/services/{id}', [UserManagementController::class, 'AdminOrganizationServices'])->name('admin.organization.services');
    Route::get('/organization/staff/{id}', [UserManagementController::class, 'AdminOrganizationStaff'])->name('admin.organization.staff');
    Route::get('/organization/volunteers/{id}', [UserManagementController::class, 'AdminOrganizationVolunteers'])->name('admin.organization.volunteers');

/* ------------------ End User Management ---------------- */

/* ------------------ sectoral Opportunities  ------------------ */
    Route::get('/sectoral/opportunities/{id}', [OpportunitiesController::class, 'SectoralOpportunities'])->name('sectoral.opportunities');
    Route::get('/add/opportunity/{id}', [OpportunitiesController::class, 'AddOpportunity'])->name('add.opportunity');
    Route::post('/opportunity/store/{id}', [OpportunitiesController::class, 'OpportunityStore'])->name('opportunity.store');
    Route::get('/opportunity/eye/{id}', [OpportunitiesController::class, 'OpportunityEye'])->name('opportunity.eye');
    Route::post('/opportunity/update/{id}', [OpportunitiesController::class, 'OpportunityUpdate'])->name('opportunity.update');
    Route::post('/opportunity/bulkAction', [OpportunitiesController::class, 'OpportunityBulkAction'])->name('opportunity.bulkAction');

    Route::get('/opportunity/report/{id}', [OpportunitiesController::class, 'OpportunityReport'])->name('opportunity.report');

/* ------------------ End sectoral Opportunities  ------------------ */

/* ------------------ Approval Section  ------------------ */
    Route::get('/opportunity/approve/{id}', [ApproveController::class, 'AdminApprove'])->name('admin.approve');
    Route::get('/opportunity/reevaluation/{id}', [ApproveController::class, 'AdminReevaluation'])->name('admin.reevaluation');
    Route::get('/super/opportunity/approve/{id}', [ApproveController::class, 'SuperApprove'])->name('super.approve');
    Route::get('/super/opportunity/not/approve/{id}', [ApproveController::class, 'SuperNotApprove'])->name('super.notApprove');

/* ------------------ End Approval Section  ------------------ */


});


/* -------------------- End Admin Route ------------------- */

/* -------------------- Main User -------------------------*/
//Route::get('/', function () {
//    return view('frontend.index');
//})->name('index');

Route::get('/', [DashboardController::class, 'index'])->name('index');
Route::get('/news/archive', [DashboardController::class, 'NewsArchive'])->name('news.archive');
Route::get('/news/data/{id}', [DashboardController::class, 'NewsData'])->name('news.data');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'DashboardView'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user/logout', [OrganizationUsersController::class, 'UserLogout'])
        ->name('user.logout');

    Route::get('/organization/basic', [AboutController::class, 'OrganizationBasic'])->name('organization.basic');
    Route::post('/organization/basic/update', [AboutController::class, 'BasicUpdate'])->name('basic.update');

    Route::get('/organization/about', [AboutController::class, 'OrganizationAbout'])->name('organization.about');
    Route::post('/organization/about/store', [AboutController::class, 'AboutStore'])->name('about.store');

    Route::get('/organization/financial', [FinancialController::class, 'OrganizationFinancial'])->name('organization.financial');
    Route::post('/organization/financial/store', [FinancialController::class, 'FinancialStore'])->name('financial.store');

    Route::get('/organization/services', [ServicesController::class, 'OrganizationServices'])->name('organization.services');
    Route::post('/organization/services/store', [ServicesController::class, 'ServicesStore'])->name('services.store');

    Route::get('/organization/staff', [StaffController::class, 'OrganizationStaff'])->name('organization.staff');
    Route::post('/organization/staff/store', [StaffController::class, 'StaffStore'])->name('staff.store');

    Route::get('/organization/volunteers', [VolunteerController::class, 'OrganizationVolunteers'])->name('organization.volunteers');
    Route::post('/organization/volunteer/store', [VolunteerController::class, 'VolunteerStore'])->name('volunteer.store');
    Route::get('/organization/volunteers', [VolunteerController::class, 'OrganizationVolunteers'])->name('organization.volunteers');

    Route::get('/organization/user/management/{id}', [OrganizationUsersController::class, 'OrganizationUserManagement'])->name('organization.user.management');
    Route::post('/organization/user/bulkAction', [OrganizationUsersController::class, 'OrganizationUserBulkAction'])->name('organization.user.bulkAction');
    Route::get('/organization/add/user/{id}', [OrganizationUsersController::class, 'OrganizationAddUser'])->name('organization.add.user');
    Route::post('/organization/store/user', [OrganizationUsersController::class, 'OrganizationStoreUser'])->name('organization.store.user');

    /* -------------------- Organization Opportunity -------------------------*/
    Route::get('/organization/opportunity/{id}', [OpportunityController::class, 'OrganizationOpportunity'])->name('organization.opportunity');
    Route::get('/organization/opportunity/eye/{id}', [OpportunityController::class, 'OrganizationOpportunityEye'])->name('organization.opportunity.eye');
    Route::post('/organization/update/status', [OpportunityController::class, 'UpdateStatus'])->name('update.status');


    Route::post('/organization/answer', [AnswersController::class, 'OrganizationAnswer'])->name('organization.answer');
    Route::get('/organization/score/{id}', [AnswersController::class, 'OrganizationScore'])->name('organization.score');
    /* -------------------- Organization Opportunity -------------------------*/

    /* -------------------- Organization User -------------------------*/
    Route::get('/user/basic/{id}', [OrganizationUsersController::class, 'OrganizationUserBasic'])->name('organization.user.basic');
    Route::get('/user/about/{id}', [OrganizationUsersController::class, 'OrganizationUserAbout'])->name('organization.user.about');
    Route::get('/user/financial/{id}', [OrganizationUsersController::class, 'OrganizationUserFinancial'])->name('organization.user.financial');
    Route::get('/user/services/{id}', [OrganizationUsersController::class, 'OrganizationUserServices'])->name('organization.user.services');
    Route::get('/user/staff/{id}', [OrganizationUsersController::class, 'OrganizationUserStaff'])->name('organization.user.staff');
    Route::get('/user/volunteers/{id}', [OrganizationUsersController::class, 'OrganizationUserVolunteers'])->name('organization.user.volunteers');
    /* -------------------- End Organization User -------------------------*/
});

/* -------------------- End Main User -------------------------*/




require __DIR__.'/auth.php';
