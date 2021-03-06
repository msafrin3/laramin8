<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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



Route::group(['middleware' => 'logs'], function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Auth::routes();
    
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::post('/setTheme', [App\Http\Controllers\SettingController::class, 'setTheme'])->name('setTheme');

        Route::get('dashboard/statistic', [App\Http\Controllers\StatisticController::class, 'index'])->name('dashboard.statistic');

        Route::get('kempen', [App\Http\Controllers\KempenController::class, 'index'])->name('kempen.index');
        Route::post('kempen/list', [App\Http\Controllers\KempenController::class, 'list'])->name('kempen.list');
        Route::get('kempen/add', [App\Http\Controllers\KempenController::class, 'create'])->name('kempen.add');
        Route::post('kempen/add', [App\Http\Controllers\KempenController::class, 'store'])->name('kempen.store');
        Route::get('kempen/edit/{kempen}', [App\Http\Controllers\KempenController::class, 'edit'])->name('kempen.edit');
        Route::post('kempen/edit/{kempen}', [App\Http\Controllers\KempenController::class, 'update'])->name('kempen.update');
        Route::get('kempen/view/{kempen}', [App\Http\Controllers\KempenController::class, 'view'])->name('kempen.view');
        Route::post('kempen/batch', [App\Http\Controllers\KempenController::class, 'batch'])->name('kempen.batch');
    
        Route::group(['middleware' => 'admin'], function() {
            Route::get('admin', function() {
                return redirect('admin/home');
            });
            Route::get('admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
            Route::get('admin/permission', [App\Http\Controllers\AdminController::class, 'permission'])->name('admin.permission');
            Route::post('admin/permission/list', [App\Http\Controllers\AdminController::class, 'permissionGet'])->name('admin.permission.list');
            Route::get('admin/permission/add', [App\Http\Controllers\AdminController::class, 'permissionAdd'])->name('admin.permission.add');
            Route::post('admin/permission/add', [App\Http\Controllers\AdminController::class, 'permissionStore'])->name('admin.permission.store');
            Route::get('admin/permission/edit/{permission}', [App\Http\Controllers\AdminController::class, 'permissionEdit'])->name('admin.permission.edit');
            Route::post('admin/permission/edit/{permission}', [App\Http\Controllers\AdminController::class, 'permissionUpdate'])->name('admin.permission.update');
        
            Route::get('admin/role', [App\Http\Controllers\AdminController::class, 'role'])->name('admin.role');
            Route::post('admin/role/list', [App\Http\Controllers\AdminController::class, 'roleGet'])->name('admin.role.list');
            Route::get('admin/role/add', [App\Http\Controllers\AdminController::class, 'roleAdd'])->name('admin.role.add');
            Route::post('admin/role/add', [App\Http\Controllers\AdminController::class, 'roleStore'])->name('admin.role.store');
            Route::get('admin/role/edit/{role}', [App\Http\Controllers\AdminController::class, 'roleEdit'])->name('admin.role.edit');
            Route::post('admin/role/edit/{role}', [App\Http\Controllers\AdminController::class, 'roleUpdate'])->name('admin.role.update');
        
            Route::get('admin/meta', [App\Http\Controllers\AdminController::class, 'meta'])->name('admin.meta');
            Route::post('admin/meta/list', [App\Http\Controllers\AdminController::class, 'metaGet'])->name('admin.meta.list');
            Route::get('admin/meta/add', [App\Http\Controllers\AdminController::class, 'metaAdd'])->name('admin.meta.add');
            Route::post('admin/meta/add', [App\Http\Controllers\AdminController::class, 'metaStore'])->name('admin.meta.store');
            Route::get('admin/meta/edit/{meta}', [App\Http\Controllers\AdminController::class, 'metaEdit'])->name('admin.meta.edit');
            Route::post('admin/meta/edit/{meta}', [App\Http\Controllers\AdminController::class, 'metaUpdate'])->name('admin.meta.update');
        
            Route::get('admin/metadata', [App\Http\Controllers\AdminController::class, 'metadata'])->name('admin.metadata');
            Route::post('admin/metadata/list', [App\Http\Controllers\AdminController::class, 'metadataGet'])->name('admin.metadata.list');
            Route::get('admin/metadata/add', [App\Http\Controllers\AdminController::class, 'metadataAdd'])->name('admin.metadata.add');
            Route::post('admin/metadata/add', [App\Http\Controllers\AdminController::class, 'metadataStore'])->name('admin.metadata.store');
            Route::get('admin/metadata/edit/{metadata}', [App\Http\Controllers\AdminController::class, 'metadataEdit'])->name('admin.metadata.edit');
            Route::post('admin/metadata/edit/{metadata}', [App\Http\Controllers\AdminController::class, 'metadataUpdate'])->name('admin.metadata.update');
        
            Route::get('admin/user', [App\Http\Controllers\AdminController::class, 'user'])->name('admin.user');
            Route::post('admin/user/list', [App\Http\Controllers\AdminController::class, 'userGet'])->name('admin.user.list');
            Route::get('admin/user/add', [App\Http\Controllers\AdminController::class, 'userAdd'])->name('admin.user.add');
            Route::post('admin/user/add', [App\Http\Controllers\AdminController::class, 'userStore'])->name('admin.user.store');
            Route::get('admin/user/edit/{user}', [App\Http\Controllers\AdminController::class, 'userEdit'])->name('admin.user.edit');
            Route::post('admin/user/edit/{user}', [App\Http\Controllers\AdminController::class, 'userUpdate'])->name('admin.user.update');
    
            Route::post('admin/batch', [App\Http\Controllers\AdminController::class, 'batch'])->name('admin.batch');
        });
    });
});

Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::get('admin/log', [App\Http\Controllers\AdminController::class, 'log'])->name('admin.log');
    Route::post('admin/log/list', [App\Http\Controllers\AdminController::class, 'logGet'])->name('admin.log.list');
    Route::get('admin/log/parameters/{log}', [App\Http\Controllers\AdminController::class, 'logParam'])->name('admin.log.param');
    Route::get('admin/analysis', [App\Http\Controllers\AdminController::class, 'analysis'])->name('admin.analysis');
    Route::get('admin/analysis/data', [App\Http\Controllers\AdminController::class, 'analysisGet'])->name('admin.analysis.data');
});