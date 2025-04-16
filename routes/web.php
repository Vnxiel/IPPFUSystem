<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManager;
use App\Http\Controllers\SystemAdminManager;
use App\Http\Controllers\ActivityLogs; // Import the ActivityLogs controller
use App\Http\Controllers\ProjectManager;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\FundsUtilizationController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\GenerateProjectReport;
use App\Http\Controllers\AdminManager;
use App\Http\Controllers\StaffManager;


Route::get('/', function () {
    return view('index');
});

Route::controller(UserManager::class)->group(function () {
    Route::get('/FirstUserRegistration/register', 'goToRegister')->name('FirstUserRegistration.register');
    Route::post('/registerSystemAdmin', 'registerSystemAdmin')->name(name: 'registerSystemAdmin');
    Route::get('/', 'index');
    Route::post('/login', 'userLogin')->name('login');

    Route::get('/systemAdmin/projects', 'projects')->name('systemAdmin.projects');
    
    Route::get('/systemAdmin/overview', 'overview')->name('systemAdmin.overview');
    Route::get('/systemAdmin/reports', 'funds')->name('systemAdmin.funds');
    Route::get('/systemAdmin/trash', 'trash')->name('systemAdmin.trash');

    //staff
    Route::get('/staff/index', 'staffIndex')->name('staff.index');
    Route::get('/staff/overview', 'overview')->name('staff.overview');
    Route::get('/staff/projects', 'projects')->name('staff.projects');
    Route::get('/staff/userManagement', 'userManagemenr')->name('staff.userManagement');
    Route::get('/staff/activityLogs', 'activityLogs')->name('staff.activityLogs');
     //admin
     Route::get('/admin/index', 'index');
     Route::get('/admin/projects', 'projects');
     Route::get('/admin/overview', 'overview');
});



Route::controller(SystemAdminManager::class)->group(function () {
    Route::get('/systemAdmin/index', 'index')->name(name: 'systemAdmin.index');
    Route::get('/systemAdmin/userManagement', 'viewUserManagement')->name('systemAdmin.userManagement');

    Route::post('/userRegistration', 'registerUser')->name('userRegistration');
    Route::get('/getUsers', 'viewUserManagement')->name('getUsers');

    Route::get('/getUserRole', 'getUserRole');
    Route::post('/changeRole', 'changeRole');

    Route::get('/systemAdmin/activityLogs', 'viewActivityLogs')->name('systemAdmin.activityLogs');

});

// Admin Management Routes
Route::controller(AdminManager::class)->group(function () {
    Route::get('/admin/index', 'index');
    Route::get('/admin/projects', 'projects');
    Route::get('/admin/userManagement', 'userManagement');
    Route::get('/admin/overview', 'overview');
 });

 // Staff Management Routes
 Route::controller(StaffManager::class)->group(function () {
    Route::get('/staff/index', 'index');
    Route::get('/staff/projects', 'projects');
    Route::get('/staff/overview', 'overview');
    Route::get('/staff/projects', 'contractorsList');
 });

Route::controller(ActivityLogs::class)->group(function () {
    // Activity Logs Routes
    Route::post('/activity-logs', 'store'); // Store a new log
    Route::get('/activity-logs', 'index'); // Retrieve all logs
    Route::get('/getActivityLogs', 'index')->name(name: 'getActivityLogs');
});

   // Project Management Routes
   Route::controller(ProjectManager::class)->group(function () {
    Route::get('/projects/ProjectDetails', 'ProjectDetails')->name('projects.ProjectDetails');
    Route::post('/projects/addProject', 'addProject')->name('projects.addProject');
    Route::get('/projects/getProject/{project_id}', 'getProject');
    Route::get('/projects/summary', 'getProjectSummary');
    Route::get('/projects/getAllProjects', 'getAllProjects');
    Route::get('/projects/fetch-trash', 'fetchTrashedProjects');
    Route::post('/projects/insertProjectStatus',  'insertProjectStatus');
    Route::post('/update-project-status', 'updateProjectStatus');
    Route::put('/projects/update/{project_id}', 'updateProject')->name('projects.update');
    Route::put('/projects/trash/{project_id}', 'trashProject')->name('projects.trash');
    Route::put('/projects/restore/{project_id}', 'restoreProject')->name('projects.restore');
    Route::get('/project-status/{project_id}', 'fetchStatus')->name('projects.status.fetch');
    Route::post('/project-status/addStatus', 'addStatus');

});

// funds utilization
Route::get('/fund-utilization/{project_id}', [FundsUtilizationController::class, 'getFundUtilization']);
Route::post('/fund-utilization/store', [FundsUtilizationController::class, 'storeFundUtilization']);


// Generate Project Routes
Route::get('generateProject/{project_id}', [GenerateProjectReport::class, 'generateProjectPDF']);


// Session Handling Routes
Route::post('/store-project-id', [SessionController::class, 'storeProjectID'])->name('store.project.id');
Route::get('/get-project-id', [SessionController::class, 'getProjectID']);

 

  // File Management Routes
  Route::controller(FileManager::class)->group(function () {
    Route::post('/upload-file/{project_id}', 'uploadFile');
    Route::get('/files/{projectID}', 'getFiles')->name('get.files');
    Route::delete('/delete/{fileID}',  'delete');
   Route::get('/download-file/{filename}', 'downloadFile');
});
