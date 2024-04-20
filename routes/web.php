<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'prevent-back-history'],function(){

    Auth::routes(['register'=>false,'login'=>false,'logout'=>false]);

    Route::get('/',function(){
        return redirect()->route('admin.dashboard');
    })->name('index');

});
