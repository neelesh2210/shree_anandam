<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TreeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

//Login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('login', [LoginController::class, 'login'])->name('admin.login.submit');

Route::group(['middleware'=>'auth:admin','as'=>'admin.'],function () {

    //Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //User
    Route::resource('users', UserController::class)->except('show','destroy');
    Route::post('change-user-password',[UserController::class,'changePassword'])->name('change.user.password');
    Route::get('user-documnet-detail/{id}',[UserController::class,'userDocumnetDetail'])->name('user.documnet.detail');
    Route::post('user-documnet-detail-update/{id}',[UserController::class,'userDocumnetDetailUpdate'])->name('user.documnet.detail.update');
    Route::get('user-block/{id}/{status}',[UserController::class,'userBlock'])->name('user.block');
    Route::get('user-verify/{id}/{status}',[UserController::class,'userVerify'])->name('user.verify');

    //Tree
    Route::get('tree',[TreeController::class,'index'])->name('tree');

    //Profile
    Route::get('profile',[ProfileController::class,'index'])->name('profile');
    Route::post('profile-store',[ProfileController::class,'store'])->name('profile.store');

    //Change Password
    Route::post('change-password',[ProfileController::class,'changePassword'])->name('change.password');

    //Staff Management
    Route::resource('roles', RoleController::class);
    Route::resource('staffs', StaffController::class);

    //Logout
    Route::post('logout/', [LoginController::class, 'logout'])->name('logout');

});
