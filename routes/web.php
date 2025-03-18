<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\APIController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserManager;


Route::get('/', function() {
    return view('index');
});


Route::controller(UserManager::class)->group(function () {
    Route::get('/','index')->name('index');
    Route::get('/admin/register', action: 'goToRegister')->name('admin.register');
    Route::post('/register', 'register')->name('register');
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

