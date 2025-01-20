<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::group(['middleware' => ['guest']], function () {

    Route::get("/", [AdminController::class, "showLoginForm"])->name('login');

    Route::post("/", [AdminController::class, "login"]);
});
Route::group(['middleware' => ['role:admin', 'auth']], function () {
    Route::post('/logout' , [AdminController::class , 'logout'])->name('logout');
    Route::get('/index' , [AdminController::class , 'index'])->name('dashboard.index');
    Route::post('/users/{user}/block',[UserController::class , 'blockUser'])->name('users.block');
    Route::post('/users/{user}/unblock',[UserController::class , 'unblockUser'])->name('users.unblock');
    Route::resource('users' , UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
});