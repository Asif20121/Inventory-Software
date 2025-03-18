<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $permissions = [

            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'admin.dashboard',
                    'store.wise.dashboard',
                    'sales.dashboard',
                ]
                ],

            [
                'group_name' => 'admin',
                'permissions' => [
                    'admin.menu',
                    'admin.list',
                    'admin.create',
                    'admin.edit',
                    'admin.delete',

                ]
                ],
            [
                'group_name' => 'role_permission',
                'permissions' => [
                    'role.permission.menu',
                    'permission.list',
                    'permission.create',
                    'role.list',
                    'role.create',
                    'role.permission.list',
                    'role.permission.create',

                ]
            ],
            [
                'group_name' => 'admin.store_wise_list',
                'permissions' => [
                    'admin.store_wise_list',

                ]
            ],
            [
                'group_name' => 'salese_manage',
                'permissions' => [
                    'salese_manage.menu',
                    'salese_manage.pos',
                    'salese_manage.invoice_list',
                    'salese_manage.edit_invoice',
                    'salese_manage.date_wise_cashier_report',
                    'salese_manage.paid_invoice_list',
                    'salese_manage.due_list',
                    'salese_manage.due_collection',
                    'salese_manage.cancel_invoice',
                    'salese_manage.cancel_invoice_list',
                    'salese_manage.reorder_list',

                ]
            ],
            [
                'group_name' => 'store_previlage',
                'permissions' => [
                    'store_previlage.menu',
                    'store_previlage.list',
                    'store_previlage.create',
                    'store_previlage.edit',
                    'store_previlage.delete',

                ]
            ],
            [
                'group_name' => 'purchase',
                'permissions' => [
                    'purchase.menu',
                    'purchase.new_purchase',
                    'purchase.pending_list',
                    'purchase.approve',
                    'purchase.reject',
                    'purchase.delete',
                    'purchase.view',
                    'purchase.edit',
                    'purchase.list',
                    'purchase.approve_list',
                    'purchase.cancel_list',

                ]
            ],
            [
                'group_name' => 'expense_manage',
                'permissions' => [
                    'expense_manage.menu',
                    'expense_manage.list',
                    'expense_manage.create',
                    'expense_manage.edit',
                    'expense_manage.delete',

                ]
            ],
            [
                'group_name' => 'report',
                'permissions' => [
                    'report.menu',
                    'report.daily_sales',
                    'report.daily_cancel_inv',
                    'report.monthly_sales',
                    'report.yearly_sales',
                    'report.date_wise_cashier',
                    'report.income_summery_report',
                    'report.daily_purchase',
                    'report.daily_purchase_summery',
                    'report.daily_expense_report',
                    'report.expense_summery_report',
                    'report.profit_report',

                ]
            ],
            [
                'group_name' => 'Admin.Setting',
                'permissions' => [
                    'admin_setting.menu',
                    'bloodgroup.menu',
                    'bloodgroup.list',
                    'bloodgroup.create',
                    'bloodgroup.edit',
                    'bloodgroup.delete',
                    'religion.menu',
                    'religion.list',
                    'religion.create',
                    'religion.edit',
                    'religion.delete',
                    'company.menu',
                    'company.list',
                    'company.create',
                    'company.edit',
                    'company.delete',
                    'department.menu',
                    'department.list',
                    'department.create',
                    'department.edit',
                    'department.delete',
                    'designation.menu',
                    'designation.list',
                    'designation.create',
                    'designation.edit',
                    'designation.delete',
                    'logo.menu',
                    'logo.list',
                    'logo.create',
                    'logo.edit',
                    'logo.delete',
                ]
            ],
            [
                'group_name' => 'Invoice.Setting',
                'permissions' => [
                    'invoice_setting.menu',
                    'unit.menu',
                    'unit.list',
                    'unit.create',
                    'unit.edit',
                    'unit.delete',
                    'category.menu',
                    'category.list',
                    'category.create',
                    'category.edit',
                    'category.delete',
                    'customer.menu',
                    'customer.list',
                    'customer.create',
                    'customer.edit',
                    'customer.delete',
                    'store.menu',
                    'store.list',
                    'store.create',
                    'store.edit',
                    'supplier.menu',
                    'supplier.list',
                    'supplier.create',
                    'supplier.edit',
                    'supplier.delete',
                    'supplier_wise_store.menu',
                    'supplier_wise_store.list',
                    'supplier_wise_store.create',
                    'supplier_wise_store.edit',
                    'supplier_wise_store.delete',
                    'product.menu',
                    'product.list',
                    'product.create',
                    'product.edit',
                    'product.product_wise_store',
                    'product.store_wise_product_list',
                    'product.store_wise_product_edit',
                    'expense_type.menu',
                    'expense_type.list',
                    'expense_type.create',
                    'expense_type.edit',
                    'expense_type.delete',
                    'payment_type.menu',
                    'payment_type.list',
                    'payment_type.create',
                    'payment_type.edit',
                    'payment_type.delete',

                ]
            ],
        ];

        // Create Role


        if (is_null(Role::where('role_type', '5')->first())) {
            $roleSuperAdmin = Role::create(['name' => 'Super Admin', 'role_type' => '5', 'guard_name' => 'admin']);
        } else {
            $roleSuperAdmin = Role::where('role_type', '5')->first();
        }
        // Assign Permission
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $cond =Permission::where('name','=',$permissions[$i]['permissions'][$j])->first();
                if( !isset($cond) ){
                    $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup, 'guard_name' => 'admin']);
                    $roleSuperAdmin->givePermissionTo($permission);
                    $permission->assignRole($roleSuperAdmin);
                }
            }
        }

        //Permitted Admin User
        $admin = Admin::where('role_type', '5')->first();
        if ($admin) {
            $admin->assignRole($roleSuperAdmin);
        }
    }
}
