<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{AuthController,ProfileController,PostController,UserController,RoleController,PermissionController};

Route::get('/', [AuthController::class, 'getlogin']);
Route::get('/login', [AuthController::class, 'getlogin'])->name('getlogin');
Route::post('/login', [AuthController::class, 'postlogin'])->name('postlogin');
Route::get('/register', [AuthController::class, 'getregister'])->name('getregister');
Route::post('/register', [AuthController::class, 'postregister'])->name('postregister');

Route::group(['middleware'=>['login_auth']], function(){
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [ProfileController::class, 'logout'])->name('logout');

    Route::get('/post', [PostController::class, 'index'])->name('post.index');
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/post/{post}/update', [PostController::class, 'update'])->name('post.update');
    Route::get('/post/{post}/delete', [PostController::class, 'delete'])->name('post.delete');

    Route::get('/settings/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/settings/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/settings/users', [UserController::class, 'store'])->name('user.store');
    Route::get('/settings/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/settings/users/{user}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/settings/users/{user}/delete', [UserController::class, 'delete'])->name('user.delete');
    Route::get('/users/{user}/assign-roles', [UserController::class, 'assignRoles'])->name('user.assignRoles');
    Route::post('/users/{user}/store-roles', [UserController::class, 'storeRoles'])->name('user.storeRoles');


    Route::get('/settings/roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('/settings/roles/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/settings/roles', [RoleController::class, 'store'])->name('role.store');
    Route::get('/settings/roles/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/settings/roles/{role}/update', [RoleController::class, 'update'])->name('role.update');
    Route::get('/settings/roles/{role}/delete', [RoleController::class, 'delete'])->name('role.delete');
    Route::get('/settings/roles/{role}/assign-permissions',[RoleController::class, 'assignPermissions'])->name('role.assignPermissions');
    Route::post('/settings/roles/{role}/store-permissions',[RoleController::class, 'storePermissions'])->name('role.storePermissions');

    Route::get('/settings/permissions', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/settings/permissions/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/settings/permissions', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/settings/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::put('/settings/permissions/{permission}/update', [PermissionController::class, 'update'])->name('permission.update');
    Route::get('/settings/permissions/{permission}/delete', [PermissionController::class, 'delete'])->name('permission.delete');

    // Route::get('/settings/users/{user}/assign-roles', 'UserController@show')->name('user.assignRoles');
    // Route::post('/settings/users/{user}/assign-roles', 'UserController@assign');

});
