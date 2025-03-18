<?php

use App\Http\Controllers\settings\BloodGroupController;
use App\Http\Controllers\settings\CategoryController;
use App\Http\Controllers\settings\CompanyController;
use App\Http\Controllers\settings\CustomerController;
use App\Http\Controllers\settings\DepartmentController;
use App\Http\Controllers\settings\DesignationController;
use App\Http\Controllers\settings\ExpenseController;
use App\Http\Controllers\settings\LogoController;
use App\Http\Controllers\settings\ProductController;
use App\Http\Controllers\settings\ReligionController;
use App\Http\Controllers\settings\StoreController;
use App\Http\Controllers\settings\SupplierController;
use App\Http\Controllers\settings\SupplierWiseStoreController;
use App\Http\Controllers\settings\UnitController;
use App\Http\Controllers\settings\PaymentTypeController;
use Illuminate\Support\Facades\Route;

//Admin Setting
Route::prefix('setting')->name('setting.')->middleware(['auth:admin', 'PreventBackHistory'])->group(function () {

    // Manage designation Start
    Route::get('designation/list', [DesignationController::class, 'list'])->name('designation_list');
    Route::get('designation/create', [DesignationController::class, 'create'])->name('designation_create');
    Route::post('designation/store', [DesignationController::class, 'store'])->name('designation_store');
    Route::get('designation/edit/{id}', [DesignationController::class, 'edit'])->name('designation_edit');
    Route::post('designation/update/{id}', [DesignationController::class, 'update'])->name('designation_update');
    Route::get('designation/delete/{id}', [DesignationController::class, 'delete'])->name('designation_delete');
    // Manage designation End

    // Manage department Start
    Route::get('department/list', [DepartmentController::class, 'list'])->name('department_list');
    Route::get('department/create', [DepartmentController::class, 'create'])->name('department_create');
    Route::post('department/store', [DepartmentController::class, 'store'])->name('department_store');
    Route::get('department/edit/{id}', [DepartmentController::class, 'edit'])->name('department_edit');
    Route::post('department/update/{id}', [DepartmentController::class, 'update'])->name('department_update');
    Route::get('department/delete/{id}', [DepartmentController::class, 'delete'])->name('department_delete');
    // Manage department End

    // Manage company Start
    Route::get('company/list', [CompanyController::class, 'list'])->name('company_list');
    Route::get('company/create', [CompanyController::class, 'create'])->name('company_create');
    Route::post('company/store', [CompanyController::class, 'store'])->name('company_store');
    Route::get('company/edit/{id}', [CompanyController::class, 'edit'])->name('company_edit');
    Route::post('company/update/{id}', [CompanyController::class, 'update'])->name('company_update');
    Route::get('company/delete/{id}', [CompanyController::class, 'delete'])->name('company_delete');
    // Manage company End

    // Manage Religion Start
    Route::get('religion/list', [ReligionController::class, 'list'])->name('religion_list');
    Route::get('religion/create', [ReligionController::class, 'create'])->name('religion_create');
    Route::post('religion/store', [ReligionController::class, 'store'])->name('religion_store');
    Route::get('religion/edit/{id}', [ReligionController::class, 'edit'])->name('religion_edit');
    Route::post('religion/update/{id}', [ReligionController::class, 'update'])->name('religion_update');
    Route::get('religion/delete/{id}', [ReligionController::class, 'delete'])->name('religion_delete');
    // Manage Religion End

    // Manage Blood Group Start
    Route::get('blood_group/list', [BloodGroupController::class, 'list'])->name('bloodgroup_list');
    Route::get('blood_group/create', [BloodGroupController::class, 'create'])->name('bloodgroup_create');
    Route::post('blood_group/store', [BloodGroupController::class, 'store'])->name('bloodgroup_store');
    Route::get('blood_group/edit/{id}', [BloodGroupController::class, 'edit'])->name('bloodgroup_edit');
    Route::post('blood_group/update/{id}', [BloodGroupController::class, 'update'])->name('bloodgroup_update');
    Route::get('blood_group/delete/{id}', [BloodGroupController::class, 'delete'])->name('bloodgroup_delete');
    // Manage Blood Group End

    // Manage Blood Group Start
    Route::get('logo/list', [LogoController::class, 'list'])->name('logo_list');
    Route::get('logo/create', [LogoController::class, 'create'])->name('logo_create');
    Route::post('logo/store', [LogoController::class, 'store'])->name('logo_store');
    Route::get('logo/edit/{id}', [LogoController::class, 'edit'])->name('logo_edit');
    Route::post('logo/update/{id}', [LogoController::class, 'update'])->name('logo_update');
    Route::get('logo/delete/{id}', [LogoController::class, 'delete'])->name('logo_delete');
    // Manage Blood Group End

});

