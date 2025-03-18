<?php

use App\Http\Controllers\CommonController;
use App\Http\Controllers\ExpenseManageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PurchaseManageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StorePermissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'PreventBackHistory'])->group(function () {
    // Common Search
    Route::get('/employee_auto_search', [CommonController::class, 'employee_auto_search'])->name('employee_auto_search');

    Route::get('purchase_manage/store_wise_product_search', [CommonController::class, 'store_wise_product_search'])->name('store_wise_product_search');
    Route::get('customer_search', [CommonController::class, 'customer_search'])->name('customer_search');
    Route::get('store_wise_invoice_search', [CommonController::class, 'store_wise_invoice_search'])->name('store_wise_invoice_search');
    Route::get('invoice_search_auto', [CommonController::class, 'invoice_search_auto'])->name('invoice_search_auto');
    Route::get('store_wise_employee_auto', [CommonController::class, 'store_wise_employee_auto'])->name('store_wise_employee_auto');

    //End Common Search

// Invoice Start
    // Room In Permission Start
    Route::get('store_permission/list', [StorePermissionController::class, 'list'])->name('room_permission_list');
    Route::get('store_permission/create', [StorePermissionController::class, 'create'])->name('room_permission_create');
    Route::post('store_permission/store', [StorePermissionController::class, 'store'])->name('room_permission_store');
    Route::get('store_permission/edit/{id}', [StorePermissionController::class, 'edit'])->name('room_permission_edit');
    Route::post('store_permission/update/{id}', [StorePermissionController::class, 'update'])->name('room_permission_update');
    Route::get('store_permission/delete/{id}', [StorePermissionController::class, 'delete'])->name('room_permission_delete');
    // Room In Permission End

    // Purchase Manage Start
    Route::get('purchase_manage/create', [PurchaseManageController::class, 'new_purchase'])->name('purchase_manage_create');
    Route::get('purchase_manage/store_wise_supplier', [PurchaseManageController::class, 'store_wise_supplier'])->name('store_wise_supplier');

    Route::get('purchase_manage/pending_list', [PurchaseManageController::class, 'purchase_manage_pending_list'])->name('purchase_manage_pending_list');

    Route::get('purchase_manage/list', [PurchaseManageController::class, 'purchase_manage_list'])->name('purchase_manage_list');
    Route::get('purchase_manage/showdata', [PurchaseManageController::class, 'purchase_showdata'])->name('purchase_showdata');
    Route::post('purchase_manage/search_purchase_list', [PurchaseManageController::class, 'search_purchase_list'])->name('purchase_search_purchase_list');
    Route::post('purchase_manage/search_purchase_list_print', [PurchaseManageController::class, 'search_purchase_list_print'])->name('search_purchase_list_print');

    Route::post('purchase_manage/search_pending_data', [PurchaseManageController::class, 'search_pending_data'])->name('purchase_search_pending_data');
    Route::post('purchase_manage/search_pending_list_print', [PurchaseManageController::class, 'search_pending_list_print'])->name('purchase_search_pending_list_print');
    Route::get('purchase_manage/pending-showdata', [PurchaseManageController::class, 'pending_showData'])->name('pending_showdata');

    Route::post('purchase_manage/store', [PurchaseManageController::class, 'store'])->name('purchase_manage_store');
    Route::get('purchase_manage/purchase_manage_view/{id}', [PurchaseManageController::class, 'purchase_manage_view'])->name('purchase_manage_view');
    Route::get('purchase_manage/purchase_manage_edit/{id}', [PurchaseManageController::class, 'purchase_manage_edit'])->name('purchase_manage_edit');
    Route::post('purchase_manage/purchase_manage_update', [PurchaseManageController::class, 'purchase_manage_update'])->name('purchase_manage_update');
    Route::get('purchase_manage/approve/{id}', [PurchaseManageController::class, 'approve'])->name('purchase_manage_approve');
    Route::get('purchase_manage/reject/{id}', [PurchaseManageController::class, 'reject'])->name('purchase_manage_reject');
    Route::get('purchase_manage/delete/{id}', [PurchaseManageController::class, 'delete'])->name('purchase_manage_delete');
    Route::get('purchase_manage/purchase_manage_print/{id}', [PurchaseManageController::class, 'purchase_manage_print'])->name('purchase_manage_print');

    Route::get('purchase_manage/purchase_approve_list', [PurchaseManageController::class, 'purchase_approve_list'])->name('purchase_approve_list');
    Route::get('purchase_manage/purchase_approve_list_show', [PurchaseManageController::class, 'purchase_approve_list_show'])->name('purchase_approve_list_show');
    Route::post('purchase_manage/purchase_approve_list_search', [PurchaseManageController::class, 'purchase_approve_list_search'])->name('purchase_approve_list_search');
    Route::post('purchase_manage/purchase_approve_list_print', [PurchaseManageController::class, 'purchase_approve_list_print'])->name('purchase_approve_list_print');

    Route::get('purchase_manage/purchase_cancel_list', [PurchaseManageController::class, 'purchase_cancel_list'])->name('purchase_cancel_list');
    Route::get('purchase_manage/purchase_cancel_list_show', [PurchaseManageController::class, 'purchase_cancel_list_show'])->name('purchase_cancel_list_show');
    Route::post('purchase_manage/purchase_cancel_list_search', [PurchaseManageController::class, 'purchase_cancel_list_search'])->name('purchase_cancel_list_search');
    Route::post('purchase_manage/purchase_cancel_list_print', [PurchaseManageController::class, 'purchase_cancel_list_print'])->name('purchase_cancel_list_print');

    // Purchase Manage End

    // Sales Manage Start
    Route::get('sales_manage/pos', [SalesController::class, 'sales_pos'])->name('sales_pos');
    Route::get('sales_manage/pos_show', [SalesController::class, 'sales_pos_show'])->name('sales_pos_show');
    Route::get('sales_manage/sales_pos_show_print/{id}', [SalesController::class, 'sales_pos_show_print'])->name('sales_pos_show_print');
    Route::post('sales_manage/pos/store', [SalesController::class, 'sales_pos_store'])->name('sales_pos_store');
    Route::get('sales_manage/new_customer', [SalesController::class, 'new_customer'])->name('new_customer');
    Route::post('sales_manage/new_customer', [SalesController::class, 'new_customer_store'])->name('new_customer_store');
    // Sales Manage End

    //Invoice Start
    Route::get('sales_manage/invoice_list', [InvoiceController::class, 'invoice_list'])->name('invoice_list');
    Route::get('sales_manage/edit_invoice/{id}', [InvoiceController::class, 'edit_invoice'])->name('edit_invoice');
    Route::get('sales_manage/edit_invoice_show/{id}', [InvoiceController::class, 'edit_invoice_show'])->name('edit_invoice_show');
    Route::post('sales_manage/edit_invoice/{id}', [InvoiceController::class, 'edit_invoice_update'])->name('edit_invoice_update');
    Route::post('sales_manage/search_invoice_list', [InvoiceController::class, 'search_invoice_list'])->name('search_invoice_list');
    Route::post('sales_manage/print_invoice_list', [InvoiceController::class, 'print_invoice_list'])->name('print_invoice_list');
    Route::get('sales_manage/invoice_list_show', [InvoiceController::class, 'invoice_list_show'])->name('invoice_list_show');
    Route::get('sales_manage/invoice_details/{id}', [InvoiceController::class, 'invoice_details'])->name('invoice_details');
    Route::get('sales_manage/invoice_details_print/{id}', [InvoiceController::class, 'invoice_details_print'])->name('invoice_details_print');
    Route::get('sales_manage/invoice_customer_copy_view/{id}', [InvoiceController::class, 'invoice_customer_copy_view'])->name('invoice_customer_copy_view');
    Route::get('sales_manage/invoice_customer_pos_print/{id}', [InvoiceController::class, 'invoice_customer_pos_print'])->name('invoice_customer_pos_print');
    Route::get('sales_manage/invoice_customer_copy_view_print/{id}', [InvoiceController::class, 'invoice_customer_copy_view_print'])->name('invoice_customer_copy_view_print');
    Route::get('sales_manage/paid_invoice_list', [InvoiceController::class, 'paid_invoice_list'])->name('paid_invoice_list');
    Route::get('sales_manage/paid_invoice_list_show', [InvoiceController::class, 'paid_invoice_list_show'])->name('paid_invoice_list_show');
    Route::post('sales_manage/search_paid_invoice_list', [InvoiceController::class, 'search_paid_invoice_list'])->name('search_paid_invoice_list');
    Route::post('sales_manage/print_paid_invoice_list', [InvoiceController::class, 'print_paid_invoice_list'])->name('print_paid_invoice_list');
    Route::get('sales_manage/date_wise_cashier_report', [InvoiceController::class, 'date_wise_cashier_report'])->name('date_wise_cashier_report');
    Route::get('sales_manage/date_wise_cashier_report_show', [InvoiceController::class, 'date_wise_cashier_report_show'])->name('date_wise_cashier_report_show');
    Route::get('sales_manage/invoice_per_payment/{id}', [InvoiceController::class, 'invoice_per_payment'])->name('invoice_per_payment');
    Route::get('sales_manage/due_list', [InvoiceController::class, 'due_list'])->name('due_list');
    Route::get('sales_manage/due_invoice_list_show', [InvoiceController::class, 'due_invoice_list_show'])->name('due_invoice_list_show');
    Route::post('sales_manage/due_search_invoice_list', [InvoiceController::class, 'due_search_invoice_list'])->name('due_search_invoice_list');
    Route::post('sales_manage/due_print_invoice_list', [InvoiceController::class, 'due_print_invoice_list'])->name('due_print_invoice_list');
    Route::get('sales_manage/due_collection/{id}', [InvoiceController::class, 'due_collection'])->name('due_collection');
    Route::post('sales_manage/due_collection', [InvoiceController::class, 'due_collection_update'])->name('due_collection_update');
    Route::get('sales_manage/due_invoice_details/{id}', [InvoiceController::class, 'due_invoice_details'])->name('due_invoice_details');
    Route::get('sales_manage/due_invoice_details_print/{id}', [InvoiceController::class, 'due_invoice_details_print'])->name('due_invoice_details_print');
    Route::get('sales_manage/due_invoice_customer_copy_view/{id}', [InvoiceController::class, 'due_invoice_customer_copy_view'])->name('due_invoice_customer_copy_view');
    Route::get('sales_manage/due_invoice_customer_copy_view_print/{id}', [InvoiceController::class, 'due_invoice_customer_copy_view_print'])->name('due_invoice_customer_copy_view_print');
    Route::get('sales_manage/cancel_invoice/{id}', [InvoiceController::class, 'cancel_invoice'])->name('cancel_invoice');
    Route::get('sales_manage/cancel_invoice_list', [InvoiceController::class, 'cancel_invoice_list'])->name('cancel_invoice_list');
    Route::get('sales_manage/cancel_invoice_list_show', [InvoiceController::class, 'cancel_invoice_list_show'])->name('cancel_invoice_list_show');
    Route::post('sales_manage/cancel_search_invoice_list', [InvoiceController::class, 'cancel_search_invoice_list'])->name('cancel_search_invoice_list');
    Route::post('sales_manage/cancel_print_invoice_list', [InvoiceController::class, 'cancel_print_invoice_list'])->name('cancel_print_invoice_list');
    Route::get('sales_manage/cancel_invoice_details/{id}', [InvoiceController::class, 'cancel_invoice_details'])->name('cancel_invoice_details');
    Route::get('sales_manage/cancel_invoice_details_print/{id}', [InvoiceController::class, 'cancel_invoice_details_print'])->name('cancel_invoice_details_print');
    Route::get('sales_manage/date_wise_cashier_report_details/{id}', [InvoiceController::class, 'date_wise_cashier_report_details'])->name('date_wise_cashier_report_details');
    Route::get('sales_manage/date_wise_cashier_report_details_print/{id}', [InvoiceController::class, 'date_wise_cashier_report_details_print'])->name('date_wise_cashier_report_details_print');
    Route::post('sales_manage/search_date_wise_cashier_report', [InvoiceController::class, 'search_date_wise_cashier_report'])->name('search_date_wise_cashier_report');
    Route::post('sales_manage/print_date_wise_cashier_report', [InvoiceController::class, 'print_date_wise_cashier_report'])->name('print_date_wise_cashier_report');

    Route::get('sales_manage/reorder_list', [InvoiceController::class, 'reorder_list'])->name('reorder_list');
    Route::post('sales_manage/reorder_list_print', [InvoiceController::class, 'reorder_list_print'])->name('reorder_list_print');

    //Invoice End

    // expense_manage Manage Start
    Route::get('expense_manage/list', [ExpenseManageController::class, 'list'])->name('expense_manage_list');
    Route::post('expense_manage/expense_manage_search', [ExpenseManageController::class, 'expense_manage_search'])->name('expense_manage_search');
    Route::post('expense_manage/expense_manage_search_print', [ExpenseManageController::class, 'expense_manage_search_print'])->name('expense_manage_search_print');
    Route::get('expense_manage/showdata', [ExpenseManageController::class, 'showData'])->name('expense_showdata');
    Route::get('expense_manage/create', [ExpenseManageController::class, 'create'])->name('expense_manage_create');
    Route::post('expense_manage/store', [ExpenseManageController::class, 'store'])->name('expense_manage_store');
    Route::get('expense_manage/edit/{id}', [ExpenseManageController::class, 'edit'])->name('expense_manage_edit');
    Route::post('expense_manage/update/{id}', [ExpenseManageController::class, 'update'])->name('expense_manage_update');
    Route::get('expense_manage/delete/{id}', [ExpenseManageController::class, 'delete'])->name('expense_manage_delete');

    // expense_manage Manage End

// Report Start
    Route::get('report/daily_sales', [ReportController::class, 'daily_sales'])->name('daily_sales');
    Route::get('report/daily_sales_show', [ReportController::class, 'daily_sales_show'])->name('daily_sales_show');
    Route::post('report/daily_sales_search', [ReportController::class, 'daily_sales_search'])->name('daily_sales_search');
    Route::post('report/daily_sales_list_print', [ReportController::class, 'daily_sales_list_print'])->name('daily_sales_list_print');
    Route::get('report/daily_sales_details/{id}', [ReportController::class, 'daily_sales_details'])->name('daily_sales_details');
    Route::get('report/daily_sales_details_print/{id}', [ReportController::class, 'daily_sales_details_print'])->name('daily_sales_details_print');

    Route::get('report/daily_cancel_inv', [ReportController::class, 'daily_cancel_inv'])->name('daily_cancel_inv');
    Route::get('report/daily_cancel_inv_show', [ReportController::class, 'daily_cancel_inv_show'])->name('daily_cancel_inv_show');
    Route::post('report/daily_cancel_inv_search', [ReportController::class, 'daily_cancel_inv_search'])->name('daily_cancel_inv_search');
    Route::post('report/daily_cancel_inv_list_print', [ReportController::class, 'daily_cancel_inv_list_print'])->name('daily_cancel_inv_list_print');
    Route::get('report/daily_cancel_inv_details/{id}', [ReportController::class, 'daily_cancel_inv_details'])->name('daily_cancel_inv_details');
    Route::get('report/daily_cancel_inv_details_print/{id}', [ReportController::class, 'daily_cancel_inv_details_print'])->name('daily_cancel_inv_details_print');

    Route::get('report/monthly_sales', [ReportController::class, 'monthly_sales'])->name('monthly_sales');
    Route::get('report/monthly_sales_show', [ReportController::class, 'monthly_sales_show'])->name('monthly_sales_show');
    Route::post('report/monthly_sales_search', [ReportController::class, 'monthly_sales_search'])->name('monthly_sales_search');
    Route::post('report/monthly_sales_print', [ReportController::class, 'monthly_sales_print'])->name('monthly_sales_print');

    Route::get('report/yearly_sales', [ReportController::class, 'yearly_sales'])->name('yearly_sales');
    Route::get('report/yearly_sales_show', [ReportController::class, 'yearly_sales_show'])->name('yearly_sales_show');
    Route::post('report/yearly_sales_search', [ReportController::class, 'yearly_sales_search'])->name('yearly_sales_search');
    Route::post('report/yearly_sales_print', [ReportController::class, 'yearly_sales_print'])->name('yearly_sales_print');

    Route::get('report/date_wise_cashier', [ReportController::class, 'date_wise_cashier'])->name('date_wise_cashier');
    Route::get('report/date_wise_cashier_show', [ReportController::class, 'date_wise_cashier_show'])->name('date_wise_cashier_show');
    Route::post('report/search_date_wise_cashier', [ReportController::class, 'search_date_wise_cashier'])->name('search_date_wise_cashier');
    Route::get('report/date_wise_cashier_details/{id}', [ReportController::class, 'date_wise_cashier_details'])->name('date_wise_cashier_details');
    Route::get('report/date_wise_cashier_details_print/{id}', [ReportController::class, 'date_wise_cashier_details_print'])->name('date_wise_cashier_details_print');
    Route::post('report/date_wise_cashier_list_print', [ReportController::class, 'date_wise_cashier_list_print'])->name('date_wise_cashier_list_print');

    Route::get('report/income_summery_report', [ReportController::class, 'income_summery_report'])->name('income_summery_report');
    Route::get('report/income_summery_report_show', [ReportController::class, 'income_summery_report_show'])->name('income_summery_report_show');
    Route::post('report/income_summery_report_search', [ReportController::class, 'income_summery_report_search'])->name('income_summery_report_search');
    Route::post('report/income_summery_report_print', [ReportController::class, 'income_summery_report_print'])->name('income_summery_report_print');

    Route::get('report/daily_purchase', [ReportController::class, 'daily_purchase'])->name('daily_purchase');
    Route::get('report/daily_purchase_data', [ReportController::class, 'daily_purchase_data'])->name('daily_purchase_data');
    Route::post('report/daily_purchase_search', [ReportController::class, 'daily_purchase_search'])->name('daily_purchase_search');
    Route::post('report/daily_purchase_search_print', [ReportController::class, 'daily_purchase_search_print'])->name('daily_purchase_search_print');
    Route::get('report/daily_purchase_view/{id}', [ReportController::class, 'daily_purchase_view'])->name('daily_purchase_view');
    Route::get('report/daily_purchase_view_print/{id}', [ReportController::class, 'daily_purchase_view_print'])->name('daily_purchase_view_print');

    Route::get('report/daily_purchase_summery', [ReportController::class, 'daily_purchase_summery'])->name('daily_purchase_summery');
    Route::get('report/daily_purchase_summery_data', [ReportController::class, 'daily_purchase_summery_data'])->name('daily_purchase_summery_data');
    Route::post('report/daily_purchase_summery_search', [ReportController::class, 'daily_purchase_summery_search'])->name('daily_purchase_summery_search');
    Route::post('report/daily_purchase_summery_search_print', [ReportController::class, 'daily_purchase_summery_search_print'])->name('daily_purchase_summery_search_print');


    Route::get('report/daily_expense_report', [ReportController::class, 'daily_expense_report'])->name('daily_expense_report');
    Route::get('report/daily_expense_report_show', [ReportController::class, 'daily_expense_report_show'])->name('daily_expense_report_show');
    Route::post('report/daily_expense_report_search', [ReportController::class, 'daily_expense_report_search'])->name('daily_expense_report_search');
    Route::post('report/daily_expense_report_search_print', [ReportController::class, 'daily_expense_report_search_print'])->name('daily_expense_report_search_print');

    Route::get('report/expense_summery_report', [ReportController::class, 'expense_summery_report'])->name('expense_summery_report');
    Route::get('report/expense_summery_report_shoe', [ReportController::class, 'expense_summery_report_shoe'])->name('expense_summery_report_shoe');
    Route::post('report/expense_summery_report_search', [ReportController::class, 'expense_summery_report_search'])->name('expense_summery_report_search');
    Route::post('report/expense_summery_report_print', [ReportController::class, 'expense_summery_report_print'])->name('expense_summery_report_print');


    Route::get('report/profit_report', [ReportController::class, 'profit_report'])->name('profit_report');
    Route::get('report/profit_report_show', [ReportController::class, 'profit_report_show'])->name('profit_report_show');
    Route::post('report/profit_report_search', [ReportController::class, 'profit_report_search'])->name('profit_report_search');
    Route::post('report/profit_report_print', [ReportController::class, 'profit_report_print'])->name('profit_report_print');



// Report End
});
