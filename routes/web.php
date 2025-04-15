<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManager;
use App\Http\Controllers\SystemAdminManager;
use App\Http\Controllers\ActivityLogs; // Import the ActivityLogs controller
use App\Http\Controllers\ProjectManager;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\GenerateProjectReport;


Route::get('/', function () {
    return view('index');
});

Route::controller(UserManager::class)->group(function () {
    Route::get('/FirstUserRegistration/register', 'goToRegister')->name('FirstUserRegistration.register');
    Route::post('/registerSystemAdmin', 'registerSystemAdmin')->name(name: 'registerSystemAdmin');
    Route::get('/', 'index');
    Route::post('/login', 'userLogin')->name('login');

    Route::get(uri: '/systemAdmin/projects', action: 'viewProjects')->name('systemAdmin.projects');
    Route::get('/systemAdmin/reports', 'funds')->name('systemAdmin.funds');
    Route::get('/systemAdmin/trash', 'trash')->name('systemAdmin.trash');
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

Route::controller(ActivityLogs::class)->group(function () {
    // Activity Logs Routes
    Route::post('/activity-logs', 'store'); // Store a new log
    Route::get('/activity-logs', 'index'); // Retrieve all logs
    Route::get('/getActivityLogs', 'index')->name(name: 'getActivityLogs');
});


// Project Management Routes
Route::controller(ProjectManager::class)->group(function () {
    Route::get('/systemAdmin/overview', 'overview')->name('systemAdmin.overview');

    Route::post('/projects/addProject', 'addProject')->name('projects.addProject');
    Route::get('/projects/showDetails', 'showDetails')->name('projects.showDetails');
    Route::get('/projects/getProject/{projectID}', 'getProject')->name('projects.getProject');
    Route::get('/projects/summary', 'getProjectSummary')->name('projects.summary');
    Route::put('/projects/update/{projectID}', 'updateProject')->name('projects.update'); // Ensure ID consistency
    Route::put('/projects/trash/{projectID}', 'trashProject')->name('projects.trash');
    Route::get('/projects/fetch-trash', 'fetchTrashedProjects')->name('projects.fetchTrash');
    Route::put('/projects/restore/{projectID}', 'restoreProject')->name('projects.restore');

    Route::get('/projects/contractors', 'getContractors')->name('projects.getContractors');
    Route::get('/projects/data', 'getProjectsData')->name('projects.getData');


    Route::get('/systemAdmin/projects', 'getDropdownOptions')->name('systemAdmin.projects');
    Route::get('/systemAdmin/projects', 'getDropdownOptions')->name('systemAdmin.overview');
    
});

// Generate Project Routes


// Session Handling Routes
Route::post('/store-project-id', [SessionController::class, 'storeProjectID'])->name('store.project.id');
Route::get('/get-project-id', [SessionController::class, 'getProjectID']);

// File Management Routes
Route::controller(FileManager::class)->group(function () {
    Route::post('/uploadFile', 'uploadFile')->name('upload.file');
    Route::get('/files/{projectID}', 'getFiles')->name('get.files');
    Route::delete('/delete/{fileID}', 'delete')->name('delete.file');
});
