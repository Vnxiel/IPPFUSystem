<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManager;
use App\Http\Controllers\SystemAdminManager;
use App\Http\Controllers\ActivityLogs; // Import the ActivityLogs controller

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
