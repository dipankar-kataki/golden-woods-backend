<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\ProjectAmenityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ProjectGalleryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    Route::post('signup', [UserController::class, 'signup']);
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('forgotpassword', [UserController::class, 'forgotPassword'])->name('forgotPassword');
    Route::post('resetpassword', [UserController::class, 'resetPassword'])->name('resetpassword');

    Route::get('project/getByStatus', [ProjectController::class, 'getProjectListByStatus'])->name("getProjectListByStatus");
    Route::get('project/get/{id}', [ProjectController::class, 'getById']);
    Route::get('project/list', [ProjectController::class, 'getList']);
    Route::get('project/count', [ProjectController::class, 'count']);

    Route::get('amenities/list', [AmenityController::class, 'index']);
    Route::get('amenities/get/{id}', [AmenityController::class, 'show']);

    Route::post('contact/create', [ContactController::class, 'create']);

    Route::post('enquiry/create', [EnquiryController::class, 'create']);

    Route::get('project/gallery/get/{id}', [ProjectGalleryController::class, 'index']);
    Route::get('project/amenity/get/{id}', [ProjectAmenityController::class, 'show']);

    Route::get('blog/list', [BlogController::class, 'index']);
    Route::get('blog/get/{id}', [BlogController::class, 'show']);

    Route::group(["middleware"=>'jwt.verify'],function () {
        Route::prefix('project')->group(function () {
            Route::post('create', [ProjectController::class, 'create']);
            Route::put('update/{id}', [ProjectController::class, 'edit']);
            Route::delete('delete/{id}', [ProjectController::class, 'destroy']);
        });
        Route::prefix('amenities')->group(function () {
            Route::post('create', [AmenityController::class, 'create']);
            Route::put('update/{id}', [AmenityController::class, 'update']);
            Route::delete('delete/{id}', [AmenityController::class, 'destroy']);
        });
        Route::prefix('contact')->group(function () {
            Route::get('get/{id}', [ContactController::class, 'show']);
            Route::get('list', [ContactController::class, 'index']);
            Route::put('update/{id}', [ContactController::class, 'update']);
            Route::delete('delete/{id}', [ContactController::class, 'destroy']);
        });
        Route::prefix('enquiry')->group(function () {
            Route::get('get/{enquiryType}', [EnquiryController::class, 'show']);
            Route::get('list', [EnquiryController::class, 'index']);
            Route::put('update/{id}', [EnquiryController::class, 'update']);
            Route::delete('delete/{id}', [EnquiryController::class, 'destroy']);
        });
        Route::prefix('project/amenity')->group(function () {
            Route::post('create', [ProjectAmenityController::class, 'create']);
            // Route::get('get/{id}', [ProjectAmenityController::class, 'show']);
            Route::delete('{amenityId}/delete/{projectId}', [ProjectAmenityController::class, 'destroy']);
        });        
        Route::prefix('gallery')->group(function () {
            //id is projectId
            Route::post('create/{id}', [ProjectGalleryController::class, 'create']);
            Route::delete('delete/{galleryId}', [ProjectGalleryController::class, 'deleteGalleyImageItem']);
            Route::put('{galleryId}/update/{id}', [ProjectGalleryController::class, 'updateSpecificGalleryImage']);
        });        
        Route::prefix('blog')->group(function () {
            Route::post('create', [BlogController::class, 'create']);
            Route::put('update/{id}', [BlogController::class, 'update']);
            Route::delete('delete/{id}', [BlogController::class, 'destroy']);
        });
        Route::post('logout', [UserController::class, 'logout'])->name('logout');
    });
    