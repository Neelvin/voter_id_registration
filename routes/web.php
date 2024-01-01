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

Route::view('/', 'auth.login')->name('login')->middleware('guest');
Route::view('/register', 'auth.register')->name('register')->middleware('guest');

Route::group(['namespace' => 'App\Http\Controllers\Authentication'], function(){
    Route::post('/login-submit', 'AuthController@login')->name('login-submit')->middleware('guest');
    Route::post('/register-submit', 'AuthController@register')->name('register-submit')->middleware('guest');
    Route::get('/email-verify/{token}', 'AuthController@emailVerify')->name('email-verify')->middleware('guest');

});

Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => ['auth']], function () {
    
    //dashboard route
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    
    //voter profile resource route
    Route::resource('voter', 'VoterController')->names([
        'index' => 'voter.index',
        'create' => 'voter.create',
        'store' => 'voter.store',
        'edit' => 'voter.edit',
        'update' => 'voter.update',
    ]);

    // voter reports routes
    Route::get('/reports', 'ReportController@index')->name('reports');

    // routes/web.php
    Route::get('/export-voters', 'ReportController@export')->name('export.voters');

    
    //logout route
    Route::get('/logout', 'Authentication\AuthController@logout')->name('logout');
});