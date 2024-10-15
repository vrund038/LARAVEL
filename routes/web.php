<?php

use App\Http\Controllers\admin\Dashboardcontroller as AdminDashboardcontroller;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\Dashboardcontroller;
use App\Http\Controllers\logincontroller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'account'], function () {

    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [logincontroller::class, 'index'])->name('account.login');
        Route::get('register', [logincontroller::class, 'register'])->name('account.register');
        Route::post('process-register', [logincontroller::class, 'ProcessRegister'])->name('account.ProcessRegister');
        Route::post('authenticate', [logincontroller::class, 'authenticate'])->name('account.authenticate');
    });

    Route::group(['middleware' => 'auth'], function () {

        Route::get('logout', [logincontroller::class, 'logout'])->name('account.logout');
        Route::get('dashboard', [Dashboardcontroller::class, 'index'])->name('account.dashboard');
    });
});


Route::group(['prefix' => 'admin'],function(){

    Route::group(['middleware' => 'admin.guest'],function(){
        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'],function(){
        Route::get('dashboard', [AdminDashboardcontroller::class, 'index'])->name('admin.dashboard');
        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
});





