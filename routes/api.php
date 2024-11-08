<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CampaignDonationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Register
Route::post('registration',[RegisterController::class,'registration']);

//Login
Route::post('login',[LoginController::class,'login']);

Route::middleware('auth:sanctum')->group( function () {

    //Home
    Route::get('home',[HomeController::class,'index']);

    //Gallery
    Route::get('gallery',[HomeController::class,'gallery']);

    //Event
    Route::get('event',[EventController::class,'index']);

    //Profile
    Route::get('get-profile',[ProfileController::class,'index']);
    Route::post('update-profile',[ProfileController::class,'store']);
    Route::post('update-profile-photo',[ProfileController::class,'updateProfilePhoto']);

    //Document
    Route::get('get-document',[DocumentController::class,'index']);
    Route::post('update-document',[DocumentController::class,'store']);

    //Campaign
    Route::get('campaign-list',[CampaignController::class,'index']);

    //Campaign Donation
    Route::get('campaign-donation-list',[CampaignDonationController::class,'index']);
    Route::post('campaign-donation',[CampaignDonationController::class,'store']);

});

