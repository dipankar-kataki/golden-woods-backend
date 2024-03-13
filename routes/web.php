<?php

use App\Http\Controllers\Admin\BlogController;
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

        Route::group(['prefix' => 'blog'], function(){

            Route::get('all', [BlogController::class, 'index'])->name('admin.blog.all');
            Route::match(['get', 'post'],'create', [BlogController::class, 'create'])->name('admin.blog.create');
            Route::get('details/{id}', [BlogController::class, 'details'])->name('admin.blog.details');
            Route::post('update', [BlogController::class, 'updateDetails'])->name('admin.blog.update.details');
            Route::post('delete', [BlogController::class, 'delete'])->name('admin.blog.delete');
        });

        Route::get('logout', function(){
            Session::flush();
            Auth::logout();
            return redirect()->route('admin.login');
        });
    });
});




