<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PackageController;
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

Route::get('/test', function(){
    p("Working");
});

// Routes for User Moudle
Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function(){
    Route::patch('/user/change-password/{id}', [UserController::class, 'changePassword']);
    Route::patch('/user/forget-password/{id}', [UserController::class, 'forgetPassword']);
    Route::get('/user/get-user/{id}', [UserController::class, 'getUser']);

    // Routes for packages
    Route::post('/add-package', [PackageController::class, 'addPackages']);
    Route::get('/get-packages', [PackageController::class, 'getAllPackages']);
    Route::get('/get-package/{id}', [PackageController::class, 'getPackage']);
    Route::put('/update-package/{id}', [PackageController::class, 'updatePackage']);
    Route::delete('/delete-package/{id}', [PackageController::class, 'deletePackage']);

    // Route for user subscription 
    
});

