<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManager;
use App\Http\Controllers\SystemAdminManager;
use App\Http\Controllers\ActivityLogs; // Import the ActivityLogs controller
use App\Http\Controllers\ProjectManager;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\SessionController;

Route::get('/', function() {
    return view('index');
});

Route::controller(UserManager::class)->group(function () {
    Route::get('/systemAdmin/register', 'goToRegister')->name('systemAdmin.register');
    Route::post('/registerSystemAdmin', 'registerSystemAdmin')->name(name: 'registerSystemAdmin');
    Route::get('/', 'index')->name('login');
    Route::post('/login', 'userLogin')->name('login');

    Route::get('/main/projects', 'projects')->name('main.projects');
    Route::get('/main/overview', 'overview')->name('main.overview');
    Route::get('/main/reports', 'funds')->name('main.funds');
    Route::get('/main/trash', 'trash')->name('main.trash');
});

Route::controller(SystemAdminManager::class)->group(function () {
    Route::get('/main/index', 'index')->name(name: 'main.index');
    Route::get('/main/userManagement', 'viewUserManagement')->name('main.userManagement');

    Route::post('/userRegistration', 'registerUser')->name('userRegistration');
    Route::get('/getUsers', 'viewUserManagement')->name('getUsers');

    Route::get('/getUserRole', 'getUserRole');
    Route::post('/changeRole', 'changeRole');

    Route::get('/main/activityLogs', 'viewActivityLogs')->name('main.activityLogs');

});

Route::controller(ActivityLogs::class)->group(function () {
    // Activity Logs Routes
    Route::post('/activity-logs','store'); // Store a new log
    Route::get('/activity-logs', 'index'); // Retrieve all logs
    Route::get('/getActivityLogs', 'index')->name(name:'getActivityLogs');
});

Route::controller(SystemAdminManager::class)->group(function () {
    Route::get('/main/index', 'index')->name(name: 'main.index');
    Route::get('/main/userManagement', 'viewUserManagement')->name('main.userManagement');

    Route::post('/userRegistration', 'registerUser')->name('userRegistration');
    Route::get('/getUsers', 'viewUserManagement')->name('getUsers');

    Route::get('/getUserRole', 'getUserRole');
    Route::post('/changeRole', 'changeRole');

    Route::get('/main/activityLogs', 'viewActivityLogs')->name('main.activityLogs');

});

Route::controller(ActivityLogs::class)->group(function () {
    // Activity Logs Routes
    Route::post('/activity-logs','store'); // Store a new log
    Route::get('/activity-logs', 'index'); // Retrieve all logs
    Route::get('/getActivityLogs', 'index')->name(name:'getActivityLogs');
});
   // Project Management Routes
   Route::controller(ProjectManager::class)->group(function () {
    Route::post('/projects/addProject', 'addProject')->name('projects.addProject');
    Route::get('/projects/showDetails', 'showDetails')->name('projects.showDetails');
    Route::get('/projects/getProject/{projectID}', 'getProject')->name('projects.getProject');
    Route::get('/projects/summary', 'getProjectSummary')->name('projects.summary');
    Route::put('/projects/update/{projectID}', 'updateProject')->name('projects.update'); // Ensure ID consistency
});

 // Session Handling Routes
 Route::post('/store-project-id', [SessionController::class, 'storeProjectID'])->name('store.project.id');
 Route::get('/get-project-id', [SessionController::class, 'getProjectID']);
 
 // File Management Routes
 Route::controller(FileManager::class)->group(function () {
     Route::post('/uploadFile', 'uploadFile')->name('upload.file');
     Route::get('/files/{projectID}', 'getFiles')->name('get.files');
     Route::delete('/delete/{fileID}', 'delete')->name('delete.file');
 });
