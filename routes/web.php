<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin'], function(){

    Route::group(['prefix' => 'auth'], function(){
        Route::match(['get', 'post'], 'login', [LoginController::class, 'login'])->name('admin.login');
    });

    Route::group(['middleware' => 'auth'], function(){

        Route::group(['prefix' => 'dashboard'], function(){
            Route::get('', [DashboardController::class, 'index'])->name('admin.dashboard');
        });

        Route::get('logout', function(){
            Session::flush();
            Auth::logout();
            return redirect()->route('admin.login');
        });
    });
});




