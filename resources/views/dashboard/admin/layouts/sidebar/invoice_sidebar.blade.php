@if (Auth::guard('admin')->user()->can('salese_manage.menu'))
    <li class="nav-item {{ Request::is('admin/sales_manage/*') ? 'menu-open rounded menu-bg bg-dark' : '' }}">
        <a href="#" class="nav-link">
            &nbsp; <i class="fa fa-shopping-cart" aria-hidden="true"></i> &nbsp;
            <p>
                Sales Manage
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview dark_red">
            @if (Auth::guard('admin')->user()->can('salese_manage.pos'))
                <li class="nav-item">
                    <a href="{{ route('admin.sales_pos') }}"
                        class="nav-link {{ $route === 'admin.sales_pos' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>POS</p>
                    </a>
                </li>
            @endif
            @if (Auth::guard('admin')->user()->can('salese_manage.invoice_list'))
                <li class="nav-item">
                    <a href="{{ route('admin.invoice_list') }}"
                        class="nav-link {{ $route === 'admin.invoice_list' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>Invoice List</p>
                    </a>
                </li>
            @endif
            @if (Auth::guard('admin')->user()->can('salese_manage.date_wise_cashier_report'))
                <li class="nav-item">
                    <a href="{{ route('admin.date_wise_cashier_report') }}"
                        class="nav-link {{ $route === 'admin.date_wise_cashier_report' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>D.W. Cashier Report</p>
                    </a>
                </li>
            @endif
            @if (Auth::guard('admin')->user()->can('salese_manage.paid_invoice_list'))
                <li class="nav-item">
                    <a href="{{ route('admin.paid_invoice_list') }}"
                        class="nav-link {{ $route === 'admin.paid_invoice_list' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>Paid Invoice List</p>
                    </a>
                </li>
            @endif
            @if (Auth::guard('admin')->user()->can('salese_manage.due_list'))
                <li class="nav-item">
                    <a href="{{ route('admin.due_list') }}"
                        class="nav-link {{ $route === 'admin.due_list' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>Due Collection</p>
                    </a>
                </li>
            @endif
            @if (Auth::guard('admin')->user()->can('salese_manage.cancel_invoice_list'))
                <li class="nav-item">
                    <a href="{{ route('admin.cancel_invoice_list') }}"
                        class="nav-link {{ $route === 'admin.cancel_invoice_list' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>Cancel List</p>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a href="{{ route('admin.reorder_list') }}"
                    class="nav-link {{ $route === 'admin.reorder_list' ? 'text-light' : '' }} "> <i
                        class="far fa-circle nav-icon"></i>
                    <p>Reorder List</p>
                </a>
            </li>


        </ul>
    </li>
@endif

@if (Auth::guard('admin')->user()->can('store_previlage.menu'))
    <li class="nav-item {{ Request::is('admin/store_permission/*') ? 'menu-open rounded menu-bg bg-dark' : '' }}">
        <a href="#" class="nav-link">
            &nbsp; <i class="fas fa-store"></i> &nbsp;
            <p>
                Store Privilege
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview dark_red">
            @if (Auth::guard('admin')->user()->can('store_previlage.list'))
                <li class="nav-item">
                    <a href="{{ route('admin.room_permission_list') }}"
                        class="nav-link {{ $route === 'admin.room_permission_list' ? 'text-light' : '' }} ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>SP List</p>
                    </a>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->can('store_previlage.create'))
                <li class="nav-item">
                    <a href="{{ route('admin.room_permission_create') }}"
                        class="nav-link {{ $route === 'admin.room_permission_create' ? 'text-light' : '' }} ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add New SP</p>
                    </a>
                </li>
            @endif

        </ul>
    </li>
@endif

@if (Auth::guard('admin')->user()->can('purchase.menu'))
    <li class="nav-item {{ Request::is('admin/purchase_manage/*') ? 'menu-open rounded menu-bg bg-dark' : '' }}">
        <a href="#" class="nav-link">
            &nbsp; <i class="fas fa-shopping-bag"></i> &nbsp;
            <p>
                Purchase Manage
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview dark_red">
            @if (Auth::guard('admin')->user()->can('purchase.new_purchase'))
                <li class="nav-item">
                    <a href="{{ route('admin.purchase_manage_create') }}"
                        class="nav-link {{ $route === 'admin.purchase_manage_create' ? 'text-light' : '' }} ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add New Purchase</p>
                    </a>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->can('purchase.list'))
                <li class="nav-item">
                    <a href="{{ route('admin.purchase_manage_list') }}"
                        class="nav-link {{ $route === 'admin.purchase_manage_list' ? 'text-light' : '' }} ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Purchase List</p>
                    </a>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->can('purchase.pending_list'))
                <li class="nav-item">
                    <a href="{{ route('admin.purchase_manage_pending_list') }}"
                        class="nav-link {{ $route === 'admin.purchase_manage_pending_list' ? 'text-light' : '' }} ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Purchase Pe.List</p>
                    </a>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->can('purchase.approve_list'))
                <li class="nav-item">
                    <a href="{{ route('admin.purchase_approve_list') }}"
                        class="nav-link {{ $route === 'admin.purchase_approve_list' ? 'text-light' : '' }} ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Purchase Apr.List</p>
                    </a>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->can('purchase.cancel_list'))
                <li class="nav-item">
                    <a href="{{ route('admin.purchase_cancel_list') }}"
                        class="nav-link {{ $route === 'admin.purchase_cancel_list' ? 'text-light' : '' }} ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Purchase Cancel List</p>
                    </a>
                </li>
            @endif


        </ul>
    </li>
