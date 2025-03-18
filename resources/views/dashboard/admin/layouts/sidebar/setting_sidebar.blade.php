<!-- Admin Setting -->
@if (Auth::guard('admin')->user()->can('admin_setting.menu'))
<li class="nav-item  {{ Request::is('setting*') ? 'menu-is-opening menu-open rounded menu-bg bg-dark' : '' }}">
    <a href="#" class="nav-link">
        &nbsp; <i class="fas fa-tasks"></i> &nbsp;
        <p>
            Admin Settings
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <!-- Designation -->
    @if (Auth::guard('admin')->user()->can('designation.menu'))
    <ul class="nav nav-treeview dark_red">
        <li class="nav-item {{ Request::is('setting/designation*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Designation
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('designation.list'))
                <li class="nav-item">
                    <a href="{{ route('setting.designation_list') }}"
                        class="nav-link {{ $route === 'setting.designation_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Designation List</p>

                    </a>
                </li>
                @endif

                @if (Auth::guard('admin')->user()->can('designation.create'))
                <li class="nav-item">
                    <a href="{{ route('setting.designation_create') }}"
                        class="nav-link {{ $route === 'setting.designation_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Designation Create</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    </ul>
    @endif
    <!-- Department -->
    @if (Auth::guard('admin')->user()->can('department.menu'))
    <ul class="nav nav-treeview dark_red">
        <li class="nav-item {{ Request::is('setting/department*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Department
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('department.list'))
                <li class="nav-item">
                    <a href="{{ route('setting.department_list') }}"
                        class="nav-link {{ $route === 'setting.department_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Department List</p>

                    </a>
                </li>
                @endif

                @if (Auth::guard('admin')->user()->can('department.create'))
                <li class="nav-item">
                    <a href="{{ route('setting.department_create') }}"
                        class="nav-link {{ $route === 'setting.department_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Department Create</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    </ul>
    @endif
    <!-- Company -->

    @if (Auth::guard('admin')->user()->can('company.menu'))
    <ul class="nav nav-treeview dark_red">
        <li class="nav-item {{ Request::is('setting/company*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Company
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('company.list'))
                <li class="nav-item">
                    <a href="{{ route('setting.company_list') }}"
                        class="nav-link {{ $route === 'setting.company_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Company List</p>

                    </a>
                </li>
                @endif

                @if (Auth::guard('admin')->user()->can('company.create'))
                <li class="nav-item">
                    <a href="{{ route('setting.company_create') }}"
                        class="nav-link {{ $route === 'setting.company_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Company Create</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    </ul>

    @endif
    <!-- Religion -->
    @if (Auth::guard('admin')->user()->can('religion.menu'))
    <ul class="nav nav-treeview dark_red">
        <li class="nav-item {{ Request::is('setting/religion*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Religion
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('religion.list'))
                <li class="nav-item">
                    <a href="{{ route('setting.religion_list') }}"
                        class="nav-link {{ $route === 'setting.religion_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Religion List</p>

                    </a>
                </li>
                @endif
                @if (Auth::guard('admin')->user()->can('religion.create'))
                <li class="nav-item">
                    <a href="{{ route('setting.religion_create') }}"
                        class="nav-link {{ $route === 'setting.religion_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Religion Create</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    </ul>

    @endif
    <!-- Blood group -->
    @if (Auth::guard('admin')->user()->can('bloodgroup.menu'))

        <ul class="nav nav-treeview dark_red">
            <li
                class="nav-item {{ Request::is('setting/blood_group*') ? 'menu-is-opening menu-open   rounded' : '' }}">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Blood Group
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @if (Auth::guard('admin')->user()->can('bloodgroup.list'))
                        <li class="nav-item">
                            <a href="{{ route('setting.bloodgroup_list') }}"
                                class="nav-link {{ $route === 'setting.bloodgroup_list' ? 'text-light' : '' }} ">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Blood Group List</p>

                            </a>
                        </li>
                    @endif

                    @if (Auth::guard('admin')->user()->can('bloodgroup.create'))
                        <li class="nav-item">
                            <a href="{{ route('setting.bloodgroup_create') }}"
                                class="nav-link {{ $route === 'setting.bloodgroup_create' ? 'text-light' : '' }} ">
                                <i class="far fa-dot-circle nav-icon"></i>
                                <p>Blood Group Create</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        </ul>
    @endif
    <!-- Logo and website name -->
    @if (Auth::guard('admin')->user()->can('logo.menu'))
    <ul class="nav nav-treeview dark_red">
        <li class="nav-item {{ Request::is('setting/logo*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Logo and Web Title
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('logo.list'))
                <li class="nav-item">
                    <a href="{{ route('setting.logo_list') }}"
                        class="nav-link {{ $route === 'setting.logo_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>LWT List</p>
                    </a>
                </li>
                @endif

                @if (Auth::guard('admin')->user()->can('logo.create'))
                <li class="nav-item">
                    <a href="{{ route('setting.logo_create') }}"
                        class="nav-link {{ $route === 'setting.logo_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>LWT Create</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    </ul>
    @endif
