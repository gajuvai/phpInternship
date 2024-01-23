<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

///example rotes

// Route::get('/user', function(){
//     return "hello world";
// });

// Route::post('/user', function(){
//     return response()->json("post api called");
// });

// Route::delete('/user/{id}', function($id){
//     return response("delete".$id, 200);
// });

// Route::put('/user/{id}', function($id){
//     return response("delete".$id, 200);
// });

//sucess --> 200;
//redirect --> 300;
//error ---> 400
//server side error--> 500

Route::get('/test', function(){
    p("Working");
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function(){
    Route::get('/getuser/{id}', [UserController::class, 'getUser']);
});

Route::get('/user/get/{flag}', [UserController::class, 'index']);
Route::post('/user/store', [UserController::class, 'store']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);
Route::put('/user/update/{id}', [UserController::class, 'update']);
Route::patch('/user/change-password/{id}', [UserController::class, 'changePassword']); //single data update