//Invoice
Route::prefix('invoice_setting')->name('invoice_setting.')->middleware(['auth:admin', 'PreventBackHistory'])->group(function () {

    // Manage unit Start
    Route::get('unit/list', [UnitController::class, 'list'])->name('unit_list');
    Route::get('unit/create', [UnitController::class, 'create'])->name('unit_create');
    Route::post('unit/store', [UnitController::class, 'store'])->name('unit_store');
    Route::get('unit/edit/{id}', [UnitController::class, 'edit'])->name('unit_edit');
    Route::post('unit/update/{id}', [UnitController::class, 'update'])->name('unit_update');
    Route::get('unit/delete/{id}', [UnitController::class, 'delete'])->name('unit_delete');
    // Manage unit End

    // Manage category Start
    Route::get('category/list', [CategoryController::class, 'list'])->name('category_list');
    Route::get('category/create', [CategoryController::class, 'create'])->name('category_create');
    Route::post('category/store', [CategoryController::class, 'store'])->name('category_store');
    Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('category_edit');
    Route::post('category/update/{id}', [CategoryController::class, 'update'])->name('category_update');
    Route::get('category/delete/{id}', [CategoryController::class, 'delete'])->name('category_delete');
    // Manage category End

    // Manage customer Start
    Route::get('customer/list', [CustomerController::class, 'list'])->name('customer_list');
    Route::get('customer/create', [CustomerController::class, 'create'])->name('customer_create');
    Route::post('customer/store', [CustomerController::class, 'store'])->name('customer_store');
    Route::get('customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer_edit');
    Route::post('customer/update/{id}', [CustomerController::class, 'update'])->name('customer_update');
    Route::get('customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer_delete');
    // Manage customer End

    // Manage store Start
    Route::get('store/list', [StoreController::class, 'list'])->name('store_list');
    Route::get('store/create', [StoreController::class, 'create'])->name('store_create');
    Route::post('store/store', [StoreController::class, 'store'])->name('store_store');
    Route::get('store/edit/{id}', [StoreController::class, 'edit'])->name('store_edit');
    Route::post('store/update/{id}', [StoreController::class, 'update'])->name('store_update');
    // Route::get('store/delete/{id}', [StoreController::class, 'delete'])->name('store_delete');
    Route::get('/store/view/{id}', [StoreController::class, 'view'])->name('store_view');
    // Manage store End

    // Manage supplier Start
    Route::get('supplier/list', [SupplierController::class, 'list'])->name('supplier_list');
    Route::get('supplier/create', [SupplierController::class, 'create'])->name('supplier_create');
    Route::post('supplier/store', [SupplierController::class, 'store'])->name('supplier_store');
    Route::get('supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier_edit');
    Route::post('supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier_update');
    Route::get('supplier/delete/{id}', [SupplierController::class, 'delete'])->name('supplier_delete');
    // Manage supplier End

    // Product Start
    Route::get('product/list', [ProductController::class, 'list'])->name('product_list');
    Route::get('product/create', [ProductController::class, 'create'])->name('product_create');
    Route::post('product/store', [ProductController::class, 'store'])->name('product_store');
    Route::get('product/barcode/{id}', [ProductController::class, 'product_barcode'])->name('product_barcode');
    Route::get('product/edit/{id}', [ProductController::class, 'edit'])->name('product_edit');
    Route::post('product/update/{id}', [ProductController::class, 'update'])->name('product_update');
    // Route::get('product/delete/{id}', [ProductController::class, 'delete'])->name('product_delete');
    Route::get('product/view/{id}', [ProductController::class, 'product_view'])->name('product_view');
    Route::get('product/print/{id}', [ProductController::class, 'product_print'])->name('product_print');

    Route::get('product/product_wise_store/{id}', [ProductController::class, 'product_wise_store'])->name('product_wise_store');
    Route::get('product/open_product_wise_store/{id}', [ProductController::class, 'open_product_wise_store'])->name('open_product_wise_store');
    Route::post('product/open_product_wise_store_save', [ProductController::class, 'open_product_wise_store_save'])->name('open_product_wise_store_save');
    Route::get('product/open_product_wise_store_edit/{id}', [ProductController::class, 'open_product_wise_store_edit'])->name('open_product_wise_store_edit');
    Route::post('product/open_product_wise_store_update/{id}', [ProductController::class, 'open_product_wise_store_update'])->name('open_product_wise_store_update');
    // Route::get('product/open_product_wise_store_delete/{id}', [ProductController::class, 'open_product_wise_store_delete'])->name('open_product_wise_store_delete');
    Route::get('product/sw_list', [ProductController::class, 'sw_list'])->name('product_sw_list');
    Route::get('product/sw_edit/{id}', [ProductController::class, 'sw_edit'])->name('product_sw_edit');
    Route::post('product/sw_update/{id}', [ProductController::class, 'sw_update'])->name('product_sw_update');
    Route::get('product/sw_view/{id}', [ProductController::class, 'sw_view'])->name('product_sw_view');
    Route::get('product/sw_print/{id}', [ProductController::class, 'sw_print'])->name('product_sw_print');
    Route::get('product/sw_barcode/{id}', [ProductController::class, 'sw_barcode'])->name('product_sw_barcode');
    // Product End

    // Manage expense type Start
    Route::get('expense/list', [ExpenseController::class, 'list'])->name('expense_list');
    Route::get('expense/create', [ExpenseController::class, 'create'])->name('expense_create');
    Route::post('expense/store', [ExpenseController::class, 'store'])->name('expense_store');
    Route::get('expense/edit/{id}', [ExpenseController::class, 'edit'])->name('expense_edit');
    Route::post('expense/update/{id}', [ExpenseController::class, 'update'])->name('expense_update');
    Route::get('expense/delete/{id}', [ExpenseController::class, 'delete'])->name('expense_delete');
    // Manage expense End

    //Start supplier Wise Store
    Route::get('spw/list', [SupplierWiseStoreController::class, 'list'])->name('supplier_wise_store_list');
    Route::get('spw/create', [SupplierWiseStoreController::class, 'create'])->name('supplier_wise_store_create');
    Route::post('spw/store', [SupplierWiseStoreController::class, 'store'])->name('supplier_wise_store_store');
    Route::get('spw/edit/{id}', [SupplierWiseStoreController::class, 'edit'])->name('supplier_wise_store_edit');
    Route::post('spw/update/{id}', [SupplierWiseStoreController::class, 'update'])->name('supplier_wise_store_update');
    Route::get('spw/delete/{id}', [SupplierWiseStoreController::class, 'delete'])->name('supplier_wise_store_delete');
    //Start supplier Wise Store End

    // Manage expense type Start
    Route::get('paymenttype/list', [PaymentTypeController::class, 'list'])->name('payment_list');
    Route::get('paymenttype/create', [PaymentTypeController::class, 'create'])->name('payment_create');
    Route::post('paymenttype/store', [PaymentTypeController::class, 'store'])->name('payment_store');
    Route::get('paymenttype/edit/{id}', [PaymentTypeController::class, 'edit'])->name('payment_edit');
    Route::post('paymenttype/update/{id}', [PaymentTypeController::class, 'update'])->name('payment_update');
    Route::get('paymenttype/delete/{id}', [PaymentTypeController::class, 'delete'])->name('payment_delete');
    // Manage expense End

});
