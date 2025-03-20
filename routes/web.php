<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\APIController;
use App\Models\User;
use App\Models\addProject;
use App\Models\showDetails;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserManager;
use App\Http\Controllers\ProjectManager;
use App\Http\Controllers\LoginDetails;


Route::get('/', function() {
    return view('index');
});
// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login/authenticate', [LoginDetails::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginDetails::class, 'logout'])->name('logout');


Route::controller(UserManager::class)->group(function () {
    Route::get('/','index')->name('index');
    Route::get('/admin/register', action: 'goToRegister')->name('admin.register');
    Route::post('/register', 'register')->name('register');
});


// Dashboard Route
Route::get('/main/index', function () {
    return view('main.index', [
        'username' => request('username'),
        'password' => request('password')
    ]);
})->name('main.index');


// Grouped Routes for UserManager (Requires Authentication)
Route::middleware(['auth'])->group(function () {
    Route::controller(UserManager::class)->group(function () {
        Route::get('/main/projects', 'projects')->name('main.projects');
        Route::get('/main/overview', 'overview')->name('main.overview');
        Route::get('/main/reports', 'funds')->name('main.funds');
        Route::get('/main/userManagement', 'userManagement')->name('main.userManagement');
        Route::get('/main/trash', 'trash')->name('main.trash');
        Route::get('/main/activityLogs', 'activityLogs')->name('main.activityLogs');
    });
});

// Project Management Routes
Route::middleware(['auth'])->group(function () {
    Route::controller(ProjectManager::class)->group(function () {
    Route::post('/projects/addProject', [ProjectManager::class, 'addProject'])->name('projects.addProject');
    Route::get('/projects/showDetails', [ProjectManager::class, 'showDetails'])->name('projects.showDetails');
    Route::get('/projects/getProject/{id}', [ProjectManager::class, 'getProject'])->name('projects.getProject');
    Route::get('/projects/summary', [ProjectManager::class, 'getProjectSummary'])->name('projects.summary');
    Route::put('/projects/update/{id}', [ProjectManager::class, 'updateProject'])->name('projects.update');
});
});






























// Route::get('/', function () {
//     $userExists = DB::table('user_tbl')->exists();

//     if (!$userExists) {
//         return redirect()->route('admin.register');
//     }
//     return view('index');
// })->name('index');

// Route::get('/admin/register', function () {
//     return view('admin.register');
// })->name('admin.register');

// Route::get('/main/index', function () {
//     $username = request('username');
//     $password = request('password');
//     return view('main.index', compact('username', 'password'));
// })->name('main.index');






// Route::get('/main/projects', 'projects')->name('main.projects');
// Route::get('/main/overview', 'overview')->name('main.overview');
// Route::get('/main/reports', 'funds')->name('main.funds');
// Route::get('/main/userManagement', 'userManagement')->name('main.userManagement');
// Route::get('/main/trash', 'trash')->name('main.trash');
// Route::get('/main/activityLogs', 'activityLogs')->name('main.activityLogs');

