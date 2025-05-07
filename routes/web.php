<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManager;
use App\Http\Controllers\AdminManager;
use App\Http\Controllers\StaffManager;
use App\Http\Controllers\SystemAdminManager;
use App\Http\Controllers\ActivityLogs;
use App\Http\Controllers\ProjectManager;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\FundsUtilizationController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\GenerateProjectReport;

// PUBLIC ROUTES
Route::controller(UserManager::class)->group(function () {

    // Handle login (POST request)
    Route::post('/login', 'userLogin')->name('login');  // Handle login logic
    Route::get('/FirstUserRegistration/register', 'goToRegister')->name('FirstUserRegistration.register');
    Route::post('/registerSystemAdmin', 'registerSystemAdmin')->name('registerSystemAdmin');
    Route::get('/', 'index')->name('home');
});

// SYSTEM ADMIN ROUTES
Route::middleware(['auth', 'role:System Admin'])->group(function () {
    Route::controller(UserManager::class)->group(function () {
        
        Route::post('/logout', 'logout')->name('logout');  // Handle logout logic
        Route::get('/systemAdmin/reports', 'funds')->name('systemAdmin.funds');
        Route::get('/systemAdmin/trash', 'trash')->name('systemAdmin.trash');
        Route::get('/systemAdmin/index', 'index')->name('systemAdmin.index');
    });

    Route::controller(SystemAdminManager::class)->group(function () {
        Route::get('/systemAdmin/index', 'index')->name('systemAdmin.index');
        Route::get('/systemAdmin/userManagement', 'viewUserManagement')->name('systemAdmin.userManagement');
        Route::post('/userRegistration', 'registerUser')->name('userRegistration');
        Route::get('/getUsers', 'viewUserManagement')->name('getUsers');
        Route::get('/getUserRole', 'getUserRole');
        Route::post('/changeRole', 'changeRole');
        Route::get('/systemAdmin/activityLogs', 'viewActivityLogs')->name('systemAdmin.activityLogs');
        Route::get('/systemAdmin/modals/edit-project', 'editProject')->name('systemAdmin.editProject');
    });
});

// STAFF ROUTES
Route::middleware(['auth', 'role:Staff'])->group(function () {
    Route::controller(StaffManager::class)->group(function () {
        Route::get('/staff/index', 'index')->name('staff.index');
        Route::get('/staff/projects', 'projects')->name('staff.projects');
        Route::get('/staff/userManagement', 'userManagement')->name('staff.userManagement');
        Route::get('/staff/activityLogs', 'activityLogs')->name('staff.activityLogs');
    });
});

// ADMIN ROUTES
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::controller(AdminManager::class)->group(function () {
        Route::get('/admin/index', 'index')->name('admin.index');
        Route::get('/admin/projects', 'projects')->name('admin.projects');
        Route::get('/admin/userManagement', 'viewUserManagement')->name('admin.userManagement');
        Route::get('/admin/trash', 'trash')->name('admin.trash');
        Route::get('/admin/activityLogs', 'activityLogs')->name('admin.activityLogs');
        Route::get('/getUsers', 'viewUserManagement')->name('getUsers');
        Route::get('/admin/userManagement', 'viewUserManagement')->name('admin.userManagement');
        Route::get('/admin/activityLogs', 'viewActivityLogs')->name('admin.activityLogs');
    });
});

// SHARED ROUTES (multiple roles if needed)
Route::middleware(['auth'])->group(function () {
    Route::controller(ActivityLogs::class)->group(function () {
        Route::post('/activity-logs', 'store');
        Route::get('/activity-logs', 'index');
        Route::get('/getActivityLogs', 'index')->name('getActivityLogs');
    });

    Route::controller(ProjectManager::class)->group(function () {
        Route::get('/projects/ProjectDetails', 'ProjectDetails')->name('projects.ProjectDetails');
        Route::get('/systemAdmin/projects', 'viewProjects')->name('systemAdmin.projects');
        Route::post('/projects/addProject', 'addProject')->name('projects.addProject');
        Route::get('/systemAdmin/overview/{id}', 'getProject')->name('systemAdmin.overview');
        Route::get('/admin/overview/{id}', 'getProject')->name('admin.overview');
        Route::get('/staff/overview/{id}', 'getProject')->name('staff.overview');
        Route::get('/projects/getProject/{project_id}', 'getProject');
        Route::get('/projects/summary', 'getProjectSummary');
        Route::get('/projects/getAllProjects', 'getAllProjects');
        Route::get('/projects/fetch-trash', 'fetchTrashedProjects');
        Route::put('/projects/update/{project_id}', 'updateProject')->name('projects.update');
        Route::put('/projects/trash/{project_id}', 'trashProject')->name('projects.trash');
        Route::put('/projects/restore/{project_id}', 'restoreProject')->name('projects.restore');
        Route::post('/project-status/addStatus', 'addStatus');
    });
    
  
    Route::get('/fund-utilization/{project_id}', [FundsUtilizationController::class, 'getFundUtilization']);
    Route::post('/fund-utilization/store', [FundsUtilizationController::class, 'storeFundUtilization']);
    
    Route::get('generateProject/{project_id}', [GenerateProjectReport::class, 'generateProjectPDF']);


    Route::controller(FileManager::class)->group(function () {
        Route::post('/upload-file/{project_id}', 'uploadFile');
        Route::get('/files/{projectID}', 'getFiles')->name('get.files');
        Route::delete('/file-delete/{fileName}',  'delete')->name('file.delete');
        Route::get('/download-file/{filename}', 'downloadFile');
    });

 
    
});
