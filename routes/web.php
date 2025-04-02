<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\UserManager;
use App\Http\Controllers\SystemAdminManager;
use App\Http\Controllers\AdminManager;
use App\Http\Controllers\ActivityLogs; // Import the ActivityLogs controller
use App\Http\Controllers\ProjectManager;
use App\Http\Controllers\FileManager;
// use App\Http\Controllers\LoginDetails;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ProjectFileController;

Route::get('/', function() {
    return view('index');
});

 //Authentication Routes
// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

// Route::post('/login/authenticate', [LoginDetails::class, 'authenticate'])->name('login.authenticate');
// Route::post('/logout', [LoginDetails::class, 'logout'])->name('logout');


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
    Route::get('/systemAdmin/index', 'index')->name(name: 'systemAdmin.index');
    Route::get('/systemAdmin/userManagement', 'viewUserManagement')->name('systemAdmin.userManagement');

    Route::post('/userRegistration', 'registerUser')->name('userRegistration');
    Route::get('/getUsers', 'viewUserManagement')->name('getUsers');

    Route::get('/getUserRole', 'getUserRole');
    Route::post('/changeRole', 'changeRole');

    Route::get('/systemAdmin/activityLogs', 'viewActivityLogs')->name('systemAdmin.activityLogs');
    Route::get('/systemAdmin/projects', 'projects')->name('systemAdmin.projects');
    Route::get('/systemAdmin/overview', 'overview')->name('systemAdmin.overview');
    Route::get('/systemAdmin/reports', 'funds')->name('systemAdmin.funds');
    Route::get('/systemAdmin/trash', 'trash')->name('systemAdmin.trash');
    Route::post('/systemAdmin/addProject', 'addProject')->name('systemAdmin.addProject'); // Add this route
});

Route::controller(AdminManager::class)->group(function () {
    Route::get('/admin/index', 'index')->name(name: 'admin.index');
});

 //Grouped Routes (Requires Authentication)
//Route::middleware(['auth'])->group(function () {

Route::controller(ProjectManager::class)->group(function () {
    Route::post('/projects/add-project', 'addProject')->name('projects.add'); // Updated route
    Route::get('/projects/showDetails', 'showDetails')->name('projects.showDetails'); // Ensure this route exists
    Route::get('/projects/getProject/{projectID}', 'getProject')->name('projects.getProject');
    Route::get('/projects/summary', 'getProjectSummary')->name('projects.summary');
    Route::put('/projects/update/{projectID}', 'updateProject')->name('projects.update'); // Ensure ID consistency
});

    Route::post('/store-project-id', [SessionController::class, 'storeProjectID'])->name('store.project.id');
    Route::get('/get-project-id', [SessionController::class, 'getProjectID']);

    Route::controller(FileManager::class)->group(function () {
        Route::post('/uploadFile', 'uploadFile')->name('upload.file');
        Route::get('/files/{projectID}', 'getFiles')->name('get.files');
        Route::delete('/delete/{fileID}', 'delete')->name('delete.file');
    });


Route::controller(ActivityLogs::class)->group(function () {
    // Activity Logs Routes
    Route::post('/activity-logs','store'); // Store a new log
    Route::get('/activity-logs', 'index'); // Retrieve all logs
    Route::get('/getActivityLogs', 'index')->name(name:'getActivityLogs');
});