@endif


@if (Auth::guard('admin')->user()->can('expense_manage.menu'))
    <li class="nav-item {{ Request::is('admin/expense_manage/*') ? 'menu-open rounded menu-bg bg-dark' : '' }}">
        <a href="#" class="nav-link">
            &nbsp; <i class="fas fa-minus-square"></i> &nbsp;
            <p>
                Expense Manage
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview dark_red">
            @if (Auth::guard('admin')->user()->can('expense_manage.list'))
                <li class="nav-item">
                    <a href="{{ route('admin.expense_manage_list') }}"
                        class="nav-link {{ $route === 'admin.expense_manage_list' ? 'text-light' : '' }} ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Expense List</p>
                    </a>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->can('expense_manage.create'))
                <li class="nav-item">
                    <a href="{{ route('admin.expense_manage_create') }}"
                        class="nav-link {{ $route === 'admin.expense_manage_create' ? 'text-light' : '' }} ">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add New Expense</p>
                    </a>
                </li>
            @endif

        </ul>
    </li>
@endif

@if (Auth::guard('admin')->user()->can('report.menu'))
    <li class="nav-item {{ Request::is('admin/report/*') ? 'menu-open rounded menu-bg bg-dark' : '' }}">
        <a href="#" class="nav-link">
            &nbsp; <i class="fa fa-shopping-cart" aria-hidden="true"></i> &nbsp;
            <p>
                Report
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview dark_red">
            @if (Auth::guard('admin')->user()->can('report.daily_sales'))
                <li class="nav-item">
                    <a href="{{ route('admin.daily_sales') }}" class="nav-link {{ $route === 'admin.daily_sales' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>Daily Sales</p>
                    </a>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->can('report.daily_cancel_inv'))
            <li class="nav-item">
                <a href="{{ route('admin.daily_cancel_inv') }}"
                    class="nav-link {{ $route === 'admin.daily_cancel_inv' ? 'text-light' : '' }} "> <i
                        class="far fa-circle nav-icon"></i>
                    <p>Daily Cancel Inv.</p>
                </a>
            </li>
            @endif



            @if (Auth::guard('admin')->user()->can('report.monthly_sales'))
                <li class="nav-item">
                    <a href="{{ route('admin.monthly_sales') }}"
                        class="nav-link {{ $route === 'admin.monthly_sales' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>Monthly Sales</p>
                    </a>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->can('report.yearly_sales'))
                <li class="nav-item">
                    <a href="{{ route('admin.yearly_sales') }}"
                        class="nav-link {{ $route === 'admin.yearly_sales' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>Yearly Sales</p>
                    </a>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->can('report.date_wise_cashier'))
                <li class="nav-item">
                    <a href="{{ route('admin.date_wise_cashier') }}"
                        class="nav-link {{ $route === 'admin.date_wise_cashier' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>D.W Cashier Report</p>
                    </a>
                </li>
            @endif


            @if (Auth::guard('admin')->user()->can('report.income_summery_report'))
                <li class="nav-item">
                    <a href="{{ route('admin.income_summery_report') }}"
                        class="nav-link {{ $route === 'admin.income_summery_report' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>Income SR</p>
                    </a>
                </li>
            @endif

            @if (Auth::guard('admin')->user()->can('report.daily_purchase'))
                <li class="nav-item"> <a href="{{ route('admin.daily_purchase') }}"
                        class="nav-link {{ $route === 'admin.daily_purchase' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>Daily Purchase </p>
                    </a> </li>
            @endif

            @if (Auth::guard('admin')->user()->can('report.daily_purchase_summery'))
                <li class="nav-item"> <a href="{{ route('admin.daily_purchase_summery') }}"
                        class="nav-link {{ $route === 'admin.daily_purchase_summery' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>Purchase SR</p>
                    </a> </li>
            @endif

            @if (Auth::guard('admin')->user()->can('report.daily_expense_report'))
                <li class="nav-item"> <a href="{{ route('admin.daily_expense_report') }}"
                        class="nav-link {{ $route === 'admin.daily_expense_report' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>Daily Expense</p>
                    </a></li>
            @endif

            @if (Auth::guard('admin')->user()->can('report.expense_summery_report'))
                <li class="nav-item"> <a href="{{ route('admin.expense_summery_report') }}"
                        class="nav-link {{ $route === 'admin.expense_summery_report' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>Expense SR</p>
                    </a></li>
            @endif

            @if (Auth::guard('admin')->user()->can('report.profit_report'))
                <li class="nav-item"> <a href="{{ route('admin.profit_report') }}"
                        class="nav-link {{ $route === 'admin.profit_report' ? 'text-light' : '' }} "> <i
                            class="far fa-circle nav-icon"></i>
                        <p>Profit</p>
                    </a></li>
            @endif
        </ul>
    </li>
@endif
{{-- <script>
    var currentUrl = window.location.href;
    console.log(currentUrl.includes('admin/report/'));
    if (currentUrl.includes('admin/report/')) {
        // Add the desired CSS classes
        //   navItem.classList.add('menu-open', 'rounded', 'menu-bg', 'bg-dark');
        console.log('Exist');
    } else {
        // Remove the CSS classes
        //   navItem.classList.remove('menu-open', 'rounded', 'menu-bg', 'bg-dark');

        console.log("Not Exist");
    }
</script> --}}
