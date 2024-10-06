<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\Image\ImageEditController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:api'], function () {

    Route::prefix('auth')->group(function () {
        //Route::post('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });

    Route::prefix('image')->group(function () {
        Route::post('store', [ImageController::class, 'storeImage']);
        Route::get('get-image', [ImageController::class, 'getImage']);
        Route::get('download-image', [ImageController::class, 'downloadImage']);
        Route::get('show-images', [ImageController::class, 'showImages']);

        Route::prefix('edit')->group(function () {
            Route::post('resize', [ImageEditController::class, 'resizeImage']);
        });
    });
});

Route::prefix('public')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

