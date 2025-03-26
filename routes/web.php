<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\UserManager;
use App\Http\Controllers\ProjectManager;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\LoginDetails;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ProjectFileController;

Route::get('/', function () {
    return view('index');
});

//  Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login/authenticate', [LoginDetails::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginDetails::class, 'logout'])->name('logout');

//  User Registration & Management
Route::controller(UserManager::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/admin/register', 'goToRegister')->name('admin.register');
    Route::post('/register', 'register')->name('register');
});

//  Dashboard Route
Route::get('/main/index', function () {
    return view('main.index', [
        'username' => request('username'),
        'password' => request('password')
    ]);
})->name('main.index');

//  Grouped Routes (Requires Authentication)
Route::middleware(['auth'])->group(function () {

    //  User Manager Routes
    Route::controller(UserManager::class)->group(function () {
        Route::get('/main/projects', 'projects')->name('main.projects');
        Route::get('/main/overview', 'overview')->name('main.overview');
        Route::get('/main/reports', 'funds')->name('main.funds');
        Route::get('/main/userManagement', 'userManagement')->name('main.userManagement');
        Route::get('/main/trash', 'trash')->name('main.trash');
        Route::get('/main/activityLogs', 'activityLogs')->name('main.activityLogs');
    });

    // 🔸 Project Management Routes
    Route::controller(ProjectManager::class)->group(function () {
        Route::post('/projects/addProject', 'addProject')->name('projects.addProject');
        Route::get('/projects/showDetails', 'showDetails')->name('projects.showDetails');
        Route::get('/projects/getProject/{selectedProjectID}', 'getProject')->name('projects.getProject');
        Route::get('/projects/summary', 'getProjectSummary')->name('projects.summary');
        Route::put('/projects/update/{id}', 'updateProject')->name('projects.update');
    });

    // 🔸 Session Handling Routes
    Route::post('/store-project-id', [SessionController::class, 'storeProjectID'])->name('store.project.id');
    Route::get('/get-project-id', [SessionController::class, 'getProjectID']);

    // 🔸 File Upload & Management Routes
    Route::controller(FileManager::class)->group(function () {
        Route::post('/uploadFile', 'uploadFile')->name('upload.file');
        Route::get('/files/{projectID}', 'getFiles')->name('get.files');
        Route::delete('/delete/{fileID}', 'delete')->name('delete.file');
    });
});
