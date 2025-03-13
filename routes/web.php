<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserManager;

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

Route::get('/', function () {
    return view('index');
});

Route::get('/main/index', function () {
    $username = request('username');
    $password = request('password');
    
    // Handle the form data, e.g., authenticate user
    return view('main.index', compact('username', 'password')); // Just an example
})->name('main.index');

Route::controller(UserManager::class)->group(function () {
    Route::get('/main/projects', 'projects')->name(name: 'main.projects');
    Route::get('/main/overview', 'overview')->name(name: 'main.overview');
    Route::get('/main/reports', 'funds')->name('main.funds');
    Route::get('/main/userManagement', 'userManagement')->name('main.userManagement');
    Route::get('/main/trash', 'trash')->name('main.trash');
    Route::get('/main/activityLogs', 'activityLogs')->name('main.activityLogs');
});