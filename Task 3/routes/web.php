<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{AuthController,ProfileController,PostController};
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

// Route::get('/', function () {
//     return view('dashboard');
// });
Route::get('/', [AuthController::class, 'getlogin']);
Route::get('/login', [AuthController::class, 'getlogin'])->name('getlogin');
Route::post('/login', [AuthController::class, 'postlogin'])->name('postlogin');

Route::group(['middleware'=>['login_auth']], function(){
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [ProfileController::class, 'logout'])->name('logout');

    Route::get('/post', [PostController::class, 'index'])->name('post.index');
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/post/{post}/update', [PostController::class, 'update'])->name('post.update');
    Route::get('/post/{post}/delete', [PostController::class, 'delete'])->name('post.delete');

});
