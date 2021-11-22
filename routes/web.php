<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('admin', function() {
        return redirect('admin/home');
    });
    Route::get('admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::get('admin/permission', [App\Http\Controllers\AdminController::class, 'permission'])->name('admin.permission');
    Route::get('admin/permission/add', [App\Http\Controllers\AdminController::class, 'permissionAdd'])->name('admin.permission.add');
    Route::post('admin/permission/add', [App\Http\Controllers\AdminController::class, 'permissionStore'])->name('admin.permission.store');
});