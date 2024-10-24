<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CampaignDonationController;

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

    //Campaign
    Route::resource('campaigns', CampaignController::class)->except('show','destroy');
    Route::get('campaigns-status/{id}/{status}', [CampaignController::class,'status'])->name('campaigns.status');

    //Campaign Donation
    Route::get('campaign-donation',[CampaignDonationController::class,'index'])->name('campaign.donation');

    //Profile
    Route::get('profile',[ProfileController::class,'index'])->name('profile');
    Route::post('profile-store',[ProfileController::class,'store'])->name('profile.store');

    //Image
    Route::get('image',[ImageController::class,'index'])->name('image.index');
    Route::get('image/create',[ImageController::class,'create'])->name('image.create');
    Route::post('image',[ImageController::class,'store'])->name('image.store');
    Route::delete('image/{id}',[ImageController::class,'destroy'])->name('image.destroy');

    //Event
    Route::resource('event',EventController::class);

    //About
    Route::get('about',[AboutController::class,'index'])->name('about.index');
    Route::get('about/create',[AboutController::class,'create'])->name('about.create');
    Route::post('about',[AboutController::class,'store'])->name('about.store');
    Route::get('about/show/{type}',[AboutController::class,'show'])->name('about.show');

    //Social
    Route::get('social',[SocialController::class,'index'])->name('social.index');
    Route::get('social/create',[SocialController::class,'create'])->name('social.create');
    Route::post('social',[SocialController::class,'store'])->name('social.store');
    Route::delete('social/{type}',[SocialController::class,'destroy'])->name('social.destroy');


    //Change Password
    Route::post('change-password',[ProfileController::class,'changePassword'])->name('change.password');

    //Staff Management
    Route::resource('roles', RoleController::class);
    Route::resource('staffs', StaffController::class);

    //Logout
    Route::post('logout/', [LoginController::class, 'logout'])->name('logout');

});
