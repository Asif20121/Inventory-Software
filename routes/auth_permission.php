<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\User_Auth\AdminController;
use App\Http\Controllers\User_Auth\AdminManageController;
use App\Http\Controllers\User_Auth\AdminProfileController;
use App\Http\Controllers\User_Auth\AllPermissionController;
use App\Http\Controllers\User_Auth\AllRoleController;
use App\Http\Controllers\User_Auth\RoleInPermissionController;
use App\Http\Controllers\User_Auth\StoreWiseEmController;
use Illuminate\Support\Facades\Route;

//Admin auth start
Route::name('admin.')->group(function () {
    Route::middleware(['guest:admin', 'PreventBackHistory'])->Group(function () {
        Route::get('/', [AdminController::class, 'login'])->name('login');
        Route::get('/reload-captcha', [AdminController::class, 'reloadCaptcha'])->name('reloadCaptcha');
        Route::post('/login_check', [AdminController::class, 'login_check'])->name('login_check');
        Route::get('/forgot/password', [ForgotController::class, 'forget_password'])->name('forget_password');
        Route::post('/forgot/password', [ForgotController::class, 'forget_password_send'])->name('forget_password_send');
        Route::get('/forgot/password/{token}', [ForgotController::class, 'forget_password_link'])->name('forget_password_link');
        Route::post('/forgot/password/change', [ForgotController::class, 'forget_password_change'])->name('forget_password_change');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth:admin', 'PreventBackHistory'])->Group(function () {
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/admin_dashboard', [DashboardController::class, 'admin_dashboard'])->name('admin_dashboard');
        Route::get('/admin_dashboard_show', [DashboardController::class, 'admin_dashboard_show'])->name('admin_dashboard_show');
        Route::post('/admin_dashboard_search', [DashboardController::class, 'admin_dashboard_search'])->name('admin_dashboard_search');

        Route::get('/sw_dashboard', [DashboardController::class, 'sw_dashboard'])->name('sw_dashboard');
        Route::get('/sw_dashboard_show', [DashboardController::class, 'sw_dashboard_show'])->name('sw_dashboard_show');
        Route::get('/sw_dashboard_search', [DashboardController::class, 'sw_dashboard_search'])->name('sw_dashboard_search');

        Route::get('/sales_dashboard', [DashboardController::class, 'sales_dashboard'])->name('sales_dashboard');
        Route::get('/sales_dashboard_show', [DashboardController::class, 'sales_dashboard_show'])->name('sales_dashboard_show');
        Route::get('/sales_dashboard_search', [DashboardController::class, 'sales_dashboard_search'])->name('sales_dashboard_search');
    });
});
//Admin End

//Manage Admin Dashboard Start
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'PreventBackHistory'])->group(function () {
    // Manage Admin Start
    Route::get('/manage-admin/list', [AdminManageController::class, 'admin_list'])->name('admin_list');
    Route::get('/manage-admin/create', [AdminManageController::class, 'create'])->name('admin_create');
    Route::post('/manage-admin/store', [AdminManageController::class, 'store'])->name('admin_store');
    Route::get('/manage-admin/edit/{id}', [AdminManageController::class, 'edit'])->name('admin_edit');
    Route::post('/manage-admin/update/{id}', [AdminManageController::class, 'update'])->name('admin_update');
    // Route::get('/manage-admin/delete/{id}', [AdminManageController::class, 'delete'])->name('admin_delete');
    Route::get('/manage-admin/view/{id}', [AdminManageController::class, 'admin_view'])->name('admin_view');
    Route::get('/manage-admin/print/{id}', [AdminManageController::class, 'admin_print'])->name('admin_print');
    Route::get('/manage-admin/print-idcard/{id}', [AdminManageController::class, 'print_idcard'])->name('print_idcard');
    // Manage Admin End

    // Store Wise Employee
    Route::get('/storewise-employe/list', [StoreWiseEmController::class, 'employe_list'])->name('employe_list');
    Route::get('/storewise-employe/view/{id}', [StoreWiseEmController::class, 'employe_view'])->name('employe_view');
    Route::get('/storewise-employe/print/{id}', [StoreWiseEmController::class, 'employe_print'])->name('employe_print');
    // Route::get('/storewise-employe/create', [StoreWiseEmController::class, 'create'])->name('employe_create');
    // Route::post('/storewise-employe/store', [StoreWiseEmController::class, 'store'])->name('employe_store');
    // Route::get('/storewise-employe/edit/{id}', [StoreWiseEmController::class, 'edit'])->name('employe_edit');
    // Route::post('/storewise-employe/update/{id}', [StoreWiseEmController::class, 'update'])->name('employe_update');
    // Route::get('/storewise-employe/delete/{id}', [StoreWiseEmController::class, 'delete'])->name('employe_delete');
    // Store Wise Employee End

    //Admin Frofile Manage
    Route::get('/profile/view', [AdminProfileController::class, 'view'])->name('profile.view');
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update/{id}', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change_password', [AdminProfileController::class, 'change_password'])->name('profile.change_password');
    Route::post('/profile/update_password/{id}', [AdminProfileController::class, 'update_Password'])->name('profile.update_password');
    Route::get('/profile/print', [AdminProfileController::class, 'profile_print'])->name('profile_print');
});
//Manage Admin End

// Role And Permission
Route::prefix('rpm')->name('rpm.')->middleware(['auth:admin', 'PreventBackHistory'])->group(function () {

    // Permission
    Route::get('/permission/list', [AllPermissionController::class, 'list'])->name('permission.list');
    // Route::get('/permission/create', [AllPermissionController::class, 'create'])->name('permission.create');
    // Route::post('/permission/store', [AllPermissionController::class, 'store'])->name('permission.store');
    // Route::get('/permission/edit/{id}', [AllPermissionController::class, 'edit'])->name('permission.edit');
    // Route::post('/permission/update/{id}', [AllPermissionController::class, 'update'])->name('permission.update');
    // Route::get('/permission/delete/{id}', [AllPermissionController::class, 'delete'])->name('permission.delete');

    // Role
    Route::get('/role/list', [AllRoleController::class, 'list'])->name('role.list');
    Route::get('/role/create', [AllRoleController::class, 'create'])->name('role.create');
    Route::post('/role/store', [AllRoleController::class, 'store'])->name('role.store');
    Route::get('/role/edit/{id}', [AllRoleController::class, 'edit'])->name('role.edit');
    Route::post('/role/update/{id}', [AllRoleController::class, 'update'])->name('role.update');
    Route::get('/role/delete/{id}', [AllRoleController::class, 'delete'])->name('role.delete');

    //Role in Permission
    Route::get('/in_role_permission/list', [RoleInPermissionController::class, 'list'])->name('in_role_permission.list');
    Route::get('/in_role_permission/create', [RoleInPermissionController::class, 'create'])->name('in_role_permission.create');
    Route::post('/in_role_permission/store', [RoleInPermissionController::class, 'store'])->name('in_role_permission.store');
    Route::get('/in_role_permission/edit/{id}', [RoleInPermissionController::class, 'edit'])->name('in_role_permission.edit');
    Route::post('/in_role_permission/update/{id}', [RoleInPermissionController::class, 'update'])->name('in_role_permission.update');
    Route::get('/in_role_permission/delete/{id}', [RoleInPermissionController::class, 'delete'])->name('in_role_permission.delete');
});