</li>
@endif

<!-- Invoice Setting -->
@if (Auth::guard('admin')->user()->can('invoice_setting.menu'))
<li class="nav-item  {{ Request::is('invoice_setting*') ? 'menu-is-opening menu-open rounded menu-bg bg-dark' : '' }}">
    <a href="#" class="nav-link">
        &nbsp; <i class="fas fa-tasks"></i> &nbsp;
        <p>
            Invoice Settings
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <!-- Unit -->
    @if (Auth::guard('admin')->user()->can('unit.menu'))
    <ul class="nav nav-treeview dark_red">
        <li class="nav-item {{ Request::is('invoice_setting/unit*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Unit
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('unit.list'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.unit_list') }}"
                        class="nav-link {{ $route === 'invoice_setting.unit_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Unit List</p>

                    </a>
                </li>
                @endif

                @if (Auth::guard('admin')->user()->can('unit.create'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.unit_create') }}"
                        class="nav-link {{ $route === 'invoice_setting.unit_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Unit Create</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    </ul>
    @endif
    <!-- category -->
    @if (Auth::guard('admin')->user()->can('category.menu'))
    <ul class="nav nav-treeview dark_red">
        <li
            class="nav-item {{ Request::is('invoice_setting/category*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Category
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('category.list'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.category_list') }}"
                        class="nav-link {{ $route === 'invoice_setting.category_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>category List</p>

                    </a>
                </li>
                @endif

                @if (Auth::guard('admin')->user()->can('category.create'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.category_create') }}"
                        class="nav-link {{ $route === 'invoice_setting.category_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Category Create</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    </ul>
    @endif
    <!-- Customer -->
    @if (Auth::guard('admin')->user()->can('customer.menu'))
    <ul class="nav nav-treeview dark_red">
        <li
            class="nav-item {{ Request::is('invoice_setting/customer*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Customer
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('customer.list'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.customer_list') }}"
                        class="nav-link {{ $route === 'invoice_setting.customer_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Customer List</p>

                    </a>
                </li>
                @endif

                @if (Auth::guard('admin')->user()->can('customer.create'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.customer_create') }}"
                        class="nav-link {{ $route === 'invoice_setting.customer_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Customer Create</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    </ul>
    @endif
    <!-- store -->
    @if (Auth::guard('admin')->user()->can('store.menu'))
    <ul class="nav nav-treeview dark_red">
        <li class="nav-item {{ Request::is('invoice_setting/store*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Store
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('store.list'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.store_list') }}"
                        class="nav-link {{ $route === 'invoice_setting.store_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Store List</p>

                    </a>
                </li>
                @endif

                @if (Auth::guard('admin')->user()->can('store.create'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.store_create') }}"
                        class="nav-link {{ $route === 'invoice_setting.store_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Store Create</p>
                    </a>
                </li>
                @endif

            </ul>
        </li>
    </ul>
    @endif

    <!-- Supplier -->
    @if (Auth::guard('admin')->user()->can('supplier.menu'))
    <ul class="nav nav-treeview dark_red">
        <li
            class="nav-item {{ Request::is('invoice_setting/supplier*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Supplier
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('supplier.list'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.supplier_list') }}"
                        class="nav-link {{ $route === 'invoice_setting.supplier_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Supplier List</p>

                    </a>
                </li>
                @endif

                @if (Auth::guard('admin')->user()->can('supplier.create'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.supplier_create') }}"
                        class="nav-link {{ $route === 'invoice_setting.supplier_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Supplier Create</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    </ul>
    @endif
    {{-- Store Wise Supplier --}}
    @if (Auth::guard('admin')->user()->can('supplier_wise_store.menu'))
    <ul class="nav nav-treeview dark_red">
        <li class="nav-item {{ Request::is('invoice_setting/spw*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Supplier Wise Store
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('supplier_wise_store.list'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.supplier_wise_store_list') }}"
                        class="nav-link {{ $route === 'invoice_setting.supplier_wise_store_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>SWS List</p>

                    </a>
                </li>
                @endif
                @if (Auth::guard('admin')->user()->can('supplier_wise_store.create'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.supplier_wise_store_create') }}"
                        class="nav-link {{ $route === 'invoice_setting.supplier_wise_store_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Add New SWS</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    </ul>
    @endif
    <!-- Product -->
    @if (Auth::guard('admin')->user()->can('product.menu'))
    <ul class="nav nav-treeview dark_red">
        <li
            class="nav-item {{ Request::is('invoice_setting/product*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Product
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('product.list'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.product_list') }}"
                        class="nav-link {{ $route === 'invoice_setting.product_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Product List</p>

                    </a>
                </li>
                @endif

                @if (Auth::guard('admin')->user()->can('product.create'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.product_create') }}"
                        class="nav-link {{ $route === 'invoice_setting.product_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Product Create</p>
                    </a>
                </li>
                @endif

                @if (Auth::guard('admin')->user()->can('product.store_wise_product_list'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.product_sw_list') }}"
                        class="nav-link {{ $route === 'invoice_setting.product_sw_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>SW Product List</p>

                    </a>
                </li>
                @endif
            </ul>
        </li>
    </ul>
    @endif

    @if (Auth::guard('admin')->user()->can('expense_type.menu'))
    <ul class="nav nav-treeview dark_red">
        <li
            class="nav-item {{ Request::is('invoice_setting/expense*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Expense Type
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('expense_type.list'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.expense_list') }}"
                        class="nav-link {{ $route === 'invoice_setting.expense_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Expense Type List</p>

                    </a>
                </li>
                @endif

                @if (Auth::guard('admin')->user()->can('expense_type.create'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.expense_create') }}"
                        class="nav-link {{ $route === 'invoice_setting.expense_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Expense Type Create</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    </ul>
    @endif
    {{-- payment type --}}
    @if (Auth::guard('admin')->user()->can('payment_type.menu'))
    <ul class="nav nav-treeview dark_red">
        <li
            class="nav-item {{ Request::is('invoice_setting/paymenttype*') ? 'menu-is-opening menu-open   rounded' : '' }}">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Payment Type
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::guard('admin')->user()->can('payment_type.list'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.payment_list') }}"
                        class="nav-link {{ $route === 'invoice_setting.payment_list' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>PT List</p>
                    </a>
                </li>
                @endif

                @if (Auth::guard('admin')->user()->can('payment_type.create'))
                <li class="nav-item">
                    <a href="{{ route('invoice_setting.payment_create') }}"
                        class="nav-link {{ $route === 'invoice_setting.payment_create' ? 'text-light' : '' }} ">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>PT Create</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    </ul>
    @endif

</li>

@endif
