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
    Route::post('/setTheme', [App\Http\Controllers\SettingController::class, 'setTheme'])->name('setTheme');

    Route::get('admin', function() {
        return redirect('admin/home');
    });
    Route::get('admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::get('admin/permission', [App\Http\Controllers\AdminController::class, 'permission'])->name('admin.permission');
    Route::post('admin/permission/list', [App\Http\Controllers\AdminController::class, 'permissionGet'])->name('admin.permission.list');
    Route::get('admin/permission/add', [App\Http\Controllers\AdminController::class, 'permissionAdd'])->name('admin.permission.add');
    Route::post('admin/permission/add', [App\Http\Controllers\AdminController::class, 'permissionStore'])->name('admin.permission.store');
    Route::post('admin/permission/batch', [App\Http\Controllers\AdminController::class, 'permissionBatch'])->name('admin.permission.batch');
    Route::get('admin/permission/edit/{permission}', [App\Http\Controllers\AdminController::class, 'permissionEdit'])->name('admin.permission.edit');
    Route::post('admin/permission/edit/{permission}', [App\Http\Controllers\AdminController::class, 'permissionUpdate'])->name('admin.permission.update');

    Route::get('admin/role', [App\Http\Controllers\AdminController::class, 'role'])->name('admin.role');
    Route::post('admin/role/list', [App\Http\Controllers\AdminController::class, 'roleGet'])->name('admin.role.list');
    Route::post('admin/role/batch', [App\Http\Controllers\AdminController::class, 'roleBatch'])->name('admin.role.batch');
